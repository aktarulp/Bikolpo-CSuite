<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('permissions_name_unique');
            $table->string('display_name');
            $table->string('module');
            $table->string('action');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->index(['module', 'action'], 'permissions_module_action_index');
            $table->index(['status', 'module'], 'permissions_status_module_index');
            $table->foreign('created_by', 'permissions_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('updated_by', 'permissions_updated_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
