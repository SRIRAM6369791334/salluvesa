@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
    <style>
        .mockup-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mockup-img {
            position: absolute;
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s ease;
            padding: 2rem;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));
        }
        .mockup-back {
            opacity: 0;
            transform: scale(0.95);
        }
        .premium-card:hover .mockup-front {
            opacity: 0;
            transform: scale(0.95);
        }
        .premium-card:hover .mockup-back {
            opacity: 1;
            transform: scale(1);
        }
    </style>
@endpush

@section('content')

{{-- Mobile Blocker Overlay --}}
<style>
    .mobile-blocked-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #f8fafc;
        z-index: 2147483647; /* Higher than everything */
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
        padding: 2rem;
    }
    .mobile-blocked-overlay h2 {
        color: #111827;
        font-weight: 800;
        margin-top: 1.5rem;
        font-family: var(--font-display, 'Outfit', sans-serif);
    }
    .mobile-blocked-overlay p {
        color: #6b7280;
        max-width: 450px;
        margin-top: 1rem;
        line-height: 1.6;
    }
    @media (min-width: 200px) and (max-width: 1300px) {
        .mobile-blocked-overlay {
            display: flex !important;
        }
        /* Hide the product selector, AND the site's default header/footer/buttons on this page */
        .desktop-only-container,
        .cs_site_header,
        .cs_footer,
        .whatsapp_float_btn,
        #cs_scroll_btn,
        .cs_page_heading {
            display: none !important;
        }
        
        /* Remove padding/margin from body so overlay takes full space flawlessly */
        body { padding: 0 !important; margin: 0 !important; }
    }
</style>

<div class="mobile-blocked-overlay">
    <i class="fas fa-laptop-code fa-4x" style="color: #1C30A3;"></i>
    <h2>Desktop Recommended</h2>
    <p>{{ gt('Our custom design studio requires a larger workspace. Please switch to a device with a screen wider than 1300px for the best designing experience.') }}</p>
    <a href="{{ url('/') }}" class="cs_btn_primary mt-4" style="text-decoration: none;"><i class="fas fa-home me-2"></i> {{ gt('Return Home') }}</a>
</div>

