<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'eyebrow',
        'title_line1',
        'title_line2',
        'subtitle',
        'bg_image_url',
        'banner_height_px',
        'bg_position',
        'banner_content_max_width_px',
        'bg_size',
        'primary_text',
        'primary_url',
        'secondary_text',
        'secondary_url',
    ];
}
