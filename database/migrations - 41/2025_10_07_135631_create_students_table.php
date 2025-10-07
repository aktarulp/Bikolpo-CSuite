<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->date('enroll_date')->nullable();
            $table->string('full_name');
            $table->string('student_id')->nullable()->unique('students_student_id_unique');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('photo')->nullable();
            $table->string('email')->unique('students_email_unique');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('school_college')->nullable();
            $table->string('class_grade')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->enum('guardian', ['Father', 'Mother', 'Other'])->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity', 'Buddhism'])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('enable_login', ['y', 'n'])->default('n');
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->timestamp('assignment_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('default_role')->nullable();
            $table->timestamps();
            
            $table->foreign('batch_id', 'students_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('course_id', 'students_course_id_foreign')->references('id')->on('courses')->onDelete('set NULL');
            $table->foreign('created_by', 'students_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('default_role', 'students_default_role_foreign')->references('name')->on('roles')->onDelete('set NULL');
            $table->foreign('partner_id', 'students_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('user_id', 'students_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
