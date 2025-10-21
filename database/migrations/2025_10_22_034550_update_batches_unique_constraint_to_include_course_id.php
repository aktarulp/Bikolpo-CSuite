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
            // Drop the old unique constraint (partner_id + name + year)
            $table->dropUnique('batches_partner_id_name_year_unique');
            
            // Add new unique constraint that includes course_id
            // This allows same batch name in different courses
            $table->unique(
                ['partner_id', 'course_id', 'name', 'year'], 
                'batches_partner_id_course_id_name_year_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique('batches_partner_id_course_id_name_year_unique');
            
            // Restore the old unique constraint (for rollback)
            $table->unique(
                ['partner_id', 'name', 'year'], 
                'batches_partner_id_name_year_unique'
            );
        });
    }
};
