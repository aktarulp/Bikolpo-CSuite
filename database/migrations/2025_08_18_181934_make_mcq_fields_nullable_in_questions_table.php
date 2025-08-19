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
        Schema::table('questions', function (Blueprint $table) {
            // Make MCQ-specific fields nullable to accommodate descriptive questions
            $table->string('option_a')->nullable()->change();
            $table->string('option_b')->nullable()->change();
            $table->string('option_c')->nullable()->change();
            $table->string('option_d')->nullable()->change();
            $table->enum('correct_answer', ['a', 'b', 'c', 'd'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Revert MCQ-specific fields back to required
            $table->string('option_a')->nullable(false)->change();
            $table->string('option_b')->nullable(false)->change();
            $table->string('option_c')->nullable(false)->change();
            $table->string('option_d')->nullable(false)->change();
            $table->enum('correct_answer', ['a', 'b', 'c', 'd'])->nullable(false)->change();
        });
    }
};
