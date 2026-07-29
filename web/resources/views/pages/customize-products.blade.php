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
                            <a href="{{ url('/design') . '?product_id=' . $product->id }}"
                               class="btn tool-btn-premium active w-100 py-3 fw-bold"
                               style="text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">
                                <i class="fas fa-pen-ruler me-2"></i> {{ gt('Start Designing') }}
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
    {{-- VanillaTilt — only loaded on non-touch devices --}}
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
        });
    </script>
@endpush

@endsection
