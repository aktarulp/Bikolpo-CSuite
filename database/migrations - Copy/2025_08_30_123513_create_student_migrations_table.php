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
        Schema::create('student_migrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->foreignId('to_course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->foreignId('from_batch_id')->nullable()->constrained('batches')->onDelete('set null');
            $table->foreignId('to_batch_id')->nullable()->constrained('batches')->onDelete('set null');
            $table->date('migration_date');
            $table->text('reason')->nullable();
            $table->string('status')->default('completed'); // pending, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['student_id', 'migration_date']);
            $table->index(['from_course_id', 'to_course_id']);
            $table->index(['from_batch_id', 'to_batch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_migrations');
    }
};
