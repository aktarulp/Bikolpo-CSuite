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
        // Referral codes table
        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('partners')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name')->nullable(); // Custom name for the referral code
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('max_uses')->nullable(); // Null = unlimited
            $table->integer('used_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['code', 'is_active']);
            $table->index('referrer_id');
        });

        // Referral tracking table
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('partners')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('partners')->onDelete('cascade');
            $table->foreignId('referral_code_id')->constrained('referral_codes')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, completed, expired, cancelled
            $table->timestamp('referred_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('metadata')->nullable(); // Additional tracking data
            $table->timestamps();
            
            $table->index(['referrer_id', 'status']);
            $table->index(['referred_id', 'status']);
            $table->index('referral_code_id');
            $table->unique(['referrer_id', 'referred_id']); // One referral per pair
        });

        // Referral rewards table
        Schema::create('referral_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->foreignId('referrer_id')->constrained('partners')->onDelete('cascade');
            $table->string('reward_type')->default('subscription_credit'); // subscription_credit, cash, discount
            $table->decimal('reward_value', 10, 2); // Value of the reward
            $table->string('reward_unit')->default('months'); // months, percentage, amount
            $table->string('status')->default('pending'); // pending, applied, expired, cancelled
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['referrer_id', 'status']);
            $table->index('referral_id');
        });

        // Add referral fields to subscription_plans
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->boolean('referral_eligible')->default(false)->after('annual_highlight_savings');
            $table->integer('referral_reward_months')->default(1)->after('referral_eligible');
            $table->decimal('referral_minimum_amount', 10, 2)->nullable()->after('referral_reward_months');
            $table->string('referral_conditions')->nullable()->after('referral_minimum_amount'); // JSON conditions
        });

        // Add referral tracking to partners
        Schema::table('partners', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->after('status');
            $table->integer('total_referrals')->default(0)->after('referral_code');
            $table->integer('successful_referrals')->default(0)->after('total_referrals');
            $table->decimal('referral_earnings', 10, 2)->default(0)->after('successful_referrals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_rewards');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referral_codes');
        
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'referral_eligible',
                'referral_reward_months',
                'referral_minimum_amount',
                'referral_conditions'
            ]);
        });
        
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'referral_code',
                'total_referrals',
                'successful_referrals',
                'referral_earnings'
            ]);
        });
    }
};