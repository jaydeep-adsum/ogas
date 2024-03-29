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
        'date',
        'time_slot',
        'total',
        'driver_tip',
        'customer_id',
        'status',
        'quantity',
        'type',
        'product_id',
        'invoice_id',
        'order_invoice',
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
        $orderInvoice = 'OGAS'.rand(6,999999);
        $invoiceId = 'INVOGAS'.rand(6,999999);
        $order = $this->create([
          "address_book_id" => $input['address_book_id'],
          "time_slot" => $input['time_slot'],
          "date" => $input['date'],
          "total" => $input['total'],
          "payment_method" => $input['payment_method'],
          "driver_tip" => $input['driver_tip'],
          "customer_id" => $input['customer_id'],
          "invoice_id" => $invoiceId,
          "order_invoice" => $orderInvoice,
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
