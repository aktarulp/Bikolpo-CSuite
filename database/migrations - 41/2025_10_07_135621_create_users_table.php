<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active');
            $table->string('password');
            $table->string('phone', 15)->nullable()->unique('users_phone_unique');
            $table->string('role', 50)->nullable();
            $table->unsignedBigInteger('role_id');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->foreign('created_by', 'users_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('partner_id', 'users_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('role_id', 'users_role_id_foreign')->references('id')->on('ac_roles')->onDelete('cascade');
            $table->foreign('updated_by', 'users_updated_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
