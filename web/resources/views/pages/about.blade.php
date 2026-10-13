@extends('layouts.app')

@section('content')
    <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-gradient-overlay"></div>
    <div class="noise-overlay"></div>
    <div class="mesh-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
    </div>
    <div class="hero-particles" id="heroParticles"></div>
    <div class="container position-relative text-center reveal-up" style="z-index:2">
      <div class="hero-content">
        <div class="glass-badge mb-4 d-inline-flex align-items-center gap-2">
          <span class="badge-icon pulse-glow">✨</span>
          <span>{{ gt('Our Story') }}</span>
        </div>
        <h1 class="premium-hero-title mb-4">{{ gt('About Us') }}</h1>
        <p class="hero-subtitle">{{ gt('Discover our passion for quality and innovation') }}</p>
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
  <!-- End Page Heading -->
  <!-- Start store -->
    <section class="premium-contact-section py-5 mt-xl-5">
    <div class="container py-lg-5">
      <div class="row align-items-center gy-5">
        <div class="col-xl-5">
          <div class="image-wrapper position-relative tilt-element">
            <div class="glass-panel p-2 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(14px); border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 30px 60px rgba(0,0,0,0.05);">
              <img src="img/card4.jpg" alt="Store Image" class="w-100 rounded-4" style="object-fit: cover; aspect-ratio: 4/5;">
            </div>
            <div class="floating-badge position-absolute" style="bottom: 30px; right: -30px; padding: 20px 30px; border-radius: 20px; background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 1); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);">
              <div class="d-flex align-items-center gap-3">
                <div class="badge-icon-wrapper rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(42, 72, 223, 0.1);">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2A48DF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                  </svg>
                </div>
                <div>
                  <h3 class="mb-0 fw-medium" style="font-size: 1rem; color: #4a5568;">{{ gt('Since') }}</h3>
                  <h3 class="mb-0 fw-bold" style="font-size: 1.8rem; color: #1a202c;">2015</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 offset-xl-1">
          <div class="cs_card_info reveal-up">
            <h2 class="fw-bold mb-4" style="font-size: 3rem; letter-spacing: -1px; color: #1a202c;">{{ gt('Know Our Store') }}</h2>
            <p class="text-muted mb-5" style="font-size: 1.1rem; line-height: 1.8; color: #4a5568 !important;">
              {{ gt('Welcome to our online fashion store, where style meets convenience. Explore the latest trends, timeless classics, and everything in between. Elevate your wardrobe with our curated collection of clothing, accessories, and more. Shop with confidence, knowing that quality and fashion are just a click away. Join us in the world of endless possibilities and express your unique style effortlessly. Happy shopping!') }}
            </p>
            
            <div class="feature-rows mb-5 d-flex flex-column gap-3">
              <div class="feature-row d-flex gap-4 align-items-start p-3 rounded-4 interactive-row transition-all">
                <div class="icon-box d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 50px; height: 50px; background: rgba(42, 72, 223, 0.1); color: #2A48DF;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
                <div>
                  <h4 class="fw-bold mb-2" style="font-size: 1.2rem; color: #2d3748;">{{ gt('Fashion industries leading') }}</h4>
                  <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('We are a recognized authority in our field, setting industry standards through expertise and innovation.') }}</p>
                </div>
              </div>
              
              <div class="feature-row d-flex gap-4 align-items-start p-3 rounded-4 interactive-row transition-all">
                <div class="icon-box d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 50px; height: 50px; background: rgba(42, 72, 223, 0.1); color: #2A48DF;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h4l3-9 5 18 3-9h5"/></svg>
                </div>
                <div>
                  <h4 class="fw-bold mb-2" style="font-size: 1.2rem; color: #2d3748;">{{ gt('Express your unique style') }}</h4>
                  <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('We believe in fashion as a form of self-expression. Our diverse range of products ensures that you can find pieces that reflect your individual style.') }}</p>
                </div>
              </div>
            </div>

            <a href="sample" class="btn btn-primary premium-btn px-5 py-3 rounded-pill fw-bold text-white">{{ gt('Shop Now') }}</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End store -->
  <!-- Start video block -->
  <!--<div class="cs_video_block cs_style_1 container-fluid parallax-section">-->
  <!--  <div class="parallax-bg-wrapper">-->
  <!--      <div class="parallax-bg" style="background-image: url('imd');"></div>-->
  <!--  </div>-->
  <!--  <a href="https://www.youtube.com/embed/R_Lf1Au-bqo" class="cs_play_btn_container cs_video_open cs_accent_bg"-->
  <!--    data-modal="video">-->
  <!--    <span class="cs_play_btn">-->
  <!--      <svg width="30" height="33" viewBox="0 0 30 33" fill="none" xmlns="http://www.w3.org/2000/svg">-->
  <!--        <g clip-path="url(#clip0_395_2379)">-->
  <!--          <path-->
  <!--            d="M3.2339 32.9996C3.04784 32.9652 2.86178 32.9394 2.68458 32.905C1.12522 32.5956 0.0620201 31.3581 0 29.7683C0 29.7167 0 29.6652 0 29.605C0 20.8738 0 12.1425 0 3.41127C0 1.8558 0.894861 0.6183 2.3479 0.162831C3.3225 -0.13795 4.24395 -0.0262312 5.12995 0.472206C12.6432 4.7433 20.1477 9.01439 27.661 13.2855C27.8559 13.3972 28.0419 13.5003 28.2369 13.6121C30.6025 14.9871 30.5936 18.0292 28.2191 19.3871C25.2953 21.0542 22.3627 22.7214 19.43 24.3886C14.7342 27.0613 10.0384 29.7253 5.35145 32.4066C4.77555 32.7331 4.16421 32.905 3.50856 32.9996C3.4111 32.9996 3.3225 32.9996 3.2339 32.9996ZM2.1264 16.4996C2.1264 20.8394 2.1264 25.1792 2.1264 29.5105C2.1264 29.9058 2.18842 30.2839 2.49852 30.5761C2.95924 31.0144 3.52628 31.0574 4.17307 30.6878C9.55995 27.6199 14.9557 24.5519 20.3426 21.4839C22.6019 20.1949 24.8612 18.9058 27.1294 17.6253C27.4926 17.4191 27.7584 17.1613 27.847 16.7488C27.9711 16.1386 27.723 15.7089 27.0053 15.305C22.5576 12.7785 18.1099 10.2519 13.671 7.71674C10.4903 5.91205 7.31837 4.10736 4.14649 2.29408C3.83638 2.12221 3.52628 2.01908 3.16302 2.08783C2.4808 2.23393 2.1264 2.70658 2.1264 3.48002C2.1264 7.81986 2.1264 12.1597 2.1264 16.4996Z"-->
  <!--            fill="white" />-->
  <!--        </g>-->
  <!--        <defs>-->
  <!--          <clipPath id="clip0_395_2379">-->
  <!--            <rect width="30" height="33" fill="white" />-->
  <!--          </clipPath>-->
  <!--        </defs>-->
  <!--      </svg>-->
  <!--    </span>-->
  <!--  </a>-->
  <!--</div>-->
  <!-- End video block -->
  <!-- Start Featured -->
    <section class="premium-features-section py-5 position-relative" style="background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 50%, #e2e8f0 100%);">
    <div class="container py-lg-5">
      <div class="row mb-5 justify-content-center reveal-up">
        <div class="col-lg-8 text-center">
          <h2 class="fw-bold mb-3" style="font-size: 3rem; letter-spacing: -1px; color: #1a202c;">{{ gt('Why choose our online offline store') }}</h2>
          <p class="text-muted mx-auto" style="font-size: 1.1rem; line-height: 1.7; max-width: 700px; color: #4a5568 !important;">{{ gt('We believe that winter fashion should be both functional and fabulous. Our Winter Fashion Collection reflects our commitment to quality, comfort, and style. Embrace the season with confidence.') }}</p>
        </div>
      </div>
      
      <div class="bento-grid">
        <!-- Feature 1 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 1;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4338ca;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">{{ gt('Quality Assurance') }}</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('Our products are carefully curated for quality and durability, ensuring that you get the best value for your money.') }}</p>
        </div>
        
        <!-- Feature 2 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 2;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #15803d;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"></path><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"></path></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">{{ gt('Exceptional Customer Service') }}</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('We prioritize your satisfaction. Our responsive support team is here to assist you every step of the way.') }}</p>
        </div>
        
        <!-- Feature 3 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 3;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); color: #be185d;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">User-friendly Experience</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">Our website is designed with you in mind. Enjoy a seamless and intuitive shopping experience from start to finish.</p>
        </div>

        <!-- Feature 4 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 4;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #b45309;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">{{ gt('Fast and Secure Shipping') }}</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('We offer reliable shipping options, delivering your fashion finds safely and swiftly to your doorstep.') }}</p>
        </div>

        <!-- Feature 5 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 5;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #e5e5e5 0%, #d4d4d4 100%); color: #404040;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">Affordable Luxury</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">Discover affordable fashion that doesn't compromise on style. Our competitive prices mean you can look your best payment.</p>
        </div>

        <!-- Feature 6 -->
        <div class="bento-card bg-white p-4 rounded-4 shadow-sm reveal-up transition-all" style="--delay: 6;">
          <div class="icon-wrapper mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #ffe4e6 0%, #fecdd3 100%); color: #e11d48;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
          </div>
          <h4 class="fw-bold mb-3" style="font-size: 1.3rem; color: #2d3748;">{{ gt('Regular Promotions') }}</h4>
          <p class="text-muted mb-0" style="line-height: 1.6;">{{ gt('Keep an eye out for our exclusive deals and promotions, allowing you to save even more on your favorite fashion pieces.') }}</p>
        </div>
      </div>
    </div>
  </section>
  <!-- End Featured -->
  <!-- Start testimonial -->
  <!-- <section class="premium-contact-section">
    <div class="animated-gradient-bg"></div>
    <div class="cs_height_120 cs_height_lg_70"></div>
    <div class="container">
      <h2 class="cs_section_title cs_fs_50 cs_bold mb-0 text-center reveal-text">{{ gt('What Our People Says') }}</h2>
    </div>
    <div class="cs_height_35 cs_height_lg_30"></div>
    <div class="cs_slider position-relative">
      <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0"
        data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="1" data-md-slides="1"  data-lg-slides="1" data-add-slides="1">
        <div class="container">
          <div class="cs_slider_wrapper">
            <div class="slick_slide_in">
              <div class="cs_testimonial cs_style_1 text-center">
                <blockquote class="cs_testimonial_text cs_fs_21 cs_semibold">{{ gt("Shopping at saaluvesa has been an absolute delight! I've had the pleasure of being a customer for the past year, and I can confidently say that this is my go-to online shopping destination. Highly recommend!") }}</blockquote>
                <div class="cs_testimonial_user">
                  <div class="cs_avatar_thumb">
                    <img src="img/user.png" alt="Avatar">
                  </div>
                  <h4 class="cs_avatar_title cs_fs_21 cs_semibold mb-0">{{ gt('Bonal Ahmad') }}</h4>
                  <p class="cs_avatar_subtitle mb-0">{{ gt('From London') }}</p>
                </div>
              </div>
            </div>
            <div class="slick_slide_in">
              <div class="cs_testimonial cs_style_1 text-center">
                <blockquote class="cs_testimonial_text cs_fs_21 cs_semibold">{{ gt("Shopping at saaluvesa has been an absolute delight! I've had the pleasure of being a customer for the past year, and I can confidently say that this is my go-to online shopping destination. Highly recommend!") }}</blockquote>
                <div class="cs_testimonial_user">
                   <div class="cs_avatar_thumb">
                     <img src="img/user2.png" alt="Avatar">
                   </div>
                   <h4 class="cs_avatar_title cs_fs_21 cs_semibold mb-0">{{ gt('Jhon Doe') }}</h4>
                   <p class="cs_avatar_subtitle mb-0">{{ gt('From UK') }}</p>
                </div>
              </div>
            </div>
            <div class="slick_slide_in">
              <div class="cs_testimonial cs_style_1 text-center">
                <blockquote class="cs_testimonial_text cs_fs_21 cs_semibold">{{ gt("Shopping at saaluvesa has been an absolute delight! I've had the pleasure of being a customer for the past year, and I can confidently say that this is my go-to online shopping destination. Highly recommend!") }}</blockquote>
                <div class="cs_testimonial_user">
                   <div class="cs_avatar_thumb">
                     <img src="img/user3.png" alt="Avatar">
                   </div>
                   <h4 class="cs_avatar_title cs_fs_21 cs_semibold mb-0">{{ gt('Kalio Hokeo') }}</h4>
                   <p class="cs_avatar_subtitle mb-0">{{ gt('From London') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_slider_arrows cs_style_1 cs_hide_mobile">
        <div class="cs_left_arrow cs_slider_arrow cs_accent_color">
          <span>
            <svg width="36" height="16" viewBox="0 0 36 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.292892 7.29289C-0.0976295 7.68342 -0.0976295 8.31658 0.292892 8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107 15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41422 8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107 0.928932C7.68054 0.538408 7.04738 0.538408 6.65685 0.928932L0.292892 7.29289ZM36 7L1 7V9L36 9V7Z" fill="currentColor" />
            </svg>
          </span>
        </div>
        <div class="cs_right_arrow cs_slider_arrow cs_accent_color">
          <span>
            <svg width="36" height="16" viewBox="0 0 36 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M35.7071 8.70711C36.0976 8.31659 36.0976 7.68342 35.7071 7.2929L29.3431 0.928935C28.9526 0.53841 28.3195 0.53841 27.9289 0.928935C27.5384 1.31946 27.5384 1.95262 27.9289 2.34315L33.5858 8L27.9289 13.6569C27.5384 14.0474 27.5384 14.6805 27.9289 15.0711C28.3195 15.4616 28.9526 15.4616 29.3431 15.0711L35.7071 8.70711ZM-8.74228e-08 9L35 9L35 7L8.74228e-08 7L-8.74228e-08 9Z" fill="currentColor" />
            </svg>
          </span>
        </div>
      </div>
      <div class="cs_pagination cs_style_2 cs_hide_desktop"></div>
    </div>
    <div class="cs_height_135 cs_height_lg_80"></div>
    
  </section> -->
  <!-- End testimonial -->

    <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #090E28 0%, #1c30a3 50%, #2A48DF 100%);
      --accent-color: #2A48DF;
      --surface-color: #ffffff;
      --text-main: #1a202c;
      --text-muted: #4a5568;
      --font-premium: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6, .premium-hero-title {
      font-family: var(--font-premium);
      letter-spacing: -0.02em;
    }

    /* Hero Section */
    .premium-hero-section {
      min-height: 500px;
      display: flex;
      align-items: center;
      background: var(--primary-gradient);
      position: relative;
      padding: 100px 0 120px;
    }
    
    @media (min-width: 992px) {
      .premium-hero-section { padding: 140px 0 200px; }
    }
    
    .hero-gradient-overlay {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.3) 0%, transparent 60%),
                  radial-gradient(circle at bottom left, rgba(42, 72, 223, 0.4) 0%, transparent 60%);
      animation: meshGlow 10s ease-in-out infinite alternate;
      z-index: 0;
    }

    .noise-overlay {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
      opacity: 0.05;
      pointer-events: none;
      z-index: 1;
    }

    @keyframes meshGlow {
      0% { opacity: 0.5; filter: hue-rotate(0deg); }
      100% { opacity: 1; filter: hue-rotate(15deg); }
    }
    
    .mesh-bg {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      overflow: hidden;
      z-index: 0;
    }
    
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.7;
    }
    
    .orb-1 {
      width: 300px; height: 300px;
      background: radial-gradient(circle, #7B35D8 0%, transparent 70%);
      top: -50px; left: -50px;
      animation: orbFloat 14s infinite ease-in-out alternate;
    }
    
    .orb-2 {
      width: 250px; height: 250px;
      background: radial-gradient(circle, #00C6FF 0%, transparent 70%);
      bottom: 0; right: -20px;
      animation: orbFloat 18s infinite ease-in-out alternate-reverse;
    }

    @media (min-width: 992px) {
      .orb-1 { width: 450px; height: 450px; top: -100px; left: -100px; }
      .orb-2 { width: 350px; height: 350px; right: -50px; }
    }

    @keyframes orbFloat {
      0% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(30px, -50px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
      100% { transform: translate(0, 0) scale(1); }
    }
    
    .hero-particles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
    .hero-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
    
    .glass-badge {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 8px 24px;
      border-radius: 50px;
      color: white;
      font-size: 14px;
      font-weight: 600;
    }
    
    .pulse-glow {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { text-shadow: 0 0 0 rgba(255,255,255,0.5); }
      50% { text-shadow: 0 0 15px rgba(255,255,255,1); }
      100% { text-shadow: 0 0 0 rgba(255,255,255,0.5); }
    }
    
    .premium-hero-title {
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      font-weight: 900;
      color: white;
      line-height: 1.1;
      text-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .hero-subtitle {
      font-size: clamp(1.1rem, 2vw, 1.3rem);
      color: rgba(255, 255, 255, 0.9);
    }
    
    .hero-wave { position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0; transform: rotate(180deg); z-index: 2;}
    .hero-wave svg { width: calc(100% + 2px); height: 80px; }
    .wave-fill { fill: #ffffff; }

    /* Know Our Store */
    .glass-panel-accent {
      background: var(--accent-color);
      color: white;
    }

    .tilt-element {
      transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
      perspective: 1000px;
      transform-style: preserve-3d;
    }
    .tilt-element:hover {
      transform: rotateX(2deg) rotateY(-2deg) scale3d(1.02, 1.02, 1.02);
    }
    
    .interactive-row {
      background: transparent;
      border: 1px solid transparent;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .interactive-row:hover {
      background: rgba(42, 72, 223, 0.03);
      border-color: rgba(42, 72, 223, 0.15);
      transform: translateX(10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }
    
    .premium-btn {
      background: var(--accent-color);
      border: none;
      box-shadow: 0 10px 20px rgba(42, 72, 223, 0.3);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    .premium-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 25px rgba(42, 72, 223, 0.4);
      background: #1c30a3;
    }

    /* Bento Grid */
    .bento-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }
    
    @media (min-width: 992px) {
      .bento-grid {
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: minmax(200px, auto);
      }
    }
    
    .bento-card {
      border: 1px solid rgba(0,0,0,0.05);
      border-radius: 24px;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .bento-card:hover {
      transform: translateY(-10px) scale(1.015);
      box-shadow: 0 20px 50px rgba(28, 48, 163, 0.22), 0 0 25px rgba(99, 102, 241, 0.15) !important;
      border-color: rgba(99, 102, 241, 0.6);
    }

    .icon-wrapper {
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .bento-card:hover .icon-wrapper {
      transform: scale(1.15) rotate(-5deg);
    }
    
    /* Utilities */
    .transition-all { transition: all 0.3s ease; }
    .reveal-up {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .reveal-up.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    @keyframes float {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(30px, 30px) scale(1.05); }
    }
  </style>
  <script>document.addEventListener('DOMContentLoaded',function(){const e=document.getElementById('heroParticles');if(e){for(let t=0;t<50;t++){const o=document.createElement('div');o.style.cssText=`position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*.5+.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`,e.appendChild(o)}const t=document.createElement('style');t.textContent=`@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`,document.head.appendChild(t)}});</script>
  <script src="/js/site-animations.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const delay = entry.target.style.getPropertyValue('--delay') || 0;
            setTimeout(() => {
              entry.target.classList.add('is-visible');
            }, delay * 100);
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
      
      document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
    });
  </script>
@endsection