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
    protected $with = ['product1','product2','customer','status'];

    /**
     * @var string[]
     */
    public $fillable = [
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
     * @return BelongsTo
     */
    public function product1(){
        return $this->belongsTo(Product::class, 'product1_id');
    }

    /**
     * @return BelongsTo
     */
    public function product2(){
        return $this->belongsTo(Product::class, 'product2_id');
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
