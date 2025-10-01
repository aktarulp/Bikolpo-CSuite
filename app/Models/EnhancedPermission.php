<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EnhancedPermission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'action',
        'resource',
        'group',
        'status',
        'is_system',
        'parent_permission_id',
        'created_by',
        'updated_by',
        'metadata'
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'metadata' => 'array',
    ];

    // Permission types
    const TYPE_VIEW = 'view';
    const TYPE_CREATE = 'create';
    const TYPE_EDIT = 'edit';
    const TYPE_DELETE = 'delete';
    const TYPE_EXECUTE = 'execute';
    const TYPE_APPROVE = 'approve';
    const TYPE_REJECT = 'reject';
    const TYPE_EXPORT = 'export';
    const TYPE_IMPORT = 'import';

    // Permission groups
    const GROUP_DASHBOARD = 'dashboard';
    const GROUP_USERS = 'users';
    const GROUP_ROLES = 'roles';
    const GROUP_PERMISSIONS = 'permissions';
    const GROUP_STUDENTS = 'students';
    const GROUP_COURSES = 'courses';
    const GROUP_EXAMS = 'exams';
    const GROUP_REPORTS = 'reports';
    const GROUP_SETTINGS = 'settings';
    const GROUP_SYSTEM = 'system';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Get the parent permission.
     */
    public function parentPermission(): BelongsTo
    {
        return $this->belongsTo(EnhancedPermission::class, 'parent_permission_id');
    }

    /**
     * Get the child permissions.
     */
    public function childPermissions()
    {
        return $this->hasMany(EnhancedPermission::class, 'parent_permission_id');
    }

    /**
     * Get the roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
                    EnhancedRole::class,
                    'role_permissions',
                    'enhanced_permission_id',
                    'enhanced_role_id'
                )
                    ->withPivot('granted_by', 'granted_at', 'expires_at')
                    ->withTimestamps();
    }

    /**
     * Get the users that have this permission directly.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EnhancedUser::class, 'user_permissions')
                    ->withPivot('granted_by', 'granted_at', 'expires_at')
                    ->withTimestamps();
    }

    /**
     * Get the creator of this permission.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(EnhancedUser::class, 'created_by');
    }

    /**
     * Scope a query to only include active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include system permissions.
     */
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope a query to only include permissions of a specific module.
     */
    public function scopeOfModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope a query to only include permissions of a specific group.
     */
    public function scopeOfGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope a query to only include permissions of a specific action.
     */
    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Get all child permissions recursively.
     */
    public function getAllChildPermissions()
    {
        $children = $this->childPermissions;
        $allChildren = collect();

        foreach ($children as $child) {
            $allChildren->push($child);
            $allChildren = $allChildren->merge($child->getAllChildPermissions());
        }

        return $allChildren;
    }

    /**
     * Get all parent permissions recursively.
     */
    public function getAllParentPermissions()
    {
        $parents = collect();
        $parent = $this->parentPermission;

        while ($parent) {
            $parents->push($parent);
            $parent = $parent->parentPermission;
        }

        return $parents;
    }

    /**
     * Check if permission is a child of another permission.
     */
    public function isChildOf($permissionId)
    {
        return $this->getAllParentPermissions()->contains('id', $permissionId);
    }

    /**
     * Check if permission is a parent of another permission.
     */
    public function isParentOf($permissionId)
    {
        return $this->getAllChildPermissions()->contains('id', $permissionId);
    }

    /**
     * Get the full permission name with module and action.
     */
    public function getFullNameAttribute()
    {
        return "{$this->module}.{$this->action}.{$this->resource}";
    }

    /**
     * Get the permission icon based on action type.
     */
    public function getIconAttribute()
    {
        $icons = [
            self::TYPE_VIEW => '👁️',
            self::TYPE_CREATE => '➕',
            self::TYPE_EDIT => '✏️',
            self::TYPE_DELETE => '🗑️',
            self::TYPE_EXECUTE => '▶️',
            self::TYPE_APPROVE => '✅',
            self::TYPE_REJECT => '❌',
            self::TYPE_EXPORT => '📤',
            self::TYPE_IMPORT => '📥',
        ];

        return $icons[$this->action] ?? '🔐';
    }

    /**
     * Get the permission color based on action type.
     */
    public function getColorAttribute()
    {
        $colors = [
            self::TYPE_VIEW => 'blue',
            self::TYPE_CREATE => 'green',
            self::TYPE_EDIT => 'yellow',
            self::TYPE_DELETE => 'red',
            self::TYPE_EXECUTE => 'purple',
            self::TYPE_APPROVE => 'emerald',
            self::TYPE_REJECT => 'rose',
            self::TYPE_EXPORT => 'indigo',
            self::TYPE_IMPORT => 'cyan',
        ];

        return $colors[$this->action] ?? 'gray';
    }

    /**
     * Get the permission badge HTML.
     */
    public function getBadgeAttribute()
    {
        $color = $this->color;
        $icon = $this->icon;
        
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800 dark:bg-{$color}-900 dark:text-{$color}-200\">{$icon} {$this->display_name}</span>";
    }

    /**
     * Create or get permission by name.
     */
    public static function findOrCreate($name, $displayName = null, $module = null, $action = null, $resource = null)
    {
        $permission = static::where('name', $name)->first();

        if (!$permission) {
            $permission = static::create([
                'name' => $name,
                'display_name' => $displayName ?? $name,
                'module' => $module ?? 'system',
                'action' => $action ?? 'view',
                'resource' => $resource ?? 'system',
                'status' => self::STATUS_ACTIVE,
                'is_system' => false,
                'created_by' => auth()->id(),
            ]);
        }

        return $permission;
    }

    /**
     * Get all permissions grouped by module.
     */
    public static function getGroupedByModule()
    {
        return static::active()
            ->orderBy('module')
            ->orderBy('action')
            ->orderBy('resource')
            ->get()
            ->groupBy('module');
    }

    /**
     * Get all permissions grouped by group.
     */
    public static function getGroupedByGroup()
    {
        return static::active()
            ->orderBy('group')
            ->orderBy('module')
            ->orderBy('action')
            ->orderBy('resource')
            ->get()
            ->groupBy('group');
    }

    /**
     * Get default system permissions.
     */
    public static function getDefaultSystemPermissions()
    {
        return [
            // Dashboard permissions
            [
                'name' => 'dashboard.view',
                'display_name' => 'View Dashboard',
                'module' => 'dashboard',
                'action' => 'view',
                'resource' => 'dashboard',
                'group' => self::GROUP_DASHBOARD,
                'is_system' => true,
            ],
            
            // User permissions
            [
                'name' => 'users.view',
                'display_name' => 'View Users',
                'module' => 'users',
                'action' => 'view',
                'resource' => 'users',
                'group' => self::GROUP_USERS,
                'is_system' => true,
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Create Users',
                'module' => 'users',
                'action' => 'create',
                'resource' => 'users',
                'group' => self::GROUP_USERS,
                'is_system' => true,
            ],
            [
                'name' => 'users.edit',
                'display_name' => 'Edit Users',
                'module' => 'users',
                'action' => 'edit',
                'resource' => 'users',
                'group' => self::GROUP_USERS,
                'is_system' => true,
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Delete Users',
                'module' => 'users',
                'action' => 'delete',
                'resource' => 'users',
                'group' => self::GROUP_USERS,
                'is_system' => true,
            ],
            
            // Role permissions
            [
                'name' => 'roles.view',
                'display_name' => 'View Roles',
                'module' => 'roles',
                'action' => 'view',
                'resource' => 'roles',
                'group' => self::GROUP_ROLES,
                'is_system' => true,
            ],
            [
                'name' => 'roles.create',
                'display_name' => 'Create Roles',
                'module' => 'roles',
                'action' => 'create',
                'resource' => 'roles',
                'group' => self::GROUP_ROLES,
                'is_system' => true,
            ],
            [
                'name' => 'roles.edit',
                'display_name' => 'Edit Roles',
                'module' => 'roles',
                'action' => 'edit',
                'resource' => 'roles',
                'group' => self::GROUP_ROLES,
                'is_system' => true,
            ],
            [
                'name' => 'roles.delete',
                'display_name' => 'Delete Roles',
                'module' => 'roles',
                'action' => 'delete',
                'resource' => 'roles',
                'group' => self::GROUP_ROLES,
                'is_system' => true,
            ],
            
            // Permission permissions
            [
                'name' => 'permissions.view',
                'display_name' => 'View Permissions',
                'module' => 'permissions',
                'action' => 'view',
                'resource' => 'permissions',
                'group' => self::GROUP_PERMISSIONS,
                'is_system' => true,
            ],
            [
                'name' => 'permissions.assign',
                'display_name' => 'Assign Permissions',
                'module' => 'permissions',
                'action' => 'assign',
                'resource' => 'permissions',
                'group' => self::GROUP_PERMISSIONS,
                'is_system' => true,
            ],
        ];
    }

    /**
     * Seed default system permissions.
     */
    public static function seedDefaultPermissions()
    {
        $defaultPermissions = self::getDefaultSystemPermissions();
        
        foreach ($defaultPermissions as $permission) {
            self::findOrCreate(
                $permission['name'],
                $permission['display_name'],
                $permission['module'],
                $permission['action'],
                $permission['resource']
            );
        }
    }
}
