<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('question_id');
            $table->integer('order')->default(0);
            $table->integer('marks')->default(1);
            $table->timestamps();
            
            $table->unique(['exam_id', 'question_id'], 'exam_questions_exam_id_question_id_unique');
            $table->foreign('exam_id', 'exam_questions_exam_id_foreign')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('question_id', 'exam_questions_question_id_foreign')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_questions');
    }
}
