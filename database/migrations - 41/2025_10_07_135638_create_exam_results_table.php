<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_id');
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->integer('total_questions');
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->integer('unanswered')->default(0);
            $table->decimal('score', 5, 2)->default(0.00);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->enum('result_type', ['auto', 'manual'])->default('auto')->comment("Type of result: auto (system generated) or manual (manually entered)");
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->json('answers')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by', 'student_exam_results_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('exam_id', 'student_exam_results_exam_id_foreign')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id', 'student_exam_results_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
}
