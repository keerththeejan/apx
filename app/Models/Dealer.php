<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'discount_percent',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Apply dealer discount to a total. Returns discounted amount.
     */
    public function applyDiscount(float $total): float
    {
        $pct = (float) $this->discount_percent;
        return round($total * (1 - $pct / 100), 2);
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', trim($code))->where('is_active', true)->first();
    }

    /**
     * Quotation rates this dealer is connected to (gets dealer price for these rates).
     */
    public function quotationRates()
    {
        return $this->belongsToMany(QuotationRate::class, 'quotation_rate_dealer');
    }
}
