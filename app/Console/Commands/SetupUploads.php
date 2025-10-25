<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:setup-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create upload directories for shared hosting (no symlink required)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directories = [
            'public/uploads',
            'public/uploads/student-photos',
            'public/uploads/teachers',
            'public/uploads/questions',
            'public/uploads/partners',
        ];

        $this->info('Setting up upload directories...');

        foreach ($directories as $directory) {
            $path = base_path($directory);
            
            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
                $this->info("✓ Created: {$directory}");
            } else {
                $this->info("✓ Exists: {$directory}");
            }

            // Ensure directory is writable
            if (!File::isWritable($path)) {
                $this->warn("⚠ Warning: {$directory} is not writable. Please set permissions to 775.");
            }
        }

        $this->newLine();
        $this->info('✅ Upload directories are ready!');
        $this->info('Files will be stored in public/uploads/ (no symlink needed)');
        
        return Command::SUCCESS;
    }
}

