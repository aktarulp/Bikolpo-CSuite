<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'permissions') && !Schema::hasColumn('roles', 'permissions_legacy')) {
                $table->renameColumn('permissions', 'permissions_legacy');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'permissions_legacy') && !Schema::hasColumn('roles', 'permissions')) {
                $table->renameColumn('permissions_legacy', 'permissions');
            }
        });
    }
};
