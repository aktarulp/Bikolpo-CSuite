<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code_id',
        'status',
        'referred_at',
        'completed_at',
        'expires_at',
        'metadata'
    ];

    protected $casts = [
        'referred_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array'
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'referrer_id');
    }

    public function referred(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'referred_id');
    }

    public function referralCode(): BelongsTo
    {
        return $this->belongsTo(ReferralCode::class);
    }

    public function reward(): HasOne
    {
        return $this->hasOne(ReferralReward::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeCompleted(): bool
    {
        return $this->isPending() && !$this->isExpired();
    }

    public function markAsCompleted(): bool
    {
        if (!$this->canBeCompleted()) {
            return false;
        }

        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        // Create reward for referrer
        $this->createReward();

        return true;
    }

    public function markAsExpired(): bool
    {
        if ($this->isCompleted()) {
            return false;
        }

        return $this->update([
            'status' => 'expired'
        ]);
    }

    protected function createReward(): void
    {
        // Get the subscription plan that triggered the reward
        $subscription = $this->getTriggeringSubscription();
        
        if (!$subscription || !$subscription->plan->referral_eligible) {
            return;
        }

        $rewardMonths = $subscription->plan->referral_reward_months ?? 1;
        
        ReferralReward::create([
            'referral_id' => $this->id,
            'referrer_id' => $this->referrer_id,
            'reward_type' => 'subscription_credit',
            'reward_value' => $rewardMonths,
            'reward_unit' => 'months',
            'status' => 'pending',
            'expires_at' => now()->addYear(), // Rewards expire in 1 year
            'notes' => "Referral reward for {$this->referred->name} subscription"
        ]);
    }

    protected function getTriggeringSubscription()
    {
        // This would need to be implemented based on your subscription system
        // For now, we'll return null - you'll need to implement this based on your actual subscription logic
        return null;
    }

    public static function createReferral(Partner $referrer, Partner $referred, ReferralCode $code): self
    {
        return self::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $referred->id,
            'referral_code_id' => $code->id,
            'status' => 'pending',
            'referred_at' => now(),
            'expires_at' => now()->addMonths(6), // Referrals expire in 6 months
            'metadata' => [
                'referrer_name' => $referrer->name,
                'referred_name' => $referred->name,
                'code_used' => $code->code
            ]
        ]);
    }

    public static function findByCode(string $code): ?self
    {
        $referralCode = ReferralCode::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$referralCode) {
            return null;
        }

        return self::where('referral_code_id', $referralCode->id)
            ->where('status', 'pending')
            ->first();
    }
}