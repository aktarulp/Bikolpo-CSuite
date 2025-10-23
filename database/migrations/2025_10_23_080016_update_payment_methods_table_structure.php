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
        // Drop existing payment_methods table if it exists
        Schema::dropIfExists('payment_methods');
        
        // Create new payment_methods table with updated structure
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->enum('type', ['Bank', 'MFS', 'Cash']); // Payment type
            $table->string('provider_name', 100)->nullable(); // Bank name or MFS provider (nullable for Cash)
            $table->string('branch_name', 100)->nullable(); // Bank branch (nullable for MFS and Cash)
            $table->string('account_number', 50)->nullable(); // Account number (nullable for Cash)
            $table->string('account_title', 150)->nullable(); // Name of account holder (nullable for Cash)
            $table->string('routing_number', 50)->nullable(); // Optional, mainly for banks (nullable)
            $table->timestamps(); // Auto timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
