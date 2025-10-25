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
        Schema::table('teachers', function (Blueprint $table) {
            // Add missing columns for teacher profile
            $table->string('subject_specialization')->nullable()->after('department');
            $table->integer('experience_years')->nullable()->after('subject_specialization');
            $table->string('highest_degree')->nullable()->after('experience_years');
            $table->string('institution_name')->nullable()->after('highest_degree');
            $table->string('salary_type')->nullable()->after('institution_name');
            $table->decimal('salary_amount', 10, 2)->nullable()->after('salary_type');
            $table->string('payment_method')->nullable()->after('salary_amount');
            $table->text('account_details')->nullable()->after('payment_method');
            $table->text('present_address')->nullable()->after('account_details');
            $table->text('permanent_address')->nullable()->after('present_address');
            $table->text('notes')->nullable()->after('permanent_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn([
                'subject_specialization',
                'experience_years',
                'highest_degree',
                'institution_name',
                'salary_type',
                'salary_amount',
                'payment_method',
                'account_details',
                'present_address',
                'permanent_address',
                'notes'
            ]);
        });
    }
};
