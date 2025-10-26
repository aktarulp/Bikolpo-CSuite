<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('teacher_id')->unique('teachers_teacher_id_unique');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('photo')->nullable();
            $table->string('email')->unique('teachers_email_unique');
            $table->string('phone')->unique('teachers_phone_unique');
            $table->string('alternate_phone')->nullable();
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('mother_name');
            $table->string('mother_phone')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->string('emergency_contact_relation');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Other'])->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('upazila_id')->nullable();
            $table->string('post_office')->nullable();
            $table->string('village_road')->nullable();
            $table->string('designation');
            $table->string('department')->nullable();
            $table->string('subject_specialization')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('highest_degree')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('salary_type')->nullable();
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->text('account_details')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('notes')->nullable();
            $table->date('joining_date')->index('teachers_joining_date_index');
            $table->string('employee_type')->default('Permanent');
            $table->string('employment_status')->default('Active');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_routing_number')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->string('last_degree')->nullable();
            $table->string('university')->nullable();
            $table->integer('completion_year')->nullable();
            $table->string('achievement')->nullable();
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamp('deleted_at')->nullable();
            
            $table->index(['designation', 'department'], 'teachers_designation_department_index');
            $table->index(['employment_status', 'employee_type'], 'teachers_employment_status_employee_type_index');
            $table->foreign('created_by', 'teachers_created_by_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
            $table->foreign('district_id', 'teachers_district_id_foreign')->references('id')->on('districts')->onDelete('set NULL');
            $table->foreign('division_id', 'teachers_division_id_foreign')->references('id')->on('divisions')->onDelete('set NULL');
            $table->foreign('partner_id', 'teachers_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('upazila_id', 'teachers_upazila_id_foreign')->references('id')->on('upazilas')->onDelete('set NULL');
            $table->foreign('updated_by', 'teachers_updated_by_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
            $table->foreign('user_id', 'teachers_user_id_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
