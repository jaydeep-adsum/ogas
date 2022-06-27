<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    use Notifiable,HasApiTokens;

    public $table = 'drivers';

    public $fillable = [
        'name',
        'mobile',
        'email',
        'licence_no',
        'vehicle_no',
        'device_token',
        'device_type',
    ];
}