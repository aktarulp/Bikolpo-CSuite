<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use Carbon\Carbon;

class UpdateExamStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exams:update-statuses {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exam statuses based on current time (published -> ongoing -> completed)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        }

        $this->info('📚 Updating exam statuses...');
        $this->newLine();

        // Get exams that need status updates
        $exams = Exam::needsStatusUpdate()->get();
        
        if ($exams->isEmpty()) {
            $this->info('✅ No exams need status updates at this time.');
            return 0;
        }

        $this->info("Found {$exams->count()} exam(s) that may need status updates:");
        $this->newLine();

        $updatedCount = 0;
        $tableData = [];

        foreach ($exams as $exam) {
            $currentStatus = $exam->getCurrentStatusAttribute();
            $oldStatus = $exam->status;
            $statusChanged = false;

            if ($currentStatus === 'ongoing' && $oldStatus !== 'ongoing') {
                $statusChanged = true;
                $newStatus = 'ongoing';
            } elseif ($currentStatus === 'completed' && $oldStatus !== 'completed') {
                $statusChanged = true;
                $newStatus = 'completed';
            } else {
                $newStatus = $oldStatus;
            }

            $tableData[] = [
                $exam->id,
                $exam->title,
                $oldStatus,
                $newStatus,
                $exam->start_time->format('M d, Y H:i'),
                $exam->end_time->format('M d, Y H:i'),
                $statusChanged ? '🔄' : '✅'
            ];

            if ($statusChanged && !$isDryRun) {
                $exam->updateStatus();
                $updatedCount++;
            }
        }

        // Display results in a table
        $this->table([
            'ID', 'Title', 'Old Status', 'New Status', 'Start Time', 'End Time', 'Action'
        ], $tableData);

        $this->newLine();

        if ($isDryRun) {
            $this->info("🔍 DRY RUN: Would update {$updatedCount} exam(s)");
            $this->info('Run without --dry-run to apply changes');
        } else {
            $this->info("✅ Successfully updated {$updatedCount} exam(s)");
        }

        return 0;
    }
}
