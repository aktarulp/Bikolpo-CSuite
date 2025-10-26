<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique('subscription_transactions_transaction_id_unique');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('plan_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BDT');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method');
            $table->string('payment_gateway')->nullable();
            $table->string('gateway_transaction_id')->nullable();
            $table->text('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable()->index('subscription_transactions_paid_at_index');
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['partner_id', 'status'], 'subscription_transactions_partner_id_status_index');
            $table->index(['status', 'created_at'], 'subscription_transactions_status_created_at_index');
            $table->foreign('partner_id', 'subscription_transactions_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('plan_id', 'subscription_transactions_plan_id_foreign')->references('id')->on('subscription_plans');
            $table->foreign('subscription_id', 'subscription_transactions_subscription_id_foreign')->references('id')->on('partner_subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_transactions');
    }
}
