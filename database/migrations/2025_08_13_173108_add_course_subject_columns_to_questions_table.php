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
            if (!Schema::hasColumn('questions', 'course_id')) {
                $table->unsignedBigInteger('course_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('questions', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('course_id');
            }
            if (!Schema::hasColumn('questions', 'question_type')) {
                $table->enum('question_type', ['mcq', 'descriptive', 'comprehensive'])->default('mcq')->after('subject_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['course_id', 'subject_id', 'question_type']);
        });
    }
};
