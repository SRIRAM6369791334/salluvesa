<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch application language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(string $locale)
    {
        $allowedLocales = [
            'en', 'fr', 'de', 'nl', 'hr', 'el', 'et', 'fi', 
            'ga', 'it', 'lv', 'lt', 'lb', 'mt', 'pt', 'sk', 'sl', 'es'
        ];

        if (in_array($locale, $allowedLocales)) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
            
            // Set the Google Translate cookie to trigger the browser-side translation instantly
            // Duration: 24 hours
            setcookie('googtrans', '/en/' . $locale, time() + 86400, '/');
        }

        return redirect()->back();
    }
}
