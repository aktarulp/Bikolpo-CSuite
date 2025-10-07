<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing subject-course relationships to the pivot table
        $subjects = DB::table('subjects')
            ->whereNotNull('course_id')
            ->where('course_id', '>', 0)
            ->get();

        foreach ($subjects as $subject) {
            // Check if the relationship doesn't already exist
            $exists = DB::table('subject_on_course')
                ->where('course_id', $subject->course_id)
                ->where('subject_id', $subject->id)
                ->where('partner_id', $subject->partner_id)
                ->exists();

            if (!$exists) {
                DB::table('subject_on_course')->insert([
                    'course_id' => $subject->course_id,
                    'subject_id' => $subject->id,
                    'partner_id' => $subject->partner_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all relationships from the pivot table
        DB::table('subject_on_course')->truncate();
    }
};
