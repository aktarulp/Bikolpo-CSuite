<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('ac_role_permissions', 'permission_name') && !Schema::hasColumn('ac_role_permissions', 'module_name')) {
            Schema::table('ac_role_permissions', function (Blueprint $table) {
                $table->renameColumn('permission_name', 'module_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ac_role_permissions', 'module_name') && !Schema::hasColumn('ac_role_permissions', 'permission_name')) {
            Schema::table('ac_role_permissions', function (Blueprint $table) {
                $table->renameColumn('module_name', 'permission_name');
            });
        }
    }
};
