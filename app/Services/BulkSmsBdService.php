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
     * @return string The raw response body from the SMS provider, or an error string.
     */
    public function sendSms(string $number, string $message): string
    {
        if (empty($this->apiKey) || empty($this->senderId) || empty($this->baseUrl)) {
            Log::error('BulkSmsBdService: API credentials are not configured.');
            return 'API credentials not configured.';
        }

        try {
            $response = Http::timeout(30)->get($this->baseUrl, [
                'api_key' => $this->apiKey,
                'type' => 'text',
                'number' => $number,
                'senderid' => $this->senderId,
                'message' => $message,
            ]);

            $responseData = $response->body();

            Log::info('BulkSMSBD API Raw Response', [
                'status' => $response->status(),
                'body' => $responseData,
                'number' => $number,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info('SMS API call successfully made to ' . $number);
                return $responseData; // Return the raw response body on success
            } else {
                Log::error('SMS API call failed for ' . $number, ['response' => $responseData]);
                return $responseData; // Return the raw response body on failure as well
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS via BulkSmsBdService: ' . $e->getMessage(), [
                'number' => $number,
                'message' => $message,
                'exception' => $e,
            ]);
            return 'Exception: ' . $e->getMessage(); // Return exception message
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
