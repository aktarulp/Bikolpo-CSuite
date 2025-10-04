<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessControlController extends Controller
{
    /**
     * Display the access control dashboard.
     */
    public function index()
    {
        // Get current user's highest role level
        $currentUser = \App\Models\EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser->getHighestRoleLevel() ?? 1;
        
        // Get roles with same or higher level
        $roles = \App\Models\EnhancedRole::with('permissions')
            ->where('level', '>=', $currentUserLevel)
            ->orderBy('level')
            ->get();

        // Build normalized permission structure for the UI from config
        $menusConfig = config('permissions.menus', []);
        $permissionStructure = [];
        foreach ($menusConfig as $menuKey => $menuConfig) {
            $entry = [
                'label' => $menuConfig['label'] ?? ucfirst($menuKey),
                'menu_permission' => "menu-{$menuKey}",
                'buttons' => []
            ];
            foreach (($menuConfig['buttons'] ?? []) as $buttonKey => $buttonLabel) {
                $entry['buttons'][$buttonKey] = [
                    'label' => $buttonLabel,
                    'permission' => "{$menuKey}-{$buttonKey}",
                ];
            }
            $permissionStructure[$menuKey] = $entry;
        }

        return view('partner.access-control.index', [
            'roles' => $roles,
            'permissionStructure' => $permissionStructure,
        ]);
    }

    /**
     * Get role permissions
     */
    public function getRolePermissions($roleId)
    {
        $role = \App\Models\EnhancedRole::findOrFail($roleId);
        return response()->json([
            'success' => true,
            'permissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    

    /**
     * Show the form for creating a new role.
     */
    public function createRole()
    {
        // Get all existing roles for copying permissions
        $existingRoles = Role::with('permissions')->get();
        
        $permissions = Permission::all()->groupBy(function($permission) {
            if (str_starts_with($permission->name, 'menu-')) {
                return substr($permission->name, 5);
            }
            
            $parts = explode('-', $permission->name, 2);
            return $parts[0] ?? 'other';
        });

        $permissionConfig = config('permissions.menus', []);

        return view('partner.access-control.create-role', compact('permissions', 'permissionConfig', 'existingRoles'));
    }

    /**
     * Show the form for editing role permissions.
     */
    public function editRole(Role $role)
    {
        $permissionConfig = config('permissions.menus', []);
        
        return view('partner.access-control.edit-role', compact('role', 'permissionConfig'));
    }

    /**
     * Store a newly created role.
     */
    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:' . config('permission.table_names.roles') . ',name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:' . config('permission.table_names.permissions') . ',name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create the role
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            // Assign permissions to the role
            if ($request->has('permissions') && is_array($request->permissions)) {
                $role->givePermissionTo($request->permissions);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'redirect' => route('partner.access-control.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update role permissions.
     */
    public function updateRolePermissions(Request $request, $roleId)
    {
        try {
            $role = \App\Models\EnhancedRole::findOrFail($roleId);
            $permissions = $request->input('permissions', []);
            
            // Validate permissions exist
            $validPermissions = \App\Models\EnhancedPermission::whereIn('name', $permissions)
                ->pluck('name')
                ->toArray();
            
            // Sync permissions (this will remove old permissions and add new ones)
            $role->syncPermissions($validPermissions);

            // If this is an AJAX/JSON request, return JSON; otherwise redirect back with a flash message
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role permissions updated successfully'
                ]);
            }

            return redirect()
                ->route('partner.access-control.index')
                ->with('success', 'Role permissions updated successfully.');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a role.
     */
    public function destroyRole(Role $role)
    {
        // Prevent deletion of critical roles
        $protectedRoles = ['Admin', 'Super Admin'];
        if (in_array($role->name, $protectedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete protected role: ' . $role->name
            ], 403);
        }

        try {
            // Check if role is assigned to any users
            $userCount = $role->users()->count();
            if ($userCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete role '{$role->name}' as it is assigned to {$userCount} user(s)."
                ], 400);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get permission structure for JavaScript.
     */
    public function getPermissionStructure()
    {
        $permissionConfig = config('permissions.menus', []);
        $permissions = Permission::all()->keyBy('name');
        
        $structure = [];
        
        foreach ($permissionConfig as $menuKey => $menuConfig) {
            $menuPermission = "menu-{$menuKey}";
            
            $structure[$menuKey] = [
                'name' => $menuConfig['label'] ?? ucfirst($menuKey),
                'menu_permission' => $menuPermission,
                'buttons' => []
            ];
            
            foreach ($menuConfig['buttons'] as $buttonKey => $buttonLabel) {
                $buttonPermission = "{$menuKey}-{$buttonKey}";
                $structure[$menuKey]['buttons'][$buttonKey] = [
                    'label' => $buttonLabel,
                    'permission' => $buttonPermission
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'structure' => $structure
        ]);
    }

    /**
     * Get current partner ID.
     */
    private function getPartnerId()
    {
        return auth()->user()->partner_id ?? 1;
    }

    /**
     * Manually sync menu and button permissions from config into ac_permissions.
     */
    public function syncPermissions(Request $request)
    {
        try {
            \App\Services\PermissionSyncService::syncMenus();
            return response()->json([
                'success' => true,
                'message' => 'Permissions synchronized from config.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