<div class="container py-5 entrance-fade desktop-only-container">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold reveal-text" style="color: #111827; letter-spacing: -1px;">
            <span>{{ gt('Design Your Masterpiece') }}</span>
        </h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            {{ gt('Choose a premium canvas from our collection and unleash your creativity with our professional design tools.') }}
        </p>
    </div>

    @if($products->isEmpty())
        {{-- ── Empty state ──────────────────────────────────────── --}}
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-5x text-muted opacity-25 mb-4 d-block"></i>
            <h3 style="color: #374151;">{{ gt('No products available yet') }}</h3>
            <p class="text-muted">{{ gt('Check back soon — new products are being added regularly.') }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                <i class="fas fa-home me-2"></i> {{ gt('Return Home') }}
            </a>
        </div>
    @else
        <div class="row g-5" id="products-grid">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="premium-card h-100 border-0 cs-shadow-premium"
                         data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-perspective="1000">

                        <div class="card-img-top position-relative"
                             style="height: 320px; background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%); overflow: hidden;">

                            <div class="mockup-container">
                                @if($product->front_mockup)
                                    @php
                                        $mainUrl = rtrim(config('app.main_url', ''), '/');
                                        
                                        $frontPath = ltrim($product->front_mockup, '/');
                                        $frontFullUrl = $mainUrl ? $mainUrl . '/' . $frontPath : asset($frontPath);
                                        $frontSrc = $mainUrl ? route('image.proxy', ['url' => $frontFullUrl]) : $frontFullUrl;

                                        $backSrc = null;
                                        if ($product->is_two_sided && $product->back_mockup) {
                                            $backPath = ltrim($product->back_mockup, '/');
                                            $backFullUrl = $mainUrl ? $mainUrl . '/' . $backPath : asset($backPath);
                                            $backSrc = $mainUrl ? route('image.proxy', ['url' => $backFullUrl]) : $backFullUrl;
                                        }
                                    @endphp
                                    
                                    <img src="{{ $frontSrc }}"
                                         alt="{{ e($product->name) }} Front"
                                         loading="lazy"
                                         class="mockup-img mockup-front"
                                         onerror="this.src='https://placehold.co/800x900/f3f4f6/111827?text={{ urlencode($product->name) }}'">

                                    @if($backSrc)
                                        <img src="{{ $backSrc }}"
                                             alt="{{ e($product->name) }} Back"
                                             loading="lazy"
                                             class="mockup-img mockup-back">
                                    @endif
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-tshirt fa-5x text-muted opacity-25"></i>
                                        <p class="small text-muted mt-2">{{ gt('Preview Unavailable') }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Price badge --}}
                            <div class="position-absolute top-0 start-0 p-3">
                                <span class="price-badge-premium">${{ number_format($product->base_price, 0) }}</span>
                            </div>

                            @if($product->is_two_sided)
                                <div class="position-absolute top-0 end-0 p-3">
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill fw-bold"
                                          style="font-size: 10px; letter-spacing: 0.5px;">
                                        {{ gt('DUAL VIEW') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-2" style="color: #111827; letter-spacing: -0.5px;">
                                {{ e($product->name) }}
                            </h5>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">
                                {{ $product->description ?? gt('High-quality breathable fabric optimized for premium printing.') }}
                            </p>

                            {{-- /design?product_id=X — design.index has no name, so use url() --}}
                            <div class="d-flex gap-2">
                                <a href="{{ url('/design') . '?product_id=' . $product->id }}"
                                   class="btn tool-btn-premium active w-50 py-3 fw-bold"
                                   style="text-transform: uppercase; letter-spacing: 0.5px; font-size: 11px;">
                                    <i class="fas fa-pen-ruler me-1"></i> {{ gt('Studio') }}
                                </a>
                                <button type="button"
                                        class="btn btn-primary w-50 py-3 fw-bold open-custom-modal"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ e($product->name) }}"
                                        data-baseprice="{{ $product->base_price }}"
                                        data-front="{{ $frontSrc }}"
                                        data-back="{{ $backSrc }}"
                                        data-left="{{ $product->left_shoulder_mockup ? ($mainUrl ? route('image.proxy', ['url' => rtrim(config('app.main_url'), '/') . '/' . ltrim($product->left_shoulder_mockup, '/')]) : asset($product->left_shoulder_mockup)) : '' }}"
                                        data-right="{{ $product->right_shoulder_mockup ? ($mainUrl ? route('image.proxy', ['url' => rtrim(config('app.main_url'), '/') . '/' . ltrim($product->right_shoulder_mockup, '/')]) : asset($product->right_shoulder_mockup)) : '' }}"
                                        data-placement="{{ is_array($product->printable_rect) ? json_encode($product->printable_rect) : ($product->printable_rect ?: '') }}"
                                        style="text-transform: uppercase; letter-spacing: 0.5px; font-size: 11px; background: linear-gradient(135deg, #1C30A3 0%, #2B45D4 100%); border: none;">
                                    <i class="fas fa-magic me-1"></i> {{ gt('Quick Custom') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── Quick Customization Modal Overlay ── --}}
