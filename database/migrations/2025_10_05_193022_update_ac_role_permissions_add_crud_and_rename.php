<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Rename permission_id -> module_id (if present)
        if (Schema::hasColumn('ac_role_permissions', 'permission_id')) {
            Schema::table('ac_role_permissions', function (Blueprint $table) {
                $table->renameColumn('permission_id', 'module_id');
            });
        }

        // 2) Add 5 new columns: permission_name and 4 CRUD flags (default 0/false)
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('ac_role_permissions', 'permission_name')) {
                $table->string('permission_name')->nullable()->after('module_id');
            }
            if (!Schema::hasColumn('ac_role_permissions', 'can_create')) {
                $table->boolean('can_create')->default(false)->after('permission_name');
            }
            if (!Schema::hasColumn('ac_role_permissions', 'can_read')) {
                $table->boolean('can_read')->default(false)->after('can_create');
            }
            if (!Schema::hasColumn('ac_role_permissions', 'can_update')) {
                $table->boolean('can_update')->default(false)->after('can_read');
            }
            if (!Schema::hasColumn('ac_role_permissions', 'can_delete')) {
                $table->boolean('can_delete')->default(false)->after('can_update');
            }
        });
    }

    public function down(): void
    {
        // Drop newly added columns if they exist
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            $cols = ['permission_name','can_create','can_read','can_update','can_delete'];
            $existing = array_filter($cols, fn ($c) => Schema::hasColumn('ac_role_permissions', $c));
            if ($existing) {
                $table->dropColumn($existing);
            }
        });

        // Rename module_id back to permission_id (if present)
        if (Schema::hasColumn('ac_role_permissions', 'module_id')) {
            Schema::table('ac_role_permissions', function (Blueprint $table) {
                $table->renameColumn('module_id', 'permission_id');
            });
        }
    }
};
