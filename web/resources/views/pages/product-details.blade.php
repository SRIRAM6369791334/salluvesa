@extends('layouts.app')
@section('content')
  <section class="premium-hero-section position-relative overflow-hidden"><div class="hero-particles" id="heroParticles"></div><div class="hero-gradient-overlay"></div><div class="container position-relative text-center" style="z-index:2"><div class="hero-content"><div class="hero-badge"><span class="badge-icon">👕</span><span>{{ gt('Product Info') }}</span></div><h1 class="premium-hero-title">{{ gt('Product Details') }}</h1><p class="hero-subtitle">{{ gt('Explore our premium quality products') }}</p></div></div><div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path></svg></div></section>
  <!-- Start single product -->
  <section>
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="cs_single_product_breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ gt('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/shop') }}">{{ gt('Shop') }}</a></li>
          <li class="breadcrumb-item"><a href="#">{{ $product->category->category_name ?? 'Category' }}</a></li>
          <li class="breadcrumb-item active">{{ $product->subcategory->subcategory_name ?? 'Subcategory' }}</li>
        </ol>
      </nav>
      <div class="row">
        <div class="col-xl-7">
          <div class="row">
            <div class="col-3">
              <div class="cs_single_product_nav slick-slider">
                <div class="cs_single_product_thumb_mini">
                  <img src="{{ asset($product->product_image) }}" alt="Thumb">
                </div>
              </div>
            </div>
            <div class="col-9">
              <div class="cs_single_product_thumb slick-slider">
                <div class="cs_single_product_thumb_item">
                  <img src="{{ asset($product->product_image) }}" alt="Thumb">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-5">
          <div class="cs_single_product_details">
            <h2 class="cs_fs_37 cs_semibold">{{ $product->product_name }}</h2>
            <div class="cs_single_product_review">
              <div class="cs_rating_container">
                <div class="cs_rating cs_size_sm" data-rating="5">
                  <div class="cs_rating_percentage"></div>
                </div>
              </div>
              <span>(5)</span>
              <span>{{ gt('Stock') }}: <span class="cs_accent_color">{{ $product->product_quantity }} {{ gt('in stock') }}</span></span>
            </div>
            <h4 class="cs_single_product_price cs_fs_21 cs_primary_color cs_semibold">{{ gt('Price') }}: {{ format_currency($product->product_mrp_price) }}</h4>
            <hr>
            <div class="cs_single_product_details_text">
              <p class="mb-0">{{ $product->product_description }}</p>
            </div>
            <div class="cs_single_product_size">
              <h4 class="cs_fs_16 cs_medium">{{ gt('Size') }}</h4>
              <ul class="cs_size_filter_list cs_mp0">
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="size" value="S" class="premium-control-input">
                    <span>S</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="size" value="M" checked class="premium-control-input">
                    <span>M</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="size" value="L" class="premium-control-input">
                    <span>L</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="size" value="XL" class="premium-control-input">
                    <span>XL</span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="cs_single_product_color ">
              <h4 class="cs_fs_16 cs_medium">{{ gt('Color') }}</h4>
              <ul class="cs_color_filter_list cs_type_1 cs_mp0">
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="color" value="Red" class="premium-control-input">
                    <span class="cs_color_filter_circle cs_accent_bg"></span>
                    <span class="cs_color_text">{{ gt('Red') }}</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="color" value="Gray" class="premium-control-input">
                    <span class="cs_color_filter_circle cs_secondary_bg"></span>
                    <span class="cs_color_text">{{ gt('Gray') }}</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="color" value="Black" checked class="premium-control-input">
                    <span class="cs_color_filter_circle cs_primary_bg"></span>
                    <span class="cs_color_text">{{ gt('Black') }}</span>
                  </label>
                </li>
                <li>
                  <label class="premium-checkbox-group">
                    <input type="radio" name="color" value="White" class="premium-control-input">
                    <span class="cs_color_filter_circle cs_white_bg"></span>
                    <span class="cs_color_text">{{ gt('White') }}</span>
                  </label>
                </li>
              </ul>
            </div>
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="id" value="{{ $product->id }}">
              <input type="hidden" name="type" value="own">
              <div class="cs_action_btns">
                <div class="cs_quantity">
                  <button type="button" class="cs_quantity_btn cs_increment"><i class="fa-solid fa-angle-up"></i></button>
                  <input type="text" name="quantity" class="cs_quantity_input bg-transparent border-0 text-center" value="1" style="width: 40px" readonly>
                  <button type="button" class="cs_quantity_btn cs_decrement"><i class="fa-solid fa-angle-down"></i></button>
                </div>
                <button type="submit" class="cs_btn cs_style_1 cs_fs_16 cs_medium border-0 cs_cart_btn">{{ gt('Add to Cart') }}</button>
                <a href="{{ url('customize-products') }}" class="cs_btn cs_style_1 cs_fs_16 cs_medium">{{ gt('Place design') }}</a>
                <button type="button" class="cs_heart_btn"><i class="fa-regular fa-heart"></i></button>
              </div>
            </form>
            <ul class="cs_single_product_info">
              <li class="cs_fs_16 cs_normal">
                <b class="cs_medium">{{ gt('SKU') }}: </b>{{ $product->prod_unique_name ?? 'N/A' }}
              </li>
              <li class="cs_fs_16 cs_normal">
                <b class="cs_medium">{{ gt('Categories') }}: </b>{{ $product->category->category_name ?? 'N/A' }}, {{ $product->subcategory->subcategory_name ?? 'N/A' }}
              </li>
              <li class="cs_fs_16 cs_normal">
                <b class="cs_medium">{{ gt('Specification') }}: </b>{{ $product->product_specification }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="cs_height_70 cs_height_lg_60"></div>
      <hr>
      <div class="cs_product_meta_info">
        <ul class="cs_tab_links cs_style_2 cs_product_tab cs_fs_21 cs_primary_color cs_semibold cs_mp0">
          <li><a href="#tab_1">{{ gt('Description') }}</a></li>
          <li><a href="#tab_2">{{ gt('Additional information') }}</a></li>
          <li><a href="#tab_3">{{ gt('Size Guide') }}</a></li>
          <li class="active"><a href="#tab_4">{{ gt('Review') }} (1)</a></li>
        </ul>
        <div class="cs_tabs">
          <div class="cs_tab" id="tab_1">
            {{ $product->product_description }}
          </div>
          <div class="cs_tab" id="tab_2">
            <table class="m-0">
              <tbody>
                <tr>
                  <td>{{ gt('Color') }}</td>
                  <td>{{ gt('Blue') }}, {{ gt('Gray') }}, {{ gt('Green') }}, {{ gt('Red') }}, {{ gt('Yellow') }}</td>
                </tr>
                <tr>
                  <td>{{ gt('Size') }}</td>
                  <td>{{ gt('Large') }}, {{ gt('Medium') }}, {{ gt('Small') }}</td>
                </tr>
              </tbody>
            </table>
            <hr>
          </div>
          <div class="cs_tab" id="tab_3">
            {{ gt('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis orci ac odio dictum tincidunt. Donec ut metus leo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed luctus, dui eu sagittis sodales, nulla nibh sagittis augue, vel porttitor diam enim non metus. Vestibulum aliquam augue neque. Phasellus tincidunt odio eget ullamcorper efficitur. Cras placerat ut turpis pellentesque vulputate. Nam sed consequat tortor. Curabitur finibus sapien dolor. Ut eleifend tellus nec erat pulvinar dignissim. Nam non arcu purus. Vivamus et massa massa.') }}
          </div>
          <div class="cs_tab active" id="tab_4">
            <ul class="cs_client_review_list cs_mp0">
              <li>
                <div class="cs_client_review">
                  <div class="cs_review_media">
                    <div class="cs_review_media_thumb"><img src="img/avatar.png" alt="Avatar"></div>
                    <div class="cs_review_media_right">
                      <div class="cs_rating_container">
                        <div class="cs_rating cs_size_sm" data-rating="5">
                          <div class="cs_rating_percentage"></div>
                        </div>
                      </div>
                      <p class="mb-0 cs_primary_color cs_semibold">Zhon Abony</p>
                    </div>
                    <p class="cs_review_posted_by">August 12, 2023</p>
                  </div>
                  <p class="cs_review_text">{{ gt('I recently purchased the Arino T-shirts and I\'m thoroughly impressed. The sound quality is exceptional, the wireless connectivity is seamless, and the noise cancellation technology is a standout feature. They\'re a bit pricey, but well worth the investment. Highly recommend.') }}</p>
                </div>
              </li>
            </ul>
            <p class="m-0">{{ gt('Your email address will not be published. Required fields are marked *') }}</p>
            <div class="cs_height_20 cs_height_lg_20"></div>
            <div class="cs_input_rating_wrap">
              <p>{{ gt('Your rating') }}  *</p>
              <div class="cs_input_rating cs_accent_color" data-rating="0">
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
              </div>
            </div>
            <div class="cs_height_20 cs_height_lg_22"></div>
            <form class="row cs_review_form cs_gap_y_24">
              <div class="col-lg-12">
                <div class="premium-form-group">
                  <label class="premium-form-label">{{ gt('Your Review') }} *</label>
                  <textarea rows="4" class="premium-form-input" placeholder="{{ gt('Write your review here...') }}"></textarea>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="premium-form-group">
                  <label class="premium-form-label">{{ gt('Your Name') }} *</label>
                  <input type="text" class="premium-form-input" placeholder="{{ gt('Full Name') }}">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="premium-form-group">
                  <label class="premium-form-label">{{ gt('Your Email') }} *</label>
                  <input type="email" class="premium-form-input" placeholder="{{ gt('Email Address') }}">
                </div>
              </div>
              <div class="col-lg-12">
                <label class="premium-checkbox-group mb-4">
                  <input class="premium-control-input" type="checkbox">
                  <span class="ms-2 fs-14 text-muted">
                    {{ gt('By using this form you agree with the storage and handling of your data by this website.') }} *
                  </span>
                </label>
              </div>
              <div class="col-lg-12">
                <button class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100" type="submit" style="padding: 15px;">{{ gt('Submit Now') }}</button>
              </div>
            </form>
          </div>
        </div>
        <!-- .cs_tabs -->
      </div>
    </div>
  </section>
  <!-- End single product -->
  <!-- Start new item store -->
  <section class="cs_slider container-fluid position-relative">
    <div class="cs_height_120 cs_height_lg_70"></div>
    <div class="container">
      <div class="cs_section_heading cs_style_1">
        <div class="cs_section_heading_in">
          <h2 class="cs_section_title cs_fs_50 cs_bold cs_fs_48 cs_semibold mb-0">{{ gt('Related Products') }}</h2>
        </div>
        <div class="cs_slider_arrows cs_style_2">
          <div class="cs_left_arrow cs_slider_arrow cs_accent_color">
            <i class="fa-solid fa-chevron-left"></i>
          </div>
          <div class="cs_right_arrow cs_slider_arrow cs_accent_color">
            <i class="fa-solid fa-chevron-right"></i>
          </div>
        </div>
      </div>
      <div class="cs_height_63 cs_height_lg_35"></div>
    </div>
    <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0"
      data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2" data-md-slides="2" data-lg-slides="3"
      data-add-slides="4">
      <div class="cs_slider_wrapper">
        @forelse($relatedProducts ?? [] as $related)
        <div class="slick_slide_in">
          <div class="cs_product cs_style_1">
            <div class="cs_product_thumb position-relative">
              <img src="{{ asset($related->product_image) }}" alt="{{ $related->product_name }}" class="w-100">
              <div class="cs_cart_badge position-absolute">
                <a href="wishlist" class="cs_cart_icon cs_accent_bg cs_white_color">
                  <i class="fa-regular fa-heart"></i>
                </a>
                <a href="{{ route('product.details', $related->id) }}" class="cs_cart_icon cs_accent_bg cs_white_color">
                  <i class="fa-regular fa-eye"></i>
                </a>
              </div>
              <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="id" value="{{ $related->id }}">
                <input type="hidden" name="type" value="own">
                <button type="submit" class="cs_cart_btn cs_accent_bg cs_fs_16 cs_white_color cs_medium position-absolute w-100 text-center border-0" style="bottom: 0">{{ gt('Add To Cart') }}</button>
              </form>
            </div>
            <div class="cs_product_info text-center">
              <h3 class="cs_product_title cs_fs_21 cs_medium">
                <a href="{{ route('product.details', $related->id) }}">{{ $related->product_name }}</a>
              </h3>
              <p class="cs_product_price cs_fs_18 cs_accent_color mb-0 cs_medium">{{ format_currency($related->product_mrp_price) }}</p>
            </div>
          </div>
        </div>
        @empty
        <div class="slick_slide_in">
            <p class="text-center w-100">{{ gt('No related products found') }}</p>
        </div>
        @endforelse
      </div>
    </div>
    <div class="cs_height_134 cs_height_lg_80"></div>
  </section>
  <!-- End new item store -->
  <style>.premium-hero-section{min-height:400px;display:flex;align-items:center;background:linear-gradient(135deg,#1C30A3 0%,#2541C8 50%,#3B5FE0 100%);position:relative;padding:120px 0 180px}.hero-particles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:1}.hero-gradient-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(circle at 20% 50%,rgba(102,126,234,.3) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(240,147,251,.3) 0%,transparent 50%);z-index:1}.hero-content{position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);padding:10px 24px;border-radius:50px;color:white;font-size:14px;font-weight:500;margin-bottom:30px}.premium-hero-title{font-size:56px;font-weight:900;font-family:'Merriweather',serif;color:white;margin:0 0 20px 0;line-height:1.2}.hero-subtitle{font-size:18px;color:rgba(255,255,255,.9);margin:0;max-width:600px;margin-left:auto;margin-right:auto}.hero-wave{position:absolute;bottom:0;left:0;width:100%;overflow:hidden;line-height:0;transform:rotate(180deg)}.hero-wave svg{position:relative;display:block;width:calc(100% + 1.3px);height:80px}.wave-fill{fill:#fff}.cs_height_100{height:100px}.cs_height_140{height:140px}@media(max-width:991px){.cs_height_lg_60{height:60px!important}.cs_height_lg_80{height:80px!important}}</style>
  <script>document.addEventListener('DOMContentLoaded',function(){const e=document.getElementById('heroParticles');if(e){for(let t=0;t<50;t++){const o=document.createElement('div');o.style.cssText=`position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*.5+.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`,e.appendChild(o)}const t=document.createElement('style');t.textContent=`@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`,document.head.appendChild(t)}});</script>
@endsection
