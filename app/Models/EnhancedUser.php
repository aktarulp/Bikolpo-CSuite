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

class EnhancedUser extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
        'metadata',
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
     * Role checking disabled - always returns true.
     */
    public function hasRole($role): bool
    {
        return true;
    }

    /**
     * Check if user has any of the given roles.
     * Role checking disabled - always returns true.
     */
    public function hasAnyRole($roles): bool
    {
        return true;
    }

    /**
     * Check if user has all of the given roles.
     * Role checking disabled - always returns true.
     */
    public function hasAllRoles($roles): bool
    {
        return true;
    }

    /**
     * Check if user has a specific permission.
     * Permission checking disabled - always returns true.
     */
    public function hasPermission($permission): bool
    {
        return true;
    }

    /**
     * Check if user has permission through roles.
     * Permission checking disabled - always returns true.
     */
    public function hasPermissionThroughRole($permission): bool
    {
        return true;
    }

    /**
     * Check if user has permission through roles by ID.
     * Permission checking disabled - always returns true.
     */
    public function hasPermissionThroughRoleById($permissionId): bool
    {
        return true;
    }

    /**
     * Assign a role to the user with additional metadata.
     * Role assignment disabled - always returns true.
     */
    public function assignRoleWithMetadata($role, $assignedBy = null, $expiresAt = null)
    {
        return true;
    }

    /**
     * Remove a role from the user.
     * Role removal disabled - always returns true.
     */
    public function removeRoleWithMetadata($role)
    {
        return true;
    }


    /**
     * Get all permissions (direct + through roles).
     * Permission checking disabled - returns empty collection.
     */
    public function getAllPermissions()
    {
        return collect([]);
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
     * Role level checking disabled - returns null.
     */
    public function getHighestRoleLevel(): ?int
    {
        return null;
    }

    /**
     * Get the user's highest role (lowest level number).
     * Role checking disabled - returns null.
     */
    public function getHighestRole(): ?EnhancedRole
    {
        return null;
    }

    /**
     * Check if user can view roles of the given level or higher.
     * Role level checking disabled - always returns true.
     */
    public function canViewRole(int $roleLevel): bool
    {
        return true;
    }

    /**
     * Laravel's authorization method - check if user can perform an action.
     * Permission checking disabled - always returns true.
     */
    public function can($ability, $arguments = []): bool
    {
        return true;
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
