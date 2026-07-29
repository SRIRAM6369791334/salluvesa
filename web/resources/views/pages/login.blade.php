@extends('layouts.app')
@section('content')
  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center" style="z-index: 2;">
      <div class="hero-content">
        <div class="hero-badge">
          <span class="badge-icon">✨</span>
          <span>{{ gt('Account Access') }}</span>
        </div>
        <h1 class="premium-hero-title">{{ gt('Welcome Back') }}</h1>
        <p class="hero-subtitle">{{ gt('Login to access your account and continue shopping') }}</p>
      <div class="row justify-content-center" >
        <div class="cs_height_100 cs_height_lg_60"></div>
      <div class="col-xl-5 col-lg-6 col-md-8">
        <div class="auth-card">
          <h2 class="cs_fs_28 cs_semibold text-center">{{ gt('Login to Your Account') }}</h2>
          <div class="cs_height_40 cs_height_lg_40"></div>
          <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Customer Email ID') }} *</label>
              <div class="form-icon-wrapper">
                <input type="email" name="email" class="premium-form-input" placeholder="{{ gt('Enter your email') }}" value="{{ old('email') }}" required>
                <i class="fa-solid fa-envelope"></i>
              </div>
              @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Password') }} *</label>
              <div class="form-icon-wrapper">
                <input type="password" name="password" class="premium-form-input" placeholder="{{ gt('Enter your password') }}" required>
                <i class="fa-solid fa-lock"></i>
              </div>
              @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="text-end">
              <a href="{{ route('forgot-password') }}" class="cs_medium" style="color: #5E5E5E; text-decoration: none;">{{ gt('Forgot Password?') }}</a>
            </div>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <button type="submit" class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100">{{ gt('Login') }}</button>
            <div class="cs_height_25 cs_height_lg_25"></div>
            <p class="text-center mb-0 cs_medium">
              {{ gt("Don't have an account?") }} <a href="{{ route('register') }}" style="color: #000; text-decoration: underline;">{{ gt('Register') }}</a>
            </p>
          </form>

          @push('scripts')
          <script>
            $(document).ready(function() {
              $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                let formData = $(this).serialize();
                let submitBtn = $(this).find('button[type="submit"]');
                let originalBtnText = submitBtn.text();
                
                submitBtn.prop('disabled', true).text("{{ gt('Logging in...') }}");
                showLoader("{{ gt('Logging in...') }}");
                
                $.ajax({
                  url: "{{ route('login') }}",
                  method: 'POST',
                  data: formData,
                  success: function(response) {
                    if (response.success) {
                      showLoader("{{ gt('Redirecting...') }}");
                      Swal.fire({
                        icon: 'success',
                        title: "{{ gt('Logged In!') }}",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                      }).then(() => {
                        window.location.href = response.redirect;
                      });
                    }
                  },
                  error: function(xhr) {
                    hideLoader();
                    submitBtn.prop('disabled', false).text(originalBtnText);
                    let errorMessage = "{{ gt('The provided credentials do not match our records.') }}";
                    if (xhr.status === 422 || xhr.status === 401) {
                      errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                      icon: 'error',
                      title: "{{ gt('Login Failed') }}",
                      text: errorMessage
                    });
                  }
                });
              });
            });
          </script>
          @endpush
        </div>
      </div>
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

  <!-- Login Form Section -->


  <style>
    /* Premium Hero Section */
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
      background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
                  radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.3) 0%, transparent 50%);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
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
      max-width: 600px;
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
      fill: #ffffff;
    }
    .cs_height_100 { height: 100px; }
    .cs_height_140 { height: 140px; }
    @media (max-width: 991px) {
      .cs_height_lg_60 { height: 60px !important; }
      .cs_height_lg_80 { height: 80px !important; }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const heroParticles = document.getElementById('heroParticles');
      if (heroParticles) {
        for (let i = 0; i < 50; i++) {
          const particle = document.createElement('div');
          particle.style.cssText = `
            position: absolute;
            width: ${Math.random() * 4 + 2}px;
            height: ${Math.random() * 4 + 2}px;
            background: rgba(255, 255, 255, ${Math.random() * 0.5 + 0.2});
            border-radius: 50%;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation: float ${Math.random() * 10 + 10}s infinite ease-in-out;
            animation-delay: ${Math.random() *5}s;
          `;
          heroParticles.appendChild(particle);
        }
        const style = document.createElement('style');
        style.textContent = `
          @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
            25% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.2); opacity: 0.6; }
            50% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(0.8);  opacity: 0.4; }
            75% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.1); opacity: 0.5; }
          }
        `;
        document.head.appendChild(style);
      }
    });
  </script>

@endsection
