<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // If the new table already exists, nothing to do
        if (Schema::hasTable('ac_role_permissions')) {
            return;
        }

        // If legacy table exists, rename and adjust columns
        if (Schema::hasTable('role_permissions')) {
            Schema::rename('role_permissions', 'ac_role_permissions');

            // Rename legacy columns if present
            if (Schema::hasColumn('ac_role_permissions', 'role_id') && !Schema::hasColumn('ac_role_permissions', 'enhanced_role_id')) {
                Schema::table('ac_role_permissions', function (Blueprint $table) {
                    $table->renameColumn('role_id', 'enhanced_role_id');
                });
            }
            if (Schema::hasColumn('ac_role_permissions', 'permission_id') && !Schema::hasColumn('ac_role_permissions', 'enhanced_permission_id')) {
                Schema::table('ac_role_permissions', function (Blueprint $table) {
                    $table->renameColumn('permission_id', 'enhanced_permission_id');
                });
            }

            // Add missing metadata/timestamps columns if not present
            Schema::table('ac_role_permissions', function (Blueprint $table) {
                if (!Schema::hasColumn('ac_role_permissions', 'granted_by')) {
                    $table->unsignedBigInteger('granted_by')->nullable()->after('enhanced_permission_id');
                }
                if (!Schema::hasColumn('ac_role_permissions', 'granted_at')) {
                    $table->timestamp('granted_at')->nullable()->after('granted_by');
                }
                if (!Schema::hasColumn('ac_role_permissions', 'expires_at')) {
                    $table->timestamp('expires_at')->nullable()->after('granted_at');
                }
                if (!Schema::hasColumn('ac_role_permissions', 'created_at')) {
                    $table->timestamps();
                }
            });

            // Add a unique index on (enhanced_role_id, enhanced_permission_id) if not present
            try {
                Schema::table('ac_role_permissions', function (Blueprint $table) {
                    $table->unique(['enhanced_role_id', 'enhanced_permission_id'], 'ac_role_permissions_role_permission_unique');
                });
            } catch (\Throwable $e) {
                // ignore if exists
            }

            return;
        }

        // Otherwise create fresh table
        Schema::create('ac_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enhanced_role_id');
            $table->unsignedBigInteger('enhanced_permission_id');
            $table->unsignedBigInteger('granted_by')->nullable();
            $table->timestamp('granted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['enhanced_role_id', 'enhanced_permission_id'], 'ac_role_permissions_role_permission_unique');
            // Foreign keys optional; skip to be safe in mixed legacy DBs
            // $table->foreign('enhanced_role_id')->references('id')->on('ac_roles')->onDelete('cascade');
            // $table->foreign('enhanced_permission_id')->references('id')->on('ac_permissions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('ac_role_permissions')) {
            Schema::drop('ac_role_permissions');
        }
    }
};
