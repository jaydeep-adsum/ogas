<?php


namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderDetail;

class OrderRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldsSearchable = [
        'location',
        'quantity1',
        'quantity2',
        'date',
        'time_slot',
        'type1',
        'type2',
        'total',
        'driver_tip',
        'customer_id',
        'product1_id',
        'product2_id',
        'status_id',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Order::class;
    }
}
