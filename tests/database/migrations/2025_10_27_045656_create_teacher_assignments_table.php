<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('partner_id');
            $table->timestamp('assigned_at')->useCurrent()->index('teacher_assignments_assigned_at_index');
            $table->unsignedBigInteger('assigned_by');
            $table->enum('status', ['active', 'inactive', 'completed', 'dropped'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->unique(['teacher_id', 'course_id', 'subject_id', 'student_id'], 'unique_teacher_assignment');
            $table->index(['teacher_id', 'status'], 'teacher_assignments_teacher_id_status_index');
            $table->index(['course_id', 'status'], 'teacher_assignments_course_id_status_index');
            $table->index(['subject_id', 'status'], 'teacher_assignments_subject_id_status_index');
            $table->index(['student_id', 'status'], 'teacher_assignments_student_id_status_index');
            $table->index(['batch_id', 'status'], 'teacher_assignments_batch_id_status_index');
            $table->index(['partner_id', 'status'], 'teacher_assignments_partner_id_status_index');
            $table->foreign('assigned_by', 'teacher_assignments_assigned_by_foreign')->references('id')->on('ac_users')->onDelete('cascade');
            $table->foreign('batch_id', 'teacher_assignments_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('course_id', 'teacher_assignments_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('partner_id', 'teacher_assignments_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('student_id', 'teacher_assignments_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id', 'teacher_assignments_subject_id_foreign')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id', 'teacher_assignments_teacher_id_foreign')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_assignments');
    }
}
