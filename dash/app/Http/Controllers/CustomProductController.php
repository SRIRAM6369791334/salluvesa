<?php

namespace App\Http\Controllers;

use App\Models\CustomProduct;
use App\Models\ProductColor;
use App\Models\ProductColorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomProductController extends Controller
{
    public function index()
    {
        $customProducts = CustomProduct::all();
        return view("pages.custom_products", compact("customProducts"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric',
            'product_type' => 'required|string',
            'front_mockup' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'back_mockup' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'colors' => 'nullable|array',
            'colors.*.name' => 'required|string',
            'colors.*.code' => 'required|string',
            'colors.*.images' => 'nullable|array',
        ]);

        $customProduct = new CustomProduct();
        $customProduct->name = $request->name;
        $customProduct->description = $request->description;
        $customProduct->base_price = $request->base_price;
        $customProduct->product_type = $request->product_type;
        $customProduct->status = 'active';

        if ($request->hasFile('front_mockup')) {
            $imageName = time() . '_front.' . $request->front_mockup->extension();
            $request->front_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->front_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('back_mockup')) {
            $imageName = time() . '_back.' . $request->back_mockup->extension();
            $request->back_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->back_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('right_shoulder_mockup')) {
            $imageName = time() . '_right_shoulder.' . $request->right_shoulder_mockup->extension();
            $request->right_shoulder_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->right_shoulder_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('left_shoulder_mockup')) {
            $imageName = time() . '_left_shoulder.' . $request->left_shoulder_mockup->extension();
            $request->left_shoulder_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->left_shoulder_mockup = 'images/custom_products/' . $imageName;
        }

        $customProduct->save();

        // Handle Colors and their Images
        if ($request->has('colors')) {
            foreach ($request->colors as $index => $colorData) {
                $productColor = new ProductColor();
                $productColor->customproduct_id = $customProduct->id;
                $productColor->color_name = $colorData['name'];
                $productColor->color_code = $colorData['code'];
                $productColor->status = 'active';
                $productColor->save();

                // Handle Color Images (if uploaded)
                if ($request->hasFile("colors.{$index}.images")) {
                    foreach ($request->file("colors.{$index}.images") as $viewType => $imageFile) {
                         $imageName = time() . "_{$productColor->id}_{$viewType}." . $imageFile->extension();
                         $imageFile->move(public_path('images/product_colors'), $imageName);

                         $colorImage = new ProductColorImage();
                         $colorImage->product_color_id = $productColor->id;
                         $colorImage->image_path = 'images/product_colors/' . $imageName;
                         $colorImage->view_type = $viewType; // front, back, etc.
                         $colorImage->save();
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'products' => CustomProduct::all()
        ]);
    }

    public function edit($id)
    {
        $product = CustomProduct::with('colors.images')->find($id);
        if ($product) {
            return response()->json(['success' => true, 'product' => $product]);
        }
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    public function update(Request $request, $id)
    {
        // Validation (simplified for now)
        $request->validate([
             'name' => 'required|string|max:255',
             // ... other fields
        ]);

        $customProduct = CustomProduct::find($id);
        if (!$customProduct) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // ... Existing update logic for main fields ...
        $customProduct->name = $request->name;
        $customProduct->description = $request->description;
        $customProduct->base_price = $request->base_price;
        $customProduct->product_type = $request->product_type;
        
        if ($request->hasFile('front_mockup')) {
            // Delete old image
            if ($customProduct->front_mockup && File::exists(public_path($customProduct->front_mockup))) {
                File::delete(public_path($customProduct->front_mockup));
            }
            $imageName = time() . '_front.' . $request->front_mockup->extension();
            $request->front_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->front_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('back_mockup')) {
            // Delete old image
            if ($customProduct->back_mockup && File::exists(public_path($customProduct->back_mockup))) {
                File::delete(public_path($customProduct->back_mockup));
            }
            $imageName = time() . '_back.' . $request->back_mockup->extension();
            $request->back_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->back_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('right_shoulder_mockup')) {
            // Delete old image
            if ($customProduct->right_shoulder_mockup && File::exists(public_path($customProduct->right_shoulder_mockup))) {
                File::delete(public_path($customProduct->right_shoulder_mockup));
            }
            $imageName = time() . '_right_shoulder.' . $request->right_shoulder_mockup->extension();
            $request->right_shoulder_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->right_shoulder_mockup = 'images/custom_products/' . $imageName;
        }

        if ($request->hasFile('left_shoulder_mockup')) {
            // Delete old image
            if ($customProduct->left_shoulder_mockup && File::exists(public_path($customProduct->left_shoulder_mockup))) {
                File::delete(public_path($customProduct->left_shoulder_mockup));
            }
            $imageName = time() . '_left_shoulder.' . $request->left_shoulder_mockup->extension();
            $request->left_shoulder_mockup->move(public_path('images/custom_products'), $imageName);
            $customProduct->left_shoulder_mockup = 'images/custom_products/' . $imageName;
        }

        $customProduct->save();

        // Logic to sync/update colors
        if ($request->has('colors')) {
            // Get IDs of colors sent in request
            $sentColorIds = [];
            foreach ($request->colors as $index => $colorData) {
                if (isset($colorData['id'])) {
                    $sentColorIds[] = $colorData['id'];
                    
                    // Update existing color
                    $productColor = ProductColor::find($colorData['id']);
                    if ($productColor && $productColor->customproduct_id == $customProduct->id) {
                         $productColor->color_name = $colorData['name'];
                         $productColor->color_code = $colorData['code'];
                         $productColor->save();
                         
                         // Update Images
                         if ($request->hasFile("colors.{$index}.images")) {
                            foreach ($request->file("colors.{$index}.images") as $viewType => $imageFile) {
                                // Find existing image for this view (optional: or just create new)
                                // Let's try to replace if exists
                                $existingImage = ProductColorImage::where('product_color_id', $productColor->id)
                                                                  ->where('view_type', $viewType)
                                                                  ->first();
                                
                                $imageName = time() . "_{$productColor->id}_{$viewType}." . $imageFile->extension();
                                $imageFile->move(public_path('images/product_colors'), $imageName);
                                
                                if($existingImage) {
                                     if(File::exists(public_path($existingImage->image_path))) {
                                         File::delete(public_path($existingImage->image_path));
                                     }
                                     $existingImage->image_path = 'images/product_colors/' . $imageName;
                                     $existingImage->save();
                                } else {
                                     $colorImage = new ProductColorImage();
                                     $colorImage->product_color_id = $productColor->id;
                                     $colorImage->image_path = 'images/product_colors/' . $imageName;
                                     $colorImage->view_type = $viewType;
                                     $colorImage->save();
                                }
                            }
                        }
                    }
                } else {
                    // New Color
                    $productColor = new ProductColor();
                    $productColor->customproduct_id = $customProduct->id;
                    $productColor->color_name = $colorData['name'];
                    $productColor->color_code = $colorData['code'];
                    $productColor->status = 'active';
                    $productColor->save();
                    
                     // Handle Color Images (if uploaded)
                    if ($request->hasFile("colors.{$index}.images")) {
                        foreach ($request->file("colors.{$index}.images") as $viewType => $imageFile) {
                             $imageName = time() . "_{$productColor->id}_{$viewType}." . $imageFile->extension();
                             $imageFile->move(public_path('images/product_colors'), $imageName);
    
                             $colorImage = new ProductColorImage();
                             $colorImage->product_color_id = $productColor->id;
                             $colorImage->image_path = 'images/product_colors/' . $imageName;
                             $colorImage->view_type = $viewType; 
                             $colorImage->save();
                        }
                    }
                }
            }
            
            // Delete colors that were not sent (optional, but good for cleanup)
            // BE CAREFUL: If the frontend sends partial updates, this might delete data. 
            // In this full-edit modal approach, we usually send all current colors.
            // If a color was removed in frontend, it won't be in $request->colors.
            
            // However, we need to be sure we are not deleting colors if the request didn't include them for some other reason.
            // Given the form structure, 'colors' array will be present.
            
            // Identify colors to delete
            $existingColors = $customProduct->colors()->pluck('id')->toArray();
            
            // If new colors are added, they won't have IDs in the request yet, so they won't be in sentColorIds. Used ones will be.
            
            $colorsToDelete = array_diff($existingColors, $sentColorIds);
            
            if (!empty($colorsToDelete)) {
                // Determine if any logic prevents deletion (e.g. orders)
                // For now, just delete
                foreach ($colorsToDelete as $deleteId) {
                    $colorToDelete = ProductColor::find($deleteId);
                    if($colorToDelete) {
                         // Delete images first
                        foreach ($colorToDelete->images as $image) {
                             if (File::exists(public_path($image->image_path))) {
                                File::delete(public_path($image->image_path));
                             }
                        }
                        $colorToDelete->delete();
                    }
                }
            }
            
        } else {
            // Request does NOT have 'colors'. 
            // Does this mean delete all colors? Or just no update?
            // If the form was submitted, and the colors container was empty, 'colors' might be missing or empty.
            // Check if it was an edit form submission
            // If we assume the edit form ALWAYS includes the 'colors' input if any exist...
            // Let's assume if it's missing, we do nothing to be safe, or check if we should delete all.
            // But if the user deleted all colors in UI, $request->colors might be empty.
            // Let's rely on the frontend sending an empty array or not sending it.
            // For now, let's NOT delete everything if key is missing, to be safe.
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'products' => CustomProduct::all()
        ]);
    }

    public function destroy($id)
    {
        $product = CustomProduct::find($id);
        if ($product) {
            // Delete images
            if ($product->front_mockup && File::exists(public_path($product->front_mockup))) {
                File::delete(public_path($product->front_mockup));
            }
            if ($product->back_mockup && File::exists(public_path($product->back_mockup))) {
                File::delete(public_path($product->back_mockup));
            }

            // Delete color images
             foreach ($product->colors as $color) {
                foreach ($color->images as $image) {
                     if (File::exists(public_path($image->image_path))) {
                        File::delete(public_path($image->image_path));
                     }
                }
             }

            $product->delete();
            return response()->json([
                'success' => true,
                'products' => CustomProduct::all()
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    public function duplicate($id)
    {
        $product = CustomProduct::with('colors.images')->find($id);
        if ($product) {
            $newProduct = $product->replicate();
            $newProduct->name = $newProduct->name . ' (Copy)';
            $newProduct->push(); // Save and push to DB

            // Replicate colors and images
            foreach ($product->colors as $color) {
                $newColor = $color->replicate();
                $newColor->customproduct_id = $newProduct->id;
                $newColor->push();

                foreach ($color->images as $image) {
                    $newImage = $image->replicate();
                    $newImage->product_color_id = $newColor->id;
                    $newImage->save();
                }
            }

            return response()->json([
                'success' => true,
                'products' => CustomProduct::all()
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    public function getDesignerData($id)
    {
        $product = CustomProduct::with(['colors.images'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Use available sizes from database or fall back to default sizes
        $sizes = $product->available_sizes ?? ['S', 'M', 'L', 'XL', 'XXL'];

        // Prepare colors/views data
        $colors = $product->colors->filter(fn($c) => $c->status === 'active')->map(function ($color) use ($product) {
            $views = [];
            
            // 1. Try to use color-specific images first (from product_color_images table)
            foreach ($color->images as $image) {
                // Use the image_path directly and prepend with asset()
                $views[$image->view_type] = asset($image->image_path);
            }

            // 2. If no color-specific images, use the Product's Base Mockups (New System)
            if (empty($views['front']) && $product->front_mockup) {
                $views['front'] = asset($product->front_mockup);
            }
            if (empty($views['back']) && $product->back_mockup) {
                $views['back'] = asset($product->back_mockup);
            }

            // Fill missing views with nulls to maintain structure
            $requiredViews = ['front', 'back', 'chest', 'shoulder'];
            foreach ($requiredViews as $rv) {
                if (!isset($views[$rv])) {
                    $views[$rv] = null;
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
            $views = [
                'front' => $product->front_mockup ? asset($product->front_mockup) : null,
                'back' => $product->back_mockup ? asset($product->back_mockup) : null,
                'chest' => null,
                'shoulder' => null
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
            'base_price' => $product->base_price,
            'sizes' => $sizes,
            'colors' => $colors,
            'printable_rect' => $product->printable_rect ?? [
                'x' => 100, 'y' => 100, 'width' => 200, 'height' => 300 // Fallback
            ],
            'is_two_sided' => (bool)$product->is_two_sided,
            'canvas' => $canvasConfig
        ]);
    }
}
