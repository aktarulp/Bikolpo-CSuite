<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // 1) Backfill created_by from the role's created_by when available
        try {
            DB::statement("UPDATE ac_role_permissions arp
                JOIN ac_roles r ON r.id = arp.role_id
                SET arp.created_by = r.created_by
                WHERE arp.created_by IS NULL");
        } catch (\Throwable $e) {
            // ignore backfill errors to avoid breaking deploys
        }

        // 2) Add FK constraint to ac_users(id) with SET NULL on delete
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            if (Schema::hasColumn('ac_role_permissions', 'created_by')) {
                // Add index if not exists, then FK
                try {
                    $table->index('created_by', 'arp_created_by_idx');
                } catch (\Throwable $e) {}
                try {
                    $table->foreign('created_by', 'arp_created_by_fk')
                        ->references('id')->on('ac_users')
                        ->onUpdate('cascade')
                        ->onDelete('set null');
                } catch (\Throwable $e) {}
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('ac_role_permissions')) {
            return;
        }
        Schema::table('ac_role_permissions', function (Blueprint $table) {
            // Drop FK and index if they exist
            try { $table->dropForeign('arp_created_by_fk'); } catch (\Throwable $e) {}
            try { $table->dropIndex('arp_created_by_idx'); } catch (\Throwable $e) {}
        });

        // Optionally nullify created_by values (no-op)
    }
};
