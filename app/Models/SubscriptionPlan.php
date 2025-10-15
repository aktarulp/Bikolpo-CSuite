<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'currency', 
        'billing_cycle', 'partner_type', 'is_active', 'is_popular', 
        'sort_order', 'features', 'limits'
    ];

    protected $casts = [
        'features' => 'array',
        'limits' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(PartnerSubscription::class, 'plan_id');
    }

    public function usage(): HasMany
    {
        return $this->hasMany(SubscriptionUsage::class, 'plan_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SubscriptionTransaction::class, 'plan_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return '৳' . number_format($this->price, 0);
    }

    public function getFeatureValue(string $feature): mixed
    {
        return $this->features[$feature] ?? null;
    }

    public function getLimitValue(string $limit): mixed
    {
        return $this->limits[$limit] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPartnerType($query, string $type)
    {
        return $query->where('partner_type', $type);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }
}
