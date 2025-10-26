<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Bank', 'MFS', 'Cash']);
            $table->string('provider_name', 100)->nullable();
            $table->string('branch_name', 100)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('account_title', 150)->nullable();
            $table->string('routing_number', 50)->nullable();
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
        Schema::dropIfExists('payment_methods');
    }
}
