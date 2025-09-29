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
        Schema::table('exams', function (Blueprint $table) {
            $table->string('exam_type')->default('online')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            // Revert to previous state if necessary, e.g., an enum with all previous values
            // Note: This might require knowing the previous state of the column if it wasn't a simple string
            $table->string('exam_type')->default('mcq')->change();
        });
    }
};
