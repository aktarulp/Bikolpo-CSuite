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
        Schema::table('students', function (Blueprint $table) {
            // Add default_role column as text data type
            $table->string('default_role')->nullable()->after('created_by');
            
            // Add foreign key constraint to roles table name column
            $table->foreign('default_role')->references('name')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['default_role']);
            
            // Drop the column
            $table->dropColumn('default_role');
        });
    }
};
