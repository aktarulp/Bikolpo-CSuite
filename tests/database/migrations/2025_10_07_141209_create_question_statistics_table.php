<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id')->index('question_statistics_student_id_foreign');
            $table->unsignedBigInteger('exam_result_id')->index('question_statistics_exam_result_id_foreign');
            $table->string('student_answer')->nullable();
            $table->string('correct_answer');
            $table->boolean('is_correct')->default(0);
            $table->boolean('is_answered')->default(0);
            $table->boolean('is_skipped')->default(0);
            $table->integer('time_spent_seconds')->nullable();
            $table->timestamp('question_started_at')->nullable();
            $table->timestamp('question_answered_at')->nullable();
            $table->integer('question_order')->default(0);
            $table->integer('marks')->default(1);
            $table->string('question_type')->default('mcq');
            $table->json('answer_metadata')->nullable();
            $table->timestamps();
            
            $table->index(['question_id', 'exam_id'], 'question_statistics_question_id_exam_id_index');
            $table->index(['question_id', 'is_correct'], 'question_statistics_question_id_is_correct_index');
            $table->index(['exam_id', 'student_id'], 'question_statistics_exam_id_student_id_index');
            $table->index(['question_id', 'created_at'], 'question_statistics_question_id_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_statistics');
    }
}
