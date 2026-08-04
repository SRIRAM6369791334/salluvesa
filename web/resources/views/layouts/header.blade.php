<!-- Start header -->
  <header class="cs_site_header cs_style_1 cs_primary_color cs_site_header_full_width cs_sticky_header">
    <!-- <div class="cs_top_header cs_primary_color">
      <div class="container-fluid">
        <div class="cs_top_header_in">
          <div class="cs_top_header_left">
            <p class="cs_medium mb-0">Support : product@saaluvesa.com</p>
          </div>
          <div class="cs_top_header_center">
            <div class="cd-headline slide">
              <span class="cd-words-wrapper text-center">
                <b class="cs_text_slide cs_medium is-visible">
                  <span>100% Happy return policy</span>
                  <span>
                    <a href="about.html" class="cs_text_slide_btn">Learn More</a>
                  </span>
                </b>
                <b class="cs_text_slide cs_medium">
                  <span>Big sale offer with 50%</span>
                  <span>
                    <a href="#" class="cs_text_slide_btn">Learn More</a>
                  </span>
                </b>
                <b class="cs_text_slide cs_medium">
                  <span>New arrival item for you</span>
                  <span>
                    <a href="#" class="cs_text_slide_btn">Learn More</a>
                  </span>
                </b>
              </span>
            </div>
          </div>
          <div class="cs_top_header_right">
            <p class="cs_medium mb-0">Mon-Fri Open : 11:00 - 19:00</p>
          </div>
        </div>
      </div>
    </div> -->
    <div class="cs_main_header">
      <div class="container-fluid">
        <div class="cs_main_header_in">
          <div class="cs_main_header_left">
            <a class="cs_site_branding" href="/">
              <img src="img/logo.png" alt="Logo" class="headerimage" />
            </a>
          </div>
          <div class="cs_main_header_center">
            <div class="cs_nav cs_medium">
              <ul class="cs_nav_list">
                <li><a href="/" @if(request()->is('/') || request()->is('home')) style="color: #5e5e5e;" @endif>{{ gt('Home') }}</a></li>
                <li><a href="/sample" @if(request()->is('sample')) style="color: #5e5e5e;" @endif>{{ gt('Sample') }}</a></li>
                <li><a href="/about" @if(request()->is('about')) style="color: #5e5e5e;" @endif>{{ gt('About') }}</a></li>
                <li><a href="/contact" @if(request()->is('contact')) style="color: #5e5e5e;" @endif>{{ gt('Contact') }}</a></li>
                @if(Auth::check() && Auth::user()->hasPurchasedSample())
                  <li><a href="/own-design" @if(request()->is('own-design')) style="color: #5e5e5e;" @endif>{{ gt('Own Design') }}</a></li>
                  <li><a href="{{ route('bulk.order') }}" @if(request()->is('bulk-order')) style="color: #5e5e5e;" @endif>{{ gt('Bulk Order') }}</a></li>
                  <li class="desktop-only-nav-item"><a href="/customize-products" @if(request()->is('customize-products')) style="color: #5e5e5e;" @endif>{{ gt('Place Your Design') }}</a></li>
                @endif
                <li class="menu-item-has-children">
                  <a href="#">{{ strtoupper(app()->getLocale()) }}</a>
                  <ul>
                    <li><a href="{{ route('language.switch', 'en') }}">English (EN)</a></li>
                    <li><a href="{{ route('language.switch', 'de') }}">Austria – German</a></li>
                    <li><a href="{{ route('language.switch', 'nl') }}">Belgium – Dutch</a></li>
                    <li><a href="{{ route('language.switch', 'hr') }}">Croatia – Croatian</a></li>
                    <li><a href="{{ route('language.switch', 'el') }}">Cyprus – Greek</a></li>
                    <li><a href="{{ route('language.switch', 'et') }}">Estonia – Estonian</a></li>
                    <li><a href="{{ route('language.switch', 'fi') }}">Finland – Finnish</a></li>
                    <li><a href="{{ route('language.switch', 'fr') }}">France – French</a></li>
                    <li><a href="{{ route('language.switch', 'de') }}">Germany – German</a></li>
                    <li><a href="{{ route('language.switch', 'el') }}">Greece – Greek</a></li>
                    <li><a href="{{ route('language.switch', 'ga') }}">Ireland – Irish</a></li>
                    <li><a href="{{ route('language.switch', 'it') }}">Italy – Italian</a></li>
                    <li><a href="{{ route('language.switch', 'lv') }}">Latvia – Latvian</a></li>
                    <li><a href="{{ route('language.switch', 'lt') }}">Lithuania – Lithuanian</a></li>
                    <li><a href="{{ route('language.switch', 'lb') }}">Luxembourg – Luxembourgish</a></li>
                    <li><a href="{{ route('language.switch', 'mt') }}">Malta – Maltese</a></li>
                    <li><a href="{{ route('language.switch', 'nl') }}">Netherlands – Dutch</a></li>
                    <li><a href="{{ route('language.switch', 'pt') }}">Portugal – Portuguese</a></li>
                    <li><a href="{{ route('language.switch', 'sk') }}">Slovakia – Slovak</a></li>
                    <li><a href="{{ route('language.switch', 'sl') }}">Slovenia – Slovene</a></li>
                    <li><a href="{{ route('language.switch', 'es') }}">Spain – Spanish</a></li>
                  </ul>
                </li>
                <li class="menu-item-has-children">
                  @php
                    $currencyService = app(\App\Services\CurrencyService::class);
                    $supported = $currencyService->getSupportedCurrencies();
                    $currentCurrency = session('currency', 'INR');
                    $currentSymbol = $supported[$currentCurrency]['symbol'] ?? '₹';
                  @endphp
                  <a href="#">{{ $currentCurrency }} ({{ $currentSymbol }})</a>
                  <ul>
                    @foreach($supported as $code => $info)
                      <li>
                        <a href="{{ route('currency.switch.get', $code) }}">
                          {{ $info['name'] }} ({{ $info['symbol'] }})
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <div class="cs_main_header_right">
            <div class="cs_header_action">
              <a href="{{ Auth::check() ? route('myaccount') : route('login') }}" class="cs_action_icon cs_modal_btn @if(Auth::check()) auth-hover @endif" title="{{ gt('My Account') }}">
                <i class="fa-regular fa-circle-user"></i>
              </a>
              <a href="{{ Auth::check() ? '/cart' : route('login') }}" class="cs_action_icon" title="{{ gt('Cart') }}">
                <i class="fa-solid fa-cart-shopping"></i>
              </a>
              <button type="button" class="cs_action_icon cs_mobile_menu_btn d-lg-none" id="mobile-menu-toggle-btn" aria-label="{{ gt('Toggle Menu') }}">
                <i class="fa-solid fa-bars"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="cs_header_search_wrap">
      <div class="container">
        <div class="cs_header_search_in">
          <div class="cs_hero_search_heading">
            <h3>{{ gt('What are you looking for?') }}</h3>
            <button class="cs_header_search_close" type="button"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form action="#" class="cs_header_search_form">
            <input type="text" placeholder="{{ gt('Search...') }}">
          </form>
        </div>
      </div>
    </div>
  </header>
  <div class="cs_header_spacer"></div>
  <!-- End header -->
  <style>
    /* Main Header Container & Vertical Alignment Fix */
    .cs_main_header {
      height: 85px !important;
      display: flex !important;
      align-items: center !important;
      background: #ffffff !important;
      box-shadow: 0 2px 16px rgba(15, 23, 42, 0.06) !important;
      transition: height 0.3s ease, background 0.3s ease !important;
    }
    .cs_main_header_in {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      width: 100% !important;
    }
    .cs_main_header_left,
    .cs_main_header_center,
    .cs_main_header_right {
      display: flex !important;
      align-items: center !important;
      margin: 0 !important;
      padding: 0 !important;
    }

    /* Logo Image Sizing */
    .headerimage {
      max-height: 52px !important;
      height: auto !important;
      width: auto !important;
      margin: 0 !important;
      display: block !important;
      object-fit: contain !important;
    }

    /* Action Icons Flex Container & Pixel-Perfect Baseline Alignment */
    .cs_header_action {
      display: flex !important;
      align-items: center !important;
      gap: 14px !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    .cs_header_action .cs_action_icon {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      width: 40px !important;
      height: 40px !important;
      border-radius: 50% !important;
      background: #f8fafc !important;
      border: 1.5px solid #e2e8f0 !important;
      color: #1e293b !important;
      font-size: 17px !important;
      line-height: 1 !important;
      transition: all 0.25s ease !important;
      text-decoration: none !important;
      margin: 0 !important;
      padding: 0 !important;
      box-sizing: border-box !important;
    }
    .cs_header_action .cs_action_icon i {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      line-height: 1 !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    .cs_header_action .cs_action_icon:hover {
      background: #1C30A3 !important;
      color: #ffffff !important;
      border-color: #1C30A3 !important;
      transform: translateY(-2px) !important;
      box-shadow: 0 6px 18px rgba(28, 48, 163, 0.25) !important;
    }

    /* Page Top Spacer */
    .cs_header_spacer {
      height: 85px !important;
    }

    @media (max-width: 1300px) {
      .desktop-only-nav-item {
        display: none !important;
      }
    }

    /* Explicit Desktop Breakpoint Enforcement (≥ 992px) */
    @media (min-width: 992px) {
      #mobile-menu-toggle-btn,
      .cs_mobile_menu_btn,
      span.cs_menu_toggle {
        display: none !important;
      }
      .cs_main_header_center .cs_nav {
        display: flex !important;
        position: static !important;
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
      }
      .cs_nav_list {
        display: flex !important;
        align-items: center !important;
      }
    }

    /* Hide default theme injected span toggle element */
    span.cs_menu_toggle {
      display: none !important;
    }

    @media (max-width: 992px) {
      .cs_main_header {
        height: 72px !important;
      }
      .cs_header_spacer {
        height: 72px !important;
      }
      .headerimage {
        max-height: 40px !important;
      }
      .cs_main_header_in {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: nowrap !important;
        height: 100% !important;
      }
      .cs_main_header_left {
        display: flex !important;
        align-items: center !important;
      }
      .cs_main_header_right {
        display: flex !important;
        align-items: center !important;
        margin-left: auto !important;
      }
      .cs_header_action {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
      }
      .cs_header_action .cs_action_icon {
        width: 38px !important;
        height: 38px !important;
        font-size: 16px !important;
      }

      /* Clean Full-Width Mobile Navigation Drawer (CLOSED BY DEFAULT) */
      .cs_site_header .cs_main_header_center .cs_nav,
      .cs_main_header_center .cs_nav {
        display: none !important;
        position: fixed !important;
        top: 72px !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        background: #ffffff !important;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15) !important;
        border-bottom: 3px solid #1C30A3 !important;
        z-index: 99999 !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .cs_site_header .cs_main_header_center .cs_nav.cs_mobile_active,
      .cs_main_header_center .cs_nav.cs_mobile_active {
        display: block !important;
      }
      .cs_nav_list {
        display: block !important;
        padding: 12px 16px !important;
        margin: 0 !important;
        list-style: none !important;
      }
      .cs_nav_list > li {
        position: relative !important;
        margin-left: 0 !important;
        border-bottom: 1px solid #f1f5f9 !important;
      }
      .cs_nav_list > li:last-child {
        border-bottom: none !important;
      }
      .cs_nav_list > li > a {
        padding: 12px 10px !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        color: #1e293b !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        transition: all 0.2s ease !important;
        border-radius: 8px !important;
      }
      .cs_nav_list > li.menu-item-has-children > a {
        padding-right: 48px !important;
      }
      .cs_nav_list > li > a:hover {
        color: #1C30A3 !important;
        background: #f8fafc !important;
        padding-left: 14px !important;
      }
      .cs_menu_dropdown_toggle {
        position: absolute !important;
        top: 50% !important;
        left: auto !important;
        right: 12px !important;
        transform: translateY(-50%) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 50% !important;
        background: #f1f5f9 !important;
        color: #1C30A3 !important;
        margin: 0 !important;
        padding: 0 !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        z-index: 2 !important;
      }
      .cs_menu_dropdown_toggle.active {
        background: #1C30A3 !important;
        color: #ffffff !important;
      }
    }

    /* Scrollable Header Navigation Dropdowns (Language & Currency Dropdowns) */
    .cs_nav .cs_nav_list ul:not(.cs_mega_wrapper) {
      max-height: 280px !important;
      overflow-y: auto !important;
      scrollbar-width: thin;
      scrollbar-color: #1C30A3 #f1f5f9;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
      border-radius: 8px;
      border: 1px solid #e2e8f0;
    }
    .cs_nav .cs_nav_list ul:not(.cs_mega_wrapper)::-webkit-scrollbar {
      width: 6px;
    }
    .cs_nav .cs_nav_list ul:not(.cs_mega_wrapper)::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 4px;
    }
    .cs_nav .cs_nav_list ul:not(.cs_mega_wrapper)::-webkit-scrollbar-thumb {
      background: #1C30A3;
      border-radius: 4px;
    }
    .cs_nav .cs_nav_list ul:not(.cs_mega_wrapper)::-webkit-scrollbar-thumb:hover {
      background: #152482;
    }
    #mobile-menu-toggle-btn.active {
      background: #1C30A3 !important;
      border-color: #1C30A3 !important;
      color: #ffffff !important;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('mobile-menu-toggle-btn');
      const navMenu = document.querySelector('.cs_main_header_center .cs_nav');
      if (toggleBtn && navMenu) {
        toggleBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          const isOpen = navMenu.classList.toggle('cs_mobile_active');
          const icon = toggleBtn.querySelector('i');
          if (isOpen) {
            if (icon) icon.className = 'fa-solid fa-xmark';
            toggleBtn.classList.add('active');
            toggleBtn.setAttribute('title', 'Close Menu');
          } else {
            if (icon) icon.className = 'fa-solid fa-bars';
            toggleBtn.classList.remove('active');
            toggleBtn.setAttribute('title', 'Open Menu');
          }
        });
      }
    });
  </script>
