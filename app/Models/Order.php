<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    /**
     * @var string[]
     */
    protected $with = ['customer','orderHistory'];

    /**
     * @var string[]
     */
    public $fillable = [
        'location',
        'date',
        'time_slot',
        'total',
        'driver_tip',
        'customer_id',
        'status',
        'latitude',
        'longitude',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return HasMany
     */
    public function orderHistory(){
        return $this->hasMany(orderHistory::class);
    }
}
