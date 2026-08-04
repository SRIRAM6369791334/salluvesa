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
    <div class="cs_main_header" style="height: 130px;">
      <div class="container-fluid">
        <div class="cs_main_header_in">
          <div class="cs_main_header_left">
            <a class="cs_site_branding" href="/">
              <img src="img/logo.png" alt="Logo" class="headerimage" style="max-width:100%;margin-top: 50px;" />
            </a>
          </div>
          <div class="cs_main_header_center" style="margin-top: 22px;">
            <div class="cs_nav cs_medium">
              <ul class="cs_nav_list">
                <li><a href="/" @if(request()->is('/') || request()->is('home')) style="color: #5e5e5e;" @endif>{{ gt('Home') }}</a></li>
                <!-- <li class="menu-item-has-children cs_mega_menu">
                  <a href="/categories">{{ gt('Categorys') }}</a>
                  <ul class="cs_mega_wrapper">
                    <li class="menu-item-has-children">
                      <a href="" style="text-decoration: underline; text-decoration-color: #1C30A3;">{{ gt('Mens') }}</a>
                      <ul>
                         <li><a href="#">{{ gt('POLO T – SHIRTS') }} </a></li>
                        <li><a href="#">{{ gt('T- SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('TANK TOPS') }} </a></li>                       
                      </ul>
                    </li>
                    <li class="menu-item-has-children">
                      <a href="" style="text-decoration: underline; text-decoration-color: #1C30A3;">{{ gt('Womens') }}</a>
                      <ul>
                        <li><a href="#">{{ gt('POLO T – SHIRTS') }} </a></li>
                        <li><a href="#">{{ gt('T- SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('TANK TOPS') }} </a></li>    
                      </ul>
                    </li>
                    <li class="menu-item-has-children">
                      <a href="" style="text-decoration: underline; text-decoration-color: #1C30A3;">{{ gt('Kids') }}</a>
                      <ul>
                        <li><a href="#">{{ gt('POLO T – SHIRTS') }} </a></li>
                        <li><a href="#">{{ gt('T- SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('TANK TOPS') }} </a></li>    
                      </ul>
                    </li>
                    <li class="menu-item-has-children">
                      <a href="" style="text-decoration: underline; text-decoration-color: #1C30A3;">{{ gt('Children') }}</a>
                      <ul>
                       <li><a href="#">{{ gt('POLO T – SHIRTS') }} </a></li>
                        <li><a href="#">{{ gt('T- SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('SHIRTS') }}</a></li>
                        <li><a href="#">{{ gt('TANK TOPS') }} </a></li>    
                      </ul>
                    </li>
                  </ul>
                </li> -->
                
                  <!-- <li><a href="/shop" @if(request()->is('shop')) style="color: #5e5e5e;" @endif>{{ gt('Products') }}</a></li> -->
                
                  <li><a href="/sample" @if(request()->is('sample')) style="color: #5e5e5e;" @endif>{{ gt('Sample') }}</a></li>
               
                <li><a href="/about" @if(request()->is('about')) style="color: #5e5e5e;" @endif>{{ gt('About') }}</a></li>
                <!-- <li class="menu-item-has-children">
                  <a href="#">Home</a>
                  <ul>
                    <li><a href="#">Fashion V1</a></li>
                    <li><a href="home-v2.html">Fashion V2</a></li>
                    <li><a href="home-v3.html">Jewelry</a></li>
                  </ul>
                </li> -->
                <!-- <li class="menu-item-has-children">
                  <a href="#">Product</a>
                  <ul>
                    <li><a href="#">All Product</a></li>
                    <li><a href="shop_sidebar.html">Shop Sidebar</a></li>
                    <li><a href="product-details">Product Details</a></li>
                  </ul>
                </li> -->
                <!-- <li><a href="blog.html">Blog</a></li>
                <li class="menu-item-has-children">
                  <a href="">Pages</a>
                  <ul>
                    <li><a href="about.html">About</a></li>
                    <li><a href="blog_details.html">Blog Details</a></li>
                    <li><a href="cart">Cart</a></li>
                    <li><a href="checkout">Checkout</a></li>
                    <li><a href="success">Success</a></li>
                    <li><a href="wishlist">Wishlist</a></li>
                  </ul>
                </li> -->
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
                <li class="menu-item-has-children" style="margin-left: 10px;">
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
          <div class="cs_main_header_right"style="margin-top: 22px;">
            <div class="cs_header_action">
              <!-- <button type="button" class="cs_action_icon cs_header_search_btn">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button> -->
              <a href="{{ Auth::check() ? route('myaccount') : route('login') }}" class="cs_action_icon cs_modal_btn @if(Auth::check()) auth-hover @endif">
                <i class="fa-regular fa-circle-user"></i>
              </a>
              <a href="{{ Auth::check() ? '/cart' : route('login') }}" class="cs_action_icon">
                <span>
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_395_1018)">
                      <path d="M17.0347 3.05775C16.8238 2.80458 16.5597 2.60096 16.2612 2.46136C15.9626 2.32176 15.637 2.2496 15.3075 2.25H3.1815L3.15 1.98675C3.08554 1.43956 2.82254 0.935049 2.41087 0.568858C1.9992 0.202667 1.46747 0.000256345 0.9165 0L0.75 0C0.551088 0 0.360322 0.0790176 0.21967 0.21967C0.0790176 0.360322 0 0.551088 0 0.75C0 0.948912 0.0790176 1.13968 0.21967 1.28033C0.360322 1.42098 0.551088 1.5 0.75 1.5H0.9165C1.1002 1.50002 1.2775 1.56747 1.41478 1.68954C1.55206 1.81161 1.63976 1.97981 1.66125 2.16225L2.69325 10.9373C2.80039 11.8498 3.23886 12.6913 3.92543 13.302C4.612 13.9127 5.49889 14.25 6.41775 14.25H14.25C14.4489 14.25 14.6397 14.171 14.7803 14.0303C14.921 13.8897 15 13.6989 15 13.5C15 13.3011 14.921 13.1103 14.7803 12.9697C14.6397 12.829 14.4489 12.75 14.25 12.75H6.41775C5.95354 12.7487 5.5011 12.6038 5.12245 12.3353C4.7438 12.0668 4.45748 11.6877 4.30275 11.25H13.2428C14.122 11.2501 14.9733 10.9412 15.6479 10.3773C16.3225 9.81348 16.7775 9.03052 16.9335 8.16525L17.5223 4.89975C17.581 4.57576 17.5678 4.2428 17.4836 3.92448C17.3993 3.60616 17.2461 3.31026 17.0347 3.05775ZM16.05 4.6335L15.4605 7.899C15.3668 8.41875 15.0934 8.889 14.6879 9.2274C14.2824 9.5658 13.7709 9.7508 13.2428 9.75H4.06425L3.3585 3.75H15.3075C15.4177 3.74934 15.5266 3.77297 15.6267 3.81919C15.7267 3.86542 15.8153 3.93311 15.8861 4.01746C15.957 4.1018 16.0085 4.20073 16.0368 4.3072C16.0651 4.41368 16.0696 4.52508 16.05 4.6335Z" fill="currentColor" />
                      <path d="M5.25 18C6.07843 18 6.75 17.3284 6.75 16.5C6.75 15.6716 6.07843 15 5.25 15C4.42157 15 3.75 15.6716 3.75 16.5C3.75 17.3284 4.42157 18 5.25 18Z" fill="currentColor" />
                      <path d="M12.75 18C13.5784 18 14.25 17.3284 14.25 16.5C14.25 15.6716 13.5784 15 12.75 15C11.9216 15 11.25 15.6716 11.25 16.5C11.25 17.3284 11.9216 18 12.75 18Z" fill="currentColor" />
                    </g>
                    <defs>
                      <clipPath id="clip0_395_1018">
                        <rect width="18" height="18" fill="currentColor" />
                      </clipPath>
                    </defs>
                  </svg>
                </span>
              </a>
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
            <!-- <button type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button> -->
          </form>
        </div>
      </div>
    </div>
  </header>
  <div class="cs_height_130 cs_height_lg_130"></div>
  <!-- End header -->
  <style>
    @media (max-width: 1300px) {
      .desktop-only-nav-item {
        display: none !important;
      }
    }
    .auth-hover {
      position: relative;
      transition: all 0.3s ease;
    }
    .auth-hover:hover {
      color: #1C30A3 !important;
      transform: scale(1.15);
    }
    .auth-hover::after {
      content: '';
      position: absolute;
      top: -2px;
      right: -2px;
      width: 8px;
      height: 8px;
      /* background-color: #28a745; */
      border-radius: 50%;
      border: 2px solid #fff;
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
  </style>
