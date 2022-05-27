<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Customer extends Authenticatable implements HasMedia
{
    use Notifiable,InteractsWithMedia,HasApiTokens;
    const PATH = 'customer';

    public $table = 'customers';
    protected $appends = ['image_url'];
    public $fillable = [
        'name',
        'mobile',
        'address',
        'device_token',
        'device_type',
    ];

    public function getImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PATH)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('public/assets/images/no-user.jpg');
    }
}
