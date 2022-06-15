<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    /**
     * @var string[]
     */
    protected $with = ['product','customer','status'];

    /**
     * @var string[]
     */
    public $fillable = [
        'location',
        'quantity',
        'date',
        'time_slot',
        'type',
        'total',
        'driver_tip',
        'product_id',
        'customer_id',
        'status_id',
    ];

    /**
     * @return BelongsTo
     */
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function status(){
        return $this->hasMany(Status::class, 'order_id');
    }
}
