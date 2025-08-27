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
            // Drop the existing foreign key constraint if it exists
            $table->dropForeign(['question_set_id']);
            
            // Rename the column
            $table->renameColumn('question_set_id', 'exam_question_id');
            
            // Add new foreign key constraint
            $table->foreign('exam_question_id')->references('id')->on('exam_questions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['exam_question_id']);
            
            // Rename the column back
            $table->renameColumn('exam_question_id', 'question_set_id');
            
            // Restore the original foreign key constraint
            $table->foreign('question_set_id')->references('id')->on('question_sets')->onDelete('set null');
        });
    }
};
