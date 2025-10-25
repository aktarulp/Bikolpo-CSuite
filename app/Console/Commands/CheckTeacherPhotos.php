<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Teacher;

class CheckTeacherPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:check-teachers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check teacher photos and diagnose issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking teacher photos...');
        $this->newLine();

        // Check directory structure
        $this->info('📁 Directory Structure:');
        $directories = [
            'public/uploads',
            'public/uploads/teachers',
            'storage/app/public',
            'storage/app/public/teachers'
        ];

        foreach ($directories as $dir) {
            $fullPath = base_path($dir);
            if (is_dir($fullPath)) {
                $files = scandir($fullPath);
                $fileCount = count($files) - 2;
                $this->line("✓ {$dir} - EXISTS ({$fileCount} files)");
            } else {
                $this->line("✗ {$dir} - NOT EXISTS");
            }
        }

        $this->newLine();

        // Check teachers with photos
        $teachers = Teacher::whereNotNull('photo')->get();
        $this->info("👨‍🏫 Teachers with photos: {$teachers->count()}");

        if ($teachers->count() > 0) {
            $this->newLine();
            $this->info('📋 Teacher Photo Details:');
            
            foreach ($teachers as $teacher) {
                $this->line("Teacher: {$teacher->full_name}");
                $this->line("  Photo Path: {$teacher->photo}");
                $this->line("  Photo URL: {$teacher->photo_url}");
                
                // Check if file exists
                $photoPath = public_path('uploads/' . $teacher->photo);
                if (file_exists($photoPath)) {
                    $this->line("  File Status: ✓ EXISTS");
                    $this->line("  File Size: " . filesize($photoPath) . " bytes");
                    $this->line("  File Permissions: " . substr(sprintf('%o', fileperms($photoPath)), -4));
                } else {
                    $this->line("  File Status: ✗ NOT FOUND");
                    
                    // Check alternative locations
                    $altPaths = [
                        storage_path('app/public/' . $teacher->photo),
                        storage_path('app/public/teachers/' . basename($teacher->photo)),
                        public_path('uploads/teachers/' . basename($teacher->photo)),
                    ];
                    
                    foreach ($altPaths as $altPath) {
                        if (file_exists($altPath)) {
                            $this->line("  Alternative found: {$altPath}");
                        }
                    }
                }
                $this->newLine();
            }
        }

        // Check file permissions
        $this->info('🔐 File Permissions:');
        $uploadsDir = public_path('uploads');
        if (is_dir($uploadsDir)) {
            $this->line("Uploads directory permissions: " . substr(sprintf('%o', fileperms($uploadsDir)), -4));
            
            $teachersDir = public_path('uploads/teachers');
            if (is_dir($teachersDir)) {
                $this->line("Teachers directory permissions: " . substr(sprintf('%o', fileperms($teachersDir)), -4));
            }
        }

        // Test URL generation
        $this->newLine();
        $this->info('🌐 URL Generation Test:');
        $this->line("App URL: " . config('app.url'));
        $this->line("Asset test: " . asset('uploads/test.jpg'));
        
        if ($teachers->count() > 0) {
            $sampleTeacher = $teachers->first();
            $this->line("Sample teacher photo URL: {$sampleTeacher->photo_url}");
        }

        // Recommendations
        $this->newLine();
        $this->info('💡 Recommendations:');
        
        $teachersWithMissingFiles = 0;
        foreach ($teachers as $teacher) {
            $photoPath = public_path('uploads/' . $teacher->photo);
            if (!file_exists($photoPath)) {
                $teachersWithMissingFiles++;
            }
        }
        
        if ($teachersWithMissingFiles > 0) {
            $this->warn("⚠ {$teachersWithMissingFiles} teachers have missing photo files");
            $this->line("Run: php artisan photos:migrate-teachers-direct");
        }
        
        if (!is_dir(public_path('uploads/teachers'))) {
            $this->warn("⚠ Teachers upload directory doesn't exist");
            $this->line("Run: mkdir -p public/uploads/teachers && chmod 755 public/uploads/teachers");
        }
        
        $this->newLine();
        $this->info('✅ Check complete!');
        
        return Command::SUCCESS;
    }
}
