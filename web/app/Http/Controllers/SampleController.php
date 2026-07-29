<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sample;
use App\Models\SizeChart;

class SampleController extends Controller
{
    public function index()
    {
        $samples = Sample::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $sizeCharts = SizeChart::where('is_active', true)
            ->orderBy('serial_no')
            ->get();

        $appSetting = get_app_setting('sample');

        return view('pages.sample', compact('samples', 'sizeCharts', 'appSetting'));
    }
}
