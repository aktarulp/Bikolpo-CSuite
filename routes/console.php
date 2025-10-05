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

// List module stats and preview what would be kept vs removed
Artisan::command('permissions:list-modules', function () {
    $permTable = Schema::hasTable('ac_modules') ? 'ac_modules' : (Schema::hasTable('ac_permissions') ? 'ac_permissions' : null);
    if (!$permTable) { $this->error('No permissions table (ac_modules/ac_permissions).'); return 1; }
    $nameCol = Schema::hasColumn($permTable, 'module_name') ? 'module_name' : 'name';

    $all = DB::table($permTable)->select('id', $nameCol . ' as name')->get();
    $menu = $all->filter(fn($r) => str_starts_with($r->name, 'menu-'));
    $nonMenu = $all->reject(fn($r) => str_starts_with($r->name, 'menu-'));

    $this->info('Total modules: ' . $all->count());
    $this->line('  Menu modules: ' . $menu->count());
    $this->line('  Non-menu modules: ' . $nonMenu->count());

    $keepKeys = array_keys(config('permissions.menus', []));
    $keep = collect($keepKeys)->map(fn($k) => 'menu-' . $k)->values()->all();
    $this->line('Will keep (from config): ' . implode(', ', $keep));

    $previewRemove = $all->reject(fn($r) => in_array($r->name, $keep, true));
    $this->warn('Would remove/disable ' . $previewRemove->count() . ' modules (showing first 50):');
    foreach ($previewRemove->take(50) as $r) { $this->line('  - ' . $r->name); }

    return 0;
})->purpose('List modules and preview pruning results based on config(permissions.menus)');

// Prune modules to keep only menu-* defined in config(permissions.menus)
Artisan::command('permissions:prune-modules {--keep=} {--soft} {--force}', function () {
    $permTable = Schema::hasTable('ac_modules') ? 'ac_modules' : (Schema::hasTable('ac_permissions') ? 'ac_permissions' : null);
    if (!$permTable) { $this->error('No permissions table (ac_modules/ac_permissions).'); return 1; }
    $nameCol = Schema::hasColumn($permTable, 'module_name') ? 'module_name' : 'name';

    // Base keep list from config menus
    $keepKeys = array_keys(config('permissions.menus', []));
    $keep = collect($keepKeys)->map(fn($k) => 'menu-' . $k)->values()->all();

    // Merge any user-specified keep names (comma-separated)
    $extraKeep = $this->option('keep');
    if ($extraKeep) {
        $extra = collect(explode(',', $extraKeep))->map(fn($s) => trim($s))->filter()->values()->all();
        $keep = array_values(array_unique(array_merge($keep, $extra)));
    }

    $all = DB::table($permTable)->select('id', $nameCol . ' as name')->get();
    $remove = $all->reject(fn($r) => in_array($r->name, $keep, true));

    $this->info('Keeping ' . count($keep) . ' module names. Candidates to remove: ' . $remove->count());
    if (!$this->option('force')) {
        $this->warn('Dry-run: use --force to execute. Use --soft to mark status=inactive instead of deleting.');
        foreach ($remove->take(50) as $r) { $this->line('  - ' . $r->name); }
        return 0;
    }

    DB::beginTransaction();
    try {
        if ($this->option('soft') && Schema::hasColumn($permTable, 'status')) {
            $affected = DB::table($permTable)->whereIn('id', $remove->pluck('id'))->update(['status' => 'inactive', 'updated_at' => now()]);
            $this->info("Soft-disabled modules: {$affected}");
        } else {
            // Delete pivot rows in ac_role_permissions if present
            if (Schema::hasTable('ac_role_permissions')) {
                $moduleIdCol = Schema::hasColumn('ac_role_permissions', 'module_id') ? 'module_id' : (Schema::hasColumn('ac_role_permissions', 'enhanced_permission_id') ? 'enhanced_permission_id' : null);
                if ($moduleIdCol) {
                    $deletedPivots = DB::table('ac_role_permissions')->whereIn($moduleIdCol, $remove->pluck('id'))->delete();
                    $this->line('Deleted pivot rows in ac_role_permissions: ' . $deletedPivots);
                }
            }
            $deleted = DB::table($permTable)->whereIn('id', $remove->pluck('id'))->delete();
            $this->info('Deleted modules: ' . $deleted);
        }
        DB::commit();
    } catch (\Throwable $e) {
        DB::rollBack();
        $this->error('Prune failed: ' . $e->getMessage());
        return 1;
    }

    // Clear permission cache if any
    try { Cache::forget(config('permission.cache.key', 'spatie.permission.cache')); } catch (\Throwable $e) {}

    $this->info('Prune complete.');
    return 0;
})->purpose('Prune permissions table to only keep configured menu-* entries');

