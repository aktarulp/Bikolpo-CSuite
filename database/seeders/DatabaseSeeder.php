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
            RoleSeeder::class, // Create default hierarchical roles
            BasicDemoSeeder::class,
            DemoStudentsSeeder::class, // Add Bangladeshi demo students
            // McqQuestionSeeder::class,
            DescriptiveQuestionSeeder::class,
        ]);
    }
}
