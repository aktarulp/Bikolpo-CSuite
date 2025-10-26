<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('plan_id');
            $table->enum('usage_type', ['students', 'tests', 'questions', 'storage'])->default('students');
            $table->integer('current_usage')->default(0);
            $table->integer('limit_value')->default(0);
            $table->decimal('usage_percentage', 5, 2)->default(0.00);
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            
            $table->unique(['partner_id', 'usage_type'], 'subscription_usage_partner_id_usage_type_unique');
            $table->index(['partner_id', 'plan_id'], 'subscription_usage_partner_id_plan_id_index');
            $table->foreign('partner_id', 'subscription_usage_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('plan_id', 'subscription_usage_plan_id_foreign')->references('id')->on('subscription_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_usage');
    }
}
