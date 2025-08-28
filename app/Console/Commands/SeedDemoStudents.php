<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DemoStudentsSeeder;

class SeedDemoStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:demo-students {--force : Force seeding even if students exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed demo students for the currently authenticated user\'s partner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting demo students seeding...');
        
        try {
            // Run the seeder
            $seeder = new DemoStudentsSeeder();
            $seeder->setCommand($this);
            $seeder->run();
            
            $this->info('Demo students seeding completed successfully!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error seeding demo students: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
