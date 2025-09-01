<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'parent_role_id',
        'permissions',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'permissions' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the parent role
     */
    public function parentRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'parent_role_id');
    }

    /**
     * Get child roles
     */
    public function childRoles(): HasMany
    {
        return $this->hasMany(Role::class, 'parent_role_id');
    }

    /**
     * Get users with this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the creator of this role
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the updater of this role
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Check if role has specific permission
     */
    public function hasPermission(string $module, string $action): bool
    {
        if (!isset($this->permissions[$module])) {
            return false;
        }

        $modulePermissions = $this->permissions[$module];
        
        if ($action === 'full') {
            return in_array('full', $modulePermissions);
        } elseif ($action === 'limited') {
            return in_array('limited', $modulePermissions) || in_array('full', $modulePermissions);
        } elseif ($action === 'read') {
            return in_array('read', $modulePermissions) || in_array('limited', $modulePermissions) || in_array('full', $modulePermissions);
        }

        return false;
    }

    /**
     * Get all permissions for a module
     */
    public function getModulePermissions(string $module): array
    {
        return $this->permissions[$module] ?? [];
    }

    /**
     * Scope for active roles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
