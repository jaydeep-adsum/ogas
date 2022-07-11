<?php


namespace App\Repositories;


use App\Models\Order;
use App\Models\orderHistory;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldsSearchable = [
        'location',
        'date',
        'time_slot',
        'total',
        'driver_tip',
        'customer_id',
        'status',
        'latitude',
        'longitude',
        'quantity',
        'type',
        'product_id',
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

    /**
     * @param $input
     * @return Model
     */
    public function store($input){
        $order = $this->create([
          "location" => $input['location'],
          "latitude" => $input['latitude'],
          "longitude" => $input['longitude'],
          "time_slot" => $input['time_slot'],
          "date" => $input['date'],
          "total" => $input['total'],
          "driver_tip" => $input['driver_tip'],
          "customer_id" => $input['customer_id'],
        ]);
        foreach (explode(',',$input['product_id']) as $key=>$product_id){
              orderHistory::create([
                'quantity'=>$input['quantity'][$key],
                'type'=>$input['type'][$key],
                'product_id'=>$product_id,
                'order_id'=>$order->id
            ]);
        }
        return $order;
    }
}
