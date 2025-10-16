<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanFeature extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'type',
        'options',
        'unit',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];

    public function subscriptionPlans(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_features')
            ->withPivot(['is_enabled', 'value', 'limit_value', 'notes'])
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getFormattedValue($pivotValue = null): string
    {
        if ($this->type === 'boolean') {
            return $pivotValue ? 'Yes' : 'No';
        }

        if ($this->type === 'numeric' && $pivotValue) {
            $unit = $this->unit ? " {$this->unit}" : '';
            return $pivotValue . $unit;
        }

        if ($this->type === 'select' && $pivotValue) {
            $options = $this->options ?? [];
            return $options[$pivotValue] ?? $pivotValue;
        }

        return $pivotValue ?? 'Not set';
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function getCategoryDisplayName(): string
    {
        return match($this->category) {
            'dashboard' => 'Dashboard Features',
            'analytics' => 'Analytics & Reporting',
            'communication' => 'Communication',
            'storage' => 'Storage & Files',
            'users' => 'User Management',
            'api' => 'API & Integration',
            'support' => 'Support',
            'security' => 'Security',
            'customization' => 'Customization',
            default => ucfirst($this->category)
        };
    }

    public function getTypeDisplayName(): string
    {
        return match($this->type) {
            'boolean' => 'Yes/No',
            'numeric' => 'Number',
            'text' => 'Text',
            'select' => 'Selection',
            default => ucfirst($this->type)
        };
    }

    public static function getCategories(): array
    {
        return [
            'dashboard' => 'Dashboard Features',
            'analytics' => 'Analytics & Reporting',
            'communication' => 'Communication',
            'storage' => 'Storage & Files',
            'users' => 'User Management',
            'api' => 'API & Integration',
            'support' => 'Support',
            'security' => 'Security',
            'customization' => 'Customization',
            'general' => 'General'
        ];
    }

    public static function getTypes(): array
    {
        return [
            'boolean' => 'Yes/No Feature',
            'numeric' => 'Numeric Value',
            'text' => 'Text Value',
            'select' => 'Selection from Options'
        ];
    }
}