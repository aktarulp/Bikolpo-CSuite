<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ensure table exists before altering
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // 1) Change CRUD columns to CHAR(1) NOT NULL DEFAULT 'N'
        // Use raw SQL to avoid requiring doctrine/dbal for change()
        $crudCols = ['can_create','can_read','can_update','can_delete'];
        foreach ($crudCols as $col) {
            if (Schema::hasColumn('ac_role_permissions', $col)) {
                try {
                    DB::statement("ALTER TABLE ac_role_permissions MODIFY `{$col}` CHAR(1) NOT NULL DEFAULT 'N'");
                } catch (\Throwable $e) {
                    // Fallback: add if missing
                    // no-op: we assume column exists from previous migration
                }
            } else {
                // If the column didn't exist for some reason, create it
                Schema::table('ac_role_permissions', function (Blueprint $table) use ($col) {
                    $table->char($col, 1)->default('N');
                });
            }
        }

        // Normalize existing values to 'Y'/'N' right after type change
        try {
            DB::statement("UPDATE ac_role_permissions SET 
                can_create = CASE WHEN can_create IN ('1', 1, 'Y', 'y') THEN 'Y' ELSE 'N' END,
                can_read   = CASE WHEN can_read   IN ('1', 1, 'Y', 'y') THEN 'Y' ELSE 'N' END,
                can_update = CASE WHEN can_update IN ('1', 1, 'Y', 'y') THEN 'Y' ELSE 'N' END,
                can_delete = CASE WHEN can_delete IN ('1', 1, 'Y', 'y') THEN 'Y' ELSE 'N' END");
        } catch (\Throwable $e) {
            // Ignore normalization errors; columns already default to 'N'
        }

        // 2) Add new columns: created_by (nullable) and is_default CHAR(1) NOT NULL DEFAULT 'N'
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('ac_role_permissions', 'is_default')) {
                $table->char('is_default', 1)->default('N')->after('can_delete');
            }
            if (!Schema::hasColumn('ac_role_permissions', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('is_default');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // Drop added columns if exist
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            if (Schema::hasColumn('ac_role_permissions', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('ac_role_permissions', 'is_default')) {
                $table->dropColumn('is_default');
            }
        });

        // Revert CRUD columns back to TINYINT(1) NOT NULL DEFAULT 0 (boolean)
        $crudCols = ['can_create','can_read','can_update','can_delete'];
        foreach ($crudCols as $col) {
            if (Schema::hasColumn('ac_role_permissions', $col)) {
                try {
                    DB::statement("ALTER TABLE ac_role_permissions MODIFY `{$col}` TINYINT(1) NOT NULL DEFAULT 0");
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }
    }
};
