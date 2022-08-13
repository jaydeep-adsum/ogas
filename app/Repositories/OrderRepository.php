<?php


namespace App\Repositories;


use App\Models\Order;
use App\Models\orderHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'invoice_id',
        'payment_method',
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
        $invoiceId = Str::random(6);
        $order = $this->create([
          "location" => $input['location'],
          "latitude" => $input['latitude'],
          "longitude" => $input['longitude'],
          "time_slot" => $input['time_slot'],
          "date" => $input['date'],
          "total" => $input['total'],
          "driver_tip" => $input['driver_tip'],
          "customer_id" => $input['customer_id'],
          "invoice_id" => $invoiceId,
        ]);
//        $quantity = explode(',',$input['quantity']);
//        $type = explode(',',$input['type']);
//        foreach (explode(',',$input['product_id']) as $key=>$product_id){
//            orderHistory::create([
//                'quantity'=>$quantity[$key],
//                'type'=>$type[$key],
//                'product_id'=>$product_id,
//                'order_id'=>$order->id
//            ]);
//        }
        $products = json_decode($input['product']);
        foreach ($products as $data){
              orderHistory::create([
                'quantity'=>$data->quantity,
                'type'=>$data->type,
                'product_id'=>$data->id,
                'order_id'=>$order->id
            ]);
        }

        return $order;
    }
}
