<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GoogleTranslationService
{
    protected $cacheKeyPrefix = 'gtrans_';
    protected $cacheTtl = 604800; // 7 days in seconds

    /**
     * Translate text to the target language using Google Translate API.
     *
     * @param string $text
     * @param string $targetLocale
     * @return string
     */
    public function translate(string $text, string $targetLocale): string
    {
        // Default to English being base, so no translation if target is English
        if ($targetLocale === 'en' || empty($text) || trim($text) === '') {
            return $text;
        }

        $cacheKey = $this->cacheKeyPrefix . md5($text . '_' . $targetLocale);
        
        // If already in cache, return immediately (fast)
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // IMPORTANT: We no longer make fresh server-side network calls here.
        // Making 100+ calls during page render was causing the "10 minute wait".
        // Instead, we return the original text and let the Google Translate Browser Widget 
        // (added in app.blade.php) handle the translation instantly in the user's browser.
        return $text;
    }
}
