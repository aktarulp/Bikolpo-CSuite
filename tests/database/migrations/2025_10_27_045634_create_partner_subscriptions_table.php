<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('plan_id');
            $table->enum('status', ['active', 'inactive', 'cancelled', 'expired', 'trial'])->default('trial');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at')->nullable()->index('partner_subscriptions_expires_at_index');
            $table->boolean('auto_renew')->default(1);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('currency', 3)->default('BDT');
            $table->timestamps();
            
            $table->index(['partner_id', 'status'], 'partner_subscriptions_partner_id_status_index');
            $table->foreign('partner_id', 'partner_subscriptions_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('plan_id', 'partner_subscriptions_plan_id_foreign')->references('id')->on('subscription_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_subscriptions');
    }
}
