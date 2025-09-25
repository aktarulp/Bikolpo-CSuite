<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BulkSmsBdService;

class SendTestSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-test-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test SMS using BulkSmsBdService';

    protected $bulkSmsBdService;

    public function __construct(BulkSmsBdService $bulkSmsBdService)
    {
        parent::__construct();
        $this->bulkSmsBdService = $bulkSmsBdService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $testNumber = '8801XXXXXXXXX'; // Replace with a valid test number (e.g., your own phone number)
        $testMessage = 'This is a test SMS from Bikolpo LQ.';

        $this->info("Attempting to send SMS to {$testNumber} with message: '{$testMessage}'");

        $success = $this->bulkSmsBdService->sendSms($testNumber, $testMessage);

        if ($success) {
            $this->info('SMS sent successfully!');
        } else {
            $this->error('Failed to send SMS. Check logs for details.');
        }
    }
}
