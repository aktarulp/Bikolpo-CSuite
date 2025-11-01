<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $apiKey;
    protected $senderId;
    protected $apiUrl = 'http://bulksmsbd.net/api/smsapi';
    protected $apiUrlHttps = 'https://bulksmsbd.net/api/smsapi';

    public function __construct()
    {
        // Use provided credentials or fallback to config
        $this->apiKey = config('services.bulksmsbd.api_key', 'TGWqm40rFegeF9t5gM6S');
        $this->senderId = config('services.bulksmsbd.sender_id', '8809617625574');
    }

    /**
     * Validate configuration before sending SMS
     *
     * @return array
     */
    protected function validateConfiguration()
    {
        if (empty($this->apiKey)) {
            return [
                'valid' => false,
                'message' => 'BulkSMSBD API key is not configured'
            ];
        }

        if (empty($this->senderId)) {
            return [
                'valid' => false,
                'message' => 'BulkSMSBD Sender ID is not configured'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Configuration is valid'
        ];
    }

    /**
     * Send SMS using BulkSMSBD
     *
     * @param string $phoneNumber
     * @param string $message
     * @return array
     */
    public function sendSms($phoneNumber, $message)
    {
        try {
            // Validate configuration first
            $configValidation = $this->validateConfiguration();
            if (!$configValidation['valid']) {
                return [
                    'success' => false,
                    'message' => $configValidation['message']
                ];
            }

            // Format the phone number (ensure it starts with 880)
            $formattedNumber = $this->formatPhoneNumber($phoneNumber);
            
            if (!$formattedNumber) {
                return [
                    'success' => false,
                    'message' => 'Invalid phone number format'
                ];
            }

            // Build API URL with query parameters (as per BulkSMS BD API documentation)
            $apiUrl = $this->apiUrl . '?' . http_build_query([
                'api_key' => $this->apiKey,
                'type' => 'text',
                'number' => $formattedNumber,
                'senderid' => $this->senderId,
                'message' => $message,
            ]);

            // Log the request for debugging (without exposing full API key)
            Log::info('BulkSMSBD API Request', [
                'url' => $this->apiUrl,
                'api_key' => $this->apiKey ? substr($this->apiKey, 0, 5) . '...' : null,
                'senderid' => $this->senderId,
                'number' => $formattedNumber,
                'message_length' => strlen($message)
            ]);

            // Try GET request first (as per API documentation)
            // Try HTTP first, then HTTPS if HTTP fails
            $response = Http::timeout(30)->get($apiUrl);
            
            // Log the raw response for debugging
            Log::info('BulkSMSBD API GET Response (HTTP)', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $apiUrl
            ]);
            
            // If HTTP fails, try HTTPS
            if ($response->status() !== 200 || $response->failed()) {
                $apiUrlHttps = $this->apiUrlHttps . '?' . http_build_query([
                    'api_key' => $this->apiKey,
                    'type' => 'text',
                    'number' => $formattedNumber,
                    'senderid' => $this->senderId,
                    'message' => $message,
                ]);
                
                Log::info('BulkSMSBD API trying HTTPS');
                $response = Http::timeout(30)->get($apiUrlHttps);
                
                Log::info('BulkSMSBD API GET Response (HTTPS)', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $apiUrlHttps
                ]);
            }
            
            // If GET still fails, try POST
            if ($response->status() !== 200 || $response->failed()) {
                Log::info('BulkSMSBD API trying POST method');
                $response = Http::timeout(30)->asForm()->post($this->apiUrlHttps, [
                    'api_key' => $this->apiKey,
                    'type' => 'text',
                    'number' => $formattedNumber,
                    'senderid' => $this->senderId,
                    'message' => $message,
                ]);
                
                Log::info('BulkSMSBD API POST Response', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

            $responseBody = $response->body();
            $responseData = [];
            
            // Try to parse as JSON first
            $jsonData = json_decode($responseBody, true);
            if (json_last_error() === JSON_ERROR_NONE && $jsonData !== null) {
                $responseData = $jsonData;
            } else {
                // If not JSON, store as text response
                $responseData = ['response' => trim($responseBody)];
            }
            
            // Check if the response indicates success
            // BulkSMS BD can return various success indicators
            $isSuccess = false;
            $responseBodyLower = strtolower(trim($responseBody));
            
            // Check for success in various formats
            if (isset($responseData['response_code'])) {
                // JSON response with response_code
                if (in_array($responseData['response_code'], [200, 202])) {
                    $isSuccess = true;
                }
            } elseif (isset($responseData['status']) && strtolower($responseData['status']) === 'success') {
                $isSuccess = true;
            } elseif (stripos($responseBody, 'success') !== false) {
                // Text response containing "success"
                $isSuccess = true;
            } elseif (stripos($responseBody, 'sent') !== false && stripos($responseBody, 'sms') !== false) {
                // Response like "SMS Sent Successfully"
                $isSuccess = true;
            } elseif ($response->status() === 200 && (empty($responseBody) || strlen($responseBody) < 100)) {
                // Empty or short response with 200 status might indicate success
                $isSuccess = true;
            }
            
            if ($isSuccess) {
                    Log::info('BulkSMSBD SMS sent successfully', [
                        'phone' => $formattedNumber,
                        'response' => $responseData
                    ]);
                    
                    return [
                        'success' => true,
                        'message' => 'SMS sent successfully',
                        'data' => $responseData
                    ];
                } else {
                    // Handle specific error codes from BulkSMSBD
                    $errorMessage = 'Failed to send SMS. ';
                    
                    if (isset($responseData['response_code'])) {
                        switch ($responseData['response_code']) {
                            case 1002:
                                $errorMessage = 'Sender ID not correct or disabled';
                                break;
                            case 1003:
                                $errorMessage = 'Required fields missing';
                                break;
                            case 1005:
                                $errorMessage = 'Internal error';
                                break;
                            case 1006:
                                $errorMessage = 'Balance validity not available';
                                break;
                            case 1007:
                                $errorMessage = 'Insufficient balance';
                                break;
                            case 1011:
                                $errorMessage = 'API key not found or invalid';
                                break;
                            case 1012:
                                $errorMessage = 'Masking SMS must be sent in Bengali';
                                break;
                            case 1013:
                                $errorMessage = 'Sender ID has not found gateway';
                                break;
                            default:
                                $errorMessage .= 'Error code: ' . $responseData['response_code'];
                                if (isset($responseData['response'])) {
                                    $errorMessage .= ' - ' . $responseData['response'];
                                }
                        }
                    } elseif (isset($responseData['response'])) {
                        $errorMessage .= $responseData['response'];
                    } else {
                        $errorMessage .= 'Unknown error. Response: ' . substr($responseBody, 0, 200);
                    }

                    Log::error('BulkSMSBD API Error', [
                        'response' => $responseData,
                        'response_body' => $responseBody,
                        'status' => $response->status(),
                        'phone' => $formattedNumber,
                        'api_key_preview' => substr($this->apiKey, 0, 5) . '...',
                        'sender_id' => $this->senderId
                    ]);

                    return [
                        'success' => false,
                        'message' => $errorMessage,
                        'data' => $responseData
                    ];
                }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('SMS Sending Connection Exception', [
                'exception' => $e->getMessage(),
                'phone' => $phoneNumber,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Unable to connect to SMS service. Please check your internet connection and try again.'
            ];
        } catch (\Exception $e) {
            Log::error('SMS Sending Exception', [
                'exception' => $e->getMessage(),
                'exception_class' => get_class($e),
                'phone' => $phoneNumber,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while sending SMS: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format Bangladeshi phone number
     *
     * @param string $phoneNumber
     * @return string|null
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-digit characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Handle different formats
        if (strlen($phoneNumber) == 11 && substr($phoneNumber, 0, 2) == '01') {
            // Convert 01xxxxxxxxx to 8801xxxxxxxxx
            return '88' . $phoneNumber;
        } elseif (strlen($phoneNumber) == 13 && substr($phoneNumber, 0, 3) == '880') {
            // Already in correct format
            return $phoneNumber;
        } elseif (strlen($phoneNumber) == 10 && substr($phoneNumber, 0, 1) == '1') {
            // Convert 1xxxxxxxxx to 8801xxxxxxxxx
            return '880' . $phoneNumber;
        }

        // Invalid format
        return null;
    }
}