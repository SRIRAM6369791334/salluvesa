<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\SizeChart;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    public function index()
    {
        $userTypes = ['Normal', 'B2B'];
        $productTypes = ['Own Design', 'Bulk Custom', 'Own Custom'];

        // Ensure all combinations exist
        foreach ($userTypes as $userType) {
            foreach ($productTypes as $productType) {
                AppSetting::firstOrCreate([
                    'user_type' => $userType,
                    'product_type' => $productType
                ]);
            }
        }

        $settings = AppSetting::all()->groupBy('user_type');
        $sizeCharts = SizeChart::orderBy('serial_no', 'asc')->get();
        $checkoutSettings = \Illuminate\Support\Facades\DB::table('checkout_settings')->where('id', 1)->first();
        
        return view('pages.settings', compact('settings', 'userTypes', 'productTypes', 'sizeCharts', 'checkoutSettings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|exists:app_settings,id',
            'settings.*.min_quantity' => 'required|integer|min:0',
            'settings.*.max_quantity' => 'required|integer|min:0',
        ]);

        foreach ($data['settings'] as $settingData) {
            $setting = AppSetting::find($settingData['id']);
            $setting->update([
                'min_quantity' => $settingData['min_quantity'],
                'max_quantity' => $settingData['max_quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function updateSizeChart(Request $request)
    {
        $request->validate([
            'size_charts' => 'required|array',
            'size_charts.*.id' => 'required|exists:size_charts,id',
            'size_charts.*.usa_uk' => 'required|string',
            'size_charts.*.eu' => 'required|string',
            'size_charts.*.japan' => 'required|string',
            'size_charts.*.korea' => 'required|string',
            'size_charts.*.chest_cm' => 'required|string',
            'size_charts.*.chest_inches' => 'required|string',
            'size_charts.*.serial_no' => 'required|integer',
            'size_charts.*.is_active' => 'required|boolean',
        ]);

        foreach ($request->size_charts as $chartData) {
            $chart = SizeChart::find($chartData['id']);
            $chart->update($chartData);
        }

        return redirect()->back()->with('success', 'Size Charts updated successfully!');
    }

    public function updateCheckoutSettings(Request $request)
    {
        $request->validate([
            'paypal_max_quantity' => 'required|integer|min:1',
        ]);

        \Illuminate\Support\Facades\DB::table('checkout_settings')
            ->where('id', 1)
            ->update([
                'paypal_max_quantity' => $request->paypal_max_quantity,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Checkout settings updated successfully!');
    }
}
