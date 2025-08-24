<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Must be first as other seeders depend on roles
            PartnerSeeder::class,
            PartnerComprehensiveSeeder::class, // Add comprehensive partner data
            CourseSeeder::class,
            StudentSeeder::class,
            QuestionTypeSeeder::class,
            QuestionSeeder::class,
            McqQuestionSeeder::class,
            QuestionHistorySeeder::class,
        ]);
    }
}
