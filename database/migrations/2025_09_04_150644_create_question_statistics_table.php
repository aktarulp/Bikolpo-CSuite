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
        Schema::create('question_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_result_id');
            
            // Question performance data
            $table->string('student_answer')->nullable(); // The answer given by student
            $table->string('correct_answer'); // The correct answer
            $table->boolean('is_correct')->default(false); // Whether the answer was correct
            $table->boolean('is_answered')->default(false); // Whether the question was answered at all
            $table->boolean('is_skipped')->default(false); // Whether the question was skipped
            
            // Time tracking
            $table->integer('time_spent_seconds')->nullable(); // Time spent on this question
            $table->timestamp('question_started_at')->nullable(); // When student started this question
            $table->timestamp('question_answered_at')->nullable(); // When student answered this question
            
            // Question context
            $table->integer('question_order')->default(0); // Order of question in exam
            $table->integer('marks')->default(1); // Marks for this question
            $table->string('question_type')->default('mcq'); // Type of question (mcq, descriptive)
            
            // Additional tracking
            $table->json('answer_metadata')->nullable(); // Additional data like word count for descriptive questions
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('exam_result_id')->references('id')->on('exam_results')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['question_id', 'exam_id']);
            $table->index(['question_id', 'is_correct']);
            $table->index(['exam_id', 'student_id']);
            $table->index(['question_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_statistics');
    }
};