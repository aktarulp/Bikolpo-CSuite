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
            // Offer pricing fields
            $table->decimal('offer_price', 10, 2)->nullable()->after('price');
            $table->string('offer_name')->nullable()->after('offer_price');
            $table->text('offer_description')->nullable()->after('offer_name');
            
            // Offer conditions
            $table->timestamp('offer_start_date')->nullable()->after('offer_description');
            $table->timestamp('offer_end_date')->nullable()->after('offer_start_date');
            $table->integer('offer_max_users')->nullable()->after('offer_end_date');
            $table->integer('offer_used_count')->default(0)->after('offer_max_users');
            
            // Offer settings
            $table->boolean('offer_is_active')->default(false)->after('offer_used_count');
            $table->boolean('offer_auto_apply')->default(false)->after('offer_is_active');
            $table->string('offer_code')->nullable()->unique()->after('offer_auto_apply');
            
            // Offer display settings
            $table->string('offer_badge_text')->nullable()->after('offer_code');
            $table->string('offer_badge_color')->default('red')->after('offer_badge_text');
            $table->boolean('offer_show_original_price')->default(true)->after('offer_badge_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'offer_price',
                'offer_name', 
                'offer_description',
                'offer_start_date',
                'offer_end_date',
                'offer_max_users',
                'offer_used_count',
                'offer_is_active',
                'offer_auto_apply',
                'offer_code',
                'offer_badge_text',
                'offer_badge_color',
                'offer_show_original_price'
            ]);
        });
    }
};