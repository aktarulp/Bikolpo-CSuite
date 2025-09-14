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
            // Rename existing columns
            $table->renameColumn('parent_name', 'father_name');
            $table->renameColumn('parent_phone', 'father_phone');
            
            // Add new columns
            $table->string('mother_name')->nullable()->after('father_phone');
            $table->string('mother_phone')->nullable()->after('mother_name');
            $table->enum('guardian', ['Father', 'Mother', 'Other'])->nullable()->after('mother_phone');
            $table->string('guardian_name')->nullable()->after('guardian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['guardian_name', 'guardian', 'mother_phone', 'mother_name']);
            
            // Rename columns back
            $table->renameColumn('father_name', 'parent_name');
            $table->renameColumn('father_phone', 'parent_phone');
        });
    }
};
