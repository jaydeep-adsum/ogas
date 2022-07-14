<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use Notifiable,HasApiTokens;
    const PATH = 'customer';

    public $table = 'customers';

    public $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'payment_customer_id',
        'device_token',
        'device_type',
    ];
}
