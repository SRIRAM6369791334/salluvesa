<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerImage;

class HomeController extends Controller
{
    public function index()
    {
        $bannerImages = BannerImage::all();
        return view('pages.home', compact('bannerImages'));
    }
}
