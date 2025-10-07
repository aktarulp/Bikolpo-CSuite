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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enhanced_role_id');
            $table->unsignedBigInteger('enhanced_permission_id');
            $table->unsignedBigInteger('granted_by')->nullable();
            $table->timestamp('granted_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('enhanced_role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('enhanced_permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('granted_by')->references('id')->on('users')->onDelete('set null');

            // Unique constraint to prevent duplicate role-permission assignments
            $table->unique(['enhanced_role_id', 'enhanced_permission_id'], 'role_permission_unique');

            // Indexes for better performance
            $table->index(['enhanced_role_id']);
            $table->index(['enhanced_permission_id']);
            $table->index(['granted_by']);
            $table->index(['expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
