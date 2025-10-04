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
        Schema::table('ac_roles', function (Blueprint $table) {
            // Add flag column with default value 'active'
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active')->after('status');
            
            // Add is_default boolean column with default 'N' on null insertion, nullable
            $table->char('is_default', 1)->default('N')->nullable()->after('flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ac_roles', function (Blueprint $table) {
            // Remove the added columns
            $table->dropColumn(['flag', 'is_default']);
        });
    }
};
