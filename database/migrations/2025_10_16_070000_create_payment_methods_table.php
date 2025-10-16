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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Credit Card", "Bank Transfer", "Mobile Banking"
            $table->string('slug')->unique(); // e.g., "credit_card", "bank_transfer", "mobile_banking"
            $table->string('type'); // e.g., "card", "bank", "mobile", "digital_wallet", "crypto"
            $table->string('provider')->nullable(); // e.g., "Visa", "Mastercard", "bKash", "Rocket", "Nagad"
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Icon class or image path
            $table->string('color')->default('#3B82F6'); // Brand color for the payment method
            $table->json('configuration')->nullable(); // Payment gateway specific settings
            $table->json('supported_currencies')->nullable(); // Array of supported currencies
            $table->decimal('processing_fee_percentage', 5, 2)->default(0.00); // Processing fee percentage
            $table->decimal('processing_fee_fixed', 10, 2)->default(0.00); // Fixed processing fee
            $table->integer('min_amount')->default(0); // Minimum transaction amount
            $table->integer('max_amount')->nullable(); // Maximum transaction amount (null = unlimited)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->boolean('requires_verification')->default(false); // KYC verification required
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable(); // Additional metadata
            $table->timestamps();
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
