<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Customer extends Authenticatable
{
    use Notifiable,HasApiTokens;
    const PATH = 'customer';

    public $table = 'customers';

    public $fillable = [
        'name',
        'mobile',
        'address',
        'device_token',
        'device_type',
    ];
}
