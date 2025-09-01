<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display the permissions management page
     */
    public function index()
    {
        $roles = Role::with(['users', 'parentRole'])->active()->get();
        $permissions = Permission::active()->get();
        $systemSettings = SystemSetting::byGroup('permissions')->get();
        
        // Get user counts for each role
        $roleUserCounts = [];
        foreach ($roles as $role) {
            $roleUserCounts[$role->id] = $role->users()->count();
        }

        // Get default system settings
        $defaultSettings = [
            'session_timeout' => SystemSetting::getValue('session_timeout', 30),
            'max_sessions' => SystemSetting::getValue('max_sessions', 3),
            'idle_timeout' => SystemSetting::getValue('idle_timeout', 15),
            'permission_inheritance' => SystemSetting::getValue('permission_inheritance', true),
            'inherit_parent_permissions' => SystemSetting::getValue('inherit_parent_permissions', true),
            'allow_permission_overrides' => SystemSetting::getValue('allow_permission_overrides', false),
            'log_permission_changes' => SystemSetting::getValue('log_permission_changes', true),
            'track_user_access' => SystemSetting::getValue('track_user_access', true),
            'notify_security_events' => SystemSetting::getValue('notify_security_events', false),
        ];

        return view('partner.Settings.permissions', compact(
            'roles', 
            'permissions', 
            'systemSettings', 
            'roleUserCounts',
            'defaultSettings'
        ));
    }

    /**
     * Store a new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:1000',
            'parent_role_id' => 'nullable|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:full,limited,read,none'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_role_id' => $request->parent_role_id,
                'permissions' => $request->permissions,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'role' => $role
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating role: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing role
     */
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:1000',
            'parent_role_id' => 'nullable|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:full,limited,read,none'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
                'description' => $request->description,
                'parent_role_id' => $request->parent_role_id,
                'permissions' => $request->permissions,
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'role' => $role
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating role: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a role
     */
    public function destroyRole(Role $role)
    {
        try {
            // Check if role has users
            if ($role->users()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role that has assigned users'
                ], 400);
            }

            // Check if role has child roles
            if ($role->childRoles()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role that has child roles'
                ], 400);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save system settings
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'session_timeout' => 'required|integer|min:5|max:480',
            'max_sessions' => 'required|integer|min:1|max:10',
            'idle_timeout' => 'required|integer|min:5|max:120',
            'permission_inheritance' => 'boolean',
            'inherit_parent_permissions' => 'boolean',
            'allow_permission_overrides' => 'boolean',
            'log_permission_changes' => 'boolean',
            'track_user_access' => 'boolean',
            'notify_security_events' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $settings = [
                'session_timeout' => $request->session_timeout,
                'max_sessions' => $request->max_sessions,
                'idle_timeout' => $request->idle_timeout,
                'permission_inheritance' => $request->boolean('permission_inheritance'),
                'inherit_parent_permissions' => $request->boolean('inherit_parent_permissions'),
                'allow_permission_overrides' => $request->boolean('allow_permission_overrides'),
                'log_permission_changes' => $request->boolean('log_permission_changes'),
                'track_user_access' => $request->boolean('track_user_access'),
                'notify_security_events' => $request->boolean('notify_security_events')
            ];

            foreach ($settings as $key => $value) {
                SystemSetting::setValue(
                    $key, 
                    $value, 
                    is_bool($value) ? 'boolean' : 'integer',
                    'Permission system setting',
                    'permissions'
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Settings saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saving settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset permissions to defaults
     */
    public function resetToDefaults()
    {
        try {
            DB::beginTransaction();

            // Delete all existing roles and permissions
            Role::truncate();
            Permission::truncate();

            // Create default roles with permissions
            $this->createDefaultRoles();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permissions reset to defaults successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error resetting permissions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error resetting permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export permissions
     */
    public function export()
    {
        try {
            $roles = Role::with(['permissions'])->get();
            $permissions = Permission::all();
            $settings = SystemSetting::byGroup('permissions')->get();

            $data = [
                'roles' => $roles,
                'permissions' => $permissions,
                'settings' => $settings,
                'exported_at' => now()->toISOString(),
                'exported_by' => auth()->id()
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error exporting permissions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error exporting permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import permissions
     */
    public function import(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.roles' => 'array',
            'data.permissions' => 'array',
            'data.settings' => 'array'
        ]);

        try {
            DB::beginTransaction();

            // Import roles
            if (!empty($request->data['roles'])) {
                foreach ($request->data['roles'] as $roleData) {
                    Role::updateOrCreate(
                        ['name' => $roleData['name']],
                        $roleData
                    );
                }
            }

            // Import permissions
            if (!empty($request->data['permissions'])) {
                foreach ($request->data['permissions'] as $permissionData) {
                    Permission::updateOrCreate(
                        ['name' => $permissionData['name']],
                        $permissionData
                    );
                }
            }

            // Import settings
            if (!empty($request->data['settings'])) {
                foreach ($request->data['settings'] as $settingData) {
                    SystemSetting::updateOrCreate(
                        ['key' => $settingData['key']],
                        $settingData
                    );
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permissions imported successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error importing permissions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error importing permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create default roles with permissions
     */
    private function createDefaultRoles()
    {
        // Administrator role
        $adminRole = Role::create([
            'name' => 'Administrator',
            'description' => 'Full system access and control',
            'permissions' => [
                'dashboard' => ['full'],
                'students' => ['full'],
                'courses' => ['full'],
                'exams' => ['full'],
                'reports' => ['full'],
                'settings' => ['full']
            ],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        // Teacher role
        $teacherRole = Role::create([
            'name' => 'Teacher',
            'description' => 'Course and student management',
            'permissions' => [
                'dashboard' => ['full'],
                'students' => ['full'],
                'courses' => ['full'],
                'exams' => ['full'],
                'reports' => ['limited'],
                'settings' => ['none']
            ],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        // Assistant role
        $assistantRole = Role::create([
            'name' => 'Assistant',
            'description' => 'Limited access to assigned areas',
            'permissions' => [
                'dashboard' => ['limited'],
                'students' => ['limited'],
                'courses' => ['read'],
                'exams' => ['limited'],
                'reports' => ['read'],
                'settings' => ['none']
            ],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        // Viewer role
        $viewerRole = Role::create([
            'name' => 'Viewer',
            'description' => 'Read-only access to reports',
            'permissions' => [
                'dashboard' => ['read'],
                'students' => ['read'],
                'courses' => ['read'],
                'exams' => ['read'],
                'reports' => ['read'],
                'settings' => ['none']
            ],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        // Create default system settings
        $defaultSettings = [
            'session_timeout' => 30,
            'max_sessions' => 3,
            'idle_timeout' => 15,
            'permission_inheritance' => true,
            'inherit_parent_permissions' => true,
            'allow_permission_overrides' => false,
            'log_permission_changes' => true,
            'track_user_access' => true,
            'notify_security_events' => false
        ];

        foreach ($defaultSettings as $key => $value) {
            SystemSetting::setValue(
                $key,
                $value,
                is_bool($value) ? 'boolean' : 'integer',
                'Default permission system setting',
                'permissions'
            );
        }
    }
}
