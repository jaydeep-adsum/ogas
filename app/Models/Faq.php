<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'faqs';

    /**
     * @var string[]
     */
    public $fillable = [
        'question',
        'answer',
    ];

}
