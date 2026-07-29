<?php

if (!function_exists('format_currency')) {
    /**
     * Format a price based on the current session currency.
     * 
     * @param float $amount Amount in INR
     * @return string
     */
    function format_currency(float $amount): string
    {
        $targetCurrency = session('currency', 'INR');
        $service = app(\App\Services\CurrencyService::class);
        
        $converted = $service->convert('INR', $targetCurrency, $amount);
        $symbol = $service->getSupportedCurrencies()[$targetCurrency]['symbol'] ?? '₹';
        
        return $symbol . ' ' . number_format($converted, 2);
    }
}
