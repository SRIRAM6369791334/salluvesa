@extends('layouts.app')
@section('content')
  <!-- Google Fonts - Merriweather -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@900&display=swap" rel="stylesheet">

  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative" style="z-index: 2;">
      <div class="hero-content text-center">
        <div class="hero-badge">
          <span class="badge-icon">✨</span>
          <span>{{ gt('Our Collection') }}</span>
        </div>
        <h1 class="premium-hero-title">
          <span class="title-line">{{ gt('Choose Your') }}</span>
          <span class="title-line gradient-text">{{ gt('Premium Samples') }}</span>
        </h1>
        <p class="premium-hero-subtitle">
          {{ gt('Hand-picked selection of our finest garments for you to experience firsthand') }}
        </p>
        <div class="premium-products-grid">
          @foreach($samples as $index => $sample)
            <!-- Product Card {{ $index + 1 }} -->
            <div class="premium-product-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <div class="product-card-inner">
                <div class="product-image-wrapper">
                  @if($sample->badge)
                    <div class="product-badge {{ $sample->badge_type }}">{{ $sample->badge }}</div>
                  @endif
                    <img src="{{ env('MAIN_URL') . 'images/' . ltrim($sample->image, '/') }}" alt="{{ $sample->title }}" class="product-image">
                  <div class="product-overlay">
                    <!-- <button class="quick-view-btn">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                      </svg>
                      Quick View
                    </button> -->
                  </div>
                </div>
                <div class="product-info">
                  <span class="product-category">{{ $sample->category }}</span>
                  <h3 class="product-title">{{ $sample->title }}</h3>
                  <p class="product-description">{{ $sample->description }}</p>
                  <div class="product-features">
                    @if($sample->features)
                      @foreach($sample->features as $feature)
                        <span class="feature-tag">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                          </svg>
                          {{ $feature }}
                        </span>
                      @endforeach
                    @endif
                  </div>
                  <button class="add-sample-btn" data-product="{{ json_encode([
                    'id' => $sample->id,
                    'name' => $sample->title,
                    'image' => asset($sample->image),
                    'price' => $sample->price,
                    'sizes' => $sample->sizes ?? ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                    'gsm' => $sample->gsm ?? [],
                    'colors' => $sample->colors ?? []
                  ]) }}">
                    <span class="btn-icon">+</span>
                    <span class="btn-text">{{ gt('Add to Sample Order') }}</span>
                    <span class="btn-shimmer"></span>
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- <div class="hero-stats">
          <div class="stat-item">
            <div class="stat-number">500+</div>
            <div class="stat-label">Fabric Options</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">24h</div>
            <div class="stat-label">Quick Delivery</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">100%</div>
            <div class="stat-label">Quality Assured</div>
          </div>
        </div> -->
      </div>
    </div>
    <div class="hero-wave">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path>
      </svg>
    </div>
  </section>

  <!-- Premium Sample Products Grid -->
  {{--<section class="premium-sample-section">
    <div class="container">
      <!-- Section Header -->
      <div class="section-header text-center">
        <span class="section-label">Our Collection</span>
        <h2 class="section-title">Choose Your Premium Samples</h2>
        <p class="section-description">
          Hand-picked selection of our finest garments for you to experience firsthand
        </p>
      </div>

      <!-- Products Grid -->
      <div class="premium-products-grid">
        <!-- Product Card 1 -->
        <div class="premium-product-card" data-aos="fade-up" data-aos-delay="0">
          <div class="product-card-inner">
            <div class="product-image-wrapper">
              <div class="product-badge">Premium</div>
              <img src="img/sample.png" alt="T-Shirts" class="product-image">
              <div class="product-overlay">
                <!-- <button class="quick-view-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  Quick View
                </button> -->
              </div>
            </div>
            <div class="product-info">
              <span class="product-category">Essentials</span>
              <h3 class="product-title">Premium T-Shirts</h3>
              <p class="product-description">100% premium cotton fabric with superior comfort</p>
              <div class="product-features">
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Breathable
                </span>
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Soft Touch
                </span>
              </div>
              <button class="add-sample-btn">
                <span class="btn-icon">+</span>
                <span class="btn-text">Add to Sample Order</span>
                <span class="btn-shimmer"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 2 -->
        <div class="premium-product-card" data-aos="fade-up" data-aos-delay="100">
          <div class="product-card-inner">
            <div class="product-image-wrapper">
              <div class="product-badge popular">Popular</div>
              <img src="img/sample1.png" alt="Polo T-Shirt" class="product-image">
              <div class="product-overlay">
                <!-- <button class="quick-view-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  Quick View
                </button> -->
              </div>
            </div>
            <div class="product-info">
              <span class="product-category">Sportswear</span>
              <h3 class="product-title">Polo T-Shirts</h3>
              <p class="product-description">Classic polo design with modern athletic fit</p>
              <div class="product-features">
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Moisture-wicking
                </span>
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Durable
                </span>
              </div>
              <button class="add-sample-btn">
                <span class="btn-icon">+</span>
                <span class="btn-text">Add to Sample Order</span>
                <span class="btn-shimmer"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 3 -->
        <div class="premium-product-card" data-aos="fade-up" data-aos-delay="200">
          <div class="product-card-inner">
            <div class="product-image-wrapper">
              <div class="product-badge exclusive">Exclusive</div>
              <img src="img/sample2.png" alt="Formal Shirts" class="product-image">
              <div class="product-overlay">
                <!-- <button class="quick-view-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  Quick View
                </button> -->
              </div>
            </div>
            <div class="product-info">
              <span class="product-category">Business</span>
              <h3 class="product-title">Formal Shirts</h3>
              <p class="product-description">Professional elegance meets exceptional comfort</p>
              <div class="product-features">
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Wrinkle-free
                </span>
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Premium
                </span>
              </div>
              <button class="add-sample-btn">
                <span class="btn-icon">+</span>
                <span class="btn-text">Add to Sample Order</span>
                <span class="btn-shimmer"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 4 -->
        <div class="premium-product-card" data-aos="fade-up" data-aos-delay="300">
          <div class="product-card-inner">
            <div class="product-image-wrapper">
              <div class="product-badge">New</div>
              <img src="img/sample3.png" alt="Tank Tops" class="product-image">
              <div class="product-overlay">
                <!-- <button class="quick-view-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  Quick View
                </button> -->
              </div>
            </div>
            <div class="product-info">
              <span class="product-category">Activewear</span>
              <h3 class="product-title">Tank Tops</h3>
              <p class="product-description">Lightweight and flexible for active lifestyles</p>
              <div class="product-features">
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Stretchy
                </span>
                <span class="feature-tag">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                  Quick-dry
                </span>
              </div>
              <button class="add-sample-btn">
                <span class="btn-icon">+</span>
                <span class="btn-text">Add to Sample Order</span>
                <span class="btn-shimmer"></span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Trust Badges -->
      <div class="trust-section">
        <div class="trust-item">
          <div class="trust-icon">🚚</div>
          <h4>Fast Shipping</h4>
          <p>24-48 hour delivery</p>
        </div>
        <div class="trust-item">
          <div class="trust-icon">✅</div>
          <h4>Quality Guaranteed</h4>
          <p>100% authentic fabrics</p>
        </div>
        <div class="trust-item">
          <div class="trust-icon">🔒</div>
          <h4>Secure Payment</h4>
          <p>SSL encrypted checkout</p>
        </div>
        <div class="trust-item">
          <div class="trust-icon">💬</div>
          <h4>24/7 Support</h4>
          <p>Always here to help</p>
        </div>
      </div>
    </div>
  </section>--}}

  <style>
    /* ============================================
       PREMIUM HERO SECTION
    ============================================ */
    .premium-hero-section {
      min-height: 600px;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%);
      position: relative;
      padding: 100px 0 150px;
    }
    /* div:where(.swal2-container).swal2-center>.swal2-popup{
    width: 100% !important;
  } */

    .hero-particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 1;
    }

    .hero-gradient-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
                  radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.3) 0%, transparent 50%);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      animation: heroFadeIn 1s ease-out;
    }

    @@keyframes heroFadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 10px 24px;
      border-radius: 50px;
      color: white;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 30px;
      animation: badgeFloat 3s ease-in-out infinite;
    }

    @@keyframes badgeFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .badge-icon {
      font-size: 18px;
      animation: iconSpin 4s linear infinite;
    }

    @@keyframes iconSpin {
      0%, 90%, 100% { transform: rotate(0deg); }
      95% { transform: rotate(15deg); }
    }

    .premium-hero-title {
      font-size: 72px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: white;
      margin: 0 0 24px 0;
      line-height: 1.1;
      letter-spacing: -2px;
    }

    .title-line {
      display: block;
      animation: titleSlideIn 0.8s ease-out backwards;
    }

    .title-line:nth-child(1) {
      animation-delay: 0.2s;
    }

    .title-line:nth-child(2) {
      animation-delay: 0.4s;
    }

    @@keyframes titleSlideIn {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .gradient-text {
      background: linear-gradient(90deg, #fff 0%, #f0f0f0 50%, #fff 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      background-size: 200% auto;
      animation: textShine 3s linear infinite;
    }

    @@keyframes textShine {
      to {
        background-position: 200% center;
      }
    }

    .premium-hero-subtitle {
      font-size: 20px;
      color: rgba(255, 255, 255, 0.9);
      margin: 0 0 50px 0;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
      animation: subtitleFadeIn 1s ease-out 0.6s backwards;
    }

    @@keyframes subtitleFadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 60px;
      margin-top: 40px;
      animation: statsFadeIn 1s ease-out 0.8s backwards;
    }

    @@keyframes statsFadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 42px;
      font-weight: 800;
      color: white;
      line-height: 1;
      margin-bottom: 8px;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-label {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 500;
    }

    .hero-wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      line-height: 0;
      transform: rotate(180deg);
    }

    .hero-wave svg {
      position: relative;
      display: block;
      width: calc(100% + 1.3px);
      height: 80px;
    }

    .wave-fill {
      fill: #ffffff;
    }

    /* ============================================
       PREMIUM SAMPLE SECTION
    ============================================ */
    .premium-sample-section {
      padding: 100px 0;
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fc 100%);
      position: relative;
    }

    .section-header {
      margin-bottom: 70px;
    }

    .section-label {
      display: inline-block;
      font-size: 14px;
      font-weight: 600;
      color: #1C30A3;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 16px;
      position: relative;
    }

    .section-label::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 40px;
      height: 2px;
      background: linear-gradient(90deg, #1C30A3, #2541C8);
      border-radius: 2px;
    }

    .section-title {
      font-size: 48px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: #1a1a2e;
      margin: 20px 0 16px 0;
      line-height: 1.2;
    }

    .section-description {
      font-size: 18px;
      color: #666;
      max-width: 600px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* ============================================
       PREMIUM PRODUCT CARDS
    ============================================ */
    .premium-products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 320px));
      gap: 28px;
      justify-content: center;
      margin-bottom: 60px;
    }

    .premium-product-card {
      opacity: 0;
      animation: cardFadeIn 0.6s ease-out forwards;
      max-width: 320px;
      width: 100%;
      margin: 0 auto;
    }

    @keyframes cardFadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .premium-product-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .premium-product-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .premium-product-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .premium-product-card:nth-child(4) {
      animation-delay: 0.4s;
    }

    .product-card-inner {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      border: 1.5px solid #e2e8f0;
      box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
      transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .product-card-inner:hover {
      transform: translateY(-8px);
      border-color: #cbd5e1;
      box-shadow: 0 16px 45px rgba(28, 48, 163, 0.15);
    }

    .product-image-wrapper {
      position: relative;
      height: 290px;
      overflow: hidden;
      background: #f8fafc;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .product-image {
      width: 100%;
      height: 100%;
      object-fit: contain;
      padding: 10px;
      transition: transform 0.5s ease;
    }

    /* .product-card-inner:hover .product-image {
      transform: scale(1.1) rotate(2deg);
    } */

    .product-badge {
      position: absolute;
      top: 20px;
      right: 20px;
      background: linear-gradient(135deg, #1C30A3 100%, #2541C8 0%);     color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(28, 48, 163, 0.4);
      animation: badgePulse 2s ease-in-out infinite;
    }

    .product-badge.popular {
      background: linear-gradient(135deg, #3B5FE0 0%, #5A7FFF 100%);
    }

    .product-badge.exclusive {
      background: linear-gradient(135deg, #0D1F6B 0%, #1C30A3 100%);
    }

    @@keyframes badgePulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }

    .product-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      /* background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%); */
      display: flex;
      align-items: flex-end;
      justify-content: center;
      padding: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .product-card-inner:hover .product-overlay {
      opacity: 1;
    }

    .quick-view-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      background: white;
      color: #1C30A3;
      border: none;
      padding: 12px 24px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transform: translateY(20px);
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .product-card-inner:hover .quick-view-btn {
      transform: translateY(0);
    }

    .quick-view-btn:hover {
      background: #1C30A3;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(28, 48, 163, 0.4);
    }

    .product-info {
      padding: 28px 24px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .product-category {
      font-size: 12px;
      font-weight: 600;
      color: #1C30A3;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 8px;
    }

    .product-title {
      font-size: 22px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: #1a1a2e;
      margin: 0 0 12px 0;
      line-height: 1.3;
    }

    .product-description {
      font-size: 14px;
      color: #666;
      line-height: 1.6;
      margin-bottom: 16px;
      flex-grow: 1;
    }

    .product-features {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 20px;
    }

    .feature-tag {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: #E8ECFF;
      color: #1C30A3;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 500;
    }

    .feature-tag svg {
      flex-shrink: 0;
    }

    .add-sample-btn {
      width: 100%;
      background: linear-gradient(135deg, #1C30A3 100%, #2541C8 0%);     color: white;
      border: none;
      padding: 16px 24px;
      border-radius: 14px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 8px 20px rgba(28, 48, 163, 0.3);
    }

    .add-sample-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 28px rgba(28, 48, 163, 0.4);
    }

    .add-sample-btn:active {
      transform: translateY(0);
    }

    .btn-icon {
      font-size: 20px;
      font-weight: 700;
      transition: transform 0.3s ease;
    }

    .add-sample-btn:hover .btn-icon {
      transform: rotate(90deg);
    }

    .btn-shimmer {
      position: absolute;
      top: 0;
      left: -100%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.6s ease;
    }

    .add-sample-btn:hover .btn-shimmer {
      left: 150%;
    }

    /* ============================================
       TRUST SECTION
    ============================================ */
    .trust-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      margin-top: 80px;
      padding: 60px 40px;
      background: white;
      border-radius: 30px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    .trust-item {
      text-align: center;
      padding: 20px;
      transition: transform 0.3s ease;
    }

    .trust-item:hover {
      transform: translateY(-8px);
    }

    .trust-icon {
      font-size: 48px;
      margin-bottom: 16px;
      filter: grayscale(0);
      transition: all 0.3s ease;
    }

    .trust-item:hover .trust-icon {
      transform: scale(1.2);
      filter: drop-shadow(0 4px 12px rgba(28, 48, 163, 0.3));
    }

    .trust-item h4 {
      font-size: 18px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: #1a1a2e;
      margin: 0 0 8px 0;
    }

    .trust-item p {
      font-size: 14px;
      color: #666;
      margin: 0;
    }

    /* ============================================
       MODAL ENHANCEMENTS
    ============================================ */
    .sample-form-container {
      max-height: 70vh;
      overflow-y: auto;
      padding-right: 10px;
    }

    .sample-form-container::-webkit-scrollbar {
      width: 6px;
    }

    .sample-form-container::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .sample-form-container::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #1C30A3 100%, #2541C8 0%);     border-radius: 10px;
    }

    .sample-form-section {
      margin-bottom: 25px;
      padding: 20px;
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      border-radius: 12px;
      border-left: 4px solid #1C30A3;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .sample-form-section h4 {
      color: #1a1a2e;
      margin-bottom: 15px;
      font-size: 16px;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #555;
    }

    .form-control {
      width: 100%;
      padding: 10px 14px;
      border: 2px solid #e1e8ed;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: #1C30A3;
      box-shadow: 0 0 0 3px rgba(28, 48, 163, 0.1);
    }

    /* ============================================
       SIMPLE SAMPLE FORM MODAL
    ============================================ */
    .premium-sample-swal-container {
      padding: 10px !important;
    }
    .premium-sample-swal-container .swal2-popup {
      margin: 0 auto !important;
      max-width: 94vw !important;
    }
    .premium-sample-modal-popup {
      border-radius: 20px !important;
      padding: 0 !important;
      overflow: hidden !important;
      max-width: 94vw !important;
      width: 760px !important;
      border: 1px solid rgba(255, 255, 255, 0.6) !important;
      box-shadow: 0 30px 80px rgba(15, 23, 42, 0.25) !important;
    }
    .premium-sample-modal-popup .swal2-html-container {
      padding: 0 !important;
      margin: 0 !important;
      overflow-x: hidden !important;
    }
    .simple-sample-form {
      background: #ffffff;
      border-radius: 0;
      padding: 0;
      box-shadow: none;
      overflow: hidden;
      width: 100%;
      animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }
    .size-chart {
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
      width: 100% !important;
      border-radius: 12px;
      margin-top: 8px;
    }

    @@keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .form-header {
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%);
      padding: 30px 25px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .form-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
      animation: headerShine 3s ease-in-out infinite;
    }

    @@keyframes headerShine {
      0%, 100% { opacity: 0; }
      50% { opacity: 1; }
    }

    .form-title {
      font-size: 24px;
      font-weight: 700;
      font-family: 'Merriweather', serif;
      margin: 0 0 8px 0;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 2;
    }

    .form-subtitle {
      font-size: 16px;
      margin: 0;
      opacity: 0.9;
      position: relative;
      z-index: 2;
    }

    .form-subtitle strong {
      color: #ffffff;
      font-weight: 600;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .garment-form {
      padding: 30px 25px;
    }

    .garment-form .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .garment-form .form-group label {
      font-size: 15px;
      font-weight: 600;
      color: #1a1a2e;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .garment-form .form-group label::before {
      content: '•';
      color: #1C30A3;
      font-size: 20px;
      font-weight: bold;
    }

    /* GSM Select Styling */
    #gsm-select {
      appearance: none;
      background: white;
      border: 2px solid #e1e8ed;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 15px;
      font-weight: 500;
      color: #333;
      cursor: pointer;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 12px center;
      background-repeat: no-repeat;
      background-size: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    #gsm-select:hover {
      border-color: #1C30A3;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(28, 48, 163, 0.15);
    }

    #gsm-select:focus {
      outline: none;
      border-color: #1C30A3;
      box-shadow: 0 0 0 4px rgba(28, 48, 163, 0.1), 0 4px 12px rgba(28, 48, 163, 0.15);
      transform: translateY(-1px);
    }

    #gsm-select option {
      padding: 12px;
      background: white;
      color: #333;
    }

    /* Color Swatch Selection */
    .color-swatch-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      padding: 10px;
      background: rgba(248, 249, 252, 0.5);
      border-radius: 12px;
      border: 2px solid #e1e8ed;
    }

    .color-swatch-item {
      position: relative;
    }

    .color-swatch-item input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    .color-swatch {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 3px solid #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      background-clip: padding-box;
    }

    .color-swatch:hover {
      transform: scale(1.2);
      box-shadow: 0 6px 15px rgba(0,0,0,0.25);
      z-index: 10;
    }

    .color-swatch-item input:checked + .color-swatch {
      border-color: #1C30A3;
      transform: scale(1.1);
      box-shadow: 0 0 0 3px rgba(28, 48, 163, 0.2), 0 4px 12px rgba(0,0,0,0.2);
    }

    .color-swatch-item input:checked + .color-swatch::after {
      content: '✓';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 20px;
      font-weight: bold;
      text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    /* Premium Tooltip */
    .color-swatch-item::before {
      content: attr(data-tooltip);
      position: absolute;
      bottom: 130%;
      left: 50%;
      transform: translateX(-50%) translateY(10px);
      background: #1a1a2e;
      color: white;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 13px;
      font-family: 'Courier New', monospace;
      white-space: nowrap;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 100;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      pointer-events: none;
    }

    .color-swatch-item::after {
      content: '';
      position: absolute;
      bottom: 110%;
      left: 50%;
      transform: translateX(-50%) translateY(10px);
      border-width: 6px;
      border-style: solid;
      border-color: #1a1a2e transparent transparent transparent;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 100;
      pointer-events: none;
    }

    .color-swatch-item:hover::before,
    .color-swatch-item:hover::after {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
    }

    /* Size Options */
    .size-options {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
      gap: 12px;
    }

    .size-options label {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 12px 16px;
      background: white;
      border: 2px solid #e1e8ed;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 600;
      color: #555;
      text-align: center;
      justify-content: center;
      user-select: none;
      position: relative;
      overflow: hidden;
    }

    .size-options label::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(28, 48, 163, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .size-options label:hover {
      border-color: #1C30A3;
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(28, 48, 163, 0.15);
    }

    .size-options label:hover::before {
      left: 100%;
    }

    .size-options input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: #1C30A3;
      cursor: pointer;
      margin: 0;
    }

    .size-options input[type="checkbox"]:checked + * {
      color: #1C30A3;
      font-weight: 700;
    }

    .size-options input[type="checkbox"]:checked {
      filter: drop-shadow(0 0 4px rgba(28, 48, 163, 0.4));
    }

    /* Form Animations */
    .garment-form .form-group {
      animation: formGroupSlideIn 0.5s ease-out backwards;
    }

    .garment-form .form-group:nth-child(1) { animation-delay: 0.1s; }
    .garment-form .form-group:nth-child(2) { animation-delay: 0.2s; }
    .garment-form .form-group:nth-child(3) { animation-delay: 0.3s; }

    @@keyframes formGroupSlideIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Responsive Design for Modal */
    @@media (max-width: 576px) {
      .simple-sample-form {
        margin: 10px;
        border-radius: 16px;
      }

      .form-header {
        padding: 25px 20px;
      }

      .form-title {
        font-size: 20px;
      }

      .form-subtitle {
        font-size: 14px;
      }

      .garment-form {
        padding: 25px 20px;
      }

      .size-options {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
      }

      .size-options label {
        padding: 10px 12px;
        font-size: 14px;
      }

      .color-picker-row {
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }

      #color-select {
        align-self: center;
      }
    }

    .size-quantity-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
      padding: 10px;
      background: white;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .size-quantity-row:hover {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .size-checkbox {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .quantity-input {
      width: 80px;
      padding: 8px 10px;
      border: 2px solid #e1e8ed;
      border-radius: 6px;
      text-align: center;
      transition: all 0.2s ease;
    }

    .quantity-input:focus {
      outline: none;
      border-color: #1C30A3;
    }

    .quantity-input:disabled {
      background: #f5f5f5;
      color: #999;
    }

    .size-chart {
      margin-top: 20px;
      overflow-x: auto;
    }

    .size-chart table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .size-chart th,
    .size-chart td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    .size-chart th {
      background: linear-gradient(135deg, #1C30A3 100%, #2541C8 0%);     color: white;
      font-weight: 600;
    }

    .size-chart tbody tr:hover {
      background: #f8f9fa;
    }

    .terms-checkbox {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      margin: 20px 0;
      padding: 15px;
      background: #E8ECFF;
      border-radius: 8px;
    }

    .terms-checkbox input[type="checkbox"] {
      margin-top: 2px;
    }

    .terms-checkbox label {
      font-size: 14px;
      line-height: 1.4;
      color: #555;
    }

    /* ============================================
       RESPONSIVE DESIGN
    ============================================ */
    @@media (max-width: 1200px) {
      .premium-hero-title {
        font-size: 60px;
      }

      .section-title {
        font-size: 42px;
      }

      .hero-stats {
        gap: 40px;
      }
    }

    @@media (max-width: 992px) {
      .premium-hero-title {
        font-size: 52px;
      }

      .premium-hero-subtitle {
        font-size: 18px;
      }

      .stat-number {
        font-size: 36px;
      }

      .section-title {
        font-size: 36px;
      }

      .premium-products-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .trust-section {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @@media (max-width: 768px) {
      .premium-hero-section {
        padding: 80px 0 120px;
        min-height: 500px;
      }

      .premium-hero-title {
        font-size: 42px;
        letter-spacing: -1px;
      }

      .premium-hero-subtitle {
        font-size: 16px;
        margin-bottom: 35px;
      }

      .hero-stats {
        gap: 30px;
        flex-wrap: wrap;
      }

      .stat-number {
        font-size: 32px;
      }

      .stat-label {
        font-size: 12px;
      }

      .section-title {
        font-size: 32px;
      }

      .section-description {
        font-size: 16px;
      }

      .premium-sample-section {
        padding: 60px 0;
      }

      .section-header {
        margin-bottom: 50px;
      }

      .premium-products-grid {
        grid-template-columns: 1fr;
        gap: 25px;
      }

      .product-image-wrapper {
        height: 280px;
      }

      .product-info {
        padding: 24px 20px;
      }

      .product-title {
        font-size: 20px;
      }

      .trust-section {
        padding: 40px 30px;
        margin-top: 60px;
      }

      .size-quantity-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
      }

      .quantity-input {
        width: 100%;
      }

      .size-chart table {
        font-size: 12px;
      }

      .size-chart th,
      .size-chart td {
        padding: 8px 6px;
      }
    }

    @@media (max-width: 576px) {
      .premium-hero-title {
        font-size: 36px;
      }

      .hero-badge {
        padding: 8px 18px;
        font-size: 13px;
      }

      .hero-stats {
        gap: 20px;
      }

      .stat-number {
        font-size: 28px;
      }

      .section-title {
        font-size: 28px;
      }

      .section-label {
        font-size: 12px;
      }

      .product-image-wrapper {
        height: 250px;
      }

      .product-badge {
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        font-size: 11px;
      }

      .trust-section {
        grid-template-columns: 1fr;
        padding: 30px 20px;
      }

      .trust-icon {
        font-size: 40px;
      }

      .sample-form-container {
        max-height: 60vh;
      }

      .sample-form-section {
        padding: 15px;
      }
    }

    /* Safari-specific fixes */
    @@supports (-webkit-backdrop-filter: blur(1px)) {
      .hero-badge {
        -webkit-backdrop-filter: blur(10px);
      }
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Print styles */
    @@media print {
      .premium-hero-section,
      .trust-section {
        page-break-inside: avoid;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Size charts data from server
      const sizeCharts = @json($sizeCharts);
      const appSetting = @json($appSetting);

      // Particle effect for hero section
      createParticles();

      // Add click event listeners to all "Add to Sample Order" buttons
      const addToSampleButtons = document.querySelectorAll('.add-sample-btn');

      addToSampleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();

          // Get product info from the data attribute
          const productData = JSON.parse(this.dataset.product);

          showSampleOrderModal(productData);
        });
      });

      function showSampleOrderModal(productData) {
        // Generate size checkboxes dynamically
        const sizeOptionsHtml = productData.sizes.map(size => 
          `<label><input type="checkbox" name="sizes[]" value="${size}"> ${size}</label>`
        ).join('');

        const formHtml = `
          <div class="simple-sample-form" style="width: 100% !important;">
            <div class="form-header">
              <h2 class="form-title" style="color: #ffffff;">{{ gt('Sample Order Request') }}</h2>
              <p class="form-subtitle">{{ gt('for') }} <strong>${productData.name}</strong></p>
            </div>

            <form class="garment-form" id="sample-order-form">
              <div class="sample-price-card">
                <span style="font-weight: 600; color: #64748b; font-size: 13px;">{{ gt('Product Price') }}</span>
                <span style="font-size: 22px; font-weight: 800; color: #1C30A3;" id="sample_price_display">
                  ${window.__currency?.symbol || '$'}${(parseFloat(productData.price || 0) * (window.__currency?.rate || 1)).toFixed(2)}
                </span>
              </div>

              <div class="form-group">
                <label>{{ gt('Select Garment Quality (GSM)') }}</label>
                <select name="gsm" id="gsm-select" required>
                  <option value="">{{ gt('Select GSM') }}</option>
                  ${(productData.gsm || []).map(g => `<option value="${g}">${g} GSM</option>`).join('')}
                </select>
              </div>

              <div class="form-group">
                <label>{{ gt('Select Colour Preference') }}</label>
                <div class="color-swatch-grid">
                  ${(productData.colors || []).map(c => `
                    <div class="color-swatch-item" data-tooltip="${c}">
                      <input type="checkbox" name="colors[]" value="${c}" id="color-${c}">
                      <label for="color-${c}" class="color-swatch" style="background-color: ${c}"></label>
                    </div>
                  `).join('')}
                </div>
              </div>

              <div class="form-group">
                <label>{{ gt('Select Garment Size') }}</label>
                <div class="size-options">
                  ${sizeOptionsHtml}
                </div>
              </div>

              <div class="form-group">
                <label>{{ gt('Size Chart Reference') }}</label>
                <div class="size-chart">
                  <table>
                    <thead>
                      <tr>
                        <th>{{ gt('SERIAL.NO') }}</th>
                        <th>{{ gt('USA/UK') }}</th>
                        <th>{{ gt('EU') }}</th>
                        <th>{{ gt('JAPAN') }}</th>
                        <th>{{ gt('KOREA') }}</th>
                        <th>{{ gt('CHEST CM') }}</th>
                        <th>{{ gt('CHEST INCHES') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${sizeCharts.map(item => `
                        <tr>
                          <td>${item.serial_no}</td>
                          <td>${item.usa_uk}</td>
                          <td>${item.eu}</td>
                          <td>${item.japan}</td>
                          <td>${item.korea}</td>
                          <td>${item.chest_cm}</td>
                          <td>${item.chest_inches}</td>
                        </tr>
                      `).join('')}
                    </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
        `;

        Swal.fire({
          title: false,
          html: formHtml,
          width: '760px',
          customClass: {
            container: 'premium-sample-swal-container',
            popup: 'premium-sample-modal-popup'
          },
          showCloseButton: true,
          showCancelButton: true,
          confirmButtonText: "{{ gt('Add to Order') }}",
          confirmButtonColor: '#1C30A3',
          cancelButtonText: "{{ gt('Cancel') }}",
          didOpen: () => {
            // Optional: Add logic if specific color display is needed
          },
          preConfirm: () => {
            const form = document.getElementById('sample-order-form');
            const gsm = document.getElementById('gsm-select').value;
            const colorCheckboxes = form.querySelectorAll('input[name="colors[]"]:checked');
            const colors = Array.from(colorCheckboxes).map(cb => cb.value);
            const checkboxes = form.querySelectorAll('input[name="sizes[]"]:checked');
            const sizes = Array.from(checkboxes).map(cb => cb.value);

            if (!gsm) {
              Swal.showValidationMessage("{{ gt('Please select GSM') }}");
              return false;
            }
            if (colors.length === 0) {
              Swal.showValidationMessage("{{ gt('Please select at least one color') }}");
              return false;
            }
            if (sizes.length === 0) {
              Swal.showValidationMessage("{{ gt('Please select at least one size') }}");
              return false;
            }
            
            const totalQuantity = sizes.length * colors.length;

            // App Setting Validation
            if (typeof appSetting !== 'undefined' && appSetting) {
              if (totalQuantity < appSetting.min_quantity) {
                Swal.showValidationMessage("{{ gt('Minimum') }} " + appSetting.min_quantity + " {{ gt('samples required') }} ({{ gt('Current Selection') }}: " + totalQuantity + ")");
                return false;
              }
              if (appSetting.max_quantity && totalQuantity > appSetting.max_quantity) {
                Swal.showValidationMessage("{{ gt('Maximum') }} " + appSetting.max_quantity + " {{ gt('samples allowed') }} ({{ gt('Current Selection') }}: " + totalQuantity + ")");
                return false;
              }
            }

            return { id: productData.id, type: 'sample', gsm, colors, sizes };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const data = result.value;
            data._token = "{{ csrf_token() }}";
            data.size = data.sizes.join(', ');
            data.color = data.colors.join(', ');
            data.quantity = data.sizes.length * data.colors.length;

            $.ajax({
              url: "{{ route('cart.add') }}",
              method: 'POST',
              data: data,
              success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: "{{ gt('Added!') }}",
                  text: res.message,
                  showCancelButton: true,
                  confirmButtonText: "{{ gt('View Cart') }}",
                  confirmButtonColor: '#1C30A3',
                  cancelButtonText: "{{ gt('Continue Shopping') }}"
                }).then((nav) => {
                  if (nav.isConfirmed) {
                    window.location.href = "{{ route('cart.index') }}";
                  }
                });
              },
              error: function(xhr) {
                if (xhr.status === 401) {
                  Swal.fire({
                    icon: 'info',
                    title: "{{ gt('Login Required') }}",
                    text: "{{ gt('Please login to add samples.') }}",
                    confirmButtonText: "{{ gt('Go to Login') }}",
                    confirmButtonColor: '#1C30A3',
                    showCancelButton: true,
                    cancelButtonText: "{{ gt('Cancel') }}"
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = "{{ route('login') }}";
                    }
                  });
                } else {
                  Swal.fire("{{ gt('Error') }}", xhr.responseJSON.message || "{{ gt('Failed to add item') }}", 'error');
                }
              }
            });
          }
        });
      }

      function createParticles() {
        const particlesContainer = document.getElementById('heroParticles');
        if (!particlesContainer) return;
        const particleCount = 50;
        for (let i = 0; i < particleCount; i++) {
          const particle = document.createElement('div');
          particle.style.cssText = `position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*0.5+0.2});border-radius:50%;top:${Math.random()*100}%;left:${Math.random()*100}%;animation:float ${Math.random()*10+10}s linear infinite;animation-delay:${Math.random()*5}s;`;
          particlesContainer.appendChild(particle);
        }
        const style = document.createElement('style');
        style.textContent = `@keyframes float{0%,100%{transform:translateY(0) translateX(0);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100vh) translateX(${Math.random()*100-50}px);opacity:0}}`;
        document.head.appendChild(style);
      }
    });
  </script>
@endsection
