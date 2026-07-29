<?php

namespace App\Http\Controllers;

use App\Models\Customproduct;
use App\Models\CustomproductDesign;
use App\Models\DesignLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomDesignController extends Controller
{
    /**
     * Initialize a new design draft
     */
    public function init(Request $request)
    {
        $request->validate([
            'customproduct_id' => 'required|exists:customproducts,id',
        ]);

        $design = CustomproductDesign::create([
            'customproduct_id' => $request->customproduct_id,
            'user_id'          => Auth::check() ? Auth::user()->user_id : null,
            'session_id'       => !Auth::check() ? session()->getId() : null,
            'status'           => 'draft',
            'design_name'      => 'Untitled Design',
            // Default values required by NOT NULL columns
            'canvas_width'     => $request->input('canvas_width', 400),
            'canvas_height'    => $request->input('canvas_height', 500),
            'product_color'    => $request->input('product_color', 'white'),
            'product_size'     => $request->input('product_size', 'M'),
        ]);

        return response()->json([
            'success'   => true,
            'design_id' => $design->id,
            'message'   => 'Design initialized'
        ]);
    }

    /**
     * Store or Update a custom design
     */
    public function store(Request $request)
    {
        Log::info('Design Save Started', ['user_id' => Auth::id(), 'product_id' => $request->customproduct_id]);
        
        try {
            $validated = $request->validate([
                'customproduct_id' => 'required|exists:customproducts,id',
                'product_color_id' => 'nullable|exists:product_colors,id',
                'canvas_width' => 'required|integer|min:100|max:2000',
                'canvas_height' => 'required|integer|min:100|max:2000',
                'product_color' => 'nullable|string|max:50',
                'product_size' => 'nullable|string|max:10',
                'status' => 'nullable|string|in:draft,confirmed',
                
                // Canvas JSONs
                'front_canvas_json' => 'nullable|json',
                'back_canvas_json' => 'nullable|json',
                'chest_canvas_json' => 'nullable|json',
                'shoulder_canvas_json' => 'nullable|json',
                'right_shoulder_canvas_json' => 'nullable|json',
                'left_shoulder_canvas_json' => 'nullable|json',
                
                // Preview Images
                'front_preview_base64' => 'nullable|string',
                'back_preview_base64' => 'nullable|string',
                'chest_preview_base64' => 'nullable|string',
                'shoulder_preview_base64' => 'nullable|string',
                'right_shoulder_preview_base64' => 'nullable|string',
                'left_shoulder_preview_base64' => 'nullable|string',
                
                // Layers for Detailed Storage
                'layers' => 'required|array|min:0|max:100', // Security: Max 100 objects total
                'layers.*.layer_type' => 'required|in:image,text,icon',
                'layers.*.text_content' => 'nullable|string|max:1000', // Security: Text limit
                'layers.*.x_position' => 'required|numeric',
                'layers.*.y_position' => 'required|numeric',
                'layers.*.width' => 'required|numeric|max:2000',
                'layers.*.height' => 'required|numeric|max:2000',
                'layers.*.rotation' => 'nullable|numeric',
                'layers.*.scale_x' => 'nullable|numeric|max:10',
                'layers.*.scale_y' => 'nullable|numeric|max:10',
                'layers.*.print_position' => 'required|string',
                'layers.*.z_index' => 'nullable|integer',
                'layers.*.layer_json' => 'nullable|json',
                'layers.*.source_path' => 'nullable|string|max:500',
                'layers.*.layer_name' => 'nullable|string|max:200',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Design Save Validation Failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except([
                    'front_preview_base64', 'back_preview_base64', 
                    'front_canvas_json', 'back_canvas_json', 
                    'chest_preview_base64', 'shoulder_preview_base64',
                    'layers' // Exclude large blobs avoid log bloat
                ])
            ]);
            throw $e;
        }

        try {
            // [Security] Whitelist and Object Count Validation
            if (count($validated['layers']) > 50) {
                return response()->json(['success' => false, 'message' => 'Design too complex. Maximum 50 objects allowed.'], 422);
            }

            $design = $request->id ? CustomproductDesign::findOrFail($request->id) : new CustomproductDesign();

            // Security check for existing design
            if ($design->exists) {
                if ($design->user_id) {
                    if (!Auth::check() || $design->user_id != Auth::user()->user_id) {
                        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                    }
                } elseif ($design->session_id && $design->session_id !== session()->getId()) {
                    if (!Auth::check()) {
                         return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                    }
                    // If Auth, we associate it below
                }
            }
            $design->customproduct_id = $validated['customproduct_id'];
            $design->product_color_id = $validated['product_color_id'] ?? null;
            $design->user_id = Auth::check() ? Auth::user()->user_id : null;
            $design->session_id = !Auth::check() ? session()->getId() : null;
            $design->canvas_width = $validated['canvas_width'];
            $design->canvas_height = $validated['canvas_height'];
            $design->product_color = $validated['product_color'] ?? 'white';
            $design->product_size = $validated['product_size'] ?? 'M';
            $design->status = $validated['status'] ?? 'draft';
            $design->design_name = $request->design_name ?? $design->design_name ?? 'Untitled Design';
            
            // Store canvas JSON
            $design->design_json_front = $validated['front_canvas_json'] ?? null;
            $design->design_json_back = $validated['back_canvas_json'] ?? null;
            $design->design_json_chest = $validated['chest_canvas_json'] ?? null;
            $design->design_json_shoulder = $validated['shoulder_canvas_json'] ?? null;
            $design->design_json_right_shoulder = $validated['right_shoulder_canvas_json'] ?? null;
            $design->design_json_left_shoulder = $validated['left_shoulder_canvas_json'] ?? null;

            // Save design record first to get ID for directory structure
            $design->save();

            // Save preview images and thumbnails
            $sides = ['front', 'back', 'chest', 'shoulder', 'right_shoulder', 'left_shoulder'];
            foreach ($sides as $side) {
                $key = $side . '_preview_base64';
                if (isset($validated[$key])) {
                    $column = 'preview_image_' . $side;
                    $design->$column = $this->saveOrganizedImage($validated[$key], $side, $design);
                    
                    // Generate thumbnail for front view
                    if ($side === 'front') {
                        $design->thumbnail_path = $this->saveOrganizedImage($validated[$key], 'thumb', $design, true);
                    }
                }
            }

            $design->save();

            // Handle layers... (Optional: Keep layers for admin/detailed view)
            DesignLayer::where('design_id', $design->id)->delete();
            foreach ($validated['layers'] as $layerData) {
                DesignLayer::create([
                    'design_id' => $design->id,
                    'layer_type' => $layerData['layer_type'],
                    'text_content' => $layerData['text_content'] ?? null,
                    'x_position' => $layerData['x_position'],
                    'y_position' => $layerData['y_position'],
                    'width' => $layerData['width'],
                    'height' => $layerData['height'],
                    'rotation' => $layerData['rotation'] ?? 0,
                    'scale_x' => $layerData['scale_x'] ?? 1,
                    'scale_y' => $layerData['scale_y'] ?? 1,
                    'print_position' => $layerData['print_position'],
                    'z_index' => $layerData['z_index'] ?? 0,
                    'layer_json' => $layerData['layer_json'] ?? null,
                    'source_path' => $layerData['source_path'] ?? null,
                    'layer_name' => $layerData['layer_name'] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'design_id' => $design->id,
                'message' => 'Design saved successfully!'
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Design save error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to save design: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Retrieve a design by ID
     */
    public function show($id)
    {
        $design = CustomproductDesign::with(['layers', 'customproduct'])->find($id);

        if (!$design) {
            return response()->json([
                'success' => false,
                'message' => 'Design not found.'
            ], 404);
        }

        // Check authorization (own design or guest session)
        if ($design->user_id) {
            if (!Auth::check() || $design->user_id != Auth::user()->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
        } else {
            if (Auth::check()) {
                // Claimant: Logged in user viewing a guest design - associate it
                $design->user_id = Auth::user()->user_id;
                $design->session_id = null;
                $design->save();
            } elseif ($design->session_id !== session()->getId()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
        }

        return response()->json([
            'success' => true,
            'design' => [
                'id' => $design->id,
                'customproduct_id' => $design->customproduct_id,
                'canvas_width' => $design->canvas_width,
                'canvas_height' => $design->canvas_height,
                'product_color' => $design->product_color,
                'product_size' => $design->product_size,
                'front_canvas_json' => $design->design_json_front,
                'back_canvas_json' => $design->design_json_back,
                'preview_front' => $design->preview_image_front ? Storage::disk('shared')->url($design->preview_image_front) : null,
                'preview_back' => $design->preview_image_back ? Storage::disk('shared')->url($design->preview_image_back) : null,
                'layers' => $design->layers,
                'created_at' => $design->created_at,
            ]
        ]);
    }

    /**
     * Get all designs for the current user
     */
    public function myDesigns()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view your designs.'
            ], 401);
        }

        $designs = CustomproductDesign::where('user_id', Auth::user()->user_id)
            ->with('customproduct')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'designs' => $designs->map(function ($design) {
                return [
                    'id'           => $design->id,
                    'design_name'  => $design->design_name ?? 'Untitled',
                    'product_name' => $design->customproduct?->name,
                    'thumbnail'    => $design->thumbnail_path
                        ? Storage::disk('shared')->url($design->thumbnail_path) : null,
                    'preview_front' => $design->preview_image_front
                        ? Storage::disk('shared')->url($design->preview_image_front) : null,
                    'product_color' => $design->product_color,
                    'product_size'  => $design->product_size,
                    'status'        => $design->status,
                    'updated_at'    => $design->updated_at->format('M d, Y'),
                ];
            })
        ]);
    }

    /**
     * PUT Update for autosave
     */
    public function update(Request $request, $id)
    {
        $design = CustomproductDesign::findOrFail($id);

        // Security check
        if ($design->user_id) {
            // Registered project: Must be the owner
            if (!Auth::check() || $design->user_id != Auth::user()->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            // Guest project: If user is now logged in, associate it with them
            if (Auth::check()) {
                $design->user_id = Auth::user()->user_id;
                $design->session_id = null;
                $design->save();
            } elseif ($design->session_id !== session()->getId()) {
                // Still a guest, but session ID changed (e.g. cookie cleared)
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        // Validation (Optional in update, but good for data integrity)
        $request->validate([
            'design_name' => 'nullable|string|max:255',
            'design_json_front' => 'nullable|string',
            'design_json_back' => 'nullable|string',
            'design_json_right' => 'nullable|string',
            'design_json_left' => 'nullable|string',
            'layers' => 'nullable|array|max:100',
            'layers.*.layer_type' => 'required_with:layers|in:image,text,icon',
            'layers.*.source_path' => 'nullable|string|max:500',
            'layers.*.layer_name' => 'nullable|string|max:200',
            'layers.*.x_position' => 'required_with:layers|numeric',
            'layers.*.y_position' => 'required_with:layers|numeric',
            'layers.*.width' => 'required_with:layers|numeric',
            'layers.*.height' => 'required_with:layers|numeric',
            'layers.*.print_position' => 'required_with:layers|string',
        ]);

        if ($request->has('design_json_front')) $design->design_json_front = $request->design_json_front;
        if ($request->has('design_json_back')) $design->design_json_back = $request->design_json_back;
        if ($request->has('design_json_right')) $design->design_json_right_shoulder = $request->design_json_right;
        if ($request->has('design_json_left')) $design->design_json_left_shoulder = $request->design_json_left;
        if ($request->has('design_name')) $design->design_name = $request->design_name;

        // Optimized side saving for update
        $sides = ['front', 'back', 'right_shoulder', 'left_shoulder'];
        foreach ($sides as $side) {
            $key = $side . '_preview_base64';
            if ($request->has($key)) {
                $column = 'preview_image_' . $side;
                $design->$column = $this->saveOrganizedImage($request->input($key), $side, $design);
                if ($side === 'front') {
                    $design->thumbnail_path = $this->saveOrganizedImage($request->input($key), 'thumb', $design, true);
                }
            }
        }

        $design->save();

        // Sync layers if provided
        if ($request->has('layers')) {
            DesignLayer::where('design_id', $design->id)->delete();
            foreach ($request->layers as $layerData) {
                DesignLayer::create([
                    'design_id' => $design->id,
                    'layer_type' => $layerData['layer_type'],
                    'text_content' => $layerData['text_content'] ?? null,
                    'x_position' => $layerData['x_position'],
                    'y_position' => $layerData['y_position'],
                    'width' => $layerData['width'],
                    'height' => $layerData['height'],
                    'rotation' => $layerData['rotation'] ?? 0,
                    'scale_x' => $layerData['scale_x'] ?? 1,
                    'scale_y' => $layerData['scale_y'] ?? 1,
                    'print_position' => $layerData['print_position'],
                    'z_index' => $layerData['z_index'] ?? 0,
                    'layer_json' => $layerData['layer_json'] ?? null,
                    'source_path' => $layerData['source_path'] ?? null,
                    'layer_name' => $layerData['layer_name'] ?? null,
                ]);
            }
        }

        return response()->json([
            'success' => true, 
            'message' => 'Design updated successfully', 
            'design_id' => $design->id
        ]);
    }

    /**
     * Organized Image Saving
     */
    private function saveOrganizedImage($base64String, $side, $design, $isThumb = false)
    {
        try {
            // Guard clause to prevent saving 0-byte corrupted images
            if (empty($base64String) || strlen(trim($base64String)) < 100 || $base64String === 'data:,') {
                return null;
            }

            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $match)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            $imageData = base64_decode($base64String);
            
            if ($imageData === false || strlen($imageData) === 0) {
                return null;
            }
            
            $userId = $design->user_id ?: 'guest_' . $design->session_id;
            $folder = "user_designs/user_{$userId}/design_{$design->id}";
            $fileName = "{$side}.png";
            $path = "{$folder}/{$fileName}";

            Storage::disk('shared')->put($path, $imageData);
            return $path;
        } catch (\Exception $e) {
            Log::error('Organized Save Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a design
     */
    public function destroy($id)
    {
        $design = CustomproductDesign::find($id);

        if (!$design) {
            return response()->json([
                'success' => false,
                'message' => 'Design not found.'
            ], 404);
        }

        // Check authorization
        if ($design->user_id) {
            if (!Auth::check() || $design->user_id != Auth::user()->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
        } else {
            if ($design->session_id !== session()->getId()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
        }

        // Delete preview images
        if ($design->preview_image_front) {
            Storage::disk('shared')->delete($design->preview_image_front);
        }
        if ($design->preview_image_back) {
            Storage::disk('shared')->delete($design->preview_image_back);
        }

        $design->delete();

        return response()->json([
            'success' => true,
            'message' => 'Design deleted successfully.'
        ]);
    }

    /**
     * Validate print boundaries
     */
    private function validatePrintBoundaries($layer, $canvasWidth, $canvasHeight)
    {
        $product = Customproduct::find(request()->customproduct_id);
        
        if ($product && $product->printable_rect) {
            $area = is_string($product->printable_rect) ? json_decode($product->printable_rect, true) : $product->printable_rect;
        } else {
            // Fallback to defaults
            $printAreas = [
                'front' => ['x' => 60, 'y' => 100, 'width' => 280, 'height' => 300],
                'back' => ['x' => 60, 'y' => 100, 'width' => 280, 'height' => 300],
                'chest' => ['x' => 50, 'y' => 100, 'width' => 100, 'height' => 100],
                'shoulder' => ['x' => 50, 'y' => 50, 'width' => 80, 'height' => 80],
            ];
            $area = $printAreas[$layer['print_position']] ?? $printAreas['front'];
        }

        // Check if layer is within boundaries
        if ($layer['x_position'] < $area['x'] ||
            $layer['y_position'] < $area['y'] ||
            ($layer['x_position'] + $layer['width']) > ($area['x'] + $area['width']) ||
            ($layer['y_position'] + $layer['height']) > ($area['y'] + $area['height'])) {
            
            throw ValidationException::withMessages([
                'layers' => 'Some design elements (on ' . $layer['print_position'] . ') are outside the printable area. Please adjust your design.'
            ]);
        }
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64String, $side)
    {
        try {
            // Remove data URL prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $imageType = strtolower($type[1]);
            } else {
                $imageType = 'png';
            }

            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Failed to decode base64 image');
            }

            $fileName = 'designs/' . uniqid() . '_' . $side . '.' . $imageType;
            Storage::disk('shared')->put($fileName, $imageData);

            return $fileName;
        } catch (\Exception $e) {
            Log::error('Image save error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle user image upload for their design
     */
    public function uploadUserImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:10240', // 10MB
        ]);

        try {
            $path = $request->file('image')->store('user_uploads', 'shared');
            
            $url = Storage::disk('shared')->url($path);
            
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => route('image.proxy', ['url' => $url]),
                'message' => 'Image uploaded successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('User image upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image'
            ], 500);
        }
    }

    /**
     * Upload an exported design image to the server
     */
    public function uploadExport(Request $request)
    {
        try {
            $base64String = $request->input('image');
            
            // Remove data URL prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $imageType = strtolower($type[1]);
            } else {
                $imageType = 'png';
            }

            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                return response()->json(['success' => false, 'message' => 'Invalid image data'], 400);
            }

            $fileName = 'design_' . uniqid() . '_' . $request->input('view') . '.' . $imageType;
            // Use the shared disk to maintain central configuration
            Storage::disk('shared')->put($fileName, $imageData);

            // Generate full URL leveraging .env MAIN_URL configuration
            $url = Storage::disk('shared')->url($fileName);

            return response()->json([
                'success' => true, 
                'message' => 'Image saved successfully',
                'url' => $url,
                'filename' => $fileName
            ]);

        } catch (\Exception $e) {
            Log::error('Export upload error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error saving image'], 500);
        }
    }
}
