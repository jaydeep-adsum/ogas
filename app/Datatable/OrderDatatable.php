<?php


namespace App\Datatable;


use App\Models\Order;

class OrderDatatable
{
    public function get($input = [])
    {
        /** @var Order $query */
        $query = Order::query()->select('orders.*');

        return $query;
    }
}
