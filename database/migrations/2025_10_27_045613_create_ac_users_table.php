<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active');
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active');
            $table->string('password');
            $table->string('phone', 15)->nullable()->unique('users_phone_unique');
            $table->string('role', 50)->nullable();
            $table->unsignedBigInteger('role_id')->index('users_role_id_foreign');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('partner_id')->nullable()->index('users_partner_id_foreign');
            $table->unsignedBigInteger('created_by')->nullable()->index('users_created_by_foreign');
            $table->unsignedBigInteger('updated_by')->nullable()->index('users_updated_by_foreign');
            
            $table->foreign('student_id', 'ac_users_student_id_foreign')->references('id')->on('students')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_users');
    }
}
