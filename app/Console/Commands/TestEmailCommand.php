<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use App\Models\ContactMessage;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email=bikolpo247@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Testing email configuration...");
        $this->info("Mail driver: " . config('mail.default'));
        $this->info("Mail host: " . config('mail.mailers.smtp.host'));
        $this->info("Sending test email to: {$email}");
        
        try {
            // Create a test contact message
            $testMessage = new ContactMessage([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '+880123456789',
                'subject' => 'Test Message',
                'message' => 'This is a test message to verify email configuration.',
                'is_read' => false
            ]);
            
            // Send test email
            Mail::to($email)->send(new ContactNotification($testMessage));
            
            $this->info("✅ Test email sent successfully!");
            $this->info("Check your inbox at: {$email}");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email:");
            $this->error($e->getMessage());
            $this->error("Check your mail configuration in .env file");
        }
    }
}
