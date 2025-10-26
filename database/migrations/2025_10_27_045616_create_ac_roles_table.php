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
            $table->boolean('is_default')->default(0);
            $table->unsignedBigInteger('parent_role_id')->nullable();
            $table->boolean('inherit_permissions')->default(1);
            $table->string('permissions_inheritance_mode')->default('recursive');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->longText('permissions')->nullable();
            $table->enum('flag', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
            
            $table->foreign('created_by', 'ac_roles_created_by_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
            $table->foreign('parent_role_id', 'ac_roles_parent_role_id_foreign')->references('id')->on('ac_roles')->onDelete('set NULL');
            $table->foreign('updated_by', 'ac_roles_updated_by_foreign')->references('id')->on('ac_users')->onDelete('set NULL');
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
