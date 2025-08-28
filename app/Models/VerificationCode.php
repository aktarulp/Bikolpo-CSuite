<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'type',
        'used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean'
    ];

    /**
     * Check if the verification code is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the verification code is valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->used;
    }

    /**
     * Mark the verification code as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Generate a new verification code
     */
    public static function generateCode(string $email, string $type = 'registration'): self
    {
        // Delete any existing unused codes for this email and type
        self::where('email', $email)
            ->where('type', $type)
            ->where('used', false)
            ->delete();

        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Set expiration to 10 minutes from now
        $expiresAt = Carbon::now()->addMinutes(10);

        return self::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => $expiresAt,
            'type' => $type,
            'used' => false
        ]);
    }

    /**
     * Verify a code for the given email
     */
    public static function verify(string $email, string $code, string $type = 'registration'): ?self
    {
        $verificationCode = self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('used', false)
            ->first();

        if ($verificationCode && $verificationCode->isValid()) {
            return $verificationCode;
        }

        return null;
    }
}
