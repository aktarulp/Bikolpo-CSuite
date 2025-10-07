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
        // Check if question_header column exists before trying to drop it
        if (Schema::hasColumn('questions', 'question_header')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->dropColumn('question_header');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add question_header back to questions table
        Schema::table('questions', function (Blueprint $table) {
            $table->text('question_header')->nullable()->after('question_text');
        });
    }
};