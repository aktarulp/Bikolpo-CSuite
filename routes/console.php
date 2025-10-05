<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Exam Status Update Command
Artisan::command('exams:status', function () {
    $this->call('exams:update-statuses');
})->purpose('Quick command to update exam statuses');

// Reset and seed menu permissions from config(permissions.menus)
Artisan::command('permissions:reset-menus {--force}', function () {
    if (!$this->option('force')) {
        $this->warn('This will DELETE all rows from ac_permissions and related pivot tables.');
        $this->warn('Re-run with --force to proceed non-interactively.');
        return;
    }

    $this->info('Starting reset of menu permissions...');

    DB::beginTransaction();
    try {
        try { DB::statement('SET FOREIGN_KEY_CHECKS=0'); } catch (\Throwable $e) {}

        $tables = [
            'ac_role_permissions',
            'model_has_permissions',
            'role_has_permissions',
        ];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->line("Clearing table: {$table}");
                try { DB::table($table)->delete(); } catch (\Throwable $e) { DB::statement("DELETE FROM {$table}"); }
            }
        }

        $permTable = Schema::hasTable('ac_modules') ? 'ac_modules' : (Schema::hasTable('ac_permissions') ? 'ac_permissions' : null);
        if (!$permTable) {
            $this->error('Neither ac_modules nor ac_permissions table found. Aborting.');
            DB::rollBack();
            return;
        }
        $this->line("Clearing table: {$permTable}");
        DB::table($permTable)->delete();

        $menus = config('permissions.menus', []);
        $now = now();
        $inserts = [];
        foreach ($menus as $menuKey => $menuConfig) {
            $name = 'menu-' . $menuKey;
            $display = $menuConfig['label'] ?? ucfirst($menuKey);

            $payload = [
                (Schema::hasColumn($permTable, 'module_name') ? 'module_name' : 'name') => $name,
                'display_name' => $display,
                'description' => "Access to {$display} menu",
                'created_at' => $now,
                'updated_at' => $now,
            ];
            if (Schema::hasColumn($permTable, 'module')) {
                $payload['module'] = 'menu';
            }
            if (Schema::hasColumn($permTable, 'action')) {
                $payload['action'] = 'view';
            }
            if (Schema::hasColumn($permTable, 'resource')) {
                $payload['resource'] = $menuKey;
            }
            if (Schema::hasColumn($permTable, 'status')) {
                $payload['status'] = 'active';
            }
            if (Schema::hasColumn($permTable, 'is_system')) {
                $payload['is_system'] = true;
            }

            $inserts[] = $payload;
        }

        if (!empty($inserts)) {
            DB::table($permTable)->insert($inserts);
            $this->info('Inserted ' . count($inserts) . " menu permissions into {$permTable}.");
        } else {
            $this->warn("No menus found in config(permissions.menus). {$permTable} remains empty.");
        }

        try { DB::statement('SET FOREIGN_KEY_CHECKS=1'); } catch (\Throwable $e) {}
        DB::commit();

        try { Cache::forget(config('permission.cache.key', 'spatie.permission.cache')); } catch (\Throwable $e) {}

        $this->info('Menu permissions reset complete.');
    } catch (\Throwable $e) {
        DB::rollBack();
        $this->error('Failed to reset menus: ' . $e->getMessage());
    }
})->purpose('Reset ac_permissions and seed menu-* entries from config');

