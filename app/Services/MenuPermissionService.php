<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MenuPermissionService
{
    /**
     * Check if current user has permission to access a menu
     */
    public function canAccessMenu(string $menuName): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Cache key for user permissions
        $cacheKey = "user_menu_permissions_{$user->id}";
        
        // Get user's menu permissions from cache or database
        $menuPermissions = Cache::remember($cacheKey, 3600, function () use ($user) {
            return $this->getUserMenuPermissions($user->id);
        });
        
        // Check if user has the specific menu permission
        $permissionName = "menu-{$menuName}";
        return in_array($permissionName, $menuPermissions);
    }
    
    /**
     * Get all menu permissions for a user
     */
    protected function getUserMenuPermissions(int $userId): array
    {
        // Get user's roles
        $roleIds = DB::table('user_roles')
            ->where('user_id', $userId)
            ->pluck('role_id')
            ->toArray();
        
        if (empty($roleIds)) {
            return [];
        }
        
        // Get permissions for these roles
        $permissions = DB::table('role_permissions')
            ->join('permissions', 'role_permissions.enhanced_permission_id', '=', 'permissions.id')
            ->whereIn('role_permissions.enhanced_role_id', $roleIds)
            ->where('permissions.name', 'LIKE', 'menu-%')
            ->pluck('permissions.name')
            ->unique()
            ->toArray();
        
        return $permissions;
    }
    
    /**
     * Get all accessible menus for current user
     */
    public function getAccessibleMenus(): array
    {
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }
        
        $cacheKey = "user_menu_permissions_{$user->id}";
        $menuPermissions = Cache::remember($cacheKey, 3600, function () use ($user) {
            return $this->getUserMenuPermissions($user->id);
        });
        
        // Extract menu names from permission names (remove 'menu-' prefix)
        return array_map(function($perm) {
            return str_replace('menu-', '', $perm);
        }, $menuPermissions);
    }
    
    /**
     * Clear user's menu permission cache
     */
    public function clearUserCache(int $userId): void
    {
        Cache::forget("user_menu_permissions_{$userId}");
    }
    
    /**
     * Check multiple menu permissions at once
     */
    public function canAccessAnyMenu(array $menuNames): bool
    {
        foreach ($menuNames as $menuName) {
            if ($this->canAccessMenu($menuName)) {
                return true;
            }
        }
        return false;
    }
}
