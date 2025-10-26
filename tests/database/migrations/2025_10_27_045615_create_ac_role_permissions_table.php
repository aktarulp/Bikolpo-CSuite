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
            $table->unsignedBigInteger('role_id')->index('role_permissions_enhanced_role_id_index');
            $table->unsignedBigInteger('module_id')->index('role_permissions_enhanced_permission_id_index');
            $table->string('module_name')->nullable();
            $table->char('can_create', 1)->default('N');
            $table->char('can_read', 1)->default('N');
            $table->char('can_update', 1)->default('N');
            $table->char('can_delete', 1)->default('N');
            $table->char('is_default', 1)->default('N');
            $table->unsignedBigInteger('created_by')->nullable()->index('arp_created_by_idx');
            $table->unsignedBigInteger('granted_by')->nullable()->index('role_permissions_granted_by_index');
            $table->timestamp('granted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable()->index('role_permissions_expires_at_index');
            $table->timestamps();
            
            $table->unique(['role_id', 'module_id'], 'role_permission_unique');
            $table->unique(['role_id', 'module_id'], 'ac_role_permissions_role_permission_unique');
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
