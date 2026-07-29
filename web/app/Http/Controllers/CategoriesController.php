<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display the categories page with dynamic data
     */
    public function index()
    {
        // Get all categories
        $categories = Category::orderBy('category_name')
            ->get();

        // Get all subcategories and group them by category
        $subCategories = SubCategory::orderBy('subcategory_name')
            ->get()
            ->groupBy('category_name');

        return view('pages.categories', compact('categories', 'subCategories'));
    }
}
