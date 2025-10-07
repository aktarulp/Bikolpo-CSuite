<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypingPassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typing_passages', function (Blueprint $table) {
            $table->id();
            $table->text('passage_text');
            $table->string('title');
            $table->enum('language', ['english', 'bangla']);
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('category', ['general', 'technical', 'literature', 'news', 'academic', 'business']);
            $table->integer('word_count');
            $table->integer('character_count');
            $table->string('author')->nullable();
            $table->string('source')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->integer('usage_count')->default(0);
            $table->integer('average_wpm')->default(0);
            $table->integer('average_accuracy')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->index(['language', 'difficulty'], 'typing_passages_language_difficulty_index');
            $table->index(['category', 'is_active'], 'typing_passages_category_is_active_index');
            $table->foreign('created_by', 'typing_passages_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('typing_passages');
    }
}
