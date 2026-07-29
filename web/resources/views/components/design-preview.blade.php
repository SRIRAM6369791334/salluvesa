@props(['design', 'side' => 'front', 'width' => 120])

@php
    $column = 'preview_image_' . $side;
    $designImage = $design->$column;
    $product = $design->customproduct;
    
    // Attempt to get printable rect for this side
    $rect = null;
    if ($product && $product->printable_rect) {
        $allRects = is_string($product->printable_rect) ? json_decode($product->printable_rect, true) : $product->printable_rect;
        // In this simplified version, we might have one rect for all or per-side rects
        $rect = $allRects[$side] ?? $allRects; 
    }

    // Fallback rect if not found
    if (!$rect || !isset($rect['x'])) {
        $rect = ['x' => 180, 'y' => 200, 'width' => 240, 'height' => 300];
    }

    // Get Mockup Image for this color/side
    $mockupUrl = '';
    if ($design->product_color_id && $design->color) {
        // Find the image for this side in the product color images
        $colorImage = $design->color->images()->where('view_type', $side)->first();
        if ($colorImage) {
            $mockupUrl = $colorImage->image_url;
        }
    }
    
    // Fallback mockup
    if (!$mockupUrl && $product) {
        $mockupUrl = ($side == 'back') ? $product->back_mockup : $product->front_mockup;
        $mainUrl = rtrim(env('MAIN_URL', ''), '/');
        if ($mockupUrl && $mainUrl && !str_starts_with($mockupUrl, 'http')) {
             $mockupUrl = $mainUrl . '/' . ltrim($mockupUrl, '/');
        }
    }

    // Calculate relative scaling for the preview box
    // Base mockup display size is 600px in the designer
    $scale = $width / 600;
@endphp

<div class="cs_design_preview_box" style="position: relative; width: {{ $width }}px; height: {{ $width }}px; background: #f8f9ff; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
    @if($designImage)
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('shared')->url($designImage) }}" style="width: 100%; height: 100%; object-fit: contain; display: block;">
    @elseif($mockupUrl)
        {{-- Fallback: just show the empty shirt --}}
        <img src="{{ $mockupUrl }}" style="width: 100%; height: 100%; object-fit: contain; display: block;">
    @else
        <div class="text-muted text-center mt-4"><i class="fa-solid fa-image fa-2x"></i></div>
    @endif
</div>

