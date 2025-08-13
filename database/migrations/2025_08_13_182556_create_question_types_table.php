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
        Schema::create('question_types', function (Blueprint $table) {
            $table->id('q_type_id');
            $table->string('q_type_name', 100)->unique();
            $table->string('q_type_code', 20)->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->boolean('has_options')->default(false);
            $table->boolean('has_explanation')->default(true);
            $table->boolean('has_image')->default(true);
            $table->boolean('has_marks')->default(true);
            $table->boolean('has_difficulty')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('q_type_code');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_types');
    }
};
