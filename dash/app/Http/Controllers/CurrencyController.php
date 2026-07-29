<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Show all supported currencies and their current rates relative to USD.
     */
    public function index()
    {
        try {
            $base = 'INR';
            $currencies = $this->currencyService->getSupportedCurrencies();
            $rates = [];

            foreach ($currencies as $code => $info) {
                $rates[$code] = [
                    'info' => $info,
                    'rate' => $this->currencyService->getRate($base, $code)
                ];
            }

            return response()->json([
                'success' => true,
                'base' => $base,
                'selected_session_currency' => session('currency', 'INR'),
                'currencies' => $rates,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Switch user session currency.
     */
    public function switchCurrency(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|size:3',
        ]);

        return $this->performSwitch($request->currency);
    }

    /**
     * Switch user session currency (GET).
     */
    public function switchCurrencyByGet(string $currency)
    {
        return $this->performSwitch($currency, true);
    }

    protected function performSwitch(string $currency, bool $redirect = false)
    {
        $currency = strtoupper($currency);
        $supported = $this->currencyService->getSupportedCurrencies();

        if (!array_key_exists($currency, $supported)) {
            if ($redirect) return back()->with('error', 'Unsupported currency.');
            return response()->json(['success' => false, 'message' => 'Unsupported currency.'], 400);
        }

        session(['currency' => $currency]);

        if ($redirect) {
            $prev = url()->previous();
            $separator = parse_url($prev, PHP_URL_QUERY) ? '&' : '?';
            return redirect($prev . $separator . 'refresh=' . time())->with('success', "Currency switched to {$currency}");
        }

        return response()->json([
            'success' => true,
            'message' => "Currency switched to {$currency}",
            'currency' => $currency,
            'symbol' => $supported[$currency]['symbol']
        ]);
    }

    /**
     * Convert endpoint.
     */
    public function convert(Request $request)
    {
        $request->validate([
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $result = $this->currencyService->convert(
                $request->from,
                $request->to,
                (float) $request->amount
            );

            return response()->json([
                'success' => true,
                'from' => strtoupper($request->from),
                'to' => strtoupper($request->to),
                'amount' => $request->amount,
                'converted_amount' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
