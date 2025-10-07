<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename table ac_permissions -> ac_modules if needed
        if (Schema::hasTable('ac_permissions') && !Schema::hasTable('ac_modules')) {
            DB::statement('RENAME TABLE ac_permissions TO ac_modules');
        }

        if (!Schema::hasTable('ac_modules')) {
            // Nothing to do if neither table exists
            return;
        }

        // Rename column `name` -> `module_name` if it exists
        if (Schema::hasColumn('ac_modules', 'name') && !Schema::hasColumn('ac_modules', 'module_name')) {
            // Try to infer column definition to keep type/defaults
            try {
                $col = collect(DB::select("SHOW FULL COLUMNS FROM ac_modules WHERE Field = 'name'"))->first();
                if ($col) {
                    $type = $col->Type ?? 'varchar(255)';
                    $nullable = (isset($col->Null) && strtoupper($col->Null) === 'YES') ? 'NULL' : 'NOT NULL';
                    $default = isset($col->Default) ? (is_numeric($col->Default) ? "DEFAULT {$col->Default}" : (is_null($col->Default) ? '' : "DEFAULT '" . str_replace("'", "''", $col->Default) . "'")) : '';
                    // Build CHANGE statement preserving type/null/default
                    $sql = "ALTER TABLE ac_modules CHANGE COLUMN `name` `module_name` {$type} {$nullable} {$default}";
                    DB::statement($sql);
                } else {
                    // Fallback to typical varchar if we couldn't read metadata
                    DB::statement("ALTER TABLE ac_modules CHANGE COLUMN `name` `module_name` VARCHAR(255) NOT NULL");
                }
            } catch (\Throwable $e) {
                // Fallback path if SHOW FULL COLUMNS is unavailable
                DB::statement("ALTER TABLE ac_modules CHANGE COLUMN `name` `module_name` VARCHAR(255) NOT NULL");
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('ac_modules')) {
            return;
        }

        // Rename column back if present
        if (Schema::hasColumn('ac_modules', 'module_name') && !Schema::hasColumn('ac_modules', 'name')) {
            try {
                $col = collect(DB::select("SHOW FULL COLUMNS FROM ac_modules WHERE Field = 'module_name'"))->first();
                if ($col) {
                    $type = $col->Type ?? 'varchar(255)';
                    $nullable = (isset($col->Null) && strtoupper($col->Null) === 'YES') ? 'NULL' : 'NOT NULL';
                    $default = isset($col->Default) ? (is_numeric($col->Default) ? "DEFAULT {$col->Default}" : (is_null($col->Default) ? '' : "DEFAULT '" . str_replace("'", "''", $col->Default) . "'")) : '';
                    $sql = "ALTER TABLE ac_modules CHANGE COLUMN `module_name` `name` {$type} {$nullable} {$default}";
                    DB::statement($sql);
                } else {
                    DB::statement("ALTER TABLE ac_modules CHANGE COLUMN `module_name` `name` VARCHAR(255) NOT NULL");
                }
            } catch (\Throwable $e) {
                DB::statement("ALTER TABLE ac_modules CHANGE COLUMN `module_name` `name` VARCHAR(255) NOT NULL");
            }
        }

        // Rename table back if needed
        if (!Schema::hasTable('ac_permissions') && Schema::hasTable('ac_modules')) {
            DB::statement('RENAME TABLE ac_modules TO ac_permissions');
        }
    }
};
