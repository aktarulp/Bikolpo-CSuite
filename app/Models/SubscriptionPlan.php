<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'currency', 
        'billing_cycle', 'partner_type', 'is_active', 'is_popular', 
        'sort_order', 'features', 'limits',
        'offer_price', 'offer_name', 'offer_description', 'offer_start_date', 
        'offer_end_date', 'offer_max_users', 'offer_used_count', 'offer_is_active',
        'offer_auto_apply', 'offer_code', 'offer_badge_text', 'offer_badge_color',
        'offer_show_original_price',
        'annual_price', 'annual_offer_name', 'annual_offer_description', 
        'annual_discount_percentage', 'annual_savings_amount', 'annual_offer_active',
        'annual_badge_text', 'annual_badge_color', 'annual_show_monthly_equivalent',
        'annual_highlight_savings',
        'referral_eligible', 'referral_reward_months', 'referral_minimum_amount', 'referral_conditions'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'offer_start_date' => 'datetime',
        'offer_end_date' => 'datetime',
        'offer_is_active' => 'boolean',
        'offer_auto_apply' => 'boolean',
        'offer_show_original_price' => 'boolean',
        'annual_price' => 'decimal:2',
        'annual_discount_percentage' => 'integer',
        'annual_savings_amount' => 'decimal:2',
        'annual_offer_active' => 'boolean',
        'annual_show_monthly_equivalent' => 'boolean',
        'annual_highlight_savings' => 'boolean',
        'referral_eligible' => 'boolean',
        'referral_reward_months' => 'integer',
        'referral_minimum_amount' => 'decimal:2',
        'referral_conditions' => 'array'
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(PartnerSubscription::class, 'plan_id');
    }

    public function planFeatures(): BelongsToMany
    {
        return $this->belongsToMany(PlanFeature::class, 'subscription_plan_features')
            ->withPivot(['enabled', 'value', 'limit_value', 'notes'])
            ->withTimestamps();
    }

    public function enabledFeatures(): BelongsToMany
    {
        return $this->planFeatures()->wherePivot('enabled', true);
    }

    public function getFeatureValue(string $featureSlug): mixed
    {
        $feature = $this->planFeatures()->where('slug', $featureSlug)->first();
        
        if (!$feature) {
            return null;
        }

        $pivot = $feature->pivot;
        
        if ($feature->type === 'boolean') {
            return $pivot->is_enabled;
        }

        if ($feature->type === 'numeric') {
            return $pivot->value ? (float) $pivot->value : null;
        }

        if ($feature->type === 'text') {
            return $pivot->value;
        }

        if ($feature->type === 'select') {
            return $pivot->value;
        }

        return null;
    }

    public function hasFeature(string $featureSlug): bool
    {
        return $this->enabledFeatures()->where('slug', $featureSlug)->exists();
    }

    public function getFeatureLimit(string $featureSlug): ?int
    {
        $feature = $this->enabledFeatures()->where('slug', $featureSlug)->first();
        
        if (!$feature) {
            return null;
        }

        return $feature->pivot->limit_value;
    }

    public function getFeaturesByCategory(): array
    {
        $features = $this->enabledFeatures()->get();
        $grouped = [];

        foreach ($features as $feature) {
            $category = $feature->category;
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $feature;
        }

        return $grouped;
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
        if ($this->price === null) {
            return 'Contact for pricing';
        }
        return '৳' . number_format($this->price, 0);
    }

    public function isCustomPricing(): bool
    {
        return $this->price === null;
    }

    public function hasActiveOffer(): bool
    {
        if (!$this->offer_is_active || !$this->offer_price) {
            return false;
        }

        $now = now();
        
        // Check if offer is within date range
        if ($this->offer_start_date && $now->lt($this->offer_start_date)) {
            return false;
        }
        
        if ($this->offer_end_date && $now->gt($this->offer_end_date)) {
            return false;
        }
        
        // Check if offer has reached max users limit
        if ($this->offer_max_users && $this->offer_used_count >= $this->offer_max_users) {
            return false;
        }
        
        return true;
    }

    public function getCurrentPrice(): ?float
    {
        if ($this->hasActiveOffer()) {
            return $this->offer_price;
        }
        
        return $this->price;
    }

    public function getFormattedCurrentPrice(): string
    {
        $currentPrice = $this->getCurrentPrice();
        
        if ($currentPrice === null) {
            return 'Contact for pricing';
        }
        
        return '৳' . number_format($currentPrice, 0);
    }

    public function getSavingsAmount(): ?float
    {
        if (!$this->hasActiveOffer() || !$this->price || !$this->offer_price) {
            return null;
        }
        
        return $this->price - $this->offer_price;
    }

    public function getSavingsPercentage(): ?float
    {
        if (!$this->hasActiveOffer() || !$this->price || !$this->offer_price) {
            return null;
        }
        
        return round((($this->price - $this->offer_price) / $this->price) * 100, 1);
    }

    public function getOfferBadgeColor(): string
    {
        return $this->offer_badge_color ?: 'red';
    }

    public function getOfferBadgeText(): string
    {
        if ($this->offer_badge_text) {
            return $this->offer_badge_text;
        }
        
        if ($this->getSavingsPercentage()) {
            return $this->getSavingsPercentage() . '% OFF';
        }
        
        return 'OFFER';
    }

    // Annual subscription methods
    public function hasAnnualOffer(): bool
    {
        return $this->annual_offer_active && $this->annual_price && $this->price;
    }

    public function getAnnualPrice(): ?float
    {
        if (!$this->hasAnnualOffer()) {
            return null;
        }
        
        return $this->annual_price;
    }

    public function getFormattedAnnualPrice(): string
    {
        if (!$this->hasAnnualOffer()) {
            return 'Annual pricing not available';
        }
        
        return '৳' . number_format($this->annual_price, 0);
    }

    public function getAnnualSavingsAmount(): ?float
    {
        if (!$this->hasAnnualOffer() || !$this->price) {
            return null;
        }
        
        $monthlyTotal = $this->price * 12;
        return $monthlyTotal - $this->annual_price;
    }

    public function getAnnualSavingsPercentage(): ?float
    {
        if (!$this->hasAnnualOffer() || !$this->price) {
            return null;
        }
        
        $monthlyTotal = $this->price * 12;
        return round((($monthlyTotal - $this->annual_price) / $monthlyTotal) * 100, 1);
    }

    public function getMonthlyEquivalentPrice(): ?float
    {
        if (!$this->hasAnnualOffer()) {
            return null;
        }
        
        return round($this->annual_price / 12, 2);
    }

    public function getFormattedMonthlyEquivalent(): string
    {
        $monthlyPrice = $this->getMonthlyEquivalentPrice();
        
        if (!$monthlyPrice) {
            return '';
        }
        
        return '৳' . number_format($monthlyPrice, 0) . '/month';
    }

    public function getAnnualBadgeText(): string
    {
        if ($this->annual_badge_text) {
            return $this->annual_badge_text;
        }
        
        if ($this->getAnnualSavingsPercentage()) {
            return 'SAVE ' . $this->getAnnualSavingsPercentage() . '%';
        }
        
        return 'SAVE 2 MONTHS';
    }

    public function getAnnualBadgeColor(): string
    {
        return $this->annual_badge_color ?: 'green';
    }

    public function getAnnualOfferName(): string
    {
        return $this->annual_offer_name ?: 'Annual Subscription';
    }

    public function getAnnualOfferDescription(): string
    {
        return $this->annual_offer_description ?: 'Get 12 months for the price of 10!';
    }

    // Referral system methods
    public function isReferralEligible(): bool
    {
        return $this->referral_eligible;
    }

    public function getReferralRewardMonths(): int
    {
        return $this->referral_reward_months ?: 1;
    }

    public function getReferralMinimumAmount(): ?float
    {
        return $this->referral_minimum_amount;
    }

    public function meetsReferralConditions(float $amount): bool
    {
        if (!$this->isReferralEligible()) {
            return false;
        }

        $minimumAmount = $this->getReferralMinimumAmount();
        if ($minimumAmount && $amount < $minimumAmount) {
            return false;
        }

        // Check additional conditions if any
        $conditions = $this->referral_conditions;
        if ($conditions) {
            // Implement custom condition checking logic here
            // For now, we'll just return true if basic conditions are met
        }

        return true;
    }

    public function getReferralRewardDescription(): string
    {
        $months = $this->getReferralRewardMonths();
        return "Get {$months} month" . ($months > 1 ? 's' : '') . " free subscription for successful referrals";
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
