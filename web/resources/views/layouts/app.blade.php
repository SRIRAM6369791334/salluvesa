<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Saaluvesa Enterprises Private Limited</title>
  <!-- Favicon -->
  <link rel="icon" type="image/jpeg" href="/img/logo.jpeg?v=2">
  <link rel="shortcut icon" type="image/jpeg" href="/img/logo.jpeg?v=2">
  <!-- Plugins css -->
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/fontawesome.min.css">
  <link rel="stylesheet" href="/css/slick.css">
  <link rel="stylesheet" href="/css/jquery-ui.min.css">
  <link rel="stylesheet" href="/css/animated-headline.css">
  <!-- Custom css -->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/premium-ui.css">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  @stack('styles')

  <style>
    /* WhatsApp Floating Button with Wave Effect */
    .whatsapp_float_btn {
      position: fixed;
      width: 60px;
      height: 60px;
      bottom: 90px; /* Positioned above the scroll top button */
      right: 30px;
      background-color: #25d366;
      color: #FFF;
      border-radius: 50px;
      text-align: center;
      font-size: 32px;
      box-shadow: 2px 2px 3px #999;
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      animation: whatsapp-wave 2s infinite;
    }
    
    .whatsapp_float_btn:hover {
      color: #FFF;
      background-color: #1ebe57;
    }

    @keyframes whatsapp-wave {
      0% {
        box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
      }
      70% {
        box-shadow: 0 0 0 25px rgba(37, 211, 102, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
      }
    }

    /* Mobile adjustments */
    @media screen and (max-width: 767px){
      .whatsapp_float_btn {
        width: 50px;
        height: 50px;
        bottom: 80px;
        right: 15px;
        font-size: 26px;
      }
    }

    /* Google Translate Widget Overrides */
    .goog-te-banner-frame.skiptranslate, .goog-te-gadget-icon {
        display: none !important;
    }
    body {
        top: 0px !important;
        
    }
    .goog-te-gadget {
        color: transparent !important;
        font-size: 0 !important;
    }
    .goog-te-gadget .goog-te-combo {
        display: none !important;
    }
    .VIpgJd-ZVi9od-ORHb-OEVmcd.skiptranslate{
          display: none !important;
    }
    #google_translate_element {
          display: none !important;
    }

    /* Loader Logo Styling */
    .cs_loader_logo {
        width: 150px;
        height: auto;
        animation: loaderLogoPulse 1.8s ease-in-out infinite;
        margin-bottom: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.08));
    }

    @keyframes loaderLogoPulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }
    @media screen {max-width: ;

    }
    @media screen and (max-width: 1199px) and (max-width: 991px) {
    .cs_site_header.cs_style_1 .cs_nav .cs_nav_list {
        width: calc(100% + 30px);
        margin-left: -15px;
        padding-left: 0px;
        padding-right: 0px;
        margin-top: 58px;
    }}
    @media screen and (max-width: 1199px) {
    .cs_site_header.cs_style_1 .cs_menu_toggle {
        top: 50%;
        right: 0px;
        margin-top: 20px;
    }
}
@media screen and (max-width: 450px) {
  .cs_site_branding img {
    margin-top: 26px !important;
  }
  .fa-regular{
   font-size: 20px;
  }
}
@media screen and (max-width: 1200px) {
  .cs_site_branding img {
    margin-top: 26px !important;
  }
  .fa-regular{
   font-size: 20px;
  }
}
@media (max-width: 991px) {
    .cs_hero.cs_style_1 .cs_hero_thumb {
        height: 600px;
        min-height: initial;
        width: 100%;
        flex: initial;
    }
}
@media screen and (max-width: 1000px) and (min-width: 700px) {
  .cs_hero_thumb_img {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: top;
    background-image: url("/images/banner_images/rgoqTw9DkcPq7MsWVEpczvoHZ0oKngDw4THPSTqh.png");
  }
}

  

  </style>

  <script>
    window.baseUrl = '{{ url("/") }}';
    @php
        $currService = app(\App\Services\CurrencyService::class);
        $targetCurr = session('currency', 'INR');
        $rate = $currService->getRate('INR', $targetCurr);
        $symbol = $currService->getSupportedCurrencies()[$targetCurr]['symbol'] ?? '₹';
    @endphp
    window.__currency = {
        code: "{{ $targetCurr }}",
        symbol: "{{ $symbol }}",
        rate: {{ $rate }}
    };
  </script>

