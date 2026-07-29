<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class CurrencyService
{
    protected string $primaryApi = 'https://api.frankfurter.app/latest';
    protected string $fallbackApi = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies';
    protected int $cacheDuration = 43200; // 12 hours in seconds

    protected array $supportedCurrencies = [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
        'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹'],
        'EUR' => ['name' => 'Euro', 'symbol' => '€'],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
        'AED' => ['name' => 'UAE Dirham', 'symbol' => 'د.إ'],
        'SAR' => ['name' => 'Saudi Riyal', 'symbol' => 'ر.س'],
        'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'C$'],
        'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$'],
        'SGD' => ['name' => 'Singapore Dollar', 'symbol' => 'S$'],
        'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥'],
        'CNY' => ['name' => 'Chinese Yuan', 'symbol' => '¥'],
    ];

    /**
     * Get list of supported currencies.
     */
    public function getSupportedCurrencies(): array
    {
        return $this->supportedCurrencies;
    }

    public function convert(string $from, string $to, float $amount): float
    {
        $rate = $this->getRate($from, $to);
        return round($amount * $rate, 2);
    }

    /**
     * Get the current exchange rate between two currencies.
     */
    public function getRate(string $from, string $to): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return 1.0;
        }

        $cacheKey = "exchange_rate_{$from}_{$to}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($from, $to) {
            // Try getting from DB first
            $rateRecord = ExchangeRate::where('base_currency', $from)
                ->where('target_currency', $to)
                ->first();

            if ($rateRecord && $rateRecord->updated_at->gt(now()->subHours(12))) {
                return (float) $rateRecord->rate;
            }

            // Fetch from API and update DB
            return $this->fetchRateFromApi($from, $to);
        });
    }

    /**
     * Fetch rate from API with fallback mechanism.
     */
    protected function fetchRateFromApi(string $from, string $to): float
    {
        try {
            // Try Primary API (Frankfurter)
            $response = Http::timeout(10)->get($this->primaryApi, [
                'from' => $from,
                'to' => $to,
            ]);

            if ($response->successful()) {
                $rate = (float) $response->json("rates.{$to}");
                $this->updateDatabaseRate($from, $to, $rate);
                return $rate;
            }

            Log::warning("Frankfurter API failed for {$from} to {$to}. Trying fallback...");

        } catch (Exception $e) {
            Log::error("Frankfurter API error: " . $e->getMessage());
        }

        // Try Fallback API (Fawaz Ahmed)
        try {
            $fromLower = strtolower($from);
            $toLower = strtolower($to);
            $response = Http::timeout(10)->get("{$this->fallbackApi}/{$fromLower}.json");

            if ($response->successful()) {
                $rate = (float) $response->json("{$fromLower}.{$toLower}");
                $this->updateDatabaseRate($from, $to, $rate);
                return $rate;
            }
        } catch (Exception $e) {
            Log::error("Fallback Currency API error: " . $e->getMessage());
        }

        // If both failed, try returning the last known rate from DB regardless of age
        $lastKnown = ExchangeRate::where('base_currency', $from)
            ->where('target_currency', $to)
            ->first();

        if ($lastKnown) {
            return (float) $lastKnown->rate;
        }

        throw new Exception("Currency conversion failed for {$from} to {$to}. All sources unavailable.");
    }

    /**
     * Bulk update rates for common currencies.
     */
    public function updateRates(string $base = 'INR'): void
    {
        try {
            $response = Http::timeout(20)->get($this->primaryApi, ['from' => $base]);
            
            if ($response->successful()) {
                $rates = $response->json('rates');
                foreach ($rates as $currency => $rate) {
                    $this->updateDatabaseRate($base, $currency, (float) $rate);
                    // Also clear cache
                    Cache::forget("exchange_rate_{$base}_{$currency}");
                }
                return;
            }
        } catch (Exception $e) {
            Log::error("Bulk rate update failed: " . $e->getMessage());
        }
    }

    /**
     * Persist rate to database.
     */
    protected function updateDatabaseRate(string $from, string $to, float $rate): void
    {
        ExchangeRate::updateOrCreate(
            ['base_currency' => $from, 'target_currency' => $to],
            ['rate' => $rate, 'updated_at' => now()]
        );
    }
}
