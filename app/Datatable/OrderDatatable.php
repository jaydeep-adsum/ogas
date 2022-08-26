<?php


namespace App\Datatable;


use App\Models\Order;

class OrderDatatable
{
    public function get($input = [])
    {
        /** @var Order $query */
        $query = Order::query()->select('orders.*');
        if (isset($input['status'])){
            $query->where('status', $input['status']);
        }

        return $query;
    }
}
