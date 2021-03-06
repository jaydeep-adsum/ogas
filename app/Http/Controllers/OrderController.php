<?php

namespace App\Http\Controllers;

use App\Datatable\OrderDatatable;
use App\Exports\OrderExport;
use App\Models\Order;
use App\Repositories\OrderRepository;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends AppBaseController
{
    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request){
        if ($request->ajax()) {
            return Datatables::of((new OrderDatatable())->get())->make(true);
        }
        return view('order.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $order = Order::find($id);
        $div = $order->driver==null?6:4;

        return view('order.show', compact('order','div'));
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->sendSuccess('Order deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new OrderExport(), 'order.xlsx');
    }
}
