<?php

namespace App\Http\Controllers;

use App\Models\Customproduct;
use Illuminate\Http\Request;

class CustomProductController extends Controller
{
    /**
     * Get all active custom products
     */
    public function index()
    {
        $products = Customproduct::active()->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Get a specific custom product
     */
    public function show($id)
    {
        $product = Customproduct::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Get all data needed for the designer lab
     */
    public function getDesignerData($id)
    {
        // ... (Old method, kept for legacy if needed, but overridden by v2 logic effectively if route changes) ...
        return $this->getDesignerDataFixed($id);
    }

    /**
     * FIXED: serve assets directly
     */
    public function getDesignerDataFixed($id)
    {
        $product = Customproduct::with(['colors.images'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Use available sizes from database or fall back to default sizes
        $sizes = $product->available_sizes ?? ['S', 'M', 'L', 'XL', 'XXL'];

        // Prep MAIN_URL and Proxy
        $mainUrl = rtrim(config('app.main_url') ?: env('MAIN_URL', ''), '/');

        // Prepare colors/views data
        $colors = $product->colors->filter(fn($c) => $c->status === 'active')->map(function ($color) use ($product, $mainUrl) {
            $views = [];
            
            // 1. Try to use color-specific images first
            foreach ($color->images as $image) {
                $path = ltrim($image->image_path, '/');
                $fullUrl = $mainUrl ? $mainUrl . '/' . $path : asset($path);
                $views[$image->view_type] = $mainUrl ? route('image.proxy', ['url' => $fullUrl]) : $fullUrl;
            }

            // 2. If no color-specific images, use the Product's Base Mockups
            if (empty($views['front']) && $product->front_mockup) {
                $path = ltrim($product->front_mockup, '/');
                $fullUrl = $mainUrl ? $mainUrl . '/' . $path : asset($path);
                $views['front'] = $mainUrl ? route('image.proxy', ['url' => $fullUrl]) : $fullUrl;
            }
            if (empty($views['back']) && $product->back_mockup) {
                $path = ltrim($product->back_mockup, '/');
                $fullUrl = $mainUrl ? $mainUrl . '/' . $path : asset($path);
                $views['back'] = $mainUrl ? route('image.proxy', ['url' => $fullUrl]) : $fullUrl;
            }
            if (empty($views['right-shoulder']) && $product->right_shoulder_mockup) {
                $path = ltrim($product->right_shoulder_mockup, '/');
                $fullUrl = $mainUrl ? $mainUrl . '/' . $path : asset($path);
                $views['right-shoulder'] = $mainUrl ? route('image.proxy', ['url' => $fullUrl]) : $fullUrl;
            }
            if (empty($views['left-shoulder']) && $product->left_shoulder_mockup) {
                $path = ltrim($product->left_shoulder_mockup, '/');
                $fullUrl = $mainUrl ? $mainUrl . '/' . $path : asset($path);
                $views['left-shoulder'] = $mainUrl ? route('image.proxy', ['url' => $fullUrl]) : $fullUrl;
            }

            // 3. Handle Intelligent Fallbacks for Shoulders
            // If we have a generic 'shoulder' but no specific sides, map it to both
            if (isset($views['shoulder']) && empty($views['right-shoulder'])) {
                $views['right-shoulder'] = $views['shoulder'];
            }
            if (isset($views['shoulder']) && empty($views['left-shoulder'])) {
                $views['left-shoulder'] = $views['shoulder'];
            }
            
            // If still empty, use a placeholder to prevent frontend errors
            $placeholder = "https://placehold.co/800x900/f3f4f6/111827?text=Side+View+Unavailable";
            if (empty($views['right-shoulder'])) $views['right-shoulder'] = $mainUrl ? route('image.proxy', ['url' => $placeholder]) : $placeholder;
            if (empty($views['left-shoulder'])) $views['left-shoulder'] = $mainUrl ? route('image.proxy', ['url' => $placeholder]) : $placeholder;

            // Fill missing standard views with null
            $requiredViews = ['front', 'back', 'right-shoulder', 'left-shoulder'];
            foreach ($requiredViews as $rv) {
                if (!isset($views[$rv])) {
                    $views[$rv] = ($rv === 'front' || $rv === 'back') ? ($mainUrl ? route('image.proxy', ['url' => $placeholder]) : $placeholder) : null;
                }
            }

            return [
                'id' => $color->id,
                'color_name' => $color->color_name,
                'color_code' => $color->color_code,
                'views' => $views
            ];
        })->values();

        // Fallback if no colors exist
        if ($colors->isEmpty()) {
            $frontPath = $product->front_mockup ? ltrim($product->front_mockup, '/') : null;
            $backPath = $product->back_mockup ? ltrim($product->back_mockup, '/') : null;
            $rightPath = $product->right_shoulder_mockup ? ltrim($product->right_shoulder_mockup, '/') : null;
            $leftPath = $product->left_shoulder_mockup ? ltrim($product->left_shoulder_mockup, '/') : null;
            
            $frontFull = $frontPath ? ($mainUrl ? $mainUrl . '/' . $frontPath : asset($frontPath)) : null;
            $backFull = $backPath ? ($mainUrl ? $mainUrl . '/' . $backPath : asset($backPath)) : null;
            $rightFull = $rightPath ? ($mainUrl ? $mainUrl . '/' . $rightPath : asset($rightPath)) : null;
            $leftFull = $leftPath ? ($mainUrl ? $mainUrl . '/' . $leftPath : asset($leftPath)) : null;

            $views = [
                'front' => ($frontFull && $mainUrl) ? route('image.proxy', ['url' => $frontFull]) : $frontFull,
                'back' => ($backFull && $mainUrl) ? route('image.proxy', ['url' => $backFull]) : $backFull,
                'chest' => null,
                'shoulder' => null,
                'right-shoulder' => $rightFull ? (($rightFull && $mainUrl) ? route('image.proxy', ['url' => $rightFull]) : $rightFull) : (($frontFull && $mainUrl) ? route('image.proxy', ['url' => $frontFull]) : $frontFull),
                'left-shoulder' => $leftFull ? (($leftFull && $mainUrl) ? route('image.proxy', ['url' => $leftFull]) : $leftFull) : (($frontFull && $mainUrl) ? route('image.proxy', ['url' => $frontFull]) : $frontFull)
            ];
            
            $colors = [[
                'id' => 0, // Default ID
                'color_name' => 'Default',
                'color_code' => '#ffffff',
                'views' => $views
            ]];
        }

        // Get canvas configuration from database or use default
        $canvasConfig = $product->canvas_config ?? [
            'width' => 800,
            'height' => 900
        ];

        return response()->json([
            'success' => true,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'base_price' => (float)$product->base_price,
            'extra_element_price' => (float)($product->extra_element_price ?? 50),
            'sizes' => $sizes,
            'colors' => $colors,
            'printable_rect' => $product->printable_rect ?? [
                'x' => 100, 'y' => 100, 'width' => 200, 'height' => 300 // Fallback
            ],
            'is_two_sided' => !empty($product->back_mockup),
            'canvas' => $canvasConfig
        ]);
    }

    /**
     * Show the product picker page
     */
    public function picker()
    {
        $products = Customproduct::active()->get();
        return view('pages.customize-products', compact('products'));
    }
}
