<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;

    public $table = 'address_books';

    public $fillable = [
        'location',
        'latitude',
        'longitude',
        'customer_id',
        'address_type',
    ];
}
