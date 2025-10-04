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
        Schema::table('batches', function (Blueprint $table) {
            // Ensure year column exists (nullable to avoid failing existing rows)
            if (!Schema::hasColumn('batches', 'year')) {
                $table->integer('year')->nullable();
            }
            // Add dates if missing (nullable to be safe)
            if (!Schema::hasColumn('batches', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('batches', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });

        // Add composite unique index to prevent duplicates per partner per year
        Schema::table('batches', function (Blueprint $table) {
            // Ensure essential columns exist before creating unique index
            if (!Schema::hasColumn('batches', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('batches', 'partner_id')) {
                $table->unsignedBigInteger('partner_id')->nullable();
            }
            if (!Schema::hasColumn('batches', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
            if (!Schema::hasColumn('batches', 'flag')) {
                $table->enum('flag', ['active', 'deleted'])->default('active');
            }
            if (!Schema::hasColumn('batches', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
            }
            if (!Schema::hasColumn('batches', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('batches', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
            // Finally, add composite unique index if all columns exist
            if (Schema::hasColumn('batches', 'partner_id') && Schema::hasColumn('batches', 'name') && Schema::hasColumn('batches', 'year')) {
                $table->unique(['partner_id', 'name', 'year'], 'batches_partner_id_name_year_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Drop composite unique
            try { $table->dropUnique('batches_partner_id_name_year_unique'); } catch (\Throwable $e) {}
            // Optionally drop dates
            if (Schema::hasColumn('batches', 'end_date')) {
                $table->dropColumn('end_date');
            }
            if (Schema::hasColumn('batches', 'start_date')) {
                $table->dropColumn('start_date');
            }
        });
    }
};