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
    public function index()
    {
        // Determine current user's highest role level
        $currentUser = EnhancedUser::find(auth()->id());
        $currentUserLevel = $currentUser?->getHighestRoleLevel() ?? 1;

        // Determine partner context (roles created by this partner)
        $partner = Partner::where('user_id', auth()->id())->first();
        $partnerUserId = $partner?->user_id;

        // Load roles with only menu permissions, filtered by visibility rules:
        // - Only roles at or below current user's privilege (level >= currentUserLevel)
        // - Only default roles OR roles created by current partner (or legacy null)
        $roles = EnhancedRole::with(['permissions' => function ($q) {
                $q->whereIn('name', self::MENUS);
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
            $granted = $role->permissions->pluck('name')->all();
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

        // Validate requested permissions exist in ac_permissions
        $valid = EnhancedPermission::whereIn('name', $requestedNames)->pluck('name')->all();

        // Keep existing non-menu permissions; replace menu ones with requested
$current = $enhancedRole->permissions()->pluck('name')->all();
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

return redirect()->route('partner.nav-permissions.index')->with('success', 'Menu permissions updated.');
    }
}