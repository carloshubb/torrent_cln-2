<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeImageList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'link',
        'order',
        'is_active',
    ];
}
