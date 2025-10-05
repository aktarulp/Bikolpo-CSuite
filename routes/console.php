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
