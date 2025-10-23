<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'type',
        'provider_name',
        'branch_name',
        'account_number',
        'account_title',
        'routing_number'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the display name for the payment method
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->type === 'Cash') {
            return 'Cash Payment';
        }
        
        if ($this->type === 'MFS') {
            return $this->provider_name ?? 'Mobile Financial Service';
        }
        
        if ($this->type === 'Bank') {
            $name = $this->provider_name ?? 'Bank';
            if ($this->branch_name) {
                $name .= ' - ' . $this->branch_name;
            }
            return $name;
        }
        
        return 'Unknown Payment Method';
    }

    /**
     * Get formatted account information
     */
    public function getFormattedAccountAttribute(): string
    {
        if ($this->type === 'Cash') {
            return 'Cash Payment';
        }
        
        $info = [];
        
        if ($this->account_title) {
            $info[] = $this->account_title;
        }
        
        if ($this->account_number) {
            $info[] = 'A/C: ' . $this->account_number;
        }
        
        if ($this->routing_number) {
            $info[] = 'Routing: ' . $this->routing_number;
        }
        
        return implode(' | ', $info) ?: 'No account details';
    }

    /**
     * Scope for Bank payment methods
     */
    public function scopeBank($query)
    {
        return $query->where('type', 'Bank');
    }

    /**
     * Scope for MFS payment methods
     */
    public function scopeMfs($query)
    {
        return $query->where('type', 'MFS');
    }

    /**
     * Scope for Cash payment methods
     */
    public function scopeCash($query)
    {
        return $query->where('type', 'Cash');
    }
}
