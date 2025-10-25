<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Teacher;

class FixTeacherPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:fix-teachers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix teacher photos by ensuring they are in the correct location';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing teacher photos...');
        $this->newLine();

        // Step 1: Create directories
        $this->info('📁 Creating directories...');
        $directories = [
            'public/uploads',
            'public/uploads/teachers'
        ];

        foreach ($directories as $dir) {
            $fullPath = base_path($dir);
            if (!is_dir($fullPath)) {
                if (mkdir($fullPath, 0755, true)) {
                    $this->info("✓ Created: {$dir}");
                } else {
                    $this->error("✗ Failed to create: {$dir}");
                    return Command::FAILURE;
                }
            } else {
                $this->line("✓ Exists: {$dir}");
            }
        }

        // Step 2: Check teachers
        $teachers = Teacher::whereNotNull('photo')->get();
        $this->newLine();
        $this->info("👨‍🏫 Found {$teachers->count()} teachers with photos");

        if ($teachers->count() === 0) {
            $this->warn("No teachers with photos found. Create a teacher with a photo first.");
            return Command::SUCCESS;
        }

        // Step 3: Fix each teacher photo
        $fixed = 0;
        $alreadyFixed = 0;
        $errors = 0;

        foreach ($teachers as $teacher) {
            $this->line("Processing: {$teacher->full_name}");
            
            // Check if photo is already in correct format
            if (str_starts_with($teacher->photo, 'teachers/')) {
                $photoPath = public_path('uploads/' . $teacher->photo);
                if (file_exists($photoPath)) {
                    $this->line("  ✓ Already correct");
                    $alreadyFixed++;
                    continue;
                }
            }
            
            // Try to find the photo in various locations
            $sourcePaths = [
                storage_path('app/public/' . $teacher->photo),
                storage_path('app/public/teachers/' . basename($teacher->photo)),
                storage_path('app/public/teacher-photos/' . basename($teacher->photo)),
                public_path('uploads/' . $teacher->photo),
                public_path('uploads/teachers/' . basename($teacher->photo)),
            ];
            
            $sourcePath = null;
            foreach ($sourcePaths as $path) {
                if (File::exists($path)) {
                    $sourcePath = $path;
                    break;
                }
            }
            
            if (!$sourcePath) {
                $this->warn("  ⚠ Photo not found for {$teacher->full_name}");
                $errors++;
                continue;
            }
            
            // Generate new filename and path
            $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
            $newFilename = time() . '_' . uniqid() . '.' . $extension;
            $destPath = public_path('uploads/teachers/' . $newFilename);
            
            try {
                // Copy file to new location
                File::copy($sourcePath, $destPath);
                
                // Update database
                $teacher->update(['photo' => 'teachers/' . $newFilename]);
                
                $this->info("  ✓ Fixed: {$teacher->full_name} -> {$newFilename}");
                $fixed++;
                
            } catch (\Exception $e) {
                $this->error("  ✗ Failed: {$teacher->full_name} - " . $e->getMessage());
                $errors++;
            }
        }

        // Step 4: Summary
        $this->newLine();
        $this->info('📊 Summary:');
        $this->info("Fixed: {$fixed} photos");
        $this->info("Already correct: {$alreadyFixed} photos");
        $this->info("Errors: {$errors} photos");

        if ($fixed > 0) {
            $this->newLine();
            $this->info('✅ Teacher photos have been fixed!');
            $this->info('Photos are now stored in: public/uploads/teachers/');
            $this->info('URLs will be: https://yourdomain.com/uploads/teachers/filename.jpg');
        }

        return Command::SUCCESS;
    }
}
