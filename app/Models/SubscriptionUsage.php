<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionUsage extends Model
{
    protected $fillable = [
        'partner_id', 'plan_id', 'usage_type', 'current_usage', 
        'limit_value', 'usage_percentage', 'last_updated'
    ];

    protected $casts = [
        'usage_percentage' => 'decimal:2',
        'last_updated' => 'datetime'
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function isLimitExceeded(): bool
    {
        return $this->current_usage > $this->limit_value;
    }

    public function getUsagePercentage(): float
    {
        if ($this->limit_value <= 0) return 0;
        return round(($this->current_usage / $this->limit_value) * 100, 2);
    }

    public function updateUsage(int $increment = 1): void
    {
        $this->increment('current_usage', $increment);
        $this->update([
            'usage_percentage' => $this->getUsagePercentage(),
            'last_updated' => now()
        ]);
    }

    public function scopeForPartner($query, int $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    public function scopeForUsageType($query, string $type)
    {
        return $query->where('usage_type', $type);
    }

    public function scopeExceedingLimit($query)
    {
        return $query->whereRaw('current_usage > limit_value');
    }
}
