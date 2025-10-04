<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ac_roles', function (Blueprint $table) {
            // Rename permissions_legacy column to is_delete
            $table->renameColumn('permissions_legacy', 'is_delete');
        });

        // First, change the column type to char(1) with default 'N' and NON-nullable
        Schema::table('ac_roles', function (Blueprint $table) {
            $table->char('is_delete', 1)->default('N')->nullable(false)->change();
        });
        
        // Then, update all existing NULL or empty values with default 'N'
        DB::table('ac_roles')
            ->whereNull('is_delete')
            ->orWhere('is_delete', '')
            ->update(['is_delete' => 'N']);
        
        // Also update any existing records that might have other values to 'N' as default
        // (unless they already have 'Y' or 'N')
        DB::table('ac_roles')
            ->whereNotIn('is_delete', ['Y', 'N'])
            ->update(['is_delete' => 'N']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ac_roles', function (Blueprint $table) {
            // Rename is_delete column back to permissions_legacy
            $table->renameColumn('is_delete', 'permissions_legacy');
        });
        
        // Note: You may need to adjust the column type back to its original type
        // if it was different from char(1). Check your original schema first.
    }
};
