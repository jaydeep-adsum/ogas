<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class orderHistory extends Model
{
    use HasFactory;

    public $table = 'order_histories';

    protected $with = ['product'];

    public $fillable = [
        'quantity',
        'type',
        'product_id',
        'order_id',
    ];

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
