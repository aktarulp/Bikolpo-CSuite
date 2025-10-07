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
            // Modify religion column to only include 4 main religions
            $table->enum('religion', [
                'Islam', 'Hinduism', 'Christianity', 'Buddhism'
            ])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Revert back to original religion options
            $table->enum('religion', [
                'Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Jainism', 
                'Sikhism', 'Judaism', 'Baháʼí', 'Zoroastrianism', 'Other'
            ])->nullable()->change();
        });
    }
};
