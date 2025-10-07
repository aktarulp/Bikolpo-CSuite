<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign keys that reference the legacy tables before dropping them
        if (Schema::hasTable('model_has_roles')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                try { $table->dropForeign(['role_id']); } catch (\Throwable $e) { /* ignore if not exists */ }
            });
        }
        if (Schema::hasTable('role_has_permissions')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                try { $table->dropForeign(['role_id']); } catch (\Throwable $e) { /* ignore if not exists */ }
                try { $table->dropForeign(['permission_id']); } catch (\Throwable $e) { /* ignore if not exists */ }
            });
        }
        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                try { $table->dropForeign(['permission_id']); } catch (\Throwable $e) { /* ignore if not exists */ }
            });
        }

        // Now drop the legacy tables if they exist
        Schema::dropIfExists('spatie_permissions');
        Schema::dropIfExists('spatie_roles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate minimal structures to allow rollback if needed
        if (!Schema::hasTable('spatie_permissions')) {
            Schema::create('spatie_permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->nullable();
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        if (!Schema::hasTable('spatie_roles')) {
            Schema::create('spatie_roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->nullable();
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        // Optionally re-add foreign keys if the pivot tables exist
        if (Schema::hasTable('model_has_roles')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                try { $table->foreign('role_id')->references('id')->on('spatie_roles')->onDelete('cascade'); } catch (\Throwable $e) { /* ignore */ }
            });
        }
        if (Schema::hasTable('role_has_permissions')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                try { $table->foreign('role_id')->references('id')->on('spatie_roles')->onDelete('cascade'); } catch (\Throwable $e) { /* ignore */ }
                try { $table->foreign('permission_id')->references('id')->on('spatie_permissions')->onDelete('cascade'); } catch (\Throwable $e) { /* ignore */ }
            });
        }
        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                try { $table->foreign('permission_id')->references('id')->on('spatie_permissions')->onDelete('cascade'); } catch (\Throwable $e) { /* ignore */ }
            });
        }
    }
};
