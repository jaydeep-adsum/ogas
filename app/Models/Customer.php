<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Authenticatable implements HasMedia
{
    use Notifiable,InteractsWithMedia,HasApiTokens;

    public $table = 'customers';

    public $fillable = [
        'name',
        'mobile',
        'address',
        'device_token',
        'device_type',
    ];
}
