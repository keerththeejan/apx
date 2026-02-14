<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'service',
        'customer_price',
        'dealer_price',
        'sort_order',
    ];

    protected $casts = [
        'customer_price' => 'decimal:2',
        'dealer_price' => 'decimal:2',
    ];

    public function getLabelAttribute(): string
    {
        return $this->country . ' – ' . $this->service;
    }

    public function totalCustomer(int|float $qty): float
    {
        return round((float) $this->customer_price * $qty, 2);
    }

    public function totalDealer(int|float $qty): float
    {
        return round((float) $this->dealer_price * $qty, 2);
    }

    /**
     * Dealers connected to this rate. Only these dealers get dealer price for this rate.
     * If none connected, any valid dealer code gets dealer price.
     */
    public function dealers()
    {
        return $this->belongsToMany(Dealer::class, 'quotation_rate_dealer');
    }

    /**
     * Whether the given dealer is allowed dealer price for this rate.
     */
    public function allowsDealer(Dealer $dealer): bool
    {
        $connected = $this->dealers()->pluck('dealers.id')->toArray();
        if (count($connected) === 0) {
            return true;
        }
        return in_array($dealer->id, $connected, true);
    }
}
