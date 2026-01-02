<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'image_url',
        'activity_date',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}
