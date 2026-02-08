<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'eyebrow',
        'eyebrow_color',
        'title_line1',
        'title_line2',
        'title_color',
        'title_line2_color',
        'subtitle',
        'subtitle_color',
        'bg_image_url',
        'bg_image_urls',
        'banner_height_px',
        'bg_position',
        'banner_content_max_width_px',
        'bg_size',
        'primary_text',
        'primary_url',
        'secondary_text',
        'secondary_url',
    ];

    protected $casts = [
        'bg_image_urls' => 'array',
    ];
}
