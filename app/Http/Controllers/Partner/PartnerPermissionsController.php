<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\EnhancedPermission;
use App\Models\EnhancedRole;
use App\Models\EnhancedUser;
use App\Models\Partner;
use App\Services\MenuPermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerPermissionsController extends Controller
{
    /**
     * Canonical list of sidebar menu permissions (exactly 11).
     */
    private const MENUS = [
        'menu-dashboard',
        'menu-courses',
        'menu-subjects',
        'menu-topics',
        'menu-batches',
        'menu-students',
        'menu-teachers',
        'menu-questions',
        'menu-exams',
        'menu-analytics',
        'menu-sms',
    ];

    /**
     * Show menu permissions matrix (nav-only) per role.
     */
    public function index(Request $request)
    {
        // Determine current user's highest role level
        $currentUser = EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser?->getHighestRoleLevel() ?? 1;

        // Determine partner context (roles created by this partner)
        $partner = Partner::where('user_id', auth()->id())->first();
        $partnerUserId = $partner?->user_id;

        // Check if a specific role is requested
        $requestedRoleId = $request->get('role');
        
        if ($requestedRoleId) {
            // Load only the specific role with permissions
            $role = EnhancedRole::with(['permissions' => function ($q) {
                    $q->whereIn('module_name', self::MENUS);
                }])
                ->active()
                ->where('id', $requestedRoleId)
                ->where('level', '>=', $currentUserLevel)
                ->where(function ($query) use ($partnerUserId) {
                    $query->where('is_default', 1)
                          ->orWhereNull('created_by');
                    if ($partnerUserId) {
                        $query->orWhere('created_by', $partnerUserId);
                    }
                })
                ->first();

            // If role not found or access denied, redirect to main permissions page
            if (!$role) {
                return redirect()->route('partner.nav-permissions.index')
                    ->with('error', 'Role not found or access denied.');
            }

            // Build permissions array for the single role
            $granted = $role->permissions->pluck('module_name')->all();
            $permissions = [];
            foreach (self::MENUS as $perm) {
                $permissions[$perm] = in_array($perm, $granted, true);
            }

            return view('partner.permissions.single-role', [
                'role' => $role,
                'permissions' => $permissions,
                'menuKeys' => self::MENUS,
            ]);
        }

        // Load all roles for the main permissions matrix view
        $roles = EnhancedRole::with(['permissions' => function ($q) {
                $q->whereIn('module_name', self::MENUS);
            }])
            ->active()
            ->where('level', '>=', $currentUserLevel)
            ->where(function ($query) use ($partnerUserId) {
                $query->where('is_default', 1)
                      ->orWhereNull('created_by');
                if ($partnerUserId) {
                    $query->orWhere('created_by', $partnerUserId);
                }
            })
            ->orderBy('level')
            ->get();

        $permissionsByRole = $roles->mapWithKeys(function ($role) {
            $granted = $role->permissions->pluck('module_name')->all();
            $row = [];
            foreach (self::MENUS as $perm) {
                $row[$perm] = in_array($perm, $granted, true);
            }
            return [$role->id => $row];
        });
        
        return view('partner.permissions.menus', [
            'roles' => $roles,
            'permissionsByRole' => $permissionsByRole,
            'menuKeys' => self::MENUS,
        ]);
    }

    /**
     * Update menu (nav-only) permissions for a role.
     */
public function update(Request $request, EnhancedRole $enhancedRole, MenuPermissionService $menuService)
    {
        // Only accept our 11 menu keys
        $requested = $request->input('menus', []);
        if (!is_array($requested)) {
            $requested = [];
        }
        $requestedNames = array_keys(array_filter($requested, fn ($v) => (bool)$v));
        $requestedNames = array_values(array_intersect(self::MENUS, $requestedNames));

        // Validate requested permissions exist in ac_modules
        $valid = EnhancedPermission::whereIn('module_name', $requestedNames)->pluck('module_name')->all();

        // Keep existing non-menu permissions; replace menu ones with requested
$current = $enhancedRole->permissions()->pluck('module_name')->all();
        $keepActions = array_values(array_filter($current, fn ($name) => !in_array($name, self::MENUS, true)));
        $final = array_values(array_unique(array_merge($keepActions, $valid)));

        // Sync and audit
$enhancedRole->syncPermissions($final);
        $enhancedRole->update(['updated_by' => auth()->id()]);

        // Clear cached menu permissions for users of this role
        try {
$userIds = $enhancedRole->users()->pluck('ac_users.id')->all();
            foreach ($userIds as $uid) {
                $menuService->clearUserCache((int)$uid);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed clearing user menu cache after menu update', [
'role_id' => $enhancedRole->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Check if we came from a single role view
        $referer = request()->header('referer');
        if ($referer && str_contains($referer, 'role=' . $enhancedRole->id)) {
            return redirect()->route('partner.nav-permissions.index', ['role' => $enhancedRole->id])
                ->with('success', 'Menu permissions updated.');
        }

return redirect()->route('partner.nav-permissions.index')->with('success', 'Menu permissions updated.');
    }
}