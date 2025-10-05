<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessControlController extends Controller
{
    // Note: Index method removed as the view /partner/access-control is no longer used.
    // All access control functionality is now managed through /partner/settings

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
        // Get current user's highest role level
        $currentUser = \App\Models\EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser->getHighestRoleLevel() ?? 1;
        
        // Get existing roles that are at the same level or lower (higher level number) than current user
        // This prevents users from copying permissions from higher-level roles they don't have access to
        $existingRoles = \App\Models\EnhancedRole::with('permissions')
            ->where('level', '>=', $currentUserLevel)
            ->orderBy('level')
            ->get();
        
        $permissions = EnhancedPermission::all()->groupBy(function($permission) {
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
     * Show the form for editing role permissions (action-level only; excludes menu-*).
     */
    public function editRole(EnhancedRole $role)
    {
        // Enforce visibility rules: role must be at or below current user's level and belong to this partner or be default/legacy
        $currentUser = \App\Models\EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser?->getHighestRoleLevel() ?? 1;
        if (($role->level ?? PHP_INT_MAX) < $currentUserLevel) {
            abort(403, 'You cannot manage a higher-privilege role.');
        }
        $partner = \App\Models\Partner::where('user_id', auth()->id())->first();
        $partnerUserId = $partner?->user_id;
        if (!($role->is_default || is_null($role->created_by) || ($partnerUserId && $role->created_by == $partnerUserId))) {
            abort(403, 'You cannot manage roles outside your organization.');
        }

        $permissionConfig = config('permissions.menus', []);

        // Current role permissions and allowed modules by menu-* grants
        $currentPerms = $role->permissions->pluck('name')->toArray();
        $allowedModules = collect($currentPerms)
            ->filter(fn($n) => str_starts_with($n, 'menu-'))
            ->map(fn($n) => substr($n, 5))
            ->filter(fn($k) => isset($permissionConfig[$k]))
            ->unique()
            ->values()
            ->all();

        // Build action-only structure (exclude menu-*), filtered by allowed modules only
        $modules = collect($permissionConfig)
            ->filter(function ($cfg, $key) use ($allowedModules) {
                return in_array($key, $allowedModules, true);
            })
            ->map(function ($cfg, $key) {
                $buttons = $cfg['buttons'] ?? [];
                return [
                    'key' => $key,
                    'label' => $cfg['label'] ?? ucfirst($key),
                    'buttons' => $buttons,
                ];
            })
            ->values();

        // Extract only action permission names for allowed modules from config for comparison
        $actionNames = [];
        foreach ($allowedModules as $menuKey) {
            $cfg = $permissionConfig[$menuKey] ?? [];
            foreach (($cfg['buttons'] ?? []) as $buttonKey => $label) {
                $actionNames[] = $menuKey . '-' . $buttonKey;
            }
        }

        // Map to boolean checked states
        $checked = [];
        foreach ($actionNames as $name) {
            $checked[$name] = in_array($name, $currentPerms, true);
        }

        return view('partner.access-control.edit-role', [
            'role' => $role,
            'modules' => $modules,
            'checked' => $checked,
        ]);
    }

    /**
     * Store a newly created role.
     */
    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ac_roles,name',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
'permissions.*' => 'exists:ac_modules,module_name'
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

            // Get current user's level to set appropriate role level
            $currentUser = \App\Models\EnhancedUser::find(auth()->id());
            $currentUserLevel = $currentUser->getHighestRoleLevel() ?? 1;
            
            // Create the role with our custom fields
            $role = EnhancedRole::create([
                'name' => $request->name,
                'display_name' => $request->display_name ?? $request->name,
                'description' => $request->description,
                'level' => $currentUserLevel + 1, // New role should be one level below current user
                'status' => 'active',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Assign permissions to the role
            if ($request->has('permissions') && is_array($request->permissions)) {
                $role->syncPermissions($request->permissions);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'redirect' => route('partner.settings.index')
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

            // Enforce visibility rules similar to edit
            $currentUser = \App\Models\EnhancedUser::find(auth()->id());
            $currentUserLevel = $currentUser?->getHighestRoleLevel() ?? 1;
            if (($role->level ?? PHP_INT_MAX) < $currentUserLevel) {
                return response()->json(['success' => false, 'message' => 'Cannot modify a higher-privilege role.'], 403);
            }
            $partner = \App\Models\Partner::where('user_id', auth()->id())->first();
            $partnerUserId = $partner?->user_id;
            if (!($role->is_default || is_null($role->created_by) || ($partnerUserId && $role->created_by == $partnerUserId))) {
                return response()->json(['success' => false, 'message' => 'Cannot modify roles outside your organization.'], 403);
            }

            $permissions = $request->input('permissions', []);
            if (!is_array($permissions)) { $permissions = []; }

            // Keep existing menu-* permissions intact
            $existing = $role->permissions()->pluck('name')->all();
            $keepMenus = array_values(array_filter($existing, fn($n) => str_starts_with($n, 'menu-')));

            // Validate only action permissions from config, restricted to allowed modules by menu-*
            $permissionConfig = config('permissions.menus', []);

            // Determine allowed modules for this role from its current menu-* grants
            $allowedModules = collect($existing)
                ->filter(fn($n) => str_starts_with($n, 'menu-'))
                ->map(fn($n) => substr($n, 5))
                ->filter(fn($k) => isset($permissionConfig[$k]))
                ->unique()
                ->values()
                ->all();

            $validActionSet = [];
            foreach ($allowedModules as $menuKey) {
                $cfg = $permissionConfig[$menuKey] ?? [];
                foreach (($cfg['buttons'] ?? []) as $buttonKey => $label) {
                    $validActionSet[] = $menuKey . '-' . $buttonKey;
                }
            }
            $selectedActions = array_values(array_intersect($permissions, $validActionSet));

            // Ensure those names exist in ac_permissions
$validSelected = \App\Models\EnhancedPermission::whereIn('module_name', $selectedActions)->pluck('module_name')->all();

            // Final permissions = keepMenus + validSelected
            $final = array_values(array_unique(array_merge($keepMenus, $validSelected)));

            // Sync
            $role->syncPermissions($final);
            $role->update(['updated_by' => auth()->id()]);

            // If this is an AJAX/JSON request, return JSON; otherwise redirect back with a flash message
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role permissions updated successfully'
                ]);
            }

            return redirect()
                ->route('partner.settings.index')
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
    public function destroyRole(EnhancedRole $role)
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
     * Show simple permission assignment (CRUD flags per module) for a role.
     */
    public function assignCrud(EnhancedRole $role)
    {
        // Ensure visibility like editRole
        $currentUser = \App\Models\EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser?->getHighestRoleLevel() ?? 1;
        if (($role->level ?? PHP_INT_MAX) < $currentUserLevel) {
            abort(403, 'You cannot manage a higher-privilege role.');
        }
        $partner = \App\Models\Partner::where('user_id', auth()->id())->first();
        $partnerUserId = $partner?->user_id;
        if (!($role->is_default || is_null($role->created_by) || ($partnerUserId && $role->created_by == $partnerUserId))) {
            abort(403, 'You cannot manage roles outside your organization.');
        }

        $permissionConfig = config('permissions.menus', []);

        // Derive modules from config keys
        $modules = collect($permissionConfig)->map(function ($cfg, $key) {
            return [
                'key' => $key,
                'label' => $cfg['label'] ?? ucfirst($key),
            ];
        })->values();

        // Current pivot flags mapped by menu permission key: 'menu-{key}'
        $flagsByKey = [];
        foreach ($modules as $m) {
            $permName = 'menu-' . $m['key'];
            $perm = \App\Models\EnhancedPermission::where('module_name', $permName)->first();
            $pivot = null;
            if ($perm) {
                $pivot = $role->permissions()->where('ac_modules.id', $perm->id)->first()?->pivot;
            }
            $flagsByKey[$m['key']] = [
                'create' => (bool)($pivot?->can_create ?? false),
                'read' => (bool)($pivot?->can_read ?? false),
                'update' => (bool)($pivot?->can_update ?? false),
                'delete' => (bool)($pivot?->can_delete ?? false),
            ];
        }

        return view('partner.permissions.assign', [
            'role' => $role,
            'modules' => $modules,
            'flagsByKey' => $flagsByKey,
        ]);
    }

    /**
     * Save CRUD flags per module for the role.
     */
    public function saveCrud(Request $request, EnhancedRole $role)
    {
        $payload = $request->input('modules', []); // expected: modules[key][create|read|update|delete] => 'on'
        if (!is_array($payload)) { $payload = []; }

        $map = [];
        foreach ($payload as $key => $flags) {
            $map['menu-' . $key] = [
                'create' => !empty($flags['create']),
                'read' => !empty($flags['read']),
                'update' => !empty($flags['update']),
                'delete' => !empty($flags['delete']),
            ];
        }

        // Sync while preserving any other permissions already attached
        $role->syncPermissionsWithCrud($map, auth()->id());
        $role->update(['updated_by' => auth()->id()]);

        return redirect()
            ->route('partner.access-control.role.assign', $role)
            ->with('success', 'Permissions updated.');
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