</head>

<body>
  <!-- Start Preloader -->
  <div class="cs_perloader">
    <div class="cs_perloader_in">
      <img src="/img/logo.png" alt="Logo" class="cs_loader_logo">
      <!-- <span class="cs_perloader_text">{{ gt('Welcome to saaluvesa. Loading...') }}</span> -->
    </div>
  </div>
  <!-- End Preloader -->

  <!-- Global Action Loader Overlay -->
  <div id="global-loader" class="global-loader-overlay" style="display:none;">
    <div class="global-loader-container">
      <img src="/img/logo.png" alt="Logo" class="global-loader-logo">
      <div class="global-loader-spinner">
        <div class="global-spinner-ring"></div>
      </div>
      <p class="global-loader-text" id="global-loader-text">{{ gt('Processing...') }}</p>
      <p class="global-loader-subtext">{{ gt('Please do not close this page') }}</p>
    </div>
  </div>
  <style>
    .global-loader-overlay{position:fixed;top:0;left:0;width:100%;height:100%;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.75);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);animation:glFadeIn .3s ease-out}
    @keyframes glFadeIn{from{opacity:0}to{opacity:1}}
    .global-loader-container{text-align:center;background:#fff;border-radius:28px;padding:50px 45px 40px;max-width:380px;width:90%;box-shadow:0 30px 80px rgba(0,0,0,.35);animation:glPopIn .4s cubic-bezier(.19,1,.22,1) forwards}
    @keyframes glPopIn{from{transform:scale(.85) translateY(20px);opacity:0}to{transform:scale(1) translateY(0);opacity:1}}
    .global-loader-logo{width:80px;height:auto;margin-bottom:28px;animation:glPulse 2s ease-in-out infinite;filter:drop-shadow(0 4px 12px rgba(0,0,0,.1))}
    @keyframes glPulse{0%,100%{transform:scale(.95);opacity:.85}50%{transform:scale(1.05);opacity:1}}
    .global-loader-spinner{display:flex;justify-content:center;margin-bottom:24px}
    .global-spinner-ring{width:48px;height:48px;border:4px solid #f0f0f0;border-top:4px solid #1C30A3;border-right:4px solid #D1A470;border-radius:50%;animation:glSpin 1s cubic-bezier(.4,0,.2,1) infinite}
    @keyframes glSpin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
    .global-loader-text{font-size:17px;font-weight:700;color:#1a1a2e;margin:0 0 8px;letter-spacing:-.3px}
    .global-loader-subtext{font-size:13px;color:#999;margin:0;font-weight:500}
    .swal2-container{z-index:100000 !important}
  </style>


  @include('layouts.header')

  <div class="cs_main_content page-entrance">
    @yield('content')
  </div>
 
  @include('layouts.footer')
  <!-- Start WhatsApp floating button -->
  <a href="https://wa.me/919597538270" target="_blank" class="whatsapp_float_btn" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
  </a>
  <!-- End WhatsApp floating button -->

  <!-- Start scroll up button -->
  <div class="cs_scrollup_btn" id="cs_scroll_btn">
    <i class="fa-solid fa-arrow-up"></i>
  </div>
  <!-- End scroll up button -->
  <!-- All script files -->
  <script src="/js/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/jquery.slick.min.js"></script>

  <script src="/js/isotope.pkg.min.js"></script>
  <script src="/js/jquery-ui.min.js"></script>
  <script src="/js/animated-headline.js"></script>
  <script src="/js/main.js"></script>
  <script src="/js/design-gallery.js"></script>
   <script src="/js/categories.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      $(document).ready(function() {
        @if(session('success'))
          Swal.fire({
            icon: 'success',
            title: "{{ gt('Success!') }}",
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
          });
        @endif

        @if(session('error'))
          Swal.fire({
            icon: 'error',
            title: "{{ gt('Oops...') }}",
            text: "{{ session('error') }}",
          });
        @endif

        @if($errors->any())
          Swal.fire({
            icon: 'error',
            title: "{{ gt('Validation Error') }}",
            text: "{{ $errors->first() }}",
          });
        @endif
      });
    </script>
   <script src="/js/premium-ui.js"></script>
   <script>
     // Global Loader Helper Functions
     function showLoader(text) {
       var el = document.getElementById('global-loader');
       var txt = document.getElementById('global-loader-text');
       if (txt) txt.textContent = text || '{{ gt("Processing...") }}';
       if (el) el.style.display = 'flex';
     }
     function hideLoader() {
       var el = document.getElementById('global-loader');
       if (el) el.style.display = 'none';
     }
   </script>

   
   <!-- Google Translate Widget Initialization -->
   <!-- Premium Onboarding Tour Overlay -->
   <div id="cs_onboarding_overlay" class="cs_onboarding_overlay" style="display: none;">
       <div class="cs_onboarding_container">
           <button class="cs_tour_skip_btn" onclick="closeTour()">{{ gt('Skip Tour') }}</button>
           
           <div id="cs_tour_steps_container">
               @php
                   $tourSteps = [
                       ['icon' => 'user-plus', 'title' => 'Strategic Registration', 'desc' => 'Choose between Individual or B2B Partnership accounts for personalized benefits.'],
                       ['icon' => 'box-open', 'title' => 'Precision Sampling', 'desc' => 'Order a physical prototype to verify our premium fabric quality and fitment.'],
                       ['icon' => 'unlock', 'title' => 'Full Ecosystem', 'desc' => 'Upon sample receipt, unlock high-end bulk tools and advanced Design Lab features.'],
                       ['icon' => 'pen-nib', 'title' => 'Design Lab', 'desc' => 'Use our industrial-grade CAD tools to position logos and text with millimeter precision.'],
                       ['icon' => 'truck-fast', 'title' => 'Swift Fulfillment', 'desc' => 'Track your custom masterpiece from our professional production line to your doorstep.'],
                   ];
               @endphp

               @foreach($tourSteps as $index => $step)
                   <div class="cs_tour_step {{ $index === 0 ? 'active' : '' }}" data-step="{{ $index }}">
                       <div class="cs_tour_icon pulse-gold">
                           <i class="fas fa-{{ $step['icon'] }}"></i>
                       </div>
                       <h2 class="cs_tour_title">{{ gt($step['title']) }}</h2>
                       <p class="cs_tour_desc">{{ gt($step['desc']) }}</p>
                   </div>
               @endforeach
           </div>

           <div class="cs_tour_footer">
               <div class="cs_tour_dots">
                   @foreach($tourSteps as $index => $step)
                       <span class="tour-dot {{ $index === 0 ? 'active' : '' }}"></span>
                   @endforeach
               </div>
               <button id="next_tour_btn" class="cs_tour_next_btn" onclick="nextTourStep()">{{ gt('Next Step') }} <i class="fas fa-arrow-right"></i></button>
           </div>
       </div>
       <div class="cs_tour_background_blur"></div>
   </div>

   <style>
       .cs_onboarding_overlay {
           position: fixed;
           top: 0; left: 0; width: 100%; height: 100%;
           z-index: 9999;
           display: flex;
           align-items: center;
           justify-content: center;
           padding: 20px;
       }
       .cs_tour_background_blur {
           position: absolute;
           top: 0; left: 0; width: 100%; height: 100%;
           background: rgba(0,0,0,0.85);
           backdrop-filter: blur(15px);
           -webkit-backdrop-filter: blur(15px);
           z-index: -1;
       }
       .cs_onboarding_container {
           background: #fff;
           max-width: 500px;
           width: 100%;
           border-radius: 40px;
           padding: 60px 40px;
           position: relative;
           text-align: center;
           box-shadow: 0 50px 100px rgba(0,0,0,0.5);
           animation: tourPopup 0.6s cubic-bezier(0.19, 1, 0.22, 1) forwards;
       }
       @keyframes tourPopup {
           from { transform: scale(0.8); opacity: 0; }
           to { transform: scale(1); opacity: 1; }
       }
       .cs_tour_skip_btn {
           position: absolute;
           top: 30px; right: 30px;
           background: none; border: none;
           font-weight: 700; font-size: 13px;
           text-transform: uppercase; color: #999;
           cursor: pointer; transition: color 0.3s;
       }
       .cs_tour_skip_btn:hover { color: #000; }
       .cs_tour_icon {
           width: 100px; height: 100px;
           background: #000; color: #fff;
           border-radius: 30px;
           display: flex; align-items: center; justify-content: center;
           margin: 0 auto 30px;
           font-size: 40px;
       }
       .pulse-gold { animation: gold-pulse 2s infinite; }
       @keyframes gold-pulse { 
           0% { box-shadow: 0 0 0 0 rgba(209, 164, 112, 0.4); }
           70% { box-shadow: 0 0 0 20px rgba(209, 164, 112, 0); }
           100% { box-shadow: 0 0 0 0 rgba(209, 164, 112, 0); }
       }
       .cs_tour_title { font-weight: 800; font-size: 32px; margin-bottom: 20px; letter-spacing: -1px; }
       .cs_tour_desc { font-size: 17px; color: #666; line-height: 1.6; margin-bottom: 0; }
       .cs_tour_step { display: none; }
       .cs_tour_step.active { display: block; animation: fadeIn 0.4s ease-out; }
       @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
       
       .cs_tour_footer { margin-top: 50px; display: flex; align-items: center; justify-content: space-between; }
       .cs_tour_dots { display: flex; gap: 8px; }
       .tour-dot { width: 8px; height: 8px; border-radius: 50%; background: #eee; transition: all 0.3s; }
       .tour-dot.active { width: 25px; border-radius: 10px; background: #000; }
       .cs_tour_next_btn {
           background: #D1A470; color: #fff;
           border: none; padding: 15px 35px;
           border-radius: 50px; font-weight: 700;
           cursor: pointer; transition: all 0.3s;
       }
       .cs_tour_next_btn:hover { background: #000; transform: scale(1.05); }
   </style>

   <script>
       let currentTourStep = 0;
       const totalTourSteps = {{ count($tourSteps) }};

       function nextTourStep() {
           if (currentTourStep < totalTourSteps - 1) {
               currentTourStep++;
               updateTourUI();
           } else {
               closeTour();
           }
       }

       function updateTourUI() {
           document.querySelectorAll('.cs_tour_step').forEach(el => el.classList.remove('active'));
           document.querySelector(`.cs_tour_step[data-step="${currentTourStep}"]`).classList.add('active');
           
           document.querySelectorAll('.tour-dot').forEach((el, idx) => {
               el.classList.toggle('active', idx === currentTourStep);
           });

           const btn = document.getElementById('next_tour_btn');
           if (currentTourStep === totalTourSteps - 1) {
               btn.innerHTML = "{{ gt('Finish Tour') }}";
           } else {
               btn.innerHTML = "{{ gt('Next Step') }} <i class='fas fa-arrow-right'></i>";
           }
       }

       function closeTour() {
           localStorage.setItem('saaluvesa_tour_seen', 'true');
           document.getElementById('cs_onboarding_overlay').style.opacity = '0';
           setTimeout(() => {
               document.getElementById('cs_onboarding_overlay').style.display = 'none';
               // Enable body scrolling if it was disabled
               document.body.style.overflow = 'auto';
           }, 500);
       }

       document.addEventListener('DOMContentLoaded', function() {
           if (!localStorage.getItem('saaluvesa_tour_seen')) {
               document.getElementById('cs_onboarding_overlay').style.display = 'flex';
               document.body.style.overflow = 'hidden';
           }
       });
   </script>
   <div id="google_translate_element"></div>
   <script type="text/javascript">
     function googleTranslateElementInit() {
       new google.translate.TranslateElement({
         pageLanguage: 'en',
         layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
         autoDisplay: false
       }, 'google_translate_element');
     }
   </script>
   <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

   @stack('scripts')
</body>
</html>
