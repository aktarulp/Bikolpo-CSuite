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
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy(function($permission) {
            // Group permissions by menu (extract menu name from permission name)
            if (str_starts_with($permission->name, 'menu-')) {
                return substr($permission->name, 5); // Remove 'menu-' prefix
            }
            
            $parts = explode('-', $permission->name, 2);
            return $parts[0] ?? 'other';
        });

        $permissionConfig = config('permissions.menus', []);

        return view('partner.access-control.index', compact('roles', 'permissions', 'permissionConfig'));
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
    public function updateRolePermissions(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
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
            // Sync permissions (this will remove old permissions and add new ones)
            $permissions = $request->input('permissions', []);
            $role->syncPermissions($permissions);

            return response()->json([
                'success' => true,
                'message' => 'Role permissions updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get role permissions for editing.
     */
    public function getRolePermissions(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return response()->json([
            'success' => true,
            'permissions' => $rolePermissions
        ]);
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
                'label' => $menuConfig['label'],
                'menu_permission' => $menuPermission,
                'menu_exists' => $permissions->has($menuPermission),
                'buttons' => []
            ];
            
            foreach ($menuConfig['buttons'] as $buttonKey => $buttonLabel) {
                $buttonPermission = "{$menuKey}-{$buttonKey}";
                $structure[$menuKey]['buttons'][$buttonKey] = [
                    'label' => $buttonLabel,
                    'permission' => $buttonPermission,
                    'exists' => $permissions->has($buttonPermission)
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
}
