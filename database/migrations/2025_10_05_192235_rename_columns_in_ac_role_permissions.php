<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // Rename enhanced_role_id -> role_id
        if (Schema::hasColumn('ac_role_permissions', 'enhanced_role_id') && !Schema::hasColumn('ac_role_permissions', 'role_id')) {
            try {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `enhanced_role_id` `role_id` BIGINT UNSIGNED NOT NULL');
            } catch (\Throwable $e) {
                // Fallback without type
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `enhanced_role_id` `role_id` BIGINT');
            }
        }

        // Rename enhanced_permission_id -> permission_id
        if (Schema::hasColumn('ac_role_permissions', 'enhanced_permission_id') && !Schema::hasColumn('ac_role_permissions', 'permission_id')) {
            try {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `enhanced_permission_id` `permission_id` BIGINT UNSIGNED NOT NULL');
            } catch (\Throwable $e) {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `enhanced_permission_id` `permission_id` BIGINT');
            }
        }

        // Update unique index if it exists under old name
        try {
            DB::statement('ALTER TABLE ac_role_permissions DROP INDEX ac_role_permissions_role_permission_unique');
        } catch (\Throwable $e) {
            // ignore if not exists
        }
        try {
            DB::statement('CREATE UNIQUE INDEX ac_role_permissions_role_permission_unique ON ac_role_permissions (role_id, permission_id)');
        } catch (\Throwable $e) {
            // ignore if already exists
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // Revert permission_id -> enhanced_permission_id
        if (Schema::hasColumn('ac_role_permissions', 'permission_id') && !Schema::hasColumn('ac_role_permissions', 'enhanced_permission_id')) {
            try {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `permission_id` `enhanced_permission_id` BIGINT UNSIGNED NOT NULL');
            } catch (\Throwable $e) {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `permission_id` `enhanced_permission_id` BIGINT');
            }
        }

        // Revert role_id -> enhanced_role_id
        if (Schema::hasColumn('ac_role_permissions', 'role_id') && !Schema::hasColumn('ac_role_permissions', 'enhanced_role_id')) {
            try {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `role_id` `enhanced_role_id` BIGINT UNSIGNED NOT NULL');
            } catch (\Throwable $e) {
                DB::statement('ALTER TABLE ac_role_permissions CHANGE COLUMN `role_id` `enhanced_role_id` BIGINT');
            }
        }

        // Restore unique index name
        try {
            DB::statement('ALTER TABLE ac_role_permissions DROP INDEX ac_role_permissions_role_permission_unique');
        } catch (\Throwable $e) {
            // ignore
        }
        try {
            DB::statement('CREATE UNIQUE INDEX ac_role_permissions_role_permission_unique ON ac_role_permissions (enhanced_role_id, enhanced_permission_id)');
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
