<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayPalService
{
    private $clientId;
    private $secret;
    private $mode;
    private $baseUrl;

    public function __construct()
    {
        $this->mode = config('services.paypal.mode', 'sandbox');
        $config = config('services.paypal.' . $this->mode);
        
        $this->clientId = $config['client_id'];
        $this->secret = $config['secret'];
        $this->baseUrl = $this->mode === 'sandbox' 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
    }

    /**
     * Get OAuth access token from PayPal
     */
    private function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('PayPal OAuth failed', ['response' => $response->json()]);
        throw new \Exception('Failed to get PayPal access token');
    }

    /**
     * Create a PayPal order
     * 
     * @param float $amount Amount in INR
     * @param string $currency Currency code (default: INR)
     * @param string $returnUrl URL to return after approval
     * @param string $cancelUrl URL to return if cancelled
     * @return array PayPal order data
     */
    public function createOrder($amount, $currency = 'USD', $returnUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();

        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'brand_name' => 'Saaluvesa Enterprises',
                'user_action' => 'PAY_NOW'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . '/v2/checkout/orders', $orderData);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal create order failed', ['response' => $response->json()]);
        
        $errorMsg = 'Failed to create PayPal order';
        $jsonData = $response->json();
        
        if (isset($jsonData['message'])) {
            $errorMsg .= ': ' . $jsonData['message'];
        }
        
        if (isset($jsonData['details']) && is_array($jsonData['details'])) {
            $details = collect($jsonData['details'])->map(function($d) {
                return ($d['issue'] ?? 'Unknown') . ': ' . ($d['description'] ?? 'No description');
            })->implode('; ');
            $errorMsg .= ' Details: ' . $details;
        }

        throw new \Exception($errorMsg);
    }

    /**
     * Capture payment for an approved order
     * 
     * @param string $orderId PayPal order ID
     * @return array Capture result
     */
    public function captureOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        // PayPal V2 capture expects a JSON object {} in the body if content-type is set
        // Using withBody explicitly sends the string "{}" to avoid PHP [] vs {} encoding issues
        $response = Http::withToken($accessToken)
            ->withHeaders([
                'PayPal-Request-Id' => Str::uuid()->toString(),
                'Prefer' => 'return=representation'
            ])
            ->withBody('{}', 'application/json')
            ->post($this->baseUrl . "/v2/checkout/orders/{$orderId}/capture");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal capture failed', ['response' => $response->json()]);
        
        $errorMsg = 'Failed to capture PayPal payment';
        $jsonData = $response->json();
        
        if (isset($jsonData['message'])) {
            $errorMsg .= ': ' . $jsonData['message'];
        }
        
        if (isset($jsonData['details']) && is_array($jsonData['details'])) {
            $details = collect($jsonData['details'])->map(function($d) {
                return ($d['issue'] ?? 'Unknown') . ': ' . ($d['description'] ?? 'No description');
            })->implode('; ');
            $errorMsg .= ' Details: ' . $details;
        }

        throw new \Exception($errorMsg);
    }

    /**
     * Get order details
     * 
     * @param string $orderId PayPal order ID
     * @return array Order details
     */
    public function getOrderDetails($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->get($this->baseUrl . "/v2/checkout/orders/{$orderId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal get order failed', ['response' => $response->json()]);
        throw new \Exception('Failed to get PayPal order details');
    }
}
