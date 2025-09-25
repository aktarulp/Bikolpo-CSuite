<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BulkSmsBdService
{
    protected $apiKey;
    protected $senderId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.bulksmsbd.api_key');
        $this->senderId = config('services.bulksmsbd.sender_id');
        $this->baseUrl = config('services.bulksmsbd.base_url');
    }

    /**
     * Send an SMS message to a single recipient.
     *
     * @param string $number The recipient's phone number (e.g., 8801XXXXXXXXX).
     * @param string $message The message content.
     * @return bool True if the SMS was sent successfully, false otherwise.
     */
    public function sendSms(string $number, string $message): bool
    {
        if (empty($this->apiKey) || empty($this->senderId) || empty($this->baseUrl)) {
            Log::error('BulkSmsBdService: API credentials are not configured.');
            return false;
        }

        try {
            $response = Http::get($this->baseUrl, [
                'api_key' => $this->apiKey,
                'type' => 'text',
                'number' => $number,
                'senderid' => $this->senderId,
                'message' => $message,
            ]);

            $responseData = $response->body();

            // Log the full response for debugging
            Log::info('BulkSMSBD API Response', [
                'status' => $response->status(),
                'body' => $responseData,
                'number' => $number,
                'message' => $message,
            ]);

            // Check for success based on BulkSMSBD's API response format
            // This might need adjustment based on their actual success indicator
            if ($response->successful() && str_contains($responseData, 'SMS TEXT FAILED: 1002') == false) {
                Log::info('SMS sent successfully to ' . $number);
                return true;
            } else {
                Log::error('Failed to send SMS to ' . $number, ['response' => $responseData]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS via BulkSmsBdService: ' . $e->getMessage(), [
                'number' => $number,
                'message' => $message,
                'exception' => $e,
            ]);
            return false;
        }
    }

    /**
     * Send an SMS message to multiple recipients.
     *
     * @param array $numbers An array of recipient phone numbers.
     * @param string $message The message content.
     * @return array An array indicating success/failure for each number.
     */
    public function sendManySms(array $numbers, string $message): array
    {
        $results = [];
        foreach ($numbers as $number) {
            $results[$number] = $this->sendSms($number, $message);
        }
        return $results;
    }
}
