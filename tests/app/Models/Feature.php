<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon', 'icon_image_url', 'title', 'description', 'sort_order', 'is_visible',
    ];
}
