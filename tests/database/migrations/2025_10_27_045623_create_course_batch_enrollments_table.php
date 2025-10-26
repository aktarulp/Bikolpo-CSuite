<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseBatchEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_batch_enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('partner_id');
            $table->date('enrolled_at');
            $table->enum('status', ['active', 'completed', 'dropped', 'suspended', 'transferred'])->default('active');
            $table->date('completion_date')->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('grade_letter', 2)->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('transferred_to_course_id')->nullable();
            $table->date('transferred_at')->nullable();
            $table->unsignedBigInteger('enrolled_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->unique(['student_id', 'course_id', 'status'], 'unique_active_enrollment');
            $table->index(['student_id', 'course_id'], 'enrollments_student_id_course_id_index');
            $table->index(['student_id', 'status'], 'enrollments_student_id_status_index');
            $table->index(['course_id', 'status'], 'enrollments_course_id_status_index');
            $table->index(['partner_id', 'status'], 'enrollments_partner_id_status_index');
            $table->foreign('batch_id', 'enrollments_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('course_id', 'enrollments_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('enrolled_by', 'enrollments_enrolled_by_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
            $table->foreign('partner_id', 'enrollments_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('student_id', 'enrollments_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_batch_enrollments');
    }
}
