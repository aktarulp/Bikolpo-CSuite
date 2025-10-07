<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('ac_roles_name_unique');
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('level')->default(1);
            $table->boolean('is_system')->default(0);
            $table->unsignedBigInteger('parent_role_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('permissions')->nullable();
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
            
            $table->foreign('parent_role_id', 'ac_roles_parent_role_id_foreign')->references('id')->on('ac_roles')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_roles');
    }
}
