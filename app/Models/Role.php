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
        'display_name',
        'description',
        'level',
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
        return $this->hasMany(User::class, 'role_id');
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
     * Check if this role is a parent of another role
     */
    public function isParentOf(Role $role): bool
    {
        return $this->id === $role->parent_role_id;
    }

    /**
     * Check if this role is a child of another role
     */
    public function isChildOf(Role $role): bool
    {
        return $this->parent_role_id === $role->id;
    }

    /**
     * Get all descendant roles (children, grandchildren, etc.)
     */
    public function getDescendants()
    {
        $descendants = collect();
        
        foreach ($this->childRoles as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getDescendants());
        }
        
        return $descendants;
    }

    /**
     * Get all ancestor roles (parent, grandparent, etc.)
     */
    public function getAncestors()
    {
        $ancestors = collect();
        
        if ($this->parentRole) {
            $ancestors->push($this->parentRole);
            $ancestors = $ancestors->merge($this->parentRole->getAncestors());
        }
        
        return $ancestors;
    }

    /**
     * Check if this role can manage another role
     */
    public function canManageRole(Role $role): bool
    {
        // System Administrator can manage all roles
        if ($this->name === 'system_administrator') {
            return true;
        }

        // Partner Admin can manage roles 3, 4, 5 (Student, Teacher, Operator)
        if ($this->name === 'partner_admin') {
            return in_array($role->level, [3, 4, 5]);
        }

        // Other roles cannot manage roles
        return false;
    }

    /**
     * Get roles that this role can manage
     */
    public function getManageableRoles()
    {
        if ($this->name === 'system_administrator') {
            return Role::all();
        }

        if ($this->name === 'partner_admin') {
            return Role::whereIn('level', [3, 4, 5])->get();
        }

        return collect();
    }

    /**
     * Scope for active roles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
