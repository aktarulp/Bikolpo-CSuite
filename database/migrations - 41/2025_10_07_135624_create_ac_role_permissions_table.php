<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('module_id');
            $table->string('module_name')->nullable();
            $table->char('can_create', 1)->default('N');
            $table->char('can_read', 1)->default('N');
            $table->char('can_update', 1)->default('N');
            $table->char('can_delete', 1)->default('N');
            $table->char('is_default', 1)->default('N');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('granted_by')->nullable();
            $table->timestamp('granted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable()->index('role_permissions_expires_at_index');
            $table->timestamps();
            
            $table->unique(['role_id', 'module_id'], 'role_permission_unique');
            $table->unique(['role_id', 'module_id'], 'ac_role_permissions_role_permission_unique');
            $table->foreign('created_by', 'arp_created_by_fk')->references('id')->on('ac_users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('module_id', 'role_permissions_enhanced_permission_id_foreign')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id', 'role_permissions_enhanced_role_id_foreign')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('granted_by', 'role_permissions_granted_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_role_permissions');
    }
}
