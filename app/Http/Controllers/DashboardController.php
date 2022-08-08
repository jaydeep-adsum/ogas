<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Auth;
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
    public function dashboard()
    {
        $data['customer'] = Customer::all()->count();
        $data['product'] = Product::all()->count();
        $data['order'] = Order::all()->count();
        $data['complaint'] = Complaint::all()->count();
        $data['driver'] = Driver::all()->count();
        $data['orderAmountTotal'] = Order::pluck('total')->sum();

        return view('dashboard.index',compact('data'));
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
