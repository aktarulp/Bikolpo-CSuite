<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ReferralCode extends Model
{
    protected $fillable = [
        'referrer_id',
        'code',
        'name',
        'description',
        'is_active',
        'max_uses',
        'used_count',
        'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime'
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'referrer_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function successfulReferrals(): HasMany
    {
        return $this->hasMany(Referral::class)->where('status', 'completed');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isMaxUsesReached(): bool
    {
        return $this->max_uses && $this->used_count >= $this->max_uses;
    }

    public function canBeUsed(): bool
    {
        return $this->is_active && !$this->isExpired() && !$this->isMaxUsesReached();
    }

    public function getUsagePercentage(): float
    {
        if (!$this->max_uses) {
            return 0;
        }
        
        return round(($this->used_count / $this->max_uses) * 100, 1);
    }

    public function getRemainingUses(): ?int
    {
        if (!$this->max_uses) {
            return null; // Unlimited
        }
        
        return max(0, $this->max_uses - $this->used_count);
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    public static function createForPartner(Partner $partner, array $options = []): self
    {
        $defaults = [
            'code' => self::generateUniqueCode(),
            'name' => $partner->name . ' Referral',
            'is_active' => true,
            'max_uses' => null, // Unlimited
        ];

        return $partner->referralCodes()->create(array_merge($defaults, $options));
    }
}