<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('currency')) {
            $currency = strtoupper($request->get('currency'));
            // Validate currency exists in our service
            $service = app(\App\Services\CurrencyService::class);
            if (array_key_exists($currency, $service->getSupportedCurrencies())) {
                session(['currency' => $currency]);
            }
        }

        if (!session()->has('currency') || session('currency') === 'USD') {
            session(['currency' => 'INR']);
        }

        return $next($request);
    }
}
