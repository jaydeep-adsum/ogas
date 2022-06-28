<?php


namespace App\Repositories;


use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $fieldsSearchable = [
        'location',
        'refill_quantity',
        'new_quantity',
        'date',
        'time_slot',
        'refill',
        'new',
        'refill_price',
        'new_price',
        'total',
        'driver_tip',
        'product_id',
        'customer_id',
        'status_id',
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
