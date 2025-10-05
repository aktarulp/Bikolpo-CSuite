<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class EnhancedUser extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $table = 'ac_users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'status',
        'flag',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'partner_id',
        'role',
        'role_id',
        'created_by',
        'updated_by',
        'preferences',
        'metadata'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'preferences' => 'array',
        'metadata' => 'array',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_PENDING = 'pending';

    // Flag constants
    const FLAG_ACTIVE = 'active';
    const FLAG_INACTIVE = 'inactive';
    const FLAG_DELETED = 'deleted';

    // User type constants
    const TYPE_ADMIN = 'admin';
    const TYPE_PARTNER = 'partner';
    const TYPE_STAFF = 'staff';
    const TYPE_STUDENT = 'student';

    /**
     * Get the partner that owns the user.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(EnhancedRole::class, 'ac_user_roles', 'user_id', 'role_id')
                    ->withPivot('assigned_by', 'assigned_at', 'expires_at')
                    ->withTimestamps();
    }

    // Direct user permissions removed - using role-based permissions only
    // Permissions are now accessed through: user → roles → role_permissions → permissions

    /**
     * Get the user activities.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Get users created by this user.
     */
    public function createdUsers(): HasMany
    {
        return $this->hasMany(EnhancedUser::class, 'created_by');
    }

    /**
     * Get the creator of this user.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(EnhancedUser::class, 'created_by');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }
        
        if (is_int($role)) {
            return $this->roles()->where('id', $role)->exists();
        }

        return false;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        $userRoles = $this->roles()->pluck('name')->toArray();
        return empty(array_diff($roles, $userRoles));
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->hasPermissionThroughRole($permission);
        }
        
        if (is_int($permission)) {
            return $this->hasPermissionThroughRoleById($permission);
        }

        return false;
    }

    /**
     * Check if user has permission through roles.
     */
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has permission through roles by ID.
     */
    public function hasPermissionThroughRoleById($permissionId): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermissionById($permissionId)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Assign a role to the user with additional metadata.
     * Note: This conflicts with Spatie's assignRole, so we'll use a different name.
     */
    public function assignRoleWithMetadata($role, $assignedBy = null, $expiresAt = null)
    {
        if (is_string($role)) {
            $role = \App\Models\EnhancedRole::where('name', $role)->first();
        }

        if (!$role) {
            return false;
        }

        return $this->roles()->attach($role->id, [
            'assigned_by' => $assignedBy ?? auth()->id(),
            'assigned_at' => now(),
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Remove a role from the user.
     * Note: This conflicts with Spatie's methods, using different name.
     */
    public function removeRoleWithMetadata($role)
    {
        if (is_string($role)) {
            $role = \App\Models\EnhancedRole::where('name', $role)->first();
        }

        if (!$role) {
            return false;
        }

        return $this->roles()->detach($role->id);
    }

    /**
     * Grant a permission to the user.
     */
    public function grantPermission($permission, $grantedBy = null, $expiresAt = null)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if (!$permission) {
            return false;
        }

        return $this->permissions()->attach($permission->id, [
            'granted_by' => $grantedBy ?? auth()->id(),
            'granted_at' => now(),
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Revoke a permission from the user.
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if (!$permission) {
            return false;
        }

        return $this->permissions()->detach($permission->id);
    }

    /**
     * Get all permissions (direct + through roles).
     */
    public function getAllPermissions()
    {
        $rolePermissions = $this->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');

        return $rolePermissions;
    }

    /**
     * Get avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7C3AED&background=EEF2FF';
    }

    /**
     * Log user activity.
     */
    public function logActivity($action, $description = null, $metadata = [])
    {
        return $this->activities()->create([
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include users of a given partner.
     */
    public function scopeOfPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    /**
     * Get the user's highest role level (lowest number = highest privilege).
     */
    public function getHighestRoleLevel(): ?int
    {
        return $this->roles()->min('level');
    }

    /**
     * Get the user's highest role (lowest level number).
     */
    public function getHighestRole(): ?EnhancedRole
    {
        return $this->roles()->orderBy('level')->first();
    }

    /**
     * Check if user can view roles of the given level or higher.
     * Users can only view roles with level >= their own role level.
     */
    public function canViewRole(int $roleLevel): bool
    {
        $userLevel = $this->getHighestRoleLevel();
        return $userLevel !== null && $roleLevel >= $userLevel;
    }

    /**
     * Laravel's authorization method - check if user can perform an action.
     */
    public function can($ability, $arguments = []): bool
    {
        // If it's a permission check, use our custom permission system
        if (is_string($ability)) {
            return $this->hasPermission($ability);
        }
        
        // Fall back to Laravel's default authorization
        return parent::can($ability, $arguments);
    }

    /**
     * Get all available user statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_SUSPENDED,
            self::STATUS_PENDING,
        ];
    }

    /**
     * Get all available user flags.
     */
    public static function getFlags(): array
    {
        return [
            self::FLAG_ACTIVE,
            self::FLAG_INACTIVE,
            self::FLAG_DELETED,
        ];
    }

    /**
     * Check if user flag is active.
     */
    public function isFlagActive(): bool
    {
        return $this->flag === self::FLAG_ACTIVE;
    }

    /**
     * Check if user flag is inactive.
     */
    public function isFlagInactive(): bool
    {
        return $this->flag === self::FLAG_INACTIVE;
    }

    /**
     * Check if user flag is deleted.
     */
    public function isFlagDeleted(): bool
    {
        return $this->flag === self::FLAG_DELETED;
    }

    /**
     * Scope a query to only include users with active flag.
     */
    public function scopeFlagActive($query)
    {
        return $query->where('flag', self::FLAG_ACTIVE);
    }

    /**
     * Scope a query to only include users with inactive flag.
     */
    public function scopeFlagInactive($query)
    {
        return $query->where('flag', self::FLAG_INACTIVE);
    }

    /**
     * Scope a query to exclude deleted users.
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('flag', '!=', self::FLAG_DELETED);
    }

    /**
     * Soft delete user by setting flag to deleted.
     */
    public function softDelete()
    {
        return $this->update(['flag' => self::FLAG_DELETED]);
    }

    /**
     * Restore soft deleted user by setting flag to active.
     */
    public function restore()
    {
        return $this->update(['flag' => self::FLAG_ACTIVE]);
    }
}