// Resequence ac_modules IDs starting from 1 and update pivots accordingly
Artisan::command('permissions:resequence-modules {--order=name} {--active-only} {--force}', function () {
    if (!$this->option('force')) {
        $this->warn('Dry-run: add --force to actually resequence IDs.');
    }

    $permTable = Schema::hasTable('ac_modules') ? 'ac_modules' : null;
    if (!$permTable) { $this->error('Table ac_modules not found.'); return 1; }

    $nameCol = Schema::hasColumn($permTable, 'module_name') ? 'module_name' : 'name';
    $statusCol = Schema::hasColumn($permTable, 'status') ? 'status' : null;

    // Load modules in desired order
    $q = DB::table($permTable)->select('id', $nameCol . ' as name');
    if ($this->option('active-only') && $statusCol) { $q->where($statusCol, 'active'); }
    $order = $this->option('order') ?: 'name';
    if ($order === 'created') { $q->orderBy('id'); } else { $q->orderBy('name'); }

    $modules = $q->get();
    if ($modules->isEmpty()) { $this->warn('No modules found to resequence.'); return 0; }

    // Build mapping old_id -> new_id
    $mapping = [];
    $newId = 1;
    foreach ($modules as $m) { $mapping[(int)$m->id] = $newId++; }

    $this->info('Prepared mapping for ' . count($mapping) . ' modules.');
    $show = 0; foreach ($mapping as $old => $new) { if ($show++ < 10) $this->line("  $old => $new"); else break; }

    if (!$this->option('force')) { return 0; }

    try {
        // Disable FKs during resequence
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Offset IDs to avoid PK collisions
        $offset = 1000000;
        DB::table($permTable)->update(['id' => DB::raw('id + ' . $offset)]);

        // Set IDs to new sequence (small ids)
        foreach ($mapping as $old => $new) {
            DB::table($permTable)->where('id', $old + $offset)->update(['id' => $new]);
        }

        // Update pivots to reference the new small ids
        if (Schema::hasTable('ac_role_permissions')) {
            $rp = 'ac_role_permissions';
            $moduleIdCol = Schema::hasColumn($rp, 'module_id') ? 'module_id' : (Schema::hasColumn($rp, 'enhanced_permission_id') ? 'enhanced_permission_id' : null);
            if ($moduleIdCol) {
                foreach ($mapping as $old => $new) {
                    DB::table($rp)->where($moduleIdCol, $old)->update([$moduleIdCol => $new]);
                }
                $this->line('Updated role-permission pivots.');
            }
        }

        // Reset auto increment to next value
        $next = max($mapping) + 1;
        DB::statement('ALTER TABLE ' . $permTable . ' AUTO_INCREMENT = ' . (int)$next);

        // Re-enable FKs
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Resequence complete. Auto-increment set to ' . $next . '.');
    } catch (\Throwable $e) {
        try { DB::statement('SET FOREIGN_KEY_CHECKS=1'); } catch (\Throwable $e2) {}
        $this->error('Resequence failed: ' . $e->getMessage());
        return 1;
    }

    // Clear caches
    try { Cache::forget(config('permission.cache.key', 'spatie.permission.cache')); } catch (\Throwable $e) {}

    return 0;
})->purpose('Resequence ac_modules IDs from 1 and update dependent pivots safely');
