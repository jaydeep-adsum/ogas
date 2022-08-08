<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    public $table = 'payment_statuses';

    public $fillable = [
        'order_id',
        'customer_id',
        'invoice_id',
        'total_amount',
        'payment_mode',
        'payment_status',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
