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
            // Add blood group column with all blood group types
            $table->enum('blood_group', [
                'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
            ])->nullable()->after('guardian_name');
            
            // Add religion column with relevant religions
            $table->enum('religion', [
                'Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Jainism', 
                'Sikhism', 'Judaism', 'Baháʼí', 'Zoroastrianism', 'Other'
            ])->nullable()->after('blood_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['religion', 'blood_group']);
        });
    }
};
