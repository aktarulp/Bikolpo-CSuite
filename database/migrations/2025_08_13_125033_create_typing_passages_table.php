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
        Schema::create('typing_passages', function (Blueprint $table) {
            $table->id();
            $table->text('passage_text'); // The actual text content
            $table->string('title', 255); // Title/name for the passage
            $table->enum('language', ['english', 'bangla']); // Language of the passage
            $table->enum('difficulty', ['easy', 'medium', 'hard']); // Difficulty level
            $table->enum('category', ['general', 'technical', 'literature', 'news', 'academic', 'business']); // Content category
            $table->integer('word_count'); // Number of words in the passage
            $table->integer('character_count'); // Number of characters in the passage
            $table->string('author', 255)->nullable(); // Author of the passage (if applicable)
            $table->string('source', 255)->nullable(); // Source of the passage (book, website, etc.)
            $table->text('description')->nullable(); // Description or notes about the passage
            $table->boolean('is_active')->default(true); // Whether the passage is available for tests
            $table->integer('usage_count')->default(0); // How many times this passage has been used
            $table->integer('average_wpm')->default(0); // Average WPM achieved with this passage
            $table->integer('average_accuracy')->default(0); // Average accuracy achieved with this passage
            $table->unsignedBigInteger('created_by')->nullable(); // User who created the passage
            $table->timestamps(); // Created and updated timestamps
            
            // Indexes for better performance
            $table->index(['language', 'difficulty']);
            $table->index(['category', 'is_active']);
            $table->index('created_by');
            
            // Foreign key constraint
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_passages');
    }
};
