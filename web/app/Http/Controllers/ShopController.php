<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Show the application shop page.
     */
    public function index(Request $request)
    {
        // Public access allowed

        // Fetch dynamic categories
        $categories = Category::with('subCategories')->where('status', 'active')->get();
        
        // Fetch products, with pagination if needed
        $query = Product::query();

        // Allow basic filtering via request
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(12);

        return view('pages.shop', compact('categories', 'products'));
    }

    /**
     * Show single product details.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);
        
        // Optional: fetch related products
        $relatedProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->take(6)
                            ->get();

        return view('pages.product-details', compact('product', 'relatedProducts'));
    }
}
