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
    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>
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
                  <div class="product-overlay"></div>
                </div>
                <div class="product-info">
                  <div class="product-header-meta">
                    <span class="product-category">{{ $sample->category }}</span>
                    <span class="product-price-badge">
                      <span class="currency-symbol">₹</span><span class="price-val" data-raw-price="{{ $sample->price }}">{{ number_format($sample->price, 2) }}</span>
                    </span>
                  </div>
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
                    'image' => env('MAIN_URL') . 'images/' . ltrim($sample->image, '/'),
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
      min-height: 620px;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #090E28 0%, #121D63 35%, #1C30A3 70%, #2A48DF 100%);
      position: relative;
      padding: 100px 0 150px;
      overflow: hidden;
    }

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
      background: radial-gradient(circle at 20% 40%, rgba(99, 102, 241, 0.4) 0%, transparent 60%),
                  radial-gradient(circle at 80% 70%, rgba(236, 72, 153, 0.28) 0%, transparent 60%),
                  radial-gradient(circle at 50% 90%, rgba(59, 130, 246, 0.35) 0%, transparent 50%);
      z-index: 1;
      animation: meshGlow 10s ease-in-out infinite alternate;
    }

    @@keyframes meshGlow {
      0% { transform: scale(1) rotate(0deg); opacity: 0.85; }
      50% { transform: scale(1.12) rotate(2deg); opacity: 1; }
      100% { transform: scale(1) rotate(0deg); opacity: 0.85; }
    }

    .ambient-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 1;
    }
    .orb-1 {
      top: 10%;
      left: 5%;
      width: 380px;
      height: 380px;
      background: radial-gradient(circle, rgba(99, 102, 241, 0.45) 0%, transparent 70%);
      animation: orbFloat1 14s ease-in-out infinite alternate;
    }
    .orb-2 {
      bottom: 15%;
      right: 5%;
      width: 440px;
      height: 440px;
      background: radial-gradient(circle, rgba(236, 72, 153, 0.3) 0%, transparent 70%);
      animation: orbFloat2 18s ease-in-out infinite alternate;
    }

    @@keyframes orbFloat1 {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(60px, 40px) scale(1.2); }
    }
    @@keyframes orbFloat2 {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(-50px, -60px) scale(1.15); }
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
      gap: 36px;
      margin-top: 50px;
      padding: 22px 32px;
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      border-radius: 24px;
      max-width: 880px;
      margin-left: auto;
      margin-right: auto;
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
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      flex: 1;
    }

    .stat-icon-badge {
      font-size: 26px;
      margin-bottom: 4px;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2));
    }

    .stat-number {
      font-size: 32px;
      font-weight: 900;
      color: white;
      line-height: 1.1;
      margin-bottom: 4px;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-label {
      font-size: 11px;
      color: rgba(255, 255, 255, 0.9);
      text-transform: uppercase;
      letter-spacing: 0.8px;
      font-weight: 700;
    }

    .product-header-meta {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .product-price-badge {
      display: inline-flex;
      align-items: center;
      gap: 2px;
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
      color: #ffffff;
      font-size: 13px;
      font-weight: 800;
      padding: 3px 12px;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(28, 48, 163, 0.25);
    }

    /* Trust & Assurance Section */
    .trust-features-section {
      padding: 70px 0;
      background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }

    .trust-section-header {
      margin-bottom: 44px;
    }

    .trust-label {
      display: inline-block;
      font-size: 12px;
      font-weight: 800;
      color: #1C30A3;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-bottom: 8px;
    }

    .trust-title {
      font-size: 32px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: #0f172a;
      margin: 0;
    }

    .trust-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 24px;
    }

    .trust-card {
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 20px;
      padding: 28px 22px;
      text-align: center;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
    }

    .trust-card:hover {
      transform: translateY(-6px);
      border-color: #1C30A3;
      box-shadow: 0 16px 40px rgba(28, 48, 163, 0.12);
    }

    .trust-card-icon {
      font-size: 36px;
      margin-bottom: 12px;
      display: inline-block;
      transition: transform 0.3s ease;
    }

    .trust-card:hover .trust-card-icon {
      transform: scale(1.18);
    }

    .trust-card h4 {
      font-size: 17px;
      font-weight: 800;
      font-family: 'Merriweather', serif;
      color: #0f172a;
      margin: 0 0 8px 0;
    }

    .trust-card p {
      font-size: 13px;
      color: #64748b;
      line-height: 1.6;
      margin: 0;
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
      transform: translateY(-10px) scale(1.015);
      border-color: rgba(99, 102, 241, 0.6);
      box-shadow: 0 20px 50px rgba(28, 48, 163, 0.22), 0 0 25px rgba(99, 102, 241, 0.15);
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
      transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .product-card-inner:hover .product-image {
      transform: scale(1.08) translateY(-4px);
    }

    .product-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 15;
      background: linear-gradient(135deg, #1C30A3 100%, #2541C8 0%);
      color: white;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(28, 48, 163, 0.4);
      animation: badgePulse 2s ease-in-out infinite;
      pointer-events: none;
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
       AGENCY-GRADE COMPACT SAMPLE ORDER FORM MODAL
    ============================================ */
    .premium-sample-swal-container {
      padding: 10px !important;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }
    .premium-sample-swal-container .swal2-popup {
      margin: 0 auto !important;
      max-width: 95vw !important;
    }
    .premium-sample-modal-popup {
      border-radius: 20px !important;
      padding: 0 !important;
      overflow: hidden !important;
      max-width: 95vw !important;
      width: 600px !important;
      border: 1px solid rgba(255, 255, 255, 0.8) !important;
      box-shadow: 0 25px 75px rgba(15, 23, 42, 0.35), 0 0 0 1px rgba(28, 48, 163, 0.08) !important;
      background: #ffffff !important;
    }
    .premium-sample-modal-popup .swal2-html-container {
      padding: 0 !important;
      margin: 0 !important;
      overflow-x: hidden !important;
    }
    .premium-sample-modal-popup .swal2-actions {
      margin: 0 !important;
      padding: 12px 22px 16px 22px !important;
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      gap: 10px;
      justify-content: flex-end;
    }
    .premium-sample-modal-popup .swal2-confirm {
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%) !important;
      box-shadow: 0 6px 16px rgba(28, 48, 163, 0.35) !important;
      border-radius: 10px !important;
      padding: 10px 22px !important;
      font-weight: 700 !important;
      font-size: 14px !important;
      transition: all 0.25s ease !important;
    }
    .premium-sample-modal-popup .swal2-confirm:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 10px 24px rgba(28, 48, 163, 0.45) !important;
    }
    .premium-sample-modal-popup .swal2-cancel {
      background: #ffffff !important;
      color: #64748b !important;
      border: 1.5px solid #cbd5e1 !important;
      border-radius: 10px !important;
      padding: 10px 18px !important;
      font-weight: 600 !important;
      font-size: 14px !important;
    }
    .premium-sample-modal-popup .swal2-cancel:hover {
      background: #f1f5f9 !important;
      color: #334155 !important;
    }
    .premium-sample-modal-popup .swal2-close {
      position: absolute !important;
      top: 14px !important;
      right: 14px !important;
      width: 32px !important;
      height: 32px !important;
      border-radius: 50% !important;
      background: rgba(255, 255, 255, 0.2) !important;
      color: #ffffff !important;
      backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.3) !important;
      transition: all 0.25s ease !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 18px !important;
      z-index: 10 !important;
    }
    .premium-sample-modal-popup .swal2-close:hover {
      background: rgba(255, 255, 255, 0.35) !important;
      transform: rotate(90deg) scale(1.1) !important;
    }

    .simple-sample-form {
      background: #ffffff;
      padding: 0;
      width: 100%;
      text-align: left;
      animation: modalSlideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }

    @@keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: scale(0.95) translateY(-15px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .form-header {
      background: linear-gradient(135deg, #0F172A 0%, #1C30A3 60%, #2541C8 100%);
      padding: 20px 22px 16px 22px;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .form-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      right: -10%;
      width: 200px;
      height: 200px;
      background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .form-header-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(8px);
      padding: 3px 10px;
      border-radius: 30px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.7px;
      text-transform: uppercase;
      margin-bottom: 8px;
      color: #e2e8f0;
    }

    .form-header-product {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .header-product-img-wrap {
      width: 48px;
      height: 48px;
      border-radius: 10px;
      background: #ffffff;
      padding: 3px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.25);
      flex-shrink: 0;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .header-product-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
    }

    .header-product-info {
      flex: 1;
      text-align: left;
    }

    .form-title {
      font-size: 18px;
      font-weight: 800;
      font-family: 'Merriweather', serif;
      margin: 0 0 2px 0;
      color: #ffffff;
      line-height: 1.2;
    }

    .form-subtitle {
      font-size: 12px;
      margin: 0;
      color: rgba(255, 255, 255, 0.8);
      font-weight: 400;
    }

    /* Live Summary Banner */
    .sample-summary-banner {
      display: flex;
      align-items: center;
      justify-content: space-around;
      background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
      padding: 10px 18px;
      border-bottom: 1px solid #e2e8f0;
    }

    .summary-stat-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .summary-stat-box.highlight {
      background: #ffffff;
      padding: 4px 14px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(28, 48, 163, 0.08);
      border: 1px solid rgba(28, 48, 163, 0.15);
    }

    .summary-stat-box .stat-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: #64748b;
      margin-bottom: 1px;
    }

    .summary-stat-box .stat-value {
      font-size: 14px;
      font-weight: 700;
      color: #1e293b;
    }

    .summary-stat-box .price-text {
      color: #1C30A3;
      font-weight: 800;
      font-size: 15px;
    }

    .summary-stat-box .total-price-text {
      color: #1C30A3;
      font-weight: 900;
      font-size: 17px;
    }

    .badge-count {
      display: inline-block;
      padding: 1px 6px;
      background: #e0e7ff;
      color: #1C30A3;
      border-radius: 8px;
      font-weight: 800;
    }

    .summary-divider {
      width: 1px;
      height: 28px;
      background: #cbd5e1;
    }

    .garment-form {
      padding: 16px 22px 8px 22px;
      max-height: 52vh;
      overflow-y: auto;
      text-align: left;
    }

    .garment-form::-webkit-scrollbar {
      width: 5px;
    }
    .garment-form::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    .garment-form::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }

    .garment-form .form-group {
      margin-bottom: 14px;
      position: relative;
    }

    .section-label-heading {
      font-size: 13px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .step-num {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #1C30A3;
      color: white;
      font-size: 10px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .required-asterisk {
      color: #ef4444;
      font-weight: bold;
    }

    .label-badge {
      margin-left: auto;
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
      background: #f1f5f9;
      padding: 2px 8px;
      border-radius: 16px;
    }

    /* GSM Options Grid */
    .gsm-options-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .gsm-pill-item {
      position: relative;
    }

    .gsm-pill-item input[type="radio"] {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .gsm-pill-card {
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 6px 14px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-weight: 700;
      color: #334155;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
      margin: 0;
    }

    .gsm-pill-card:hover {
      border-color: #1C30A3;
      background: #f8fafc;
      transform: translateY(-1px);
    }

    .gsm-pill-item input[type="radio"]:checked + .gsm-pill-card {
      background: #1C30A3;
      border-color: #1C30A3;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(28, 48, 163, 0.25);
    }

    .gsm-value {
      font-size: 14px;
      font-weight: 800;
    }

    .gsm-unit {
      font-size: 10px;
      opacity: 0.85;
      text-transform: uppercase;
    }

    /* GSM Select Styling fallback */
    #gsm-select {
      width: 100%;
      appearance: none;
      background: white;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      font-weight: 600;
      color: #333;
      cursor: pointer;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 12px center;
      background-repeat: no-repeat;
      background-size: 14px;
      transition: all 0.2s ease;
    }

    #gsm-select:focus {
      outline: none;
      border-color: #1C30A3;
      box-shadow: 0 0 0 3px rgba(28, 48, 163, 0.15);
    }

    /* Color Swatch Grid */
    .color-swatch-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 10px 14px;
      background: #f8fafc;
      border-radius: 12px;
      border: 1.5px solid #e2e8f0;
    }

    .color-swatch-item {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
    }

    .color-swatch-item input[type="checkbox"] {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .color-swatch {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 2.5px solid #ffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.12);
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .color-swatch-item.is-light-color .color-swatch {
      border: 2.5px solid #cbd5e1;
    }

    .color-swatch:hover {
      transform: scale(1.15);
      box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    }

    .color-swatch-item input[type="checkbox"]:checked + .color-swatch {
      transform: scale(1.08);
      box-shadow: 0 0 0 3px rgba(28, 48, 163, 0.35), 0 6px 16px rgba(0,0,0,0.18);
    }

    .color-name-label {
      font-size: 10px;
      font-weight: 600;
      color: #64748b;
      text-transform: capitalize;
    }

    /* Size Options Grid */
    .size-options-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(62px, 1fr));
      gap: 8px;
    }

    .size-pill-item {
      position: relative;
    }

    .size-pill-item input[type="checkbox"] {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .size-pill-card {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
      padding: 8px 10px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 13px;
      font-weight: 700;
      color: #334155;
      text-align: center;
      user-select: none;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
      margin: 0;
    }

    .size-pill-card:hover {
      border-color: #1C30A3;
      background: #f8fafc;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(28, 48, 163, 0.1);
    }

    .size-pill-item input[type="checkbox"]:checked + .size-pill-card {
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
      border-color: #1C30A3;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(28, 48, 163, 0.3);
    }

    .size-check-icon {
      display: none;
    }

    .size-pill-item input[type="checkbox"]:checked + .size-pill-card .size-check-icon {
      display: inline-flex;
    }

    /* Size Chart Accordion */
    .size-chart-accordion-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 14px;
      background: #f8fafc;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
      margin-top: 4px;
    }

    .size-chart-accordion-header:hover {
      background: #f1f5f9;
      border-color: #cbd5e1;
    }

    .accordion-title {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 700;
      color: #1e293b;
    }

    .accordion-badge {
      font-size: 11px;
      color: #1C30A3;
      font-weight: 600;
    }

    .size-chart-wrapper {
      margin-top: 8px;
      overflow-x: auto;
      border-radius: 10px;
      border: 1.5px solid #e2e8f0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
      max-height: 160px;
      overflow-y: auto;
    }

    .premium-size-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      font-size: 12px;
    }

    .premium-size-table th {
      position: sticky;
      top: 0;
      background: #f1f5f9;
      color: #1e293b;
      font-weight: 700;
      padding: 8px 8px;
      text-transform: uppercase;
      font-size: 10px;
      letter-spacing: 0.5px;
      border-bottom: 1.5px solid #e2e8f0;
      text-align: center;
      z-index: 2;
    }

    .premium-size-table td {
      padding: 7px 8px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
      color: #475569;
    }

    .premium-size-table tbody tr:hover {
      background: #f8fafc;
    }

    .serial-badge {
      display: inline-block;
      padding: 1px 6px;
      background: #e2e8f0;
      border-radius: 4px;
      font-weight: 700;
      font-size: 10px;
      color: #334155;
    }

    /* Form Animations */
    .garment-form .form-group {
      animation: formGroupSlideIn 0.35s ease-out backwards;
    }

    .garment-form .form-group:nth-child(1) { animation-delay: 0.04s; }
    .garment-form .form-group:nth-child(2) { animation-delay: 0.08s; }
    .garment-form .form-group:nth-child(3) { animation-delay: 0.12s; }
    .garment-form .form-group:nth-child(4) { animation-delay: 0.16s; }

    @@keyframes formGroupSlideIn {
      from {
        opacity: 0;
        transform: translateY(8px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive Design for Modal */
    @@media (max-width: 576px) {
      .garment-form {
        padding: 14px 16px 8px 16px;
      }
      .form-header {
        padding: 16px 16px 12px 16px;
      }
      .form-title {
        font-size: 16px;
      }
      .sample-summary-banner {
        padding: 8px 12px;
      }
      .summary-stat-box .stat-label {
        font-size: 9px;
      }
      .summary-stat-box .price-text, .summary-stat-box .total-price-text {
        font-size: 14px;
      }
      .size-options-grid {
        grid-template-columns: repeat(3, 1fr);
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
        top: 12px;
        right: 12px;
        z-index: 15;
        padding: 5px 12px;
        font-size: 10px;
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

      // Format currency symbols and prices on product cards
      const curSymbol = window.__currency?.symbol || '₹';
      const curRate = window.__currency?.rate || 1;
      document.querySelectorAll('.currency-symbol').forEach(el => el.textContent = curSymbol);
      document.querySelectorAll('.price-val').forEach(el => {
        const raw = parseFloat(el.dataset.rawPrice || 0);
        el.textContent = (raw * curRate).toFixed(2);
      });

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
        const currencySymbol = window.__currency?.symbol || '₹';
        const currencyRate = window.__currency?.rate || 1;
        const unitPrice = parseFloat(productData.price || 0) * currencyRate;

        // Size pills
        const sizeOptionsHtml = (productData.sizes || []).map(size => `
          <div class="size-pill-item">
            <input type="checkbox" name="sizes[]" value="${size}" id="size-${size}" class="size-checkbox-input">
            <label for="size-${size}" class="size-pill-card">
              <span class="size-text">${size}</span>
              <span class="size-check-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </span>
            </label>
          </div>
        `).join('');

        // GSM options - Radio pills if GSM array available, fallback to custom select
        const gsmList = productData.gsm && productData.gsm.length > 0 ? productData.gsm : [];
        let gsmOptionsHtml = '';
        if (gsmList.length > 0) {
          gsmOptionsHtml = `
            <div class="gsm-options-grid">
              ${gsmList.map((g, idx) => `
                <div class="gsm-pill-item">
                  <input type="radio" name="gsm" id="gsm-${g}" value="${g}" required ${idx === 0 ? 'checked' : ''}>
                  <label for="gsm-${g}" class="gsm-pill-card">
                    <span class="gsm-value">${g}</span>
                    <span class="gsm-unit">GSM</span>
                  </label>
                </div>
              `).join('')}
            </div>
          `;
        } else {
          gsmOptionsHtml = `
            <select name="gsm" id="gsm-select" required>
              <option value="">{{ gt('Select GSM') }}</option>
              <option value="180">180 GSM (Lightweight)</option>
              <option value="200">200 GSM (Standard)</option>
              <option value="220">220 GSM (Heavyweight)</option>
              <option value="240">240 GSM (Super Premium)</option>
            </select>
          `;
        }

        // Color swatches
        const colorsList = productData.colors && productData.colors.length > 0 ? productData.colors : ['#000000', '#ffffff'];
        const colorSwatchesHtml = colorsList.map(c => {
          const isLight = c.toLowerCase() === '#ffffff' || c.toLowerCase() === 'white' || c.toLowerCase() === '#fff';
          return `
            <div class="color-swatch-item ${isLight ? 'is-light-color' : ''}" data-tooltip="${c}">
              <input type="checkbox" name="colors[]" value="${c}" id="color-${c}">
              <label for="color-${c}" class="color-swatch" style="background-color: ${c}"></label>
            </div>
          `;
        }).join('');

        const formHtml = `
          <div class="simple-sample-form" style="width: 100% !important;">
            <div class="form-header">
              <div class="form-header-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>{{ gt('Sample Order Request') }}</span>
              </div>
              <div class="form-header-product">
                <div class="header-product-img-wrap">
                  <img src="${productData.image}" alt="${productData.name}" class="header-product-img" onerror="this.src='/img/sample.png'">
                </div>
                <div class="header-product-info">
                  <h2 class="form-title">${productData.name}</h2>
                  <p class="form-subtitle">{{ gt('Customize garment specs to request sample') }}</p>
                </div>
              </div>
            </div>

            <div class="sample-summary-banner">
              <div class="summary-stat-box">
                <span class="stat-label">{{ gt('Unit Price') }}</span>
                <span class="stat-value price-text">
                  ${currencySymbol}${unitPrice.toFixed(2)}
                </span>
              </div>
              <div class="summary-divider"></div>
              <div class="summary-stat-box">
                <span class="stat-label">{{ gt('Selections') }}</span>
                <span class="stat-value">
                  <span class="badge-count" id="color_count_badge">0</span> {{ gt('colors') }} × <span class="badge-count" id="size_count_badge">0</span> {{ gt('sizes') }}
                </span>
              </div>
              <div class="summary-divider"></div>
              <div class="summary-stat-box highlight">
                <span class="stat-label">{{ gt('Est. Total') }}</span>
                <span class="stat-value total-price-text" id="total_price_display">
                  ${currencySymbol}0.00
                </span>
              </div>
            </div>

            <form class="garment-form" id="sample-order-form">
              <div class="form-group">
                <div class="section-label-heading">
                  <span class="step-num">1</span>
                  <span>{{ gt('Select Garment Quality (GSM)') }}</span>
                  <span class="required-asterisk">*</span>
                </div>
                ${gsmOptionsHtml}
              </div>

              <div class="form-group">
                <div class="section-label-heading">
                  <span class="step-num">2</span>
                  <span>{{ gt('Select Colour Preference') }}</span>
                  <span class="required-asterisk">*</span>
                  <span class="label-badge" id="colors-selected-badge">0 {{ gt('selected') }}</span>
                </div>
                <div class="color-swatch-grid">
                  ${colorSwatchesHtml}
                </div>
              </div>

              <div class="form-group">
                <div class="section-label-heading">
                  <span class="step-num">3</span>
                  <span>{{ gt('Select Garment Size') }}</span>
                  <span class="required-asterisk">*</span>
                  <span class="label-badge" id="sizes-selected-badge">0 {{ gt('selected') }}</span>
                </div>
                <div class="size-options-grid">
                  ${sizeOptionsHtml}
                </div>
              </div>

              <div class="form-group">
                <div class="size-chart-accordion-header" id="toggle-size-chart-btn">
                  <div class="accordion-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2"/>
                      <path d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                    </svg>
                    <span>{{ gt('Size Chart Reference') }}</span>
                  </div>
                  <span class="accordion-badge" id="accordion-toggle-text">{{ gt('Hide') }} ▲</span>
                </div>
                <div class="size-chart-wrapper" id="size-chart-wrapper-box">
                  <table class="premium-size-table">
                    <thead>
                      <tr>
                        <th>{{ gt('SERIAL.NO') }}</th>
                        <th>{{ gt('USA/UK') }}</th>
                        <th>{{ gt('EU') }}</th>
                        <th>{{ gt('JAPAN') }}</th>
                        <th>{{ gt('KOREA') }}</th>
                        <th>{{ gt('CHEST (CM)') }}</th>
                        <th>{{ gt('CHEST (IN)') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${sizeCharts.map(item => `
                        <tr>
                          <td><span class="serial-badge">${item.serial_no}</span></td>
                          <td>${item.usa_uk}</td>
                          <td>${item.eu}</td>
                          <td>${item.japan}</td>
                          <td>${item.korea}</td>
                          <td><strong>${item.chest_cm}</strong></td>
                          <td><strong>${item.chest_inches}</strong></td>
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
          width: '600px',
          customClass: {
            container: 'premium-sample-swal-container',
            popup: 'premium-sample-modal-popup'
          },
          showCloseButton: true,
          showCancelButton: true,
          confirmButtonText: "{{ gt('Add to Sample Order') }}",
          confirmButtonColor: '#1C30A3',
          cancelButtonText: "{{ gt('Cancel') }}",
          didOpen: () => {
            const form = document.getElementById('sample-order-form');
            if (!form) return;

            const updateCalculations = () => {
              const checkedColors = form.querySelectorAll('input[name="colors[]"]:checked');
              const checkedSizes = form.querySelectorAll('input[name="sizes[]"]:checked');

              const colorCount = checkedColors.length;
              const sizeCount = checkedSizes.length;

              const totalQuantity = colorCount * sizeCount;
              const totalPrice = totalQuantity * unitPrice;

              const colorBadge = document.getElementById('color_count_badge');
              const sizeBadge = document.getElementById('size_count_badge');
              const totalPriceDisplay = document.getElementById('total_price_display');

              const colorsSelectedBadge = document.getElementById('colors-selected-badge');
              const sizesSelectedBadge = document.getElementById('sizes-selected-badge');

              if (colorBadge) colorBadge.textContent = colorCount;
              if (sizeBadge) sizeBadge.textContent = sizeCount;
              if (totalPriceDisplay) totalPriceDisplay.textContent = currencySymbol + totalPrice.toFixed(2);

              if (colorsSelectedBadge) colorsSelectedBadge.textContent = colorCount + " {{ gt('selected') }}";
              if (sizesSelectedBadge) sizesSelectedBadge.textContent = sizeCount + " {{ gt('selected') }}";
            };

            form.addEventListener('change', updateCalculations);
            updateCalculations();

            // Toggle size chart
            const toggleBtn = document.getElementById('toggle-size-chart-btn');
            const wrapperBox = document.getElementById('size-chart-wrapper-box');
            const toggleText = document.getElementById('accordion-toggle-text');

            if (toggleBtn && wrapperBox) {
              toggleBtn.addEventListener('click', () => {
                if (wrapperBox.style.display === 'none') {
                  wrapperBox.style.display = 'block';
                  toggleText.textContent = "{{ gt('Hide') }} ▲";
                } else {
                  wrapperBox.style.display = 'none';
                  toggleText.textContent = "{{ gt('Show') }} ▼";
                }
              });
            }
          },
          preConfirm: () => {
            const form = document.getElementById('sample-order-form');
            let gsm = '';
            
            const gsmRadio = form.querySelector('input[name="gsm"]:checked');
            if (gsmRadio) {
              gsm = gsmRadio.value;
            } else {
              const gsmSelect = document.getElementById('gsm-select');
              if (gsmSelect) gsm = gsmSelect.value;
            }

            const colorCheckboxes = form.querySelectorAll('input[name="colors[]"]:checked');
            const colors = Array.from(colorCheckboxes).map(cb => cb.value);
            const checkboxes = form.querySelectorAll('input[name="sizes[]"]:checked');
            const sizes = Array.from(checkboxes).map(cb => cb.value);

            if (!gsm) {
              Swal.showValidationMessage("{{ gt('Please select Garment Quality (GSM)') }}");
              return false;
            }
            if (colors.length === 0) {
              Swal.showValidationMessage("{{ gt('Please select at least one color preference') }}");
              return false;
            }
            if (sizes.length === 0) {
              Swal.showValidationMessage("{{ gt('Please select at least one size option') }}");
              return false;
            }

            const totalQuantity = sizes.length * colors.length;

            if (typeof appSetting !== 'undefined' && appSetting) {
              if (appSetting.min_quantity && totalQuantity < appSetting.min_quantity) {
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
                const cartCountEl = document.querySelector('.cs_cart_count');
                if (cartCountEl && res.cart_count !== undefined) {
                  cartCountEl.textContent = res.cart_count;
                  cartCountEl.style.display = res.cart_count > 0 ? 'inline-flex' : 'none';
                }

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
                  Swal.fire("{{ gt('Error') }}", xhr.responseJSON?.message || "{{ gt('Failed to add item') }}", 'error');
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
