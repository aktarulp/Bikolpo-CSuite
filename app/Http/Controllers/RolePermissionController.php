<?php

namespace App\Http\Controllers;

use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use App\Models\EnhancedUser;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{
    /**
     * Display the role and permission management dashboard.
     */
    public function index()
    {
        $this->authorize('viewAny', EnhancedRole::class);

        $roles = EnhancedRole::with(['permissions', 'users', 'parentRole', 'childRoles'])
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        $permissions = EnhancedPermission::with(['roles'])
            ->orderBy('module')
            ->orderBy('name')
            ->get();

        $stats = [
            'total_roles' => $roles->count(),
            'active_roles' => $roles->where('status', 'active')->count(),
            'total_permissions' => $permissions->count(),
            'permission_modules' => $permissions->pluck('module')->unique()->count(),
            'roles_by_level' => $roles->groupBy('level')->map->count()->toArray(),
            'permissions_by_module' => $permissions->groupBy('module')->map->count()->toArray(),
        ];

        return view('partner.settings.role-permission-management', compact('roles', 'permissions', 'stats'));
    }

    /**
     * Get the permission grid data.
     */
    public function getPermissionGrid()
    {
        $this->authorize('viewPermissionGrid', EnhancedRole::class);

        $cacheKey = 'permission_grid_data';
        $gridData = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            $roles = EnhancedRole::active()
                ->orderBy('level')
                ->orderBy('name')
                ->get(['id', 'name', 'display_name', 'level']);

            $permissions = EnhancedPermission::active()
                ->orderBy('module')
                ->orderBy('name')
                ->get(['id', 'name', 'display_name', 'description', 'module']);

            $rolePermissions = DB::table('role_permissions')
                ->get(['role_id', 'permission_id'])
                ->groupBy('role_id')
                ->map(function ($items) {
                    return $items->pluck('permission_id')->toArray();
                })
                ->toArray();

            $grid = [];
            foreach ($permissions as $permission) {
                if (!isset($grid[$permission->module])) {
                    $grid[$permission->module] = [];
                }
                
                $grid[$permission->module][] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'display_name' => $permission->display_name,
                    'description' => $permission->description,
                    'role_permissions' => $rolePermissions,
                ];
            }

            return [
                'roles' => $roles,
                'permissions' => $grid,
                'role_permissions' => $rolePermissions,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $gridData
        ]);
    }

    /**
     * Bulk update role permissions.
     */
    public function bulkUpdatePermissions(Request $request)
    {
        $this->authorize('updatePermissions', EnhancedRole::class);

        $validator = Validator::make($request->all(), [
            'changes' => 'required|array',
            'changes.*' => 'required|array',
            'changes.*.*' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $changes = $request->changes;
            $updatedCount = 0;
            $activityLogs = [];

            foreach ($changes as $roleId => $permissionChanges) {
                $role = EnhancedRole::findOrFail($roleId);
                
                // Get current permissions for this role
                $currentPermissions = $role->permissions()->pluck('permissions.id')->toArray();
                
                // Calculate changes
                $permissionsToAdd = [];
                $permissionsToRemove = [];
                
                foreach ($permissionChanges as $permissionId => $granted) {
                    if ($granted && !in_array($permissionId, $currentPermissions)) {
                        $permissionsToAdd[] = $permissionId;
                    } elseif (!$granted && in_array($permissionId, $currentPermissions)) {
                        $permissionsToRemove[] = $permissionId;
                    }
                }

                // Add new permissions
                if (!empty($permissionsToAdd)) {
                    $role->permissions()->attach($permissionsToAdd, [
                        'granted_by' => auth()->id(),
                        'granted_at' => now(),
                    ]);
                    $updatedCount += count($permissionsToAdd);
                    
                    $activityLogs[] = [
                        'role_id' => $roleId,
                        'action' => 'permissions_added',
                        'description' => "Added " . count($permissionsToAdd) . " permissions to role {$role->name}",
                        'metadata' => [
                            'permissions_added' => $permissionsToAdd,
                            'added_by' => auth()->id(),
                        ],
                    ];
                }

                // Remove permissions
                if (!empty($permissionsToRemove)) {
                    $role->permissions()->detach($permissionsToRemove);
                    $updatedCount += count($permissionsToRemove);
                    
                    $activityLogs[] = [
                        'role_id' => $roleId,
                        'action' => 'permissions_removed',
                        'description' => "Removed " . count($permissionsToRemove) . " permissions from role {$role->name}",
                        'metadata' => [
                            'permissions_removed' => $permissionsToRemove,
                            'removed_by' => auth()->id(),
                        ],
                    ];
                }
            }

            // Log activities
            foreach ($activityLogs as $log) {
                UserActivity::create([
                    'user_id' => auth()->id(),
                    'action' => $log['action'],
                    'description' => $log['description'],
                    'metadata' => $log['metadata'],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            // Clear cache
            Cache::forget('permission_grid_data');
            Cache::forget('user_permissions_' . auth()->id());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} permissions",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk permission update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get role hierarchy data.
     */
    public function getHierarchy()
    {
        $this->authorize('viewHierarchy', EnhancedRole::class);

        $cacheKey = 'role_hierarchy_data';
        $hierarchyData = Cache::remember($cacheKey, now()->addHours(1), function () {
            $roles = EnhancedRole::active()
                ->with(['parentRole', 'childRoles', 'users'])
                ->orderBy('level')
                ->get();

            $tree = $this->buildHierarchyTree($roles);
            $stats = $this->calculateHierarchyStats($roles);

            return [
                'tree' => $tree,
                'stats' => $stats,
                'flat_list' => $roles,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $hierarchyData
        ]);
    }

    /**
     * Build hierarchy tree structure.
     */
    private function buildHierarchyTree($roles)
    {
        $tree = [];
        $roleMap = [];

        // Create role map
        foreach ($roles as $role) {
            $roleMap[$role->id] = [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'level' => $role->level,
                'user_count' => $role->users->count(),
                'permission_count' => $role->permissions->count(),
                'children' => [],
                'parent_id' => $role->parent_role_id,
            ];
        }

        // Build tree structure
        foreach ($roles as $role) {
            if ($role->parent_role_id && isset($roleMap[$role->parent_role_id])) {
                $roleMap[$role->parent_role_id]['children'][] = &$roleMap[$role->id];
            } elseif (!$role->parent_role_id) {
                $tree[] = &$roleMap[$role->id];
            }
        }

        return $tree;
    }

    /**
     * Calculate hierarchy statistics.
     */
    private function calculateHierarchyStats($roles)
    {
        $totalRoles = $roles->count();
        $rootRoles = $roles->where('parent_role_id', null)->count();
        $maxDepth = $this->calculateMaxDepth($roles);
        $totalUsers = $roles->sum(function ($role) {
            return $role->users->count();
        });
        $totalPermissions = $roles->sum(function ($role) {
            return $role->permissions->count();
        });

        $rolesByLevel = $roles->groupBy('level')->map->count()->toArray();
        $usersByLevel = $roles->groupBy('level')->map(function ($group) {
            return $group->sum(function ($role) {
                return $role->users->count();
            });
        })->toArray();

        return [
            'total_roles' => $totalRoles,
            'root_roles' => $rootRoles,
            'max_depth' => $maxDepth,
            'total_users' => $totalUsers,
            'total_permissions' => $totalPermissions,
            'roles_by_level' => $rolesByLevel,
            'users_by_level' => $usersByLevel,
            'average_users_per_role' => $totalRoles > 0 ? round($totalUsers / $totalRoles, 2) : 0,
            'average_permissions_per_role' => $totalRoles > 0 ? round($totalPermissions / $totalRoles, 2) : 0,
        ];
    }

    /**
     * Calculate maximum depth of hierarchy.
     */
    private function calculateMaxDepth($roles)
    {
        $maxDepth = 0;
        $visited = [];

        foreach ($roles as $role) {
            if (!isset($visited[$role->id])) {
                $depth = $this->getRoleDepth($role, $roles, $visited);
                $maxDepth = max($maxDepth, $depth);
            }
        }

        return $maxDepth;
    }

    /**
     * Get depth of a specific role in hierarchy.
     */
    private function getRoleDepth($role, $roles, &$visited, $currentDepth = 0)
    {
        if (isset($visited[$role->id])) {
            return $visited[$role->id];
        }

        if (!$role->parent_role_id) {
            $visited[$role->id] = $currentDepth;
            return $currentDepth;
        }

        $parentRole = $roles->firstWhere('id', $role->parent_role_id);
        if (!$parentRole) {
            $visited[$role->id] = $currentDepth;
            return $currentDepth;
        }

        $depth = $this->getRoleDepth($parentRole, $roles, $visited, $currentDepth + 1);
        $visited[$role->id] = $depth;
        return $depth;
    }

    /**
     * Get real-time permission updates.
     */
    public function getRealTimeUpdates(Request $request)
    {
        $this->authorize('viewRealTimeUpdates', EnhancedRole::class);

        $lastUpdate = $request->input('last_update', now()->subMinute()->timestamp);
        $updates = [];

        // Get recent role permission changes
        $recentChanges = DB::table('role_permissions')
            ->where('created_at', '>=', date('Y-m-d H:i:s', $lastUpdate))
            ->orWhere('updated_at', '>=', date('Y-m-d H:i:s', $lastUpdate))
            ->get()
            ->groupBy('role_id');

        foreach ($recentChanges as $roleId => $changes) {
            $role = EnhancedRole::find($roleId);
            if ($role) {
                $updates[] = [
                    'type' => 'role_permissions',
                    'role_id' => $roleId,
                    'role_name' => $role->name,
                    'timestamp' => $changes->max('created_at'),
                    'changes_count' => $changes->count(),
                ];
            }
        }

        // Get recent role changes
        $recentRoleChanges = EnhancedRole::where('created_at', '>=', date('Y-m-d H:i:s', $lastUpdate))
            ->orWhere('updated_at', '>=', date('Y-m-d H:i:s', $lastUpdate))
            ->get();

        foreach ($recentRoleChanges as $role) {
            $updates[] = [
                'type' => 'role_updated',
                'role_id' => $role->id,
                'role_name' => $role->name,
                'timestamp' => $role->updated_at->timestamp,
                'action' => $role->created_at->timestamp >= $lastUpdate ? 'created' : 'updated',
            ];
        }

        return response()->json([
            'success' => true,
            'updates' => $updates,
            'timestamp' => now()->timestamp,
        ]);
    }

    /**
     * Export role and permission data.
     */
    public function export(Request $request)
    {
        $this->authorize('export', EnhancedRole::class);

        $format = $request->input('format', 'json');
        $includeUsers = $request->input('include_users', false);
        $includeHierarchy = $request->input('include_hierarchy', true);

        $roles = EnhancedRole::with(['permissions'])
            ->when($includeUsers, function ($query) {
                $query->with(['users' => function ($query) {
                    $query->select('users.id', 'users.name', 'users.email');
                }]);
            })
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        $permissions = EnhancedPermission::orderBy('module')
            ->orderBy('name')
            ->get();

        $exportData = [
            'exported_at' => now()->toISOString(),
            'roles' => $roles->map(function ($role) use ($includeUsers) {
                $roleData = [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'description' => $role->description,
                    'level' => $role->level,
                    'status' => $role->status,
                    'parent_role_id' => $role->parent_role_id,
                    'inherit_permissions' => $role->inherit_permissions,
                    'permissions_inheritance_mode' => $role->permissions_inheritance_mode,
                    'permissions' => $role->permissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name,
                            'display_name' => $permission->display_name,
                            'module' => $permission->module,
                        ];
                    })->toArray(),
                ];

                if ($includeUsers) {
                    $roleData['users'] = $role->users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ];
                    })->toArray();
                }

                return $roleData;
            })->toArray(),
            'permissions' => $permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'display_name' => $permission->display_name,
                    'description' => $permission->description,
                    'module' => $permission->module,
                    'status' => $permission->status,
                ];
            })->toArray(),
        ];

        if ($includeHierarchy) {
            $exportData['hierarchy'] = $this->buildHierarchyTree($roles);
        }

        switch ($format) {
            case 'csv':
                return $this->exportCsv($exportData);
            case 'json':
            default:
                return response()->json($exportData);
        }
    }

    /**
     * Export data as CSV.
     */
    private function exportCsv($data)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=roles_permissions_' . date('Y-m-d') . '.csv',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to fix encoding issues in Excel
            fputs($file, "\xEF\xBB\xBF");

            // Roles sheet
            fputcsv($file, ['Roles Export']);
            fputcsv($file, ['ID', 'Name', 'Display Name', 'Description', 'Level', 'Status', 'Parent Role ID', 'Inherit Permissions', 'Inheritance Mode']);
            
            foreach ($data['roles'] as $role) {
                fputcsv($file, [
                    $role['id'],
                    $role['name'],
                    $role['display_name'],
                    $role['description'],
                    $role['level'],
                    $role['status'],
                    $role['parent_role_id'] ?? '',
                    $role['inherit_permissions'] ? 'Yes' : 'No',
                    $role['permissions_inheritance_mode'] ?? '',
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Permissions Export']);
            fputcsv($file, ['ID', 'Name', 'Display Name', 'Description', 'Module', 'Status']);
            
            foreach ($data['permissions'] as $permission) {
                fputcsv($file, [
                    $permission['id'],
                    $permission['name'],
                    $permission['display_name'],
                    $permission['description'],
                    $permission['module'],
                    $permission['status'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get role analytics and insights.
     */
    public function getAnalytics()
    {
        $this->authorize('viewAnalytics', EnhancedRole::class);

        $cacheKey = 'role_permission_analytics';
        $analytics = Cache::remember($cacheKey, now()->addHours(6), function () {
            $roles = EnhancedRole::with(['permissions', 'users', 'childRoles'])
                ->active()
                ->get();

            $permissions = EnhancedPermission::active()->get();

            // Permission usage analysis
            $permissionUsage = [];
            foreach ($permissions as $permission) {
                $usageCount = $permission->roles()->count();
                $permissionUsage[] = [
                    'permission' => $permission,
                    'usage_count' => $usageCount,
                    'usage_percentage' => $roles->count() > 0 ? round(($usageCount / $roles->count()) * 100, 2) : 0,
                ];
            }

            // Role effectiveness analysis
            $roleEffectiveness = [];
            foreach ($roles as $role) {
                $userCount = $role->users->count();
                $permissionCount = $role->getAllPermissions()->count();
                $childCount = $role->childRoles->count();
                
                $roleEffectiveness[] = [
                    'role' => $role,
                    'user_count' => $userCount,
                    'permission_count' => $permissionCount,
                    'child_count' => $childCount,
                    'effectiveness_score' => $this->calculateRoleEffectiveness($role, $userCount, $permissionCount, $childCount),
                ];
            }

            // Module coverage analysis
            $moduleCoverage = $permissions->groupBy('module')->map(function ($modulePermissions, $module) use ($roles) {
                $totalPossibleRoles = $roles->count();
                $rolesWithModulePermissions = $modulePermissions->flatMap(function ($permission) {
                    return $permission->roles;
                })->unique('id')->count();
                
                return [
                    'module' => $module,
                    'permission_count' => $modulePermissions->count(),
                    'roles_with_access' => $rolesWithModulePermissions,
                    'coverage_percentage' => $totalPossibleRoles > 0 ? round(($rolesWithModulePermissions / $totalPossibleRoles) * 100, 2) : 0,
                ];
            })->toArray();

            return [
                'permission_usage' => $permissionUsage,
                'role_effectiveness' => $roleEffectiveness,
                'module_coverage' => $moduleCoverage,
                'summary' => [
                    'total_roles' => $roles->count(),
                    'total_permissions' => $permissions->count(),
                    'total_modules' => $permissions->pluck('module')->unique()->count(),
                    'average_permissions_per_role' => $roles->count() > 0 ? round($roles->avg(function ($role) {
                        return $role->getAllPermissions()->count();
                    }), 2) : 0,
                    'average_users_per_role' => $roles->count() > 0 ? round($roles->avg(function ($role) {
                        return $role->users->count();
                    }), 2) : 0,
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Calculate role effectiveness score.
     */
    private function calculateRoleEffectiveness($role, $userCount, $permissionCount, $childCount)
    {
        // Base score components
        $userScore = min($userCount * 10, 30); // Max 30 points for user usage
        $permissionScore = min($permissionCount * 2, 30); // Max 30 points for permissions
        $childScore = min($childCount * 15, 20); // Max 20 points for child roles
        $levelScore = max(0, 20 - ($role->level * 3)); // Higher level roles get more points
        
        // Bonus points for system roles
        $systemBonus = $role->is_system ? 10 : 0;
        
        // Bonus points for inheritance
        $inheritanceBonus = $role->inherit_permissions ? 10 : 0;
        
        $totalScore = $userScore + $permissionScore + $childScore + $levelScore + $systemBonus + $inheritanceBonus;
        
        return min($totalScore, 100); // Cap at 100
    }

    /**
     * Get all roles.
     */
    public function getRoles()
    {
        $this->authorize('viewAny', EnhancedRole::class);

        $roles = EnhancedRole::with(['permissions', 'users', 'parentRole', 'childRoles'])
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'roles' => $roles
        ]);
    }

    /**
     * Get a specific role.
     */
    public function getRole($id)
    {
        $role = EnhancedRole::with(['permissions', 'users', 'parentRole', 'childRoles'])
            ->findOrFail($id);

        $this->authorize('view', $role);

        return response()->json([
            'success' => true,
            'role' => $role
        ]);
    }

    /**
     * Store a new role.
     */
    public function storeRole(Request $request)
    {
        $this->authorize('create', EnhancedRole::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'level' => 'required|integer|min:1|max:10',
            'status' => 'required|in:active,inactive',
            'parent_role_id' => 'nullable|exists:roles,id',
            'inherit_permissions' => 'required|boolean',
            'is_system' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $role = EnhancedRole::create($request->all());

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'role_created',
                'description' => "Created role: {$role->name}",
                'metadata' => ['role_id' => $role->id],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');
            Cache::forget('role_hierarchy_data');

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'role' => $role
            ], 201);

        } catch (\Exception $e) {
            Log::error('Role creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a role.
     */
    public function updateRole(Request $request, $id)
    {
        $role = EnhancedRole::findOrFail($id);
        $this->authorize('update', $role);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'level' => 'required|integer|min:1|max:10',
            'status' => 'required|in:active,inactive',
            'parent_role_id' => 'nullable|exists:roles,id|not_in:' . $id,
            'inherit_permissions' => 'required|boolean',
            'is_system' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $role->update($request->all());

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'role_updated',
                'description' => "Updated role: {$role->name}",
                'metadata' => ['role_id' => $role->id],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');
            Cache::forget('role_hierarchy_data');

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'role' => $role
            ]);

        } catch (\Exception $e) {
            Log::error('Role update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a role.
     */
    public function deleteRole($id)
    {
        $role = EnhancedRole::findOrFail($id);
        $this->authorize('delete', $role);

        try {
            // Check if role has users
            if ($role->users()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role with assigned users'
                ], 422);
            }

            // Check if role has child roles
            if ($role->childRoles()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role with child roles'
                ], 422);
            }

            $roleName = $role->name;
            $role->delete();

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'role_deleted',
                'description' => "Deleted role: {$roleName}",
                'metadata' => ['role_id' => $id],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');
            Cache::forget('role_hierarchy_data');

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Role deletion failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clone a role.
     */
    public function cloneRole($id)
    {
        $sourceRole = EnhancedRole::findOrFail($id);
        $this->authorize('create', EnhancedRole::class);

        try {
            DB::beginTransaction();

            // Create new role
            $newRole = EnhancedRole::create([
                'name' => $sourceRole->name . '_clone_' . time(),
                'display_name' => $sourceRole->display_name . ' (Clone)',
                'description' => $sourceRole->description,
                'level' => $sourceRole->level,
                'status' => 'inactive',
                'parent_role_id' => $sourceRole->parent_role_id,
                'inherit_permissions' => $sourceRole->inherit_permissions,
                'is_system' => false,
            ]);

            // Copy permissions
            $permissions = $sourceRole->permissions()->pluck('permissions.id')->toArray();
            if (!empty($permissions)) {
                $newRole->permissions()->attach($permissions, [
                    'granted_by' => auth()->id(),
                    'granted_at' => now(),
                ]);
            }

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'role_cloned',
                'description' => "Cloned role from {$sourceRole->name} to {$newRole->name}",
                'metadata' => [
                    'source_role_id' => $sourceRole->id,
                    'new_role_id' => $newRole->id,
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            DB::commit();

            // Clear cache
            Cache::forget('permission_grid_data');
            Cache::forget('role_hierarchy_data');

            return response()->json([
                'success' => true,
                'message' => 'Role cloned successfully',
                'role' => $newRole
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Role cloning failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to clone role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export roles.
     */
    public function exportRoles()
    {
        $this->authorize('viewAny', EnhancedRole::class);

        $roles = EnhancedRole::with(['permissions', 'users', 'parentRole'])
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        $csvData = [];
        $csvData[] = ['ID', 'Name', 'Display Name', 'Description', 'Level', 'Status', 'Parent Role', 'Permissions', 'Users', 'Inherit Permissions', 'Is System'];

        foreach ($roles as $role) {
            $csvData[] = [
                $role->id,
                $role->name,
                $role->display_name,
                $role->description,
                $role->level,
                $role->status,
                $role->parentRole?->display_name ?? 'None',
                $role->permissions->count(),
                $role->users->count(),
                $role->inherit_permissions ? 'Yes' : 'No',
                $role->is_system ? 'Yes' : 'No',
            ];
        }

        $filename = 'roles_export_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
        exit;
    }

    /**
     * Get all permissions.
     */
    public function getPermissions()
    {
        $this->authorize('viewAny', EnhancedPermission::class);

        $permissions = EnhancedPermission::with(['roles'])
            ->orderBy('module')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'permissions' => $permissions
        ]);
    }

    /**
     * Get a specific permission.
     */
    public function getPermission($id)
    {
        $permission = EnhancedPermission::with(['roles'])
            ->findOrFail($id);

        $this->authorize('view', $permission);

        return response()->json([
            'success' => true,
            'permission' => $permission
        ]);
    }

    /**
     * Store a new permission.
     */
    public function storePermission(Request $request)
    {
        $this->authorize('create', EnhancedPermission::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'module' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $permission = EnhancedPermission::create($request->all());

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'permission_created',
                'description' => "Created permission: {$permission->name}",
                'metadata' => ['permission_id' => $permission->id],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');

            return response()->json([
                'success' => true,
                'message' => 'Permission created successfully',
                'permission' => $permission
            ], 201);

        } catch (\Exception $e) {
            Log::error('Permission creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a permission.
     */
    public function updatePermission(Request $request, $id)
    {
        $permission = EnhancedPermission::findOrFail($id);
        $this->authorize('update', $permission);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'module' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $permission->update($request->all());

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'permission_updated',
                'description' => "Updated permission: {$permission->name}",
                'metadata' => ['permission_id' => $permission->id],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');

            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully',
                'permission' => $permission
            ]);

        } catch (\Exception $e) {
            Log::error('Permission update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a permission.
     */
    public function deletePermission($id)
    {
        $permission = EnhancedPermission::findOrFail($id);
        $this->authorize('delete', $permission);

        try {
            // Check if permission is assigned to roles
            if ($permission->roles()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete permission assigned to roles'
                ], 422);
            }

            $permissionName = $permission->name;
            $permission->delete();

            // Log activity
            UserActivity::create([
                'user_id' => auth()->id(),
                'action' => 'permission_deleted',
                'description' => "Deleted permission: {$permissionName}",
                'metadata' => ['permission_id' => $id],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Clear cache
            Cache::forget('permission_grid_data');

            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Permission deletion failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export permissions.
     */
    public function exportPermissions()
    {
        $this->authorize('viewAny', EnhancedPermission::class);

        $permissions = EnhancedPermission::with(['roles'])
            ->orderBy('module')
            ->orderBy('name')
            ->get();

        $csvData = [];
        $csvData[] = ['ID', 'Name', 'Display Name', 'Description', 'Module', 'Status', 'Roles'];

        foreach ($permissions as $permission) {
            $csvData[] = [
                $permission->id,
                $permission->name,
                $permission->display_name,
                $permission->description,
                $permission->module,
                $permission->status,
                $permission->roles->pluck('display_name')->join(', '),
            ];
        }

        $filename = 'permissions_export_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
        exit;
    }
}
