<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url_template',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Build tracking URL with tracking number substituted.
     */
    public function urlFor(string $trackingNumber): string
    {
        return str_replace(
            ['{tracking_number}', '{tracking}'],
            [rawurlencode($trackingNumber), rawurlencode($trackingNumber)],
            $this->url_template
        );
    }
}
