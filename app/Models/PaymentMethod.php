<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'provider', 'account_number', 'account_title',
        'branch_name', 'routing_number', 'configuration', 'is_active',
        'is_popular', 'requires_verification', 'sort_order'
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'requires_verification' => 'boolean',
    ];

    /**
     * Get payment method types
     */
    public static function getTypes(): array
    {
        return [
            'card' => 'Credit/Debit Card',
            'bank' => 'Bank Transfer',
            'mobile' => 'Mobile Banking',
            'digital_wallet' => 'Digital Wallet',
            'crypto' => 'Cryptocurrency',
            'cash' => 'Cash Payment',
            'check' => 'Check Payment',
        ];
    }

    /**
     * Get payment method providers by type
     */
    public static function getProvidersByType(string $type): array
    {
        return match($type) {
            'card' => [
                'visa' => 'Visa',
                'mastercard' => 'Mastercard',
                'amex' => 'American Express',
                'discover' => 'Discover',
                'jcb' => 'JCB',
                'diners' => 'Diners Club',
            ],
            'mobile' => [
                'bkash' => 'bKash',
                'rocket' => 'Rocket',
                'nagad' => 'Nagad',
                'upay' => 'Upay',
                'tap' => 'Tap',
            ],
            'bank' => [
                'sbl' => 'Sonali Bank',
                'janata' => 'Janata Bank',
                'agrani' => 'Agrani Bank',
                'brac' => 'BRAC Bank',
                'city' => 'City Bank',
                'dhaka' => 'Dhaka Bank',
                'eastern' => 'Eastern Bank',
                'islami' => 'Islami Bank',
                'prime' => 'Prime Bank',
                'southeast' => 'Southeast Bank',
            ],
            'digital_wallet' => [
                'paypal' => 'PayPal',
                'stripe' => 'Stripe',
                'razorpay' => 'Razorpay',
                'square' => 'Square',
                'skrill' => 'Skrill',
                'neteller' => 'Neteller',
            ],
            'crypto' => [
                'bitcoin' => 'Bitcoin',
                'ethereum' => 'Ethereum',
                'litecoin' => 'Litecoin',
                'bitcoin_cash' => 'Bitcoin Cash',
                'ripple' => 'Ripple',
            ],
            default => []
        };
    }

    /**
     * Get supported currencies
     */
    public static function getSupportedCurrencies(): array
    {
        return [
            'BDT' => 'Bangladeshi Taka',
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'JPY' => 'Japanese Yen',
            'CAD' => 'Canadian Dollar',
            'AUD' => 'Australian Dollar',
            'INR' => 'Indian Rupee',
        ];
    }

    /**
     * Scope for active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular payment methods
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope for ordered payment methods
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get formatted processing fee
     */
    public function getFormattedProcessingFee(): string
    {
        $fee = '';
        
        if ($this->processing_fee_percentage > 0) {
            $fee .= $this->processing_fee_percentage . '%';
        }
        
        if ($this->processing_fee_fixed > 0) {
            if ($fee) $fee .= ' + ';
            $fee .= '৳' . number_format($this->processing_fee_fixed, 2);
        }
        
        return $fee ?: 'No fee';
    }

    /**
     * Get formatted amount limits
     */
    public function getFormattedAmountLimits(): string
    {
        $limits = [];
        
        if ($this->min_amount > 0) {
            $limits[] = 'Min: ৳' . number_format($this->min_amount);
        }
        
        if ($this->max_amount) {
            $limits[] = 'Max: ৳' . number_format($this->max_amount);
        }
        
        return implode(', ', $limits) ?: 'No limits';
    }

    /**
     * Check if payment method supports currency
     */
    public function supportsCurrency(string $currency): bool
    {
        if (!$this->supported_currencies) {
            return true; // No restrictions
        }
        
        return in_array($currency, $this->supported_currencies);
    }

    /**
     * Get display name with provider
     */
    public function getDisplayName(): string
    {
        if ($this->provider) {
            return $this->name . ' (' . $this->provider . ')';
        }
        
        return $this->name;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor(): string
    {
        return $this->is_active ? 'green' : 'red';
    }

    /**
     * Get type badge color
     */
    public function getTypeBadgeColor(): string
    {
        return match($this->type) {
            'card' => 'blue',
            'bank' => 'green',
            'mobile' => 'purple',
            'digital_wallet' => 'orange',
            'crypto' => 'yellow',
            'cash' => 'gray',
            'check' => 'indigo',
            default => 'gray',
        };
    }
}
