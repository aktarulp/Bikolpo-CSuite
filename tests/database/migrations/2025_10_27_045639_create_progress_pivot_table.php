<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('topic_id');
            $table->decimal('completion_percentage', 5, 2)->default(0.00);
            $table->unsignedInteger('total_questions')->default(0);
            $table->unsignedInteger('attempted_questions')->default(0);
            $table->unsignedInteger('correct_answers')->default(0);
            $table->unsignedInteger('wrong_answers')->default(0);
            $table->unsignedInteger('unanswered_questions')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'topic_id'], 'progress_pivot_student_id_topic_id_unique');
            $table->foreign('student_id', 'progress_pivot_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('topic_id', 'progress_pivot_topic_id_foreign')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress_pivot');
    }
}
