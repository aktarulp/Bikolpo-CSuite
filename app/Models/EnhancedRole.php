<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnhancedRole extends Model
{
    use HasFactory;

    protected $table = 'ac_roles';
    
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'level',
        'status',
        'is_system',
        'is_default',
        'parent_role_id',
        'inherit_permissions',
        'permissions_inheritance_mode',
        'created_by',
        'updated_by',
        'metadata'
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_default' => 'boolean',
        'inherit_permissions' => 'boolean',
        'metadata' => 'array',
    ];

    // Role levels (hierarchy)
    const LEVEL_SUPER_ADMIN = 1;
    const LEVEL_ADMIN = 2;
    const LEVEL_MANAGER = 3;
    const LEVEL_SUPERVISOR = 4;
    const LEVEL_STAFF = 5;
    const LEVEL_USER = 6;

    // Permission inheritance modes
    const INHERITANCE_MODE_NONE = 'none';
    const INHERITANCE_MODE_DIRECT = 'direct';
    const INHERITANCE_MODE_RECURSIVE = 'recursive';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Get the parent role.
     */
    public function parentRole(): BelongsTo
    {
        return $this->belongsTo(EnhancedRole::class, 'parent_role_id');
    }

    /**
     * Get the child roles.
     */
    public function childRoles(): HasMany
    {
        return $this->hasMany(EnhancedRole::class, 'parent_role_id');
    }

    /**
     * Get the permissions assigned to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
                    EnhancedPermission::class,
                    'ac_role_permissions',
                    'role_id',
                    'module_id'
                )
                    ->using(\App\Models\Pivots\RolePermission::class)
                    ->withPivot('module_name','can_create','can_read','can_update','can_delete','is_default','created_by','granted_by','granted_at','expires_at')
                    ->withTimestamps();
    }

    /**
     * Get the users that have this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EnhancedUser::class, 'ac_user_roles', 'role_id', 'user_id')
                    ->withPivot('assigned_by', 'assigned_at', 'expires_at')
                    ->withTimestamps();
    }

    /**
     * Get the creator of this role.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(EnhancedUser::class, 'created_by');
    }

    /**
     * Get the user who last updated this role.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(EnhancedUser::class, 'updated_by');
    }

    /**
     * Scope a query to only include active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include system roles.
     */
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope a query to only include default roles.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope a query to only include roles at or below a certain level.
     */
    public function scopeMaxLevel($query, $level)
    {
        return $query->where('level', '<=', $level);
    }

    /**
     * Scope a query to only include roles at or above a certain level.
     */
    public function scopeMinLevel($query, $level)
    {
        return $query->where('level', '>=', $level);
    }

    /**
     * Get all child roles recursively.
     */
    public function getAllChildRoles()
    {
        $children = $this->childRoles;
        $allChildren = collect();

        foreach ($children as $child) {
            $allChildren->push($child);
            $allChildren = $allChildren->merge($child->getAllChildRoles());
        }

        return $allChildren;
    }

    /**
     * Get all parent roles recursively.
     */
    public function getAllParentRoles()
    {
        $parents = collect();
        $parent = $this->parentRole;

        while ($parent) {
            $parents->push($parent);
            $parent = $parent->parentRole;
        }

        return $parents;
    }

    /**
     * Get all permissions including inherited ones.
     */
    public function getAllPermissions()
    {
        $permissions = $this->permissions;

        if ($this->inherit_permissions) {
            if ($this->permissions_inheritance_mode === self::INHERITANCE_MODE_DIRECT) {
                // Get permissions from direct parent only
                if ($this->parentRole) {
                    $permissions = $permissions->merge($this->parentRole->permissions);
                }
            } elseif ($this->permissions_inheritance_mode === self::INHERITANCE_MODE_RECURSIVE) {
                // Get permissions from all parent roles recursively
                $parentRoles = $this->getAllParentRoles();
                foreach ($parentRoles as $parentRole) {
                    $permissions = $permissions->merge($parentRole->permissions);
                }
            }
        }

        return $permissions->unique('id');
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->getAllPermissions()->contains('name', $permission);
        }
        
        if (is_int($permission)) {
            return $this->getAllPermissions()->contains('id', $permission);
        }

        return false;
    }

    /**
     * Check if role has a specific permission by ID.
     */
    public function hasPermissionById($permissionId): bool
    {
        return $this->getAllPermissions()->contains('id', $permissionId);
    }

    /**
     * Grant a permission to this role.
     */
    public function grantPermission($permission, $grantedBy = null, $expiresAt = null)
    {
        return $this->grantPermissionWithCrud($permission, [], $grantedBy, $expiresAt);
    }

    /**
     * Grant a permission to this role with optional CRUD flags.
     */
    public function grantPermissionWithCrud($permission, array $crudFlags = [], $grantedBy = null, $expiresAt = null)
    {
        if (is_string($permission)) {
            $permission = EnhancedPermission::where('module_name', $permission)->first();
        }

        if (!$permission) {
            return false;
        }

        $pivot = [
            'module_name' => $permission->module_name,
            'granted_by' => $grantedBy ?? auth()->id(),
            'granted_at' => now(),
            'expires_at' => $expiresAt,
        ];
        $pivot = array_merge($pivot, $this->normalizeCrudFlags($crudFlags));

        return $this->permissions()->attach($permission->id, $pivot);
    }

    /**
     * Revoke a permission from this role.
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = EnhancedPermission::where('module_name', $permission)->first();
        }

        if (!$permission) {
            return false;
        }

        return $this->permissions()->detach($permission->id);
    }

    /**
     * Sync permissions for this role.
     */
    public function syncPermissions($permissions, $grantedBy = null)
    {
        $permissionRecords = [];
        
        foreach ($permissions as $permission) {
            if (is_string($permission)) {
                $perm = EnhancedPermission::where('module_name', $permission)->first();
                if ($perm) {
                    $permissionRecords[$perm->id] = $perm->module_name;
                }
            } elseif (is_int($permission)) {
                $perm = EnhancedPermission::find($permission);
                if ($perm) {
                    $permissionRecords[$perm->id] = $perm->module_name;
                }
            }
        }

        $syncData = [];
        foreach ($permissionRecords as $permissionId => $moduleName) {
            $syncData[$permissionId] = [
                'module_name' => $moduleName,
                'granted_by' => $grantedBy ?? auth()->id(),
                'granted_at' => now(),
            ];
        }

        return $this->permissions()->sync($syncData);
    }

    /**
     * Sync permissions with CRUD flags. Accepts an associative array where key is permission id or name,
     * and value is an array like ['create' => bool, 'read' => bool, 'update' => bool, 'delete' => bool, 'is_default' => bool].
     */
    public function syncPermissionsWithCrud(array $permissionFlags, $grantedBy = null)
    {
        $syncData = [];

        foreach ($permissionFlags as $key => $flags) {
            $permissionId = null;
            $permModel = null;
            if (is_int($key)) {
                $permissionId = $key;
                $permModel = EnhancedPermission::find($permissionId);
            } elseif (is_string($key)) {
                $permModel = EnhancedPermission::where('module_name', $key)->first();
                if ($permModel) { $permissionId = $permModel->id; }
            }
            if (!$permissionId || !$permModel) { continue; }

            $syncData[$permissionId] = array_merge([
                'module_name' => $permModel->module_name,
                'granted_by' => $grantedBy ?? auth()->id(),
                'granted_at' => now(),
            ], $this->normalizeCrudFlags($flags));
        }

        if (empty($syncData)) {
            return false;
        }

        return $this->permissions()->sync($syncData);
    }

    /**
     * Ensure CRUD flags are in expected keys and normalized to 'Y'/'N' via pivot mutators.
     */
    protected function normalizeCrudFlags(array $flags): array
    {
        // Map common aliases to our pivot attributes
        $map = [
            'create' => 'can_create',
            'read' => 'can_read',
            'view' => 'can_read',
            'update' => 'can_update',
            'edit' => 'can_update',
            'delete' => 'can_delete',
            'remove' => 'can_delete',
            'is_default' => 'is_default',
            'default' => 'is_default',
        ];
        $out = [];
        foreach ($flags as $k => $v) {
            $k = strtolower((string)$k);
            if (isset($map[$k])) {
                $out[$map[$k]] = $v;
            } elseif (in_array($k, ['can_create','can_read','can_update','can_delete','is_default'], true)) {
                $out[$k] = $v;
            }
        }
        return $out;
    }

    /**
     * Check if role is a child of another role.
     */
    public function isChildOf($roleId)
    {
        return $this->getAllParentRoles()->contains('id', $roleId);
    }

    /**
     * Check if role is a parent of another role.
     */
    public function isParentOf($roleId)
    {
        return $this->getAllChildRoles()->contains('id', $roleId);
    }

    /**
     * Check if role can manage another role (higher level).
     */
    public function canManageRole($role)
    {
        if (is_int($role)) {
            $targetRole = static::find($role);
        } else {
            $targetRole = $role;
        }

        return $targetRole && $this->level < $targetRole->level;
    }

    /**
     * Get the role level badge HTML.
     */
    public function getLevelBadgeAttribute()
    {
        $badges = [
            self::LEVEL_SUPER_ADMIN => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">👑 Super Admin</span>',
            self::LEVEL_ADMIN => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">🔴 Admin</span>',
            self::LEVEL_MANAGER => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">🟠 Manager</span>',
            self::LEVEL_SUPERVISOR => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">🟡 Supervisor</span>',
            self::LEVEL_STAFF => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">🟢 Staff</span>',
            self::LEVEL_USER => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">🔵 User</span>',
        ];

        return $badges[$this->level] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">⚪ Unknown</span>';
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_ACTIVE => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">🟢 Active</span>',
            self::STATUS_INACTIVE => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">⚪ Inactive</span>',
        ];

        return $badges[$this->status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">⚪ Unknown</span>';
    }

    /**
     * Get the inheritance mode badge HTML.
     */
    public function getInheritanceModeBadgeAttribute()
    {
        if (!$this->inherit_permissions) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">🚫 No Inheritance</span>';
        }

        $badges = [
            self::INHERITANCE_MODE_DIRECT => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">📋 Direct</span>',
            self::INHERITANCE_MODE_RECURSIVE => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">🔄 Recursive</span>',
        ];

        return $badges[$this->permissions_inheritance_mode] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">⚪ Unknown</span>';
    }

    /**
     * Create or get role by name.
     */
    public static function findOrCreate($name, $displayName = null, $level = null)
    {
        $role = static::where('name', $name)->first();

        if (!$role) {
            $role = static::create([
                'name' => $name,
                'display_name' => $displayName ?? $name,
                'level' => $level ?? self::LEVEL_USER,
                'status' => self::STATUS_ACTIVE,
                'is_system' => false,
                'is_default' => false,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
                'created_by' => auth()->id(),
            ]);
        }

        return $role;
    }

    /**
     * Get all roles grouped by level.
     */
    public static function getGroupedByLevel()
    {
        return static::active()
            ->orderBy('level')
            ->orderBy('name')
            ->get()
            ->groupBy('level');
    }

    /**
     * Get default system roles.
     */
    public static function getDefaultSystemRoles()
    {
        return [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Administrator',
                'description' => 'System super administrator with full access',
                'level' => self::LEVEL_SUPER_ADMIN,
                'is_system' => true,
                'is_default' => false,
                'inherit_permissions' => false,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_NONE,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'System administrator with extensive access',
                'level' => self::LEVEL_ADMIN,
                'is_system' => true,
                'is_default' => false,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Department manager with team management access',
                'level' => self::LEVEL_MANAGER,
                'is_system' => true,
                'is_default' => false,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
            ],
            [
                'name' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Team supervisor with limited management access',
                'level' => self::LEVEL_SUPERVISOR,
                'is_system' => true,
                'is_default' => false,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Regular staff member with basic access',
                'level' => self::LEVEL_STAFF,
                'is_system' => true,
                'is_default' => true,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Basic user with minimal access',
                'level' => self::LEVEL_USER,
                'is_system' => true,
                'is_default' => true,
                'inherit_permissions' => true,
                'permissions_inheritance_mode' => self::INHERITANCE_MODE_RECURSIVE,
            ],
        ];
    }

    /**
     * Seed default system roles.
     */
    public static function seedDefaultRoles()
    {
        $defaultRoles = self::getDefaultSystemRoles();
        
        foreach ($defaultRoles as $role) {
            self::findOrCreate(
                $role['name'],
                $role['display_name'],
                $role['level']
            )->update([
                'description' => $role['description'],
                'is_system' => $role['is_system'],
                'is_default' => $role['is_default'],
                'inherit_permissions' => $role['inherit_permissions'],
                'permissions_inheritance_mode' => $role['permissions_inheritance_mode'],
            ]);
        }
    }

    /**
     * Get role hierarchy as a tree structure.
     */
    public static function getRoleHierarchy()
    {
        $roles = static::active()->orderBy('level')->get();
        $tree = [];

        foreach ($roles as $role) {
            if (!$role->parent_role_id) {
                $tree[] = $role;
                $role->children = $role->getAllChildRoles();
            }
        }

        return $tree;
    }
}
