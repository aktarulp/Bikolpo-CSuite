<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
<<<<<<< Updated upstream
            PartnerSeeder::class,
            CourseSeeder::class,
            StudentSeeder::class,
            QuestionTypeSeeder::class,
            QuestionSeeder::class,
            McqQuestionSeeder::class,
            QuestionHistorySeeder::class,
=======
            ConsolidatedSeeder::class,
>>>>>>> Stashed changes
        ]);
    }
}
