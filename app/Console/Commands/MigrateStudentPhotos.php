<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Student;

class MigrateStudentPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:migrate-students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate student photos from storage to public/uploads for Hostinger compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Migrating student photos to public/uploads/...');

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/student-photos');
        if (!File::exists($uploadsDir)) {
            File::makeDirectory($uploadsDir, 0775, true);
            $this->info("✓ Created: public/uploads/student-photos");
        }

        $students = Student::whereNotNull('photo')->get();
        $migrated = 0;
        $skipped = 0;

        foreach ($students as $student) {
            $photoPath = $student->photo;
            
            // Determine source and destination paths
            $sourcePath = storage_path('app/public/' . $photoPath);
            $destPath = public_path('uploads/' . $photoPath);
            
            // Ensure destination directory exists
            $destDir = dirname($destPath);
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0775, true);
            }
            
            if (File::exists($sourcePath)) {
                if (!File::exists($destPath)) {
                    File::copy($sourcePath, $destPath);
                    $this->info("✓ Migrated: {$student->full_name} - {$photoPath}");
                    $migrated++;
                } else {
                    $this->line("→ Skipped: {$student->full_name} - already exists");
                    $skipped++;
                }
            } else {
                $this->warn("⚠ Missing: {$student->full_name} - {$sourcePath}");
                $skipped++;
            }
        }

        $this->newLine();
        $this->info("✅ Migration complete!");
        $this->info("Migrated: {$migrated} photos");
        $this->info("Skipped: {$skipped} photos");
        
        return Command::SUCCESS;
    }
}
