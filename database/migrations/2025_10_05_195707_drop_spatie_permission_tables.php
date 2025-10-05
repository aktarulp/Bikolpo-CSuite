<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop unused Spatie tables if they exist
        if (Schema::hasTable('model_has_permissions')) {
            Schema::drop('model_has_permissions');
        }
        if (Schema::hasTable('role_has_permissions')) {
            Schema::drop('role_has_permissions');
        }
    }

    public function down(): void
    {
        // No-op: These legacy tables are intentionally removed and not recreated
    }
};
