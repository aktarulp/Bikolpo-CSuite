<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ac_roles', function (Blueprint $table) {
            if (!Schema::hasColumn('ac_roles', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('is_system');
            }
            if (!Schema::hasColumn('ac_roles', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('permissions_inheritance_mode');
                $table->foreign('created_by')->references('id')->on('ac_users')->onDelete('set null');
            }
            if (!Schema::hasColumn('ac_roles', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
                $table->foreign('updated_by')->references('id')->on('ac_users')->onDelete('set null');
            }
            if (!Schema::hasColumn('ac_roles', 'inherit_permissions')) {
                $table->boolean('inherit_permissions')->default(true)->after('parent_role_id');
            }
            if (!Schema::hasColumn('ac_roles', 'permissions_inheritance_mode')) {
                $table->string('permissions_inheritance_mode')->default('recursive')->after('inherit_permissions');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ac_roles', function (Blueprint $table) {
            if (Schema::hasColumn('ac_roles', 'is_default')) {
                $table->dropColumn('is_default');
            }
            if (Schema::hasColumn('ac_roles', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('ac_roles', 'updated_by')) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');
            }
            if (Schema::hasColumn('ac_roles', 'inherit_permissions')) {
                $table->dropColumn('inherit_permissions');
            }
            if (Schema::hasColumn('ac_roles', 'permissions_inheritance_mode')) {
                $table->dropColumn('permissions_inheritance_mode');
            }
        });
    }
};