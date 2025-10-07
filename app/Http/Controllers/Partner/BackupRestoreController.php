<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use Carbon\Carbon;

class BackupRestoreController extends Controller
{
    /**
     * Show the backup and restore page
     */
    public function index()
    {
        return view('partner.settings.backup-restore');
    }

    /**
     * Create database backup
     */
    public function createDatabaseBackup(Request $request)
    {
        try {
            \Log::info('Backup request received', ['type' => $request->input('type')]);
            
            $type = $request->input('type', 'full');
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "database_backup_{$type}_{$timestamp}.sql";
            
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
                \Log::info('Created backup directory', ['path' => $backupPath]);
            }
            
            $filePath = $backupPath . '/' . $filename;
            
            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);
            
            if ($type === 'access-control') {
                // Backup only access control tables
                $tables = ['ac_users', 'ac_roles', 'ac_permissions', 'ac_role_permissions'];
                $tablesList = implode(' ', $tables);
                $command = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} {$database} {$tablesList} > {$filePath}";
            } else {
                // Full database backup
                $command = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} {$database} > {$filePath}";
            }
            
            // Check if mysqldump is available
            exec('mysqldump --version', $versionOutput, $versionCode);
            if ($versionCode !== 0) {
                throw new \Exception('mysqldump is not available. Please install MySQL client tools.');
            }
            
            \Log::info('Executing backup command', ['command' => $command]);
            
            // Execute the backup command
            exec($command, $output, $returnCode);
            
            \Log::info('Backup command result', ['return_code' => $returnCode, 'output' => $output]);
            
            if ($returnCode !== 0) {
                throw new \Exception('Database backup failed. Return code: ' . $returnCode . '. Output: ' . implode("\n", $output));
            }
            
            if (!File::exists($filePath) || File::size($filePath) === 0) {
                throw new \Exception('Backup file was not created or is empty');
            }
            
            // Return the file for download
            return Response::download($filePath, $filename)->deleteFileAfterSend(false);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Restore database from backup
     */
    public function restoreDatabase(Request $request)
    {
        try {
            $request->validate([
                'backup_file' => 'required|file|mimes:sql,zip|max:102400' // 100MB max
            ]);

            $file = $request->file('backup_file');
            $extension = $file->getClientOriginalExtension();
            
            $backupPath = storage_path('app/backups/restore');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }
            
            $filename = 'restore_' . time() . '.' . $extension;
            $filePath = $backupPath . '/' . $filename;
            $file->move($backupPath, $filename);
            
            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);
            
            if ($extension === 'zip') {
                // Extract ZIP file
                $zip = new ZipArchive;
                if ($zip->open($filePath) === TRUE) {
                    $zip->extractTo($backupPath);
                    $zip->close();
                    
                    // Find SQL file in extracted contents
                    $sqlFiles = File::glob($backupPath . '/*.sql');
                    if (empty($sqlFiles)) {
                        throw new \Exception('No SQL file found in ZIP archive');
                    }
                    $sqlFile = $sqlFiles[0];
                } else {
                    throw new \Exception('Could not open ZIP file');
                }
            } else {
                $sqlFile = $filePath;
            }
            
            // Restore database
            $command = "mysql --host={$host} --port={$port} --user={$username} --password={$password} {$database} < {$sqlFile}";
            exec($command, $output, $returnCode);
            
            // Clean up temporary files
            File::delete($filePath);
            if (isset($sqlFile) && $sqlFile !== $filePath) {
                File::delete($sqlFile);
            }
            
            if ($returnCode !== 0) {
                throw new \Exception('Database restore failed');
            }
            
            return response()->json(['success' => true, 'message' => 'Database restored successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create configuration backup
     */
    public function createConfigBackup()
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "config_backup_{$timestamp}.zip";
            
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }
            
            $filePath = $backupPath . '/' . $filename;
            
            $zip = new ZipArchive;
            if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
                
                // Add config files
                $configPath = config_path();
                $configFiles = File::allFiles($configPath);
                foreach ($configFiles as $file) {
                    $relativePath = 'config/' . $file->getRelativePathname();
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
                
                // Add .env file if exists
                $envPath = base_path('.env');
                if (File::exists($envPath)) {
                    $zip->addFile($envPath, '.env');
                }
                
                // Add routes files
                $routesPath = base_path('routes');
                if (File::exists($routesPath)) {
                    $routeFiles = File::allFiles($routesPath);
                    foreach ($routeFiles as $file) {
                        $relativePath = 'routes/' . $file->getRelativePathname();
                        $zip->addFile($file->getRealPath(), $relativePath);
                    }
                }
                
                $zip->close();
            } else {
                throw new \Exception('Could not create ZIP file');
            }
            
            return Response::download($filePath, $filename)->deleteFileAfterSend(false);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create uploads backup
     */
    public function createUploadsBackup()
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "uploads_backup_{$timestamp}.zip";
            
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }
            
            $filePath = $backupPath . '/' . $filename;
            
            $zip = new ZipArchive;
            if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
                
                // Add storage/app/public files
                $publicPath = storage_path('app/public');
                if (File::exists($publicPath)) {
                    $files = File::allFiles($publicPath);
                    foreach ($files as $file) {
                        $relativePath = 'storage/' . $file->getRelativePathname();
                        $zip->addFile($file->getRealPath(), $relativePath);
                    }
                }
                
                // Add public/uploads if exists
                $uploadsPath = public_path('uploads');
                if (File::exists($uploadsPath)) {
                    $files = File::allFiles($uploadsPath);
                    foreach ($files as $file) {
                        $relativePath = 'public/uploads/' . $file->getRelativePathname();
                        $zip->addFile($file->getRealPath(), $relativePath);
                    }
                }
                
                $zip->close();
            } else {
                throw new \Exception('Could not create ZIP file');
            }
            
            return Response::download($filePath, $filename)->deleteFileAfterSend(false);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get backup history
     */
    public function getBackupHistory()
    {
        try {
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                return response()->json(['backups' => []]);
            }
            
            $files = File::files($backupPath);
            $backups = [];
            
            foreach ($files as $file) {
                if (in_array($file->getExtension(), ['sql', 'zip'])) {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'size' => $this->formatBytes($file->getSize()),
                        'date' => Carbon::createFromTimestamp($file->getMTime())->format('M j, Y g:i A'),
                        'download_url' => route('partner.settings.backup.download', ['filename' => $file->getFilename()])
                    ];
                }
            }
            
            // Sort by date (newest first)
            usort($backups, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            
            return response()->json(['backups' => $backups]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Download backup file
     */
    public function downloadBackup($filename)
    {
        try {
            $filePath = storage_path('app/backups/' . $filename);
            
            if (!File::exists($filePath)) {
                abort(404, 'Backup file not found');
            }
            
            return Response::download($filePath, $filename);
            
        } catch (\Exception $e) {
            abort(500, 'Error downloading backup file');
        }
    }

    /**
     * Delete backup file
     */
    public function deleteBackup(Request $request)
    {
        try {
            $filename = $request->input('filename');
            $filePath = storage_path('app/backups/' . $filename);
            
            if (!File::exists($filePath)) {
                return response()->json(['success' => false, 'message' => 'Backup file not found'], 404);
            }
            
            File::delete($filePath);
            
            return response()->json(['success' => true, 'message' => 'Backup deleted successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
