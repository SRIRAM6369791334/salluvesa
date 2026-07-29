<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('currency')) {
            $currency = strtoupper($request->get('currency'));
            // Validate currency exists in our service
            $service = app(\App\Services\CurrencyService::class);
            if (array_key_exists($currency, $service->getSupportedCurrencies())) {
                session(['currency' => $currency]);
            }
        }

        if (!session()->has('currency')) {
            session(['currency' => 'INR']);
        }

        return $next($request);
    }
}
