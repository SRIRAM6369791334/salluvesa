<?php

use App\Services\GoogleTranslationService;
use Illuminate\Support\Facades\App;

if (!function_exists('gt')) {
    /**
     * Translate text using Google Cloud Translation API (cached).
     *
     * @param string $text
     * @param string|null $targetLocale
     * @return string
     */
    function gt(string $text, ?string $targetLocale = null): string
    {
        $targetLocale = $targetLocale ?? App::getLocale();
        
        // Skip translation for English (base language)
        if ($targetLocale === 'en') {
            return $text;
        }

        return app(GoogleTranslationService::class)->translate($text, $targetLocale);
    }
}

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

if (!function_exists('get_app_setting')) {
    /**
     * Get app setting for a specific product type and current user's type.
     * 
     * @param string $productTypeSlug (e.g., 'own', 'custom', 'bulk_custom', 'own_custom')
     * @return \App\Models\AppSetting|null
     */
    function get_app_setting(string $productTypeSlug)
    {
        $userType = 'Normal';
        if (auth()->check()) {
            $user = auth()->user();
            $userType = $user->user_type == 'B2B' ? 'B2B' : 'Normal';
        }

        $ptMap = [
            'own' => 'Own Design',
            'own_design' => 'Own Design',
            'custom' => 'Own Custom',
            'own_custom' => 'Own Custom',
            'bulk_custom' => 'Bulk Custom',
            'custom_design' => 'Bulk Custom',
            'sample' => 'Sample',
        ];

        $dbPT = $ptMap[$productTypeSlug] ?? $productTypeSlug;

        return \App\Models\AppSetting::where('user_type', $userType)
            ->where('product_type', $dbPT)
            ->first();
    }
}
