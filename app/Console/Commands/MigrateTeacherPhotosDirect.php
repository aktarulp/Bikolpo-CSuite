<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Teacher;

class MigrateTeacherPhotosDirect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:migrate-teachers-direct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate teacher photos to direct public/uploads/teachers/ storage for Hostinger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Migrating teacher photos to direct uploads storage...');
        $this->newLine();

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/teachers');
        if (!File::exists($uploadsDir)) {
            File::makeDirectory($uploadsDir, 0775, true);
            $this->info("✓ Created: public/uploads/teachers");
        }

        $teachers = Teacher::whereNotNull('photo')->get();
        $migrated = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($teachers as $teacher) {
            $photoPath = $teacher->photo;
            
            // Check if photo is already in the correct format
            if (str_starts_with($photoPath, 'teachers/')) {
                $this->line("→ Already migrated: {$teacher->full_name}");
                $skipped++;
                continue;
            }
            
            // Try to find the photo in storage
            $sourcePaths = [
                storage_path('app/public/' . $photoPath),
                storage_path('app/public/teachers/' . $photoPath),
                storage_path('app/public/teacher-photos/' . $photoPath),
                public_path('uploads/' . $photoPath),
                public_path('uploads/teachers/' . $photoPath),
            ];
            
            $sourcePath = null;
            foreach ($sourcePaths as $path) {
                if (File::exists($path)) {
                    $sourcePath = $path;
                    break;
                }
            }
            
            if (!$sourcePath) {
                $this->warn("⚠ Photo not found: {$teacher->full_name} - {$photoPath}");
                $errors++;
                continue;
            }
            
            // Generate new filename
            $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
            $newFilename = time() . '_' . uniqid() . '.' . $extension;
            $destPath = $uploadsDir . '/' . $newFilename;
            
            try {
                // Copy file to new location
                File::copy($sourcePath, $destPath);
                
                // Update database with new path
                $teacher->update(['photo' => 'teachers/' . $newFilename]);
                
                $this->info("✓ Migrated: {$teacher->full_name} -> {$newFilename}");
                $migrated++;
                
            } catch (\Exception $e) {
                $this->error("✗ Failed to migrate {$teacher->full_name}: " . $e->getMessage());
                $errors++;
            }
        }

        $this->newLine();
        $this->info("🎉 Migration complete!");
        $this->info("Migrated: {$migrated} photos");
        $this->info("Skipped: {$skipped} photos");
        $this->info("Errors: {$errors} photos");
        
        if ($migrated > 0) {
            $this->newLine();
            $this->info("✅ Teacher photos are now stored directly in public/uploads/teachers/");
            $this->info("✅ Photos will be accessible via: https://yourdomain.com/uploads/teachers/filename.jpg");
        }
        
        return Command::SUCCESS;
    }
}
