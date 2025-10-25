<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Teacher;
use App\Models\Student;

class MigrateAllPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:migrate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all photos (students and teachers) from storage to public/uploads for Hostinger compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting photo migration for Hostinger compatibility...');
        $this->newLine();

        // Setup upload directories
        $this->info('📁 Setting up upload directories...');
        $directories = [
            'public/uploads',
            'public/uploads/student-photos',
            'public/uploads/teachers',
            'public/uploads/questions',
            'public/uploads/partners',
        ];

        foreach ($directories as $directory) {
            $path = base_path($directory);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
                $this->info("✓ Created: {$directory}");
            } else {
                $this->line("✓ Exists: {$directory}");
            }
        }

        $this->newLine();

        // Migrate student photos
        $this->info('👨‍🎓 Migrating student photos...');
        $students = Student::whereNotNull('photo')->get();
        $studentMigrated = 0;
        $studentSkipped = 0;

        foreach ($students as $student) {
            $photoPath = $student->photo;
            $sourcePath = storage_path('app/public/' . $photoPath);
            $destPath = public_path('uploads/' . $photoPath);
            
            $destDir = dirname($destPath);
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0775, true);
            }
            
            if (File::exists($sourcePath)) {
                if (!File::exists($destPath)) {
                    File::copy($sourcePath, $destPath);
                    $this->info("✓ Migrated: {$student->full_name}");
                    $studentMigrated++;
                } else {
                    $this->line("→ Skipped: {$student->full_name} (already exists)");
                    $studentSkipped++;
                }
            } else {
                $this->warn("⚠ Missing: {$student->full_name} - {$sourcePath}");
                $studentSkipped++;
            }
        }

        $this->newLine();

        // Migrate teacher photos
        $this->info('👨‍🏫 Migrating teacher photos...');
        $teachers = Teacher::whereNotNull('photo')->get();
        $teacherMigrated = 0;
        $teacherSkipped = 0;

        foreach ($teachers as $teacher) {
            $photoPath = $teacher->photo;
            $sourcePath = storage_path('app/public/' . $photoPath);
            $destPath = public_path('uploads/' . $photoPath);
            
            $destDir = dirname($destPath);
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0775, true);
            }
            
            if (File::exists($sourcePath)) {
                if (!File::exists($destPath)) {
                    File::copy($sourcePath, $destPath);
                    $this->info("✓ Migrated: {$teacher->full_name}");
                    $teacherMigrated++;
                } else {
                    $this->line("→ Skipped: {$teacher->full_name} (already exists)");
                    $teacherSkipped++;
                }
            } else {
                $this->warn("⚠ Missing: {$teacher->full_name} - {$sourcePath}");
                $teacherSkipped++;
            }
        }

        $this->newLine();
        $this->info("🎉 Migration complete!");
        $this->info("Students: {$studentMigrated} migrated, {$studentSkipped} skipped");
        $this->info("Teachers: {$teacherMigrated} migrated, {$teacherSkipped} skipped");
        $this->newLine();
        $this->info("✅ All photos are now accessible via public/uploads/ for Hostinger!");
        
        return Command::SUCCESS;
    }
}
