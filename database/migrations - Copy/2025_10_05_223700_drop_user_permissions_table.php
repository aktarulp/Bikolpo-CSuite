<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop legacy direct user-permissions pivot if it exists
        Schema::dropIfExists('user_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left blank: we are deprecating direct user permissions in favor of role-based permissions
        // If needed, re-create the table via the original 2025_10_03_054201_create_user_permissions_table migration
    }
};
