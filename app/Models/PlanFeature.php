<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PlanFeature extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'type',
        'feature_for',
        'is_active',
        'is_popular',
        'sort_order',
        'icon',
        'color'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope for active features
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered features
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get all unique categories
     */
    public static function getCategories(): array
    {
        return self::distinct()->pluck('category')->toArray();
    }

    /**
     * Get features for specific target audience
     */
    public function scopeForTarget(Builder $query, string $target): Builder
    {
        return $query->where(function($q) use ($target) {
            $q->where('feature_for', $target)
              ->orWhere('feature_for', 'both');
        });
    }
}
