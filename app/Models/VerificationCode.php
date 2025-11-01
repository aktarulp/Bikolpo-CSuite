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
        'phone',
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
     * Generate a new verification code for email
     */
    public static function generateCode(string $identifier, string $type = 'registration', string $identifierType = 'email'): self
    {
        // Delete any existing unused codes for this identifier and type
        $query = self::where('type', $type)
            ->where('used', false);
            
        if ($identifierType === 'email') {
            $query->where('email', $identifier);
        } else {
            $query->where('phone', $identifier);
        }
        
        $query->delete();

        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Set expiration to 10 minutes from now
        $expiresAt = Carbon::now()->addMinutes(10);

        $data = [
            'code' => $code,
            'expires_at' => $expiresAt,
            'type' => $type,
            'used' => false
        ];
        
        if ($identifierType === 'email') {
            $data['email'] = $identifier;
            $data['phone'] = null; // Ensure phone is null for email verification
        } else {
            $data['phone'] = $identifier;
            $data['email'] = null; // Ensure email is null for phone verification
        }

        return self::create($data);
    }

    /**
     * Verify a code for the given identifier
     */
    public static function verify(string $identifier, string $code, string $type = 'registration', string $identifierType = 'email'): ?self
    {
        $query = self::where('code', $code)
            ->where('type', $type)
            ->where('used', false);
            
        if ($identifierType === 'email') {
            $query->where('email', $identifier);
        } else {
            $query->where('phone', $identifier);
        }

        $verificationCode = $query->first();

        if ($verificationCode && $verificationCode->isValid()) {
            return $verificationCode;
        }

        return null;
    }
}