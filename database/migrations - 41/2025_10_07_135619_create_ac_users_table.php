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
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('email')->unique('ac_users_email_unique');
            $table->string('name');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
            
            $table->foreign('role_id', 'ac_users_role_id_foreign')->references('id')->on('ac_roles')->onDelete('cascade')->onUpdate('restrict');
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
