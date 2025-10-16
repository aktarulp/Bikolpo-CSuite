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
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Student Dashboard", "Teacher Dashboard", "Multi User"
            $table->string('slug')->unique(); // e.g., "student_dashboard", "teacher_dashboard", "multi_user"
            $table->text('description')->nullable();
            $table->string('category')->default('general'); // e.g., "dashboard", "analytics", "communication", "storage"
            $table->string('type')->default('boolean'); // boolean, numeric, text, select
            $table->json('options')->nullable(); // For select type features
            $table->string('unit')->nullable(); // e.g., "users", "GB", "months", "per_month"
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['category', 'is_active']);
            $table->index('sort_order');
        });

        // Pivot table for subscription_plans and plan_features
        Schema::create('subscription_plan_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->foreignId('plan_feature_id')->constrained('plan_features')->onDelete('cascade');
            $table->boolean('is_enabled')->default(true);
            $table->string('value')->nullable(); // For numeric/text features
            $table->integer('limit_value')->nullable(); // For limit-based features
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['subscription_plan_id', 'plan_feature_id']);
            $table->index(['subscription_plan_id', 'is_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan_features');
        Schema::dropIfExists('plan_features');
    }
};
