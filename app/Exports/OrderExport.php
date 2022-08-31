<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $order= Order::all();
        $data = [];
        foreach ($order as $item){
            $data[] = [
                'order_id'=>$item->order_invoice,
                'invoice_id'=>$item->invoice_id,
                'customer'=>  $item->customer?$item->customer->name:'-',
                'location'=>$item->address->location,
                'date'=>$item->date,
                'time_slot'=> $item->time_slot,
                'payment_method'=> $item->payment_method,
                'payment_status'=> ($item->payment&&$item->payment->payment_status=="paid")?'Paid':'Unpaid',
                'status'=> $item->status == 0 ? 'Ordered' : ($item->status == 1 ? 'Confirmed' : ($item->status == 2 ? 'On the way' : ($item->status == 3 ? 'order processing' : ($item->status == 4 ? 'Delivered' : ($item->status == 5 ? 'Canceled' : '-'))))),
                'driver'=>$item->driver?$item->driver->name:'-',
                'driver_number'=>$item->driver?$item->driver->mobile:'-',
                'total'=> $item->total,
                'driver_tip'=> $item->driver_tip,
                'cancel_reason'=>$item->cancel_reason,
            ];
        }

        return collect($data);
    }

    public function headings() :array
    {
        return [
            'Order ID',
            'Invoice ID',
            'Customer',
            'Location',
            'Delivery Date',
            'Time Slot',
            'Payment Method',
            'Payment Status',
            'Order Status',
            'Driver',
            'Driver Number',
            'Total',
            'Driver Tips',
            'Cancel Reason',
        ];
    }
}
