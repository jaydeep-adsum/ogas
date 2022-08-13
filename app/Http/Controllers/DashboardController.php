<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Models\orderHistory;
use App\Models\Product;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard(Request $request)
    {
        $input = $request->all();
//        $data['customer'] = Customer::all()->count();
        $data['product'] = Product::pluck('product_name');
        $data['order'] = Order::all()->count();
        $orderHistoryArr = orderHistory::select(DB::raw('count(product_id) as total'))->groupBy('product_id')->get()->toArray();
        $data['orderHistory'] = [];
        foreach ($orderHistoryArr as $orderHistory){
            $data['orderHistory'][] = $orderHistory['total'];
        }
        $data['complaint'] = Complaint::all()->count();
        $data['driver'] = Driver::all()->count();

        return view('dashboard.index',compact('data'));
    }

    public function dashboardChartData(Request $request): JsonResponse
    {
        $input = $request->all();
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $data = [];
        $customer = Customer::addSelect([\DB::raw('DAY(created_at) as day,created_at')])
            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
            ->orderBy('created_at')
            ->get();
        $driver = Driver::addSelect([\DB::raw('DAY(created_at) as day,created_at')])
            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
            ->orderBy('created_at')
            ->get();

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $data['customer'][] = $customer->where('day', $date->format('d'))->where('month', $date->format('m'))->where('year', $date->format('Y'))->count();
            $data['driver'][] = $driver->where('day', $date->format('d'))->where('month', $date->format('m'))->where('year', $date->format('Y'))->count();
            $data['labels'][] = $date->format('d-m-y');
        }

        return response()->json($data);
    }

    public function incomeChartData(Request $request): JsonResponse
    {
        $input = $request->all();
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $data = [];
        $data['orderAmountTotal'] = Order::pluck('total')->sum();
        $orderAmountTotal = Order::addSelect([\DB::raw('DAY(created_at) as day,created_at')])
            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
            ->orderBy('created_at')
            ->get();

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $data['customer'][] = $orderAmountTotal->where('day', $date->format('d'))->where('month', $date->format('m'))->where('year', $date->format('Y'))->count();
            $data['labels'][] = $date->format('d-m-y');
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = User::where('id',Auth::user()->id)->first();

        if(Hash::check($request->old_password, $user->password))
        {
            if($request->new_password == $request->confirm_password)
            {
                $user->password = Hash::make($request->new_password);
                $user->save();
                $data['status'] = 1;
                $data['messages'] = 'Your password changed successfully';
                return response()->json($data);
            }
            else
            {
                $data['status'] = 0;
                $data['messages'] = 'The password confirmation does not match.';
                return response()->json($data);
            }
        }
        else
        {
            $data['status'] = 0;
            $data['messages'] = 'The old password does not match.';
            return response()->json($data);
        }
    }
}
