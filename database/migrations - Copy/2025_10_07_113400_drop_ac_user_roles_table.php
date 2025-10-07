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
        Schema::dropIfExists('ac_user_roles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('ac_user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enhanced_user_id')->constrained('ac_users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('ac_roles')->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('ac_users')->onDelete('set null');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['enhanced_user_id', 'role_id']);
        });
    }
};
