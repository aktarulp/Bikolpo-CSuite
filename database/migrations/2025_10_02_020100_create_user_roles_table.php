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
        if (!Schema::hasTable('user_roles')) {
            Schema::create('user_roles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('assigned_by')->nullable();
                $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();

                // Foreign keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');

                // Unique constraint to prevent duplicate user-role assignments
                $table->unique(['user_id', 'role_id'], 'user_role_unique');

                // Indexes for better performance
                $table->index(['user_id']);
                $table->index(['role_id']);
                $table->index(['assigned_by']);
                $table->index(['expires_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
