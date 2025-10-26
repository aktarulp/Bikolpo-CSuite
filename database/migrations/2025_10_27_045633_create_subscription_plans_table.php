<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique('subscription_plans_slug_unique');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('implementation_cost', 10, 2)->nullable();
            $table->string('implementation_cost_label', 100)->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->string('offer_name')->nullable();
            $table->text('offer_description')->nullable();
            $table->timestamp('offer_start_date')->nullable();
            $table->timestamp('offer_end_date')->nullable();
            $table->integer('offer_max_users')->nullable();
            $table->integer('offer_used_count')->default(0);
            $table->boolean('offer_is_active')->default(0);
            $table->boolean('offer_auto_apply')->default(0);
            $table->string('offer_code')->nullable()->unique('subscription_plans_offer_code_unique');
            $table->string('offer_badge_text')->nullable();
            $table->string('offer_badge_color')->default('red');
            $table->boolean('offer_show_original_price')->default(1);
            $table->decimal('annual_price', 10, 2)->nullable();
            $table->string('annual_offer_name')->nullable();
            $table->text('annual_offer_description')->nullable();
            $table->integer('annual_discount_percentage')->nullable();
            $table->decimal('annual_savings_amount', 10, 2)->nullable();
            $table->boolean('annual_offer_active')->default(0);
            $table->string('annual_badge_text')->default('SAVE 2 MONTHS');
            $table->string('annual_badge_color')->default('green');
            $table->boolean('annual_show_monthly_equivalent')->default(1);
            $table->boolean('annual_highlight_savings')->default(1);
            $table->boolean('referral_eligible')->default(0);
            $table->integer('referral_reward_months')->default(1);
            $table->decimal('referral_minimum_amount', 10, 2)->nullable();
            $table->string('referral_conditions')->nullable();
            $table->string('currency', 3)->default('BDT');
            $table->enum('billing_cycle', ['monthly', 'yearly', 'lifetime'])->default('monthly');
            $table->enum('partner_type', ['student', 'partner'])->default('partner');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_popular')->default(0);
            $table->integer('sort_order')->default(0);
            $table->longText('features')->nullable();
            $table->longText('limits')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
}
