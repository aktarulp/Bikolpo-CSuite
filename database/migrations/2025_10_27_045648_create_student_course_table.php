<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_course', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->date('enrolled_at')->default('2025-10-19');
            $table->date('completed_at')->nullable();
            $table->enum('status', ['active', 'completed', 'dropped', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->timestamps();
            
            $table->foreign('batch_id', 'student_course_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('course_id', 'student_course_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('student_id', 'student_course_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_course');
    }
}
