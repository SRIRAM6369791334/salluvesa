<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;

class DesignController extends Controller
{
    public function index()
    {
        $designs = Design::paginate(6);
        $appSetting = get_app_setting('own_design');
        return view('pages.own-design', compact('designs', 'appSetting'));
    }
}
