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
            $table->unsignedBigInteger('student_id')->index('student_exam_results_student_id_foreign');
            $table->unsignedBigInteger('exam_id')->index('student_exam_results_exam_id_foreign');
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
            $table->longText('answers')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index('student_exam_results_created_by_foreign');
            $table->timestamps();
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
