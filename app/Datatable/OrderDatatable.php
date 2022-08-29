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
        if (isset($input['payment'])&&$input['payment']==0){
            $query->whereHas('payment', function ($q){
                $q->where('payment_status','paid');
            });
        }
        if (isset($input['payment'])&&$input['payment']==1){
            $query->doesntHave('payment');
        }

        return $query;
    }
}
