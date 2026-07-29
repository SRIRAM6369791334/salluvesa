@extends('layouts.app')

@section('content')
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center" style="z-index:2">
      <div class="hero-content">
        <div class="hero-badge">
          <span class="badge-icon">📜</span>
          <span>{{ gt('Official Agreement') }}</span>
        </div>
        <h1 class="premium-hero-title">{{ gt('Terms & Conditions') }}</h1>
        <p class="hero-subtitle">{{ gt('Saaluvesa Enterprises Private Limited Worldwide Export E-Commerce Agreement') }}</p>
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

  <section class="premium-contact-section">
    <div class="animated-gradient-bg"></div>
    <div class="cs_height_100 cs_height_lg_60"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <div class="policy-wrapper p-4 border rounded bg-white shadow-sm" style="position:relative; z-index:2;">
            <div class="policy-content">
              <h2 class="h4 cs_bold mb-3">{{ gt('Acceptance of Terms') }}</h2>
              <p>{{ gt('By using our website, you agree to these Terms and Conditions.') }}</p>

              <h2 class="h4 cs_bold mt-4 mb-3">{{ gt('Products & Services') }}</h2>
              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-box text-muted me-2"></i>{{ gt('All products are subject to availability and export clearance.') }}</li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-globe text-muted me-2"></i>{{ gt('Prices are listed in Currencies depending on destination.') }}</li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-info-circle text-muted me-2"></i>{{ gt('We reserve the right to modify or discontinue products.') }}</li>
              </ul>

              <h2 class="h4 cs_bold mt-4 mb-3">{{ gt('Orders & Payments') }}</h2>
              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-shopping-cart text-muted me-2"></i>{{ gt('Orders are confirmed only after successful payment.') }}</li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-credit-card text-muted me-2"></i>{{ gt('International payments processed via approved gateways.') }}</li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-map-pin text-muted me-2"></i>{{ gt('Customers must provide accurate billing/shipping details.') }}</li>
              </ul>

              <h2 class="h4 cs_bold mt-4 mb-3">{{ gt('Export Compliance') }}</h2>
              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-shield-alt text-muted me-2"></i>{{ gt('Shipments are subject to Indian customs, AD Code registration, and RBI guidelines.') }}</li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1"><i class="fas fa-exclamation-triangle text-muted me-2"></i>{{ gt('Customers are responsible for import duties, taxes, and clearance in their country if not chosen DELIVERY DUTY PAID (DDP) Option.') }}</li>
              </ul>

              <h2 class="h4 cs_bold mt-4 mb-3">{{ gt('Limitation of Liability') }}</h2>
              <p class="mb-0">{{ gt('We are not liable for delays caused by customs, courier partners.') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
  </section>

  <style>
    .premium-hero-section {
      min-height: 400px;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%);
      position: relative;
      padding: 120px 0 180px;
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
      background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.3) 0%, transparent 50%);
      z-index: 1;
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
    }
    .premium-hero-title {
      font-size: 56px;
      font-weight: 900;
      font-family: 'Merriweather', serif;
      color: white;
      margin: 0 0 20px 0;
      line-height: 1.2;
    }
    .hero-subtitle {
      font-size: 18px;
      color: rgba(255, 255, 255, 0.9);
      margin: 0;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
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
      fill: #fff;
    }
    .policy-wrapper {
      border: 1px solid #eee !important;
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px);
    }
    .policy-content h2 {
      border-left: 4px solid #1C30A3;
      padding-left: 15px;
      margin-top: 30px;
      font-family: 'Merriweather', serif;
    }
    .policy-content p,
    .policy-content li {
      font-size: 16px;
      color: #444;
      line-height: 1.8;
    }
    .cs_height_100 { height: 100px; }
    @media (max-width: 991px) {
      .cs_height_lg_60 { height: 60px !important; }
      .premium-hero-title { font-size: 36px; }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const e = document.getElementById('heroParticles');
      if (e) {
        for (let t = 0; t < 50; t++) {
          const o = document.createElement('div');
          o.style.cssText = `position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*0.5+0.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`, e.appendChild(o)
        }
        const t = document.createElement('style');
        t.textContent = `@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`, document.head.appendChild(t)
      }
    });
  </script>
  <script src="/js/site-animations.js"></script>
@endsection
