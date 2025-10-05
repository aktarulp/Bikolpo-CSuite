<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PermissionSyncService
{
    /**
    * Ensure all menu and button permissions defined in config/permissions.php exist in ac_modules.
    * Idempotent operation safe to call on boot.
    */
    public static function syncMenus(): void
    {
        try {
            $menus = config('permissions.menus', []);
            if (empty($menus)) {
                return;
            }

            $now = now();

            foreach ($menus as $menuKey => $menuConfig) {
                // Ensure ONLY the main menu permission exists (menu-*). Action/button permissions are not created.
                $menuPermName = "menu-{$menuKey}";
                $menuDisplay = $menuConfig['label'] ?? ucfirst($menuKey);

                self::upsertPermission($menuPermName, $menuDisplay, "Access to {$menuDisplay} menu");
            }
        } catch (\Throwable $e) {
            Log::warning('PermissionSyncService syncMenus failed: ' . $e->getMessage());
        }
    }

    private static function upsertPermission(string $name, string $displayName, ?string $description = null): void
    {
        [$module, $action, $resource] = self::deriveMeta($name);

        $exists = DB::table('ac_modules')->where('module_name', $name)->first();
        $now = now();
        $payload = [
            'module_name' => $name,
            'display_name' => $displayName,
            'description' => $description,
            'updated_at' => $now,
        ];
        // Conditionally include columns based on schema
        if (Schema::hasColumn('ac_modules', 'module')) {
            $payload['module'] = $module;
        }
        if (Schema::hasColumn('ac_modules', 'action')) {
            $payload['action'] = $action;
        }
        if (Schema::hasColumn('ac_modules', 'resource')) {
            $payload['resource'] = $resource;
        }

        if (!$exists) {
            $payload['created_at'] = $now;
            DB::table('ac_modules')->insert($payload);
        } else {
            DB::table('ac_modules')->where('id', $exists->id)->update($payload);
        }
    }

    private static function deriveMeta(string $name): array
    {
        // menu-dashboard => module=menu, action=view, resource=dashboard
        if (str_starts_with($name, 'menu-')) {
            $resource = substr($name, 5) ?: 'menu';
            return ['menu', 'view', $resource];
        }
        // students-add => module=students, action=add, resource=students
        if (strpos($name, '-') !== false) {
            [$module, $action] = explode('-', $name, 2);
            return [$module ?: 'system', $action ?: 'view', $module ?: 'system'];
        }
        // Fallback
        return ['system', 'view', $name];
    }
}
