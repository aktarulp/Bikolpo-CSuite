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
        Schema::create('subscription_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans');
            $table->enum('usage_type', ['students', 'tests', 'questions', 'storage'])->default('students');
            $table->integer('current_usage')->default(0);
            $table->integer('limit_value')->default(0);
            $table->decimal('usage_percentage', 5, 2)->default(0);
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            
            $table->unique(['partner_id', 'usage_type']);
            $table->index(['partner_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_usage');
    }
};
