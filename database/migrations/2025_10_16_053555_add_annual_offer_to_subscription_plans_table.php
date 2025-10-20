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
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Annual subscription offer fields
            $table->decimal('annual_price', 10, 2)->nullable()->after('offer_show_original_price');
            $table->string('annual_offer_name')->nullable()->after('annual_price');
            $table->text('annual_offer_description')->nullable()->after('annual_offer_name');
            $table->integer('annual_discount_percentage')->nullable()->after('annual_offer_description');
            $table->decimal('annual_savings_amount', 10, 2)->nullable()->after('annual_discount_percentage');
            $table->boolean('annual_offer_active')->default(false)->after('annual_savings_amount');
            $table->string('annual_badge_text')->default('SAVE 2 MONTHS')->after('annual_offer_active');
            $table->string('annual_badge_color')->default('green')->after('annual_badge_text');
            $table->boolean('annual_show_monthly_equivalent')->default(true)->after('annual_badge_color');
            $table->boolean('annual_highlight_savings')->default(true)->after('annual_show_monthly_equivalent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'annual_price',
                'annual_offer_name',
                'annual_offer_description',
                'annual_discount_percentage',
                'annual_savings_amount',
                'annual_offer_active',
                'annual_badge_text',
                'annual_badge_color',
                'annual_show_monthly_equivalent',
                'annual_highlight_savings'
            ]);
        });
    }
};