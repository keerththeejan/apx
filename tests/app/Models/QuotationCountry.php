<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'rate_per_kg',
        'base_fee',
        'sort_order',
    ];

    protected $casts = [
        'rate_per_kg' => 'decimal:2',
        'base_fee' => 'decimal:2',
    ];

    /**
     * Calculate total amount for a given weight (kg).
     */
    public function calculateTotal(float $weightKg): float
    {
        $base = (float) ($this->base_fee ?? 0);
        $rate = (float) $this->rate_per_kg;
        return round($base + ($weightKg * $rate), 2);
    }
}