// Debug menu permissions for a user
Artisan::command('debug:menus {--user=} {--email=} {--clear-cache}', function () {
    $userId = $this->option('user');
    $email = $this->option('email');

    // Resolve user
    $userQuery = \App\Models\EnhancedUser::query();
    if ($userId) { $userQuery->where('id', (int)$userId); }
    if ($email) { $userQuery->where('email', $email); }
    if (!$userId && !$email) { $userQuery->where('role', 'student'); }

    $user = $userQuery->first();
    if (!$user) {
        $this->error('User not found. Provide --user=<id> or --email=<email>.');
        return 1;
    }

    $this->info("User: {$user->id} | {$user->name} | role='{$user->role}' | partner_id=" . ($user->partner_id ?? 'null'));

    // Show roles from ac_user_roles -> ac_roles
    $roleIdCol = \Schema::hasColumn('ac_user_roles', 'role_id') ? 'role_id' : (\Schema::hasColumn('ac_user_roles', 'enhanced_role_id') ? 'enhanced_role_id' : null);
    $userIdCol = \Schema::hasColumn('ac_user_roles', 'user_id') ? 'user_id' : 'enhanced_user_id';
    $roles = collect();
    if ($roleIdCol) {
        $roles = DB::table('ac_user_roles')
            ->join('ac_roles', "ac_user_roles.{$roleIdCol}", '=', 'ac_roles.id')
            ->where("ac_user_roles.{$userIdCol}", $user->id)
            ->select('ac_roles.id', 'ac_roles.name', 'ac_roles.display_name', 'ac_roles.level')
            ->get();
    }
    $this->line("Roles (via pivot): " . ($roles->count()));
    foreach ($roles as $r) {
        $this->line("  - [{$r->id}] {$r->name} ({$r->display_name}) level={$r->level}");
    }

    // Show menu modules present
    $permTable = \Schema::hasTable('ac_modules') ? 'ac_modules' : (\Schema::hasTable('ac_permissions') ? 'ac_permissions' : null);
    if (!$permTable) {
        $this->error('No permissions table found (ac_modules/ac_permissions).');
        return 1;
    }
    $nameCol = \Schema::hasColumn($permTable, 'module_name') ? 'module_name' : 'name';
    $modules = DB::table($permTable)->where($nameCol, 'LIKE', 'menu-%')->pluck($nameCol)->toArray();
    $this->line('Menu modules in DB: ' . count($modules));
    $this->line('  ' . implode(', ', array_slice($modules, 0, 20)) . (count($modules) > 20 ? ' ...' : ''));

    // Show permissions assigned to the user's roles (menu- only)
    $rpTable = \Schema::hasTable('ac_role_permissions') ? 'ac_role_permissions' : null;
    if ($rpTable && $roleIdCol) {
        $moduleIdCol = \Schema::hasColumn($rpTable, 'module_id') ? 'module_id' : (\Schema::hasColumn($rpTable, 'enhanced_permission_id') ? 'enhanced_permission_id' : null);
        $roleIdColRP = \Schema::hasColumn($rpTable, 'role_id') ? 'role_id' : (\Schema::hasColumn($rpTable, 'enhanced_role_id') ? 'enhanced_role_id' : null);
        if ($moduleIdCol && $roleIdColRP) {
            $roleIds = $roles->pluck('id')->all();
            if (!empty($roleIds)) {
                $assigned = DB::table($rpTable)
                    ->join($permTable, "$rpTable.$moduleIdCol", '=', "$permTable.id")
                    ->whereIn("$rpTable.$roleIdColRP", $roleIds)
                    ->where("$permTable.$nameCol", 'LIKE', 'menu-%')
                    ->select("$permTable.$nameCol as name")
                    ->pluck('name')
                    ->unique()
                    ->values()
                    ->all();
                $this->line('Assigned menu-* to roles: ' . count($assigned));
                $this->line('  ' . implode(', ', $assigned));
            } else {
                $this->warn('No roleIds found for user in ac_user_roles.');
            }
        }
    } else {
        $this->warn('ac_role_permissions table not found.');
    }

    // Optionally clear menu cache
    if ($this->option('clear-cache')) {
        try {
            app(\App\Services\MenuPermissionService::class)->clearUserCache($user->id);
            $this->info('Cleared user menu cache.');
        } catch (\Throwable $e) {
            $this->warn('Failed to clear cache: ' . $e->getMessage());
        }
    }

    // Impersonate user for service checks
    try {
        \Illuminate\Support\Facades\Auth::setUser($user);
    } catch (\Throwable $e) {}

    $service = app(\App\Services\MenuPermissionService::class);
    $accessible = $service->getAccessibleMenus();
    $this->info('Service getAccessibleMenus(): [' . implode(', ', $accessible) . ']');

    $checkMenus = ['students','courses','subjects','topics'];
    foreach ($checkMenus as $menu) {
        $can = $service->canAccessMenu($menu) ? 'YES' : 'NO';
        $this->line("  canAccessMenu('{$menu}') = {$can}");
    }

    return 0;
})->purpose('Debug menu permissions for a user and show why menus are hidden');
