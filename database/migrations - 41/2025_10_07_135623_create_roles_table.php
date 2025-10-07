<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('roles_name_unique');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->integer('level')->default(1);
            $table->json('permissions_legacy')->nullable();
            $table->unsignedBigInteger('parent_role_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by', 'roles_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('parent_role_id', 'roles_parent_role_id_foreign')->references('id')->on('roles')->onDelete('set NULL');
            $table->foreign('updated_by', 'roles_updated_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
