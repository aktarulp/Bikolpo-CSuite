<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class PartnerSubscription extends Model
{
    protected $fillable = [
        'partner_id', 'plan_id', 'status', 'started_at', 'expires_at',
        'auto_renew', 'payment_method', 'transaction_id', 'amount_paid', 'currency'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'auto_renew' => 'boolean',
        'amount_paid' => 'decimal:2'
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function usage(): HasMany
    {
        return $this->hasMany(SubscriptionUsage::class, 'partner_id', 'partner_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SubscriptionTransaction::class, 'subscription_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function daysRemaining(): int
    {
        if (!$this->expires_at) return -1; // unlimited
        return max(0, $this->expires_at->diffInDays(Carbon::now()));
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere(function($q) {
                        $q->where('status', 'active')
                          ->where('expires_at', '<', now());
                    });
    }

    public function scopeTrial($query)
    {
        return $query->where('status', 'trial');
    }
}
