<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens,Notifiable;

    public $table = 'drivers';

    public $fillable = [
        'name',
        'mobile',
        'email',
        'licence_no',
        'vehicle_no',
        'status',
        'device_token',
        'device_type',
        'latitude',
        'longitude',
    ];
}
