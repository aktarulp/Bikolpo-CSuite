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
        Schema::create('question_history', function (Blueprint $table) {
            $table->id('record_id');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->string('public_exam_name');
            $table->string('exam_month');
            $table->integer('exam_year');
            $table->text('remarks')->nullable();
            $table->string('exam_board')->nullable(); // e.g., CBSE, ICSE, State Board
            $table->string('exam_type')->nullable(); // e.g., Board, Competitive, Entrance
            $table->string('subject_name')->nullable(); // Subject name for reference
            $table->string('topic_name')->nullable(); // Topic name for reference
            $table->integer('question_number')->nullable(); // Question number in the exam
            $table->integer('marks_allocated')->nullable(); // Marks allocated for this question
            $table->string('difficulty_level')->nullable(); // Easy, Medium, Hard
            $table->string('source_reference')->nullable(); // Any source or reference material
            $table->boolean('is_verified')->default(false); // Whether the question has been verified
            $table->string('verified_by')->nullable(); // Who verified the question
            $table->timestamp('verified_at')->nullable(); // When it was verified
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['question_id', 'exam_year']);
            $table->index(['public_exam_name', 'exam_year']);
            $table->index(['exam_month', 'exam_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_history');
    }
};
