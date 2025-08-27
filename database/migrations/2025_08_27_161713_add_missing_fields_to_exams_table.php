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
            $table->string('language')->default('english')->after('total_questions');
            $table->text('question_head')->nullable()->after('language');
            $table->integer('question_limit')->nullable()->after('question_head');
            $table->boolean('is_verified')->default(false)->after('negative_marks_per_question');
            $table->boolean('is_public')->default(false)->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['language', 'question_head', 'question_limit', 'is_verified', 'is_public']);
        });
    }
};
