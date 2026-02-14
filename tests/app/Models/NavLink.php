<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'icon', 'url', 'sort_order', 'is_visible', 'target',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];
}
