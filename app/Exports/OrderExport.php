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
                'order_id'=>$item->id,
                'invoice_id'=>$item->id,
                'location'=>$item->address->location,
                'latitude'=>$item->address->latitude,
                'longitude'=>$item->address->longitude,
                'date'=>$item->date,
                'time_slot'=> $item->time_slot == 1 ? 'Now' : ($item->time_slot == 2 ? '09Am-12pm' : ($item->time_slot == 3 ? '12pm-03pm' : ($item->time_slot == 4 ? '03pm-06pm' : '-'))),
                'total'=> $item->total,
                'customer'=>  $item->customer?$item->customer->name:'-',
                'driver'=>$item->driver?$item->driver->name:'-',
                'driver_tip'=> $item->driver_tip,
                'status'=> $item->status == 0 ? 'Ordered' : ($item->status == 1 ? 'Confirmed' : ($item->status == 2 ? 'On the way' : ($item->status == 3 ? 'order processing' : ($item->status == 4 ? 'Delivered' : ($item->status == 5 ? 'Canceled' : '-'))))),
                'cancel_reason'=>$item->cancel_reason,
            ];
        }

        return collect($data);
    }

    public function headings() :array
    {
        return [
            'ID',
            'Location',
            'Latitude',
            'Longitude',
            'Delivery Date',
            'Time Slot',
            'Total',
            'Customer',
            'Driver',
            'Driver Tips',
            'Order Status',
            'Cancel Reason',
        ];
    }
}
