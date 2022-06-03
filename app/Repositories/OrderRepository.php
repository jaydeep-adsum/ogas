<?php


namespace App\Repositories;


use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $fieldsSearchable = [
        'location',
        'quantity',
        'date',
        'time_slot',
        'type',
        'total',
        'driver_tip',
        'product_id',
        'customer_id',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return Order::class;
    }
}
