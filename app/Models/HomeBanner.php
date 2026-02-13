<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'is_active',
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
        'is_active' => 'boolean',
    ];

    /**
     * Get bg_image_urls without throwing on invalid JSON.
     */
    public function getBgImageUrlsForEditAttribute(): array
    {
        try {
            $v = $this->getRawOriginal('bg_image_urls');
            if ($v === null || $v === '') {
                return [];
            }
            if (is_string($v)) {
                $decoded = json_decode($v, true);
                return is_array($decoded) ? $decoded : [];
            }
            return is_array($v) ? $v : [];
        } catch (\Throwable $e) {
            return [];
        }
    }
}
