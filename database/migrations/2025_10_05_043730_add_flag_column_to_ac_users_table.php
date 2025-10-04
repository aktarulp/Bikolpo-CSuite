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
        Schema::table('ac_users', function (Blueprint $table) {
            // Add flag column as enum with active as default
            $table->enum('flag', ['active', 'inactive', 'deleted'])
                  ->default('active')
                  ->after('status')
                  ->comment('User flag status: active (default), inactive, deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ac_users', function (Blueprint $table) {
            // Remove the flag column
            $table->dropColumn('flag');
        });
    }
};
