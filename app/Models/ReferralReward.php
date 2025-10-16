<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralReward extends Model
{
    protected $fillable = [
        'referral_id',
        'referrer_id',
        'reward_type',
        'reward_value',
        'reward_unit',
        'status',
        'applied_at',
        'expires_at',
        'notes'
    ];

    protected $casts = [
        'reward_value' => 'decimal:2',
        'applied_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'referrer_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isApplied(): bool
    {
        return $this->status === 'applied';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeApplied(): bool
    {
        return $this->isPending() && !$this->isExpired();
    }

    public function apply(): bool
    {
        if (!$this->canBeApplied()) {
            return false;
        }

        // Apply the reward to the referrer's account
        $this->applyToReferrer();

        $this->update([
            'status' => 'applied',
            'applied_at' => now()
        ]);

        return true;
    }

    protected function applyToReferrer(): void
    {
        $referrer = $this->referrer;
        
        if ($this->reward_type === 'subscription_credit') {
            // Add subscription credit to referrer's account
            // This would need to be implemented based on your subscription system
            $this->addSubscriptionCredit($referrer, $this->reward_value);
        }
        
        // Update referrer's referral earnings
        $referrer->increment('referral_earnings', $this->reward_value);
    }

    protected function addSubscriptionCredit(Partner $referrer, float $months): void
    {
        // This is a placeholder - you'll need to implement this based on your subscription system
        // For example, you might:
        // 1. Add credit to the partner's account
        // 2. Extend their current subscription
        // 3. Create a credit voucher
        // 4. Apply discount to next billing cycle
        
        // Example implementation:
        // $referrer->subscription_credits += $months;
        // $referrer->save();
    }

    public function getFormattedValue(): string
    {
        switch ($this->reward_unit) {
            case 'months':
                return $this->reward_value . ' month' . ($this->reward_value > 1 ? 's' : '');
            case 'percentage':
                return $this->reward_value . '%';
            case 'amount':
                return '৳' . number_format($this->reward_value, 0);
            default:
                return $this->reward_value;
        }
    }

    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'applied' => 'green',
            'expired' => 'red',
            'cancelled' => 'gray',
            default => 'gray'
        };
    }

    public function getStatusBadgeText(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'applied' => 'Applied',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }
}