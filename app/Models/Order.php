<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    /**
     * @var string[]
     */
    protected $with = ['customer','driver','orderHistory','payment','address'];

    Const STATUS = [
        '0'=>'Ordered',
        '1'=>'Confirmed',
        '2'=>'Ongoing',
        '4'=>'Delivered',
        '5'=>'Canceled',
    ];
    /**
     * @var string[]
     */
    public $fillable = [
        'date',
        'time_slot',
        'total',
        'driver_tip',
        'customer_id',
        'status',
        'address_book_id',
        'driver_id',
        'cancel_reason',
        'invoice_id',
        'order_invoice',
        'payment_method',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return BelongsTo
     */
    public function address(){
        return $this->belongsTo(AddressBook::class, 'address_book_id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    /**
     * @return HasMany
     */
    public function orderHistory(){
        return $this->hasMany(orderHistory::class);
    }

    /**
     * @return HasOne
     */
    public function payment(){
        return $this->hasOne(PaymentStatus::class, 'order_id');
    }
}