<div class="modal fade" id="customizationModal" tabindex="-1" aria-labelledby="customizationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 bg-dark text-white p-4">
                <h5 class="modal-header-title fw-bold m-0" id="customizationModalLabel">
                    <i class="fas fa-sliders-h me-2 text-primary"></i> <span id="modal-product-title">Customize Product</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    {{-- Left View Container --}}
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm p-3 text-center position-relative bg-white" style="border-radius: 16px;">
                            {{-- View Tabs --}}
                            <div class="btn-group mb-3 w-100 shadow-sm" role="group" aria-label="Garment View">
                                <button type="button" class="btn btn-outline-dark active view-tab-btn" data-view="front"><i class="fas fa-user-ninja me-1"></i> Front</button>
                                <button type="button" class="btn btn-outline-dark view-tab-btn" data-view="back" id="tab-btn-back"><i class="fas fa-user-ninja fa-flip-horizontal me-1"></i> Back</button>
                                <button type="button" class="btn btn-outline-dark view-tab-btn" data-view="left" id="tab-btn-left"><i class="fas fa-hand-point-left me-1"></i> Left Sleeve</button>
                                <button type="button" class="btn btn-outline-dark view-tab-btn" data-view="right" id="tab-btn-right"><i class="fas fa-hand-point-right me-1"></i> Right Sleeve</button>
                            </div>

                            {{-- Capture View Area --}}
                            <div id="garment-capture-area" class="position-relative mx-auto overflow-hidden rounded bg-white" style="width: 100%; max-width: 480px; height: 500px; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center;">
                                <img id="garment-modal-img" src="" class="img-fluid w-100 h-100" style="object-fit: contain;" alt="Garment Preview">
                                
                                {{-- Overlay Target Box (Dynamically configured from Admin Dashboard) --}}
                                <div id="customization-overlay-box" class="position-absolute d-flex flex-column align-items-center justify-content-center overflow-hidden" 
                                     style="top: 25%; left: 28%; width: 44%; height: 55%; border: 2px dashed #038edc; background: rgba(3, 142, 220, 0.15); border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 10;">
                                    <span id="overlay-zone-label" class="badge bg-danger mb-1 shadow-sm" style="font-size: 10px; pointer-events: none;">LEFT CHEST</span>
                                    <img id="overlay-logo-img" src="" class="img-fluid d-none" style="max-height: 85%; max-width: 85%; object-fit: contain;" alt="Custom Logo">
                                    <span id="overlay-custom-text" class="fw-bold d-none" style="font-size: 14px; color: #1e293b; text-shadow: 0 1px 2px rgba(255,255,255,0.8); max-width: 90%; word-break: break-word;"></span>
                                    <small id="overlay-placeholder-hint" class="text-primary fw-bold" style="font-size: 10px;">🖐 Logo / Text Paste Area</small>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Admin configured artwork placement zone</small>
                        </div>
                    </div>

                    {{-- Right Controls --}}
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 16px;">
                            <h6 class="fw-bold text-uppercase text-muted mb-3" style="letter-spacing: 0.5px; font-size: 12px;">Customization Details</h6>
                            
                            {{-- Method Selection --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">1. Select Customization Method</label>
                                <select class="form-select shadow-none" id="modal-custom-method">
                                    <option value="Embroidery" data-price="150">Embroidery (+ ₹150)</option>
                                    <option value="Screen Printing" data-price="100">Screen Printing (+ ₹100)</option>
                                    <option value="DTF Printing" data-price="120">DTF Printing (+ ₹120)</option>
                                    <option value="Text Only" data-price="75">Text Embroidery Only (+ ₹75)</option>
                                </select>
                            </div>

                            {{-- Position Selection --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">2. Placement Position</label>
                                <select class="form-select shadow-none" id="modal-custom-position">
                                    <option value="Left Chest">Left Chest</option>
                                    <option value="Right Chest">Right Chest</option>
                                    <option value="Center Chest">Center Chest</option>
                                    <option value="Full Back">Full Back</option>
                                    <option value="Left Sleeve">Left Sleeve</option>
                                    <option value="Right Sleeve">Right Sleeve</option>
                                </select>
                            </div>

                            {{-- Logo Upload --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">3. Upload Logo / Image</label>
                                <input type="file" class="form-control" id="modal-logo-input" accept="image/*">
                                <small class="text-muted" style="font-size: 11px;">PNG, JPG or SVG (Max 10MB)</small>
                            </div>

                            {{-- Custom Text & Color --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">4. Custom Text (Optional)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="modal-text-input" placeholder="e.g. Staff / Company Name">
                                    <input type="color" class="form-control form-control-color" id="modal-text-color" value="#1e293b" title="Choose Text Color" style="width: 50px;">
                                </div>
                            </div>

                            {{-- Size & Quantity --}}
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold small">Size</label>
                                    <select class="form-select" id="modal-size-select">
                                        <option value="S">Small (S)</option>
                                        <option value="M" selected>Medium (M)</option>
                                        <option value="L">Large (L)</option>
                                        <option value="XL">Extra Large (XL)</option>
                                        <option value="XXL">Double XL (XXL)</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold small">Quantity</label>
                                    <input type="number" class="form-control" id="modal-qty-input" value="1" min="1" max="1000">
                                </div>
                            </div>

                            <hr class="my-3">

                            {{-- Price Calculation --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-muted">Total Calculated Price:</span>
                                <span class="fs-4 fw-bold text-primary" id="modal-total-price-display">₹0.00</span>
                            </div>

                            <button type="button" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow" id="modal-add-to-cart-btn" style="border-radius: 12px; background: #10b981; border: none;">
                                <i class="fas fa-shopping-cart me-2"></i> Add Custom Product to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    @if(request()->header('Sec-CH-UA-Mobile') !== '?1')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Reveal animation
            const reveal = document.querySelector('.reveal-text');
            if (reveal) setTimeout(() => reveal.classList.add('is-visible'), 100);

            // Initialize tilt only if library loaded — no error if absent
            if (typeof VanillaTilt !== 'undefined') {
                VanillaTilt.init(document.querySelectorAll('.premium-card'), {
                    max       : 5,
                    speed     : 400,
                    glare     : true,
                    'max-glare': 0.2,
                });
            }

            // Quick Customization Modal Logic
            let activeProductId = null;
            let basePrice = 0;
            let currentViews = {};
            let activePlacementConfig = {};
            let currentActiveView = 'front';

            // Per-View Customization State Dictionary
            let viewCustomizations = {
                front: { text: '', color: '#1e293b', logoUrl: null },
                back: { text: '', color: '#1e293b', logoUrl: null },
                left: { text: '', color: '#1e293b', logoUrl: null },
                right: { text: '', color: '#1e293b', logoUrl: null }
            };

            function resetCustomizationState() {
                viewCustomizations = {
                    front: { text: '', color: '#1e293b', logoUrl: null },
                    back: { text: '', color: '#1e293b', logoUrl: null },
                    left: { text: '', color: '#1e293b', logoUrl: null },
                    right: { text: '', color: '#1e293b', logoUrl: null }
                };
            }

            function saveCurrentViewInputs() {
                const textInput = document.getElementById('modal-text-input');
                const textColorInput = document.getElementById('modal-text-color');
                if (viewCustomizations[currentActiveView]) {
                    viewCustomizations[currentActiveView].text = textInput ? textInput.value.trim() : '';
                    viewCustomizations[currentActiveView].color = textColorInput ? textColorInput.value : '#1e293b';
                }
            }

            function renderViewOverlay(view) {
                currentActiveView = view;
                if (currentViews[view]) {
                    document.getElementById('garment-modal-img').src = currentViews[view];
                }

                // 1. Placement Box Style
                const conf = activePlacementConfig[view] || { enabled: true, top: 25, left: 28, width: 44, height: 55, radius: 4, rotation: 0, label: (view === 'front' ? 'LEFT CHEST' : (view === 'back' ? 'UPPER BACK' : view.toUpperCase() + ' SLEEVE')) };
                const box = document.getElementById('customization-overlay-box');
                const labelBadge = document.getElementById('overlay-zone-label');
                const posSelect = document.getElementById('modal-custom-position');

                if (box) {
                    if (conf.enabled !== false) {
                        box.style.display = 'flex';
                        box.style.top = (conf.top || 25) + '%';
                        box.style.left = (conf.left || 28) + '%';
                        box.style.width = (conf.width || 44) + '%';
                        box.style.height = (conf.height || 55) + '%';
                        box.style.borderRadius = (conf.radius || 4) + 'px';
                        box.style.transform = `rotate(${conf.rotation || 0}deg)`;
                        if (labelBadge) labelBadge.innerText = conf.label || (view === 'front' ? 'LEFT CHEST' : view.toUpperCase() + ' AREA');
                        if (posSelect) posSelect.value = conf.label || (view === 'front' ? 'Left Chest' : view.toUpperCase() + ' AREA');
                    } else {
                        box.style.display = 'none';
                    }
                }

                // 2. Load Active View Artwork State
                const currentData = viewCustomizations[view] || { text: '', color: '#1e293b', logoUrl: null };
                const textInput = document.getElementById('modal-text-input');
                const textColorInput = document.getElementById('modal-text-color');
                const overlayText = document.getElementById('overlay-custom-text');
                const overlayLogo = document.getElementById('overlay-logo-img');
                const placeholderHint = document.getElementById('overlay-placeholder-hint');

                if (textInput) textInput.value = currentData.text || '';
                if (textColorInput) textColorInput.value = currentData.color || '#1e293b';

                let hasArtwork = false;

                if (currentData.text && currentData.text.length > 0) {
                    overlayText.innerText = currentData.text;
                    overlayText.style.color = currentData.color || '#1e293b';
                    overlayText.classList.remove('d-none');
                    hasArtwork = true;
                } else {
                    overlayText.classList.add('d-none');
                }

                if (currentData.logoUrl) {
                    overlayLogo.src = currentData.logoUrl;
                    overlayLogo.classList.remove('d-none');
                    hasArtwork = true;
                } else {
                    overlayLogo.classList.add('d-none');
                }

                if (hasArtwork) {
                    if (placeholderHint) placeholderHint.classList.add('d-none');
                } else {
                    if (placeholderHint) placeholderHint.classList.remove('d-none');
                }
            }

            // 1. Open Modal
            document.querySelectorAll('.open-custom-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    activeProductId = this.dataset.id;
                    basePrice = parseFloat(this.dataset.baseprice) || 0;
                    
                    document.getElementById('modal-product-title').innerText = 'Customize ' + this.dataset.name;
                    
                    currentViews = {
                        front: this.dataset.front || '',
                        back: this.dataset.back || '',
                        left: this.dataset.left || '',
                        right: this.dataset.right || ''
                    };

                    try {
                        activePlacementConfig = this.dataset.placement ? JSON.parse(this.dataset.placement) : {};
                    } catch(e) { activePlacementConfig = {}; }

                    resetCustomizationState();

                    // Reset View Tabs
                    document.querySelectorAll('.view-tab-btn').forEach(tb => tb.classList.remove('active'));
                    document.querySelector('.view-tab-btn[data-view="front"]').classList.add('active');

                    renderViewOverlay('front');

                    document.getElementById('modal-logo-input').value = '';
                    updatePriceDisplay();

                    const modal = new bootstrap.Modal(document.getElementById('customizationModal'));
                    modal.show();
                });
            });

            // 2. View Tab Switching
            document.querySelectorAll('.view-tab-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    saveCurrentViewInputs();
                    document.querySelectorAll('.view-tab-btn').forEach(tb => tb.classList.remove('active'));
                    this.classList.add('active');
                    renderViewOverlay(this.dataset.view);
                });
            });

            // 3. Logo Upload per active view
            document.getElementById('modal-logo-input')?.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("customization.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        viewCustomizations[currentActiveView].logoUrl = data.url;
                        renderViewOverlay(currentActiveView);
                    } else {
                        alert(data.message || 'Logo upload failed');
                    }
                })
                .catch(err => {
                    console.error('Upload Error:', err);
                    alert('Error uploading logo image.');
                });
            });

            // 4. Custom Text Input & Color per active view
            document.getElementById('modal-text-input')?.addEventListener('input', function () {
                viewCustomizations[currentActiveView].text = this.value.trim();
                renderViewOverlay(currentActiveView);
            });

            document.getElementById('modal-text-color')?.addEventListener('input', function () {
                viewCustomizations[currentActiveView].color = this.value;
                renderViewOverlay(currentActiveView);
            });

            // 5. Method & Price Calculation
            document.getElementById('modal-custom-method')?.addEventListener('change', updatePriceDisplay);

            function updatePriceDisplay() {
                const methodSelect = document.getElementById('modal-custom-method');
                if (!methodSelect) return;
                const selectedOpt = methodSelect.options[methodSelect.selectedIndex];
                const extraPrice = parseFloat(selectedOpt?.dataset?.price) || 0;
                const totalPrice = basePrice + extraPrice;
                document.getElementById('modal-total-price-display').innerText = '₹' + totalPrice.toFixed(2);
            }

            // 6. Multi-View Capture and Add Custom Product to Cart
            document.getElementById('modal-add-to-cart-btn')?.addEventListener('click', async function () {
                saveCurrentViewInputs();
                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Capturing All View Previews...';

                const captureArea = document.getElementById('garment-capture-area');
                const viewsToCapture = ['front', 'back', 'left', 'right'];
                const capturedPreviews = {};

                for (let v of viewsToCapture) {
                    if (currentViews[v]) {
                        renderViewOverlay(v);
                        await new Promise(r => setTimeout(r, 200));
                        try {
                            const canvas = await html2canvas(captureArea, {
                                useCORS: true,
                                allowTaint: true,
                                backgroundColor: null,
                                scale: 2
                            });
                            capturedPreviews[v] = canvas.toDataURL('image/png');
                        } catch(err) {
                            console.error('Error capturing view ' + v, err);
                        }
                    }
                }

                // Restore Front View Tab
                renderViewOverlay('front');

                // Step A: Upload All View Preview Screenshots
                fetch('{{ route("customization.upload_preview") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ images: capturedPreviews, image: capturedPreviews.front || '' })
                })
                .then(res => res.json())
                .then(previewData => {
                    const previewMap = previewData.urls || { front: previewData.url || null };
                    const methodSelect = document.getElementById('modal-custom-method');
                    const selectedOpt = methodSelect.options[methodSelect.selectedIndex];
                    const extraPrice = parseFloat(selectedOpt.dataset.price) || 0;

                    // Summarize logo & text across views
                    const allTexts = Object.entries(viewCustomizations)
                        .filter(([k, v]) => v.text)
                        .map(([k, v]) => k.toUpperCase() + ': ' + v.text)
                        .join(' | ');
                    const firstLogo = Object.values(viewCustomizations).map(v => v.logoUrl).filter(Boolean)[0] || null;

                    // Step B: Add to Cart API
                    const cartPayload = {
                        id: activeProductId,
                        type: 'custom',
                        quantity: parseInt(document.getElementById('modal-qty-input').value) || 1,
                        size: document.getElementById('modal-size-select').value,
                        color: 'Standard',
                        customization_type: methodSelect.value,
                        customization_method: methodSelect.value,
                        customization_position: document.getElementById('modal-custom-position').value || 'Left Chest',
                        custom_text: allTexts || '',
                        custom_text_color: viewCustomizations.front.color || '#1e293b',
                        custom_logo_url: firstLogo,
                        customization_price: extraPrice,
                        preview_screenshot_url: JSON.stringify(previewMap),
                        _token: '{{ csrf_token() }}'
                    };

                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(cartPayload)
                    })
                    .then(res => res.json())
                    .then(cartRes => {
                        if (cartRes.success) {
                            window.location.href = '{{ route("cart.index") }}';
                        } else {
                            alert(cartRes.message || 'Could not add to cart.');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> Add Custom Product to Cart';
                        }
                    })
                    .catch(err => {
                        console.error('Cart Error:', err);
                        alert('Error adding item to cart.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> Add Custom Product to Cart';
                    });
                })
                .catch(err => {
                    console.error('Preview Upload Error:', err);
                    alert('Error uploading preview screenshots.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> Add Custom Product to Cart';
                });
            });
        });
    </script>
@endpush

@endsection
