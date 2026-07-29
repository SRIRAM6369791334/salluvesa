@extends('layouts.app')

@section('content')
  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section">
    <div id="heroParticles"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="container position-relative text-center" style="z-index: 2;">
      <div class="hero-content">
        <div class="hero-badge reveal-text">
          <span class="badge-icon">📦</span>
          <span>{{ gt('Premium Bulk Solutions') }}</span>
        </div>
        <h1 class="hero-title reveal-text">{{ gt('Scale Your Vision with Ease') }}</h1>
        <p class="hero-desc reveal-text">{{ gt('From corporate apparel to event merchandise, we deliver premium quality at scale with unmatched precision.') }}</p>
      </div>
    </div>
    <div class="hero-wave-container">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="hero-wave-svg">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#fff"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#fff"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#fff"></path>
      </svg>
    </div>
  </section>

  <!-- Section 1: Features Overlay -->
  <section class="features-overlay-section">
    <div class="container">
        <div class="row g-4 text-center justify-content-center">
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon">💰</div>
                    <h4 class="benefit-title">{{ gt('Best Rates') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Guaranteed wholesale pricing') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon">🎨</div>
                    <h4 class="benefit-title">{{ gt('Custom Art') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Your vision, our creation') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon">⚡</div>
                    <h4 class="benefit-title">{{ gt('Express') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Swift production & shipping') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon">🛡️</div>
                    <h4 class="benefit-title">{{ gt('Quality') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('100% Satisfaction guaranteed') }}</p>
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- Section 2: Why Choose Us -->
  <section class="why-choose-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <div class="section-header">
                <span class="section-badge">{{ gt('Why Saaluvesa?') }}</span>
                <h2 class="section-title">{{ gt('Premium Quality, Every Single Thread') }}</h2>
                <div class="title-underline"></div>
                <p class="text-muted section-desc">
                    {{ gt('We combine traditional craftsmanship with modern technology to produce merchandise that stands out. Whether it\'s for corporate branding, sports teams, or special events, we ensure every thread counts.') }}
                </p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="info-item-card">
                        <h6 class="info-item-title">💎 {{ gt('Premium Fabrics') }}</h6>
                        <p class="info-item-desc">{{ gt('100% Combed cotton & biowashed fabric for maximum comfort and durability.') }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="info-item-card">
                        <h6 class="info-item-title">🎨 {{ gt('Vibrant Printing') }}</h6>
                        <p class="info-item-desc">{{ gt('High-definition DTF, Screen, and durable Embroidery options that never fade.') }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="expert-guide-box">
                        <div class="expert-icon">🤝</div>
                        <h5 class="expert-title">{{ gt('One-on-One Expert Guidance') }}</h5>
                        <p class="expert-desc">{{ gt('Our dedicated account managers guide you through every step, from design refinements to final logistics.') }}</p>
                        <a href="https://wa.me/919597538270" class="custom-cta-btn">
                            <i class="fab fa-whatsapp"></i> {{ gt('Chat on WhatsApp') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-lg-0 mt-5">
            <div class="hero-image-container">
                <img src="/img/card4.jpg" alt="Bulk Products" class="why-choose-img">
                <div class="floating-badge">
                    <h4 class="floating-badge-num">500+</h4>
                    <p class="floating-badge-text">{{ gt('Trusted Partners') }}</p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 3: The Inquiry Form -->
  <section id="bulkOrderFormSection" class="form-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-11">
          <div class="form-card">
            <div class="form-content">
                <div class="form-header-center">
                    <span class="form-label-badge">{{ gt('Get Started') }}</span>
                    <h2 class="form-main-title">{{ gt('Tailor Your Bulk Order') }}</h2>
                    <p class="text-muted form-subtitle">{{ gt('Fill in your specs and our specialist will handle the rest.') }}</p>
                </div>
                
                <form id="bulkOrderForm" action="{{ route('bulk.order.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> {{ gt('Full Name') }} *</label>
                          <div class="form-icon-wrapper">
                            <input type="text" name="name" class="premium-form-input guest-guard" value="{{ Auth::check() ? Auth::user()->name : '' }}" {{ Auth::check() ? 'readonly' : '' }} required>
                            <i class="fa-solid fa-user"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> {{ gt('Email Address') }} *</label>
                          <div class="form-icon-wrapper">
                            <input type="email" name="email" class="premium-form-input guest-guard" value="{{ Auth::check() ? Auth::user()->email : '' }}" {{ Auth::check() ? 'readonly' : '' }} required>
                            <i class="fa-solid fa-envelope"></i>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label">{{ gt('Account Type') }} *</label>
                          @if(Auth::check())
                            <select class="premium-form-input premium-form-select" disabled style="background: #f8f9fa;">
                              <option value="Normal User" {{ Auth::user()->user_type == 'Normal User' ? 'selected' : '' }}>{{ gt('Normal User') }}</option>
                              <option value="B2B" {{ Auth::user()->user_type == 'B2B' ? 'selected' : '' }}>{{ gt('B2B') }}</option>
                            </select>
                            <input type="hidden" name="user_type" id="user_type_field" value="{{ Auth::user()->user_type }}">
                          @else
                            <select name="user_type" id="user_type_field" class="premium-form-input premium-form-select guest-guard" required>
                              <option value="Normal User">{{ gt('Normal User') }}</option>
                              <option value="B2B">{{ gt('B2B') }}</option>
                            </select>
                          @endif
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> {{ gt('Approximate Quantity') }} <span id="quantity_limit_badge" style="font-size: 11px; color: #1C30A3; margin-left: 5px; opacity: 0.8;"></span> *</label>
                          <div class="form-icon-wrapper">
                            <input type="number" name="quantity" id="quantity_input" class="premium-form-input guest-guard" min="1" required placeholder="{{ gt('e.g. 50') }}">
                            <i class="fa-solid fa-layer-group"></i>
                          </div>
                        </div>
                      </div>
          
                      <div class="col-12">
                        <div class="premium-form-group">
                          <label class="premium-form-label">{{ gt('Customization Style') }} *</label>
                          <select name="product_type" id="product_type" class="premium-form-input premium-form-select guest-guard" required>
                            <option value="">{{ gt('Select Option') }}</option>
                            <option value="own_design">{{ gt('Our Catalog (Own Design)') }}</option>
                            <option value="custom_design">{{ gt('My Custom Designs') }}</option>
                            <option value="own_custom">{{ gt('Upload My Own Image/Logo') }}</option>
                          </select>
                        </div>
                      </div>
       
                        <!-- Conditional Fields -->
                        <div class="col-12 product-selection-div" id="own_design_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label">{{ gt('Select from Catalog') }} *</label>
                            <select name="product_id" class="premium-form-input premium-form-select">
                                <option value="">{{ gt('Select a product') }}</option>
                                @foreach($ownDesigns as $design)
                                    <option value="{{ $design->id }}">{{ $design->title }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
          
                        <div class="col-12 product-selection-div" id="custom_design_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label">{{ gt('Your Saved Design') }} *</label>
                            @if(Auth::check())
                              @if(count($userCustomDesigns) > 0)
                                <select name="product_id" class="premium-form-input premium-form-select">
                                    <option value="">{{ gt('Select design') }}</option>
                                    @foreach($userCustomDesigns as $custom)
                                        <option value="{{ $custom->id }}">{{ $custom->customproduct->name ?? gt('Unknown Product') }} ({{ $custom->created_at->format('M d') }})</option>
                                    @endforeach
                                </select>
                              @else
                                <div class="alert alert-info py-2" style="border-radius: 12px; font-size: 13px;">
                                    {{ gt('No custom designs found.') }} <a href="{{ route('customize-products.index') }}" class="alert-link">{{ gt('Create one now') }}</a>
                                </div>
                              @endif
                            @else
                              <div class="alert alert-warning py-2" style="border-radius: 12px; font-size: 13px;">
                                  {{ gt('Authenticating required:') }} <a href="{{ route('login') }}" class="alert-link">{{ gt('Login') }}</a> {{ gt('to pick your designs.') }}
                              </div>
                            @endif
                          </div>
                        </div>
          
                        <div class="col-12 product-selection-div" id="own_custom_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label">{{ gt('Upload Your Reference Art') }} *</label>
                            <div class="upload-zone" style="border: 2px dashed #e5e7eb; border-radius: 14px; padding: 25px;">
                              <input type="file" name="custom_image" accept="image/*" class="guest-guard" style="width: 100%;">
                              <div class="upload-text-container mt-2">
                                  <span class="upload-main-text" style="font-size: 13px; color: #6b7280;">{{ gt('Drag & drop or browse files') }}</span>
                                  <span class="upload-sub-text" style="font-size: 11px; color: #9ca3af;">{{ gt('Supports JPG, PNG, SVG (Max 5MB)') }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
          
                      <div class="col-12 mt-2">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> {{ gt('Requirement Details') }}</label>
                          <textarea name="notes" class="premium-form-input guest-guard" rows="5" placeholder="{{ gt('Tell us about sizes, fabric weights, specific colors or event deadlines...') }}" style="resize: vertical;"></textarea>
                        </div>
                      </div>
                    </div>
                    
                    <button type="submit" class="cs_btn cs_style_1 cs_fs_18 cs_medium w-100 mt-4 guest-guard" style="padding: 18px;">{{ gt('Send My Inquiry') }}</button>

                </form>

                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 4: Production Lifecycle -->
  <section class="lifecycle-section">
    <div class="container text-center">
        <div class="lifecycle-header">
            <span class="lifecycle-badge">{{ gt('The Journey') }}</span>
            <h2 class="lifecycle-title">{{ gt('How We Fulfill Your Order') }}</h2>
            <div class="lifecycle-underline"></div>
            <p class="lifecycle-desc">{{ gt('A transparent, streamlined process from your initial inquiry to final doorstep delivery.') }}</p>
        </div>
        <div class="row g-5 px-lg-4">
            <div class="col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        1
                        <div class="step-line d-none d-lg-block"></div>
                    </div>
                    <h5 class="step-title">{{ gt('Inquiry') }}</h5>
                    <p class="step-desc">{{ gt('Submit your requirements through our integrated bulk form.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        2
                        <div class="step-line d-none d-lg-block"></div>
                    </div>
                    <h5 class="step-title">{{ gt('Proposal') }}</h5>
                    <p class="step-desc">{{ gt('Dedicated managers send mockups & quotes within 24 hours.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        3
                        <div class="step-line d-none d-lg-block"></div>
                    </div>
                    <h5 class="step-title">{{ gt('Production') }}</h5>
                    <p class="step-desc">{{ gt('High-quality fabric sourcing & precision printing begins.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">4</div>
                    <h5 class="step-title">{{ gt('Logistics') }}</h5>
                    <p class="step-desc">{{ gt('Real-time tracked shipping to your primary destination.') }}</p>
                </div>
            </div>
        </div>
    </div>
  </section>



  <!-- Section 6: Final Dynamic CTA -->
  <section class="final-cta-section">
      <div class="container">
          <div class="cta-card">
                <div class="cta-pattern-overlay"></div>
                <div class="cta-decor-circle-lg"></div>
                <div class="cta-decor-circle-sm"></div>
                
                <h2 class="cta-title">{{ gt('Fuel Your Brand Today') }}</h2>
                <p class="cta-desc">{{ gt('Join hundreds of elite companies that trust Saaluvesa for their primary merchandise needs.') }}</p>
                <div class="cta-btns-container">
                    <a href="#bulkOrderFormSection" class="cta-btn-primary">{{ gt('Inquire Now') }}</a>
                    <a href="/sample" class="cta-btn-outline">{{ gt('Explore Catalog') }}</a>
                </div>
          </div>
      </div>
  </section>

  @push('scripts')
  <script>
    $(document).ready(function() {
      // Toggle logic for product selection
      $('#product_type').on('change', function() {
        const val = $(this).val();
        $('.product-selection-div').hide();
        // Disable and un-require all conditional inputs to prevent multiple 'product_id' fields being sent
        $('.product-selection-div select, .product-selection-div input').attr('required', false).attr('disabled', true);
        
        if (val) {
          const targetDiv = $(`#${val}_div`);
          targetDiv.fadeIn(400);
          // Enable and require only the active inputs
          targetDiv.find('select, input').attr('required', true).attr('disabled', false).focus();
        }
      });

      // Initialize on load to ensure correct state if product_type is pre-selected
      $('#product_type').trigger('change');

      // Submit form
      $('#bulkOrderForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let submitBtn = $(this).find('button[type="submit"]');
        let originalBtnText = submitBtn.text();
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> {{ gt("Synthesizing...") }}');
        showLoader("{{ gt('Submitting your inquiry...') }}");
        
        $.ajax({
          url: "{{ route('bulk.order.post') }}",
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            hideLoader();
            submitBtn.prop('disabled', false).text(originalBtnText);
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: "{{ gt('Successfully Submitted!') }}",
                text: response.message,
                confirmButtonColor: '#1C30A3',
                confirmButtonText: "{{ gt('Excellent') }}",
                borderRadius: '25px',
                padding: '2rem'
              }).then(() => {
                window.location.reload();
              });
            }
          },
          error: function(xhr) {
            hideLoader();
            submitBtn.prop('disabled', false).text(originalBtnText);
            let errorMessage = "{{ gt('Error processing your request.') }}";
            if (xhr.status === 422) {
              errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
            }
            Swal.fire({
              icon: 'error',
              title: "{{ gt('Inquiry Halted') }}",
              text: errorMessage,
              confirmButtonColor: '#1C30A3'
            });
          }
        });
      });

      // Hero Particles Animation (Minimal for performance)
      const heroContainer = document.getElementById('heroParticles');
      if(heroContainer) {
          for(let i=0; i<35; i++) {
              let p = document.createElement('div');
              p.style.cssText = `position:absolute; width:${Math.random()*4+1}px; height:${Math.random()*4+1}px; background:rgba(255,255,255,${Math.random()*0.4}); border-radius:50%; left:${Math.random()*100}%; top:${Math.random()*100}%; pointer-events:none; transition: all ${Math.random()*2+2}s ease-in-out;`;
              heroContainer.appendChild(p);
          }
      }
    });
  </script>
  <style>

    /* Add specific pointer cursor for accordion */
    .faq-accord-btn { cursor: pointer !important; position: relative; width: 100%; display: flex; align-items: center; justify-content: space-between; }
    
    /* Hero Section Styles */
    .premium-hero-section {
        min-height: 500px; padding: 120px 0 120px; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%); position: relative; overflow: hidden;
    }
    .hero-particles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1; }
    .hero-overlay-gradient {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 20% 50%, rgba(102,126,234,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(240,147,251,0.3) 0%, transparent 50%); z-index: 1;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3); padding: 10px 24px; border-radius: 50px; color: white; font-size: 14px; font-weight: 500; margin-bottom: 30px;
    }
    .hero-title { font-size: clamp(36px, 6vw, 64px); font-weight: 900; font-family: 'Merriweather', serif; color: white; margin: 0 0 20px 0; line-height: 1.1; }
    .hero-desc { font-size: clamp(16px, 2.5vw, 20px); color: rgba(255,255,255,0.9); margin: 0; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6; }
    .hero-wave-container { position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg); }
    .hero-wave-svg { position: relative; display: block; width: calc(100% + 1.3px); height: 80px; }

    /* Features Overlay */
    .features-overlay-section { margin-top: -50px; position: relative; z-index: 10; padding-bottom: 20px; padding-top: 70px; }
    .benefit-box {
        background: white; padding: 35px 20px; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); 
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(0,0,0,0.03);
    }
    .benefit-box:hover { transform: translateY(-12px); box-shadow: 0 20px 45px rgba(28,48,163,0.12) !important; border-bottom: 5px solid #1C30A3 !important; }
    .benefit-icon { font-size: 44px; margin-bottom: 20px; filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1)); }
    .benefit-title { font-size: 18px; font-weight: 700; color: #1C30A3; margin-bottom: 8px; }

    /* Why Choose Section */
    .why-choose-section { padding: 120px 0 80px; background: #fff; }
    .section-header { margin-bottom: 35px; }
    .section-badge {
        display: inline-block; padding: 6px 18px; background: #EBF0FF; color: #1C30A3; border-radius: 50px;
        font-size: 13px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;
    }
    .section-title { font-size: clamp(32px, 5vw, 48px); font-weight: 900; color: #222; margin-bottom: 25px; line-height: 1.2; }
    .title-underline { width: 80px; height: 5px; background: #1C30A3; border-radius: 10px; margin-bottom: 30px; }
    .section-desc { font-size: 17px; line-height: 1.8; margin-bottom: 40px; }
    
    .info-item-card { background: #F8FAFF; border-radius: 20px; padding: 30px; border-left: 5px solid #1C30A3; transition: all 0.3s ease; }
    .info-item-card:hover { transform: scale(1.02); background: white !important; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    .info-item-title { font-weight: 700; margin-bottom: 12px; font-size: 16px; }
    .info-item-desc { font-size: 14px; color: #6c757d; margin: 0; line-height: 1.6; }

    .expert-guide-box { background: #1C30A3; color: white; border-radius: 20px; padding: 35px; box-shadow: 0 15px 30px rgba(28,48,163,0.15); position: relative; overflow: hidden; }
    .expert-icon { position: absolute; right: -20px; top: -20px; font-size: 100px; opacity: 0.1; transform: rotate(15deg); }
    .expert-title { font-weight: 700; margin-bottom: 12px; color: white; }
    .expert-desc { font-size: 14px; color: rgba(255,255,255,0.8); margin-bottom: 20px; max-width: 85%; }

    .custom-cta-btn { display: inline-flex; align-items: center; gap: 10px; background: white; color: #1C30A3; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 14px; transition: all 0.3s ease;}
    .custom-cta-btn:hover { background: #f0f0f0 !important; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    .hero-image-container { position: relative; border-radius: 40px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.12); }
    .why-choose-img { width: 100%; height: auto; display: block; filter: brightness(0.95); }
    .floating-badge {
        position: absolute; bottom: 30px; left: 30px; background: white; padding: 25px 40px; border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15); animation: float 3s ease-in-out infinite;
    }
    .floating-badge-num { font-weight: 900; color: #1C30A3; font-size: 32px; margin-bottom: 5px; }
    .floating-badge-text { margin: 0; font-weight: 600; color: #444; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }

    /* Form Styles */
    .form-section { padding: 120px 0; background: #fafafa; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0; }
    .form-card { background: white; border-radius: 40px; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.05); }
    .form-content { padding: clamp(35px, 7vw, 70px); }
    .form-header-center { text-align: center; margin-bottom: 50px; }
    .form-label-badge { color: #1C30A3; font-weight: 700; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; }
    .form-main-title { font-size: clamp(34px, 5vw, 44px); font-weight: 800; margin: 15px 0; color: #222; }
    .form-subtitle { font-size: 16px; max-width: 500px; margin: 0 auto; }
    .form-input-label { font-weight: 700; margin-bottom: 10px; font-size: 14px; color: #333; display: block; }
    .custom-form-input { 
        border-radius: 15px; border: 2px solid #f2f2f2; padding: 15px 20px; width: 100%; font-size: 15px; 
        transition: all 0.3s ease; outline: none; background: #fdfdfd;
    }
    .custom-form-input:focus { border-color: #1C30A3; background: #fff; }
    select.custom-form-input { height: 55px; cursor: pointer; }
    .text-area-custom { height: 140px; resize: none; }
    .submit-query-btn {
        margin-top: 40px; width: 100%; padding: 20px; border-radius: 15px; font-size: 18px; font-weight: 800;
        background: #1C30A3; color: white; border: none; box-shadow: 0 12px 25px rgba(28,48,163,0.25); transition: all 0.3s ease; cursor: pointer;
    }
    .submit-query-btn:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(28,48,163,0.4) !important; filter: brightness(1.1); }
    .form-alert-info { padding: 20px; background: #f8f9fa; border-radius: 15px; font-size: 14px; border: 1px solid #eee; }
    .form-alert-warning { padding: 20px; background: #FFF3CD; border-radius: 15px; font-size: 14px; border: 1px solid #FFEEBA; color: #856404; }
    .alert-link-custom { color: #1C30A3; font-weight: 700; text-decoration: underline; }

    .upload-zone { border: 2px dashed #1C30A3; padding: 40px; border-radius: 20px; text-align: center; background: #F8FAFF; transition: all 0.3s ease; }
    .upload-zone:hover { background: #eff4ff !important; border-color: #3b5fe0 !important; }
    .upload-input { cursor: pointer; position: relative; z-index: 2; }
    .upload-main-text { font-size: 13px; color: #666; display: block; }
    .upload-sub-text { font-size: 11px; color: #999; }

    /* Lifecycle Section */
    .lifecycle-section { padding: 120px 0; background: #fff; }
    .lifecycle-header { margin-bottom: 70px; }
    .lifecycle-badge { display: inline-block; padding: 6px 20px; background: #EBF0FF; color: #1C30A3; border-radius: 50px; font-size: 13px; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; }
    .lifecycle-title { font-size: clamp(34px, 5.5vw, 46px); font-weight: 900; margin-bottom: 20px; color: #222; }
    .lifecycle-underline { width: 70px; height: 4px; background: #1C30A3; border-radius: 10px; margin: 0 auto 25px;}
    .lifecycle-desc { color: #666; max-width: 650px; margin: 0 auto; font-size: 17px; line-height: 1.7; }
    
    .process-step-container { transition: all 0.3s ease; }
    .step-circle {
        width: 85px; height: 85px; background: #1C30A3; color: white; border-radius: 50%; display: flex; 
        align-items: center; justify-content: center; font-weight: 900; font-size: 32px; margin: 0 auto 25px; 
        box-shadow: 0 15px 30px rgba(28,48,163,0.3); border: 8px solid #f8f9fa; position: relative;
    }
    .step-line { position: absolute; width: 100px; height: 2px; background: #eee; right: -100px; top: 50%; z-index: -1; }
    .step-title { font-weight: 800; margin-bottom: 12px; color: #222; }
    .step-desc { font-size: 15px; color: #777; line-height: 1.6; }

    /* FAQ Section */
    .faq-section { padding: 120px 0; background: #fafafa; }
    .faq-left-content { margin-bottom: 40px; }
    .faq-badge { display: inline-block; padding: 6px 18px; background: #F8FAFF; color: #1C30A3; border-radius: 50px; font-size: 12px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; }
    .faq-main-title { font-size: clamp(34px, 5vw, 48px); font-weight: 900; margin-bottom: 25px; color: #222; line-height: 1.1; }
    .faq-sub-desc { color: #666; font-size: 17px; line-height: 1.8; margin-bottom: 45px; }
    .faq-cta-box { padding: 35px; background: #1C30A3; border-radius: 30px; color: white; box-shadow: 0 15px 35px rgba(28,48,163,0.2); }
    .faq-cta-title { color: white; margin-bottom: 12px; font-weight: 700; }
    .faq-cta-desc { font-size: 14px; line-height: 1.6; color: rgba(255,255,255,0.7); margin-bottom: 20px; }
    .faq-contact-btn { display: inline-block; padding: 14px 30px; background: white; color: #1C30A3; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 15px; transition: all 0.3s ease; }

    .faq-accord-item { border: none; margin-bottom: 20px; border-radius: 20px !important; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); transition: transform 0.3s ease; }
    .faq-accord-item:hover { transform: translateY(-3px); }
    .faq-accord-btn { border-radius: 0; padding: 25px 35px !important; font-weight: 700; font-size: 17px !important; background: white !important; color: #222 !important; box-shadow: none !important; }
    .faq-accord-btn:not(.collapsed) { color: #1C30A3 !important; font-size: 18px !important; background-color: #F8FAFF !important;}
    .faq-accord-body { padding: 5px 35px 35px; color: #666; font-size: 16px; background: white; line-height: 1.7; }

    /* Final CTA */
    .final-cta-section { padding: 0 0 120px; background: #fafafa; }
    .cta-card { padding: clamp(60px, 10vw, 100px); background: linear-gradient(135deg, #1C30A3, #3B5FE0); border-radius: 50px; position: relative; overflow: hidden; text-align: center; box-shadow: 0 25px 60px rgba(28,48,163,0.3); }
    .cta-pattern-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background: url('https://www.transparenttextures.com/patterns/cubes.png'); pointer-events: none; }
    .cta-decor-circle-lg { position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -100px; right: -100px; }
    .cta-decor-circle-sm { position: absolute; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; bottom: -50px; left: -50px; }
    
    .cta-title { color: white; font-size: clamp(32px, 6vw, 54px); font-weight: 900; margin-bottom: 25px; position: relative; z-index: 2; line-height: 1.1; }
    .cta-desc { color: rgba(255,255,255,0.85); margin-bottom: 45px; max-width: 650px; margin-left: auto; margin-right: auto; position: relative; z-index: 2; font-size: 18px; line-height: 1.6; }
    .cta-btns-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; position: relative; z-index: 2; }
    
    .cta-btn-primary { padding: 18px 50px; background: white; color: #1C30A3; font-weight: 800; border-radius: 15px; text-decoration: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15); font-size: 16px; transition: all 0.3s ease; }
    .cta-btn-outline { padding: 18px 50px; background: transparent; border: 2px solid rgba(255,255,255,0.4); color: white; font-weight: 800; border-radius: 15px; text-decoration: none; font-size: 16px; transition: all 0.3s ease; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    @media (max-width: 991px) {
        .premium-hero-section { min-height: 400px; padding: 80px 0; }
        .hero-wave-svg { height: 45px; }
        .features-overlay-section { padding-top: 50px; }
    }
  </style>
  <script>
    $(document).ready(function() {
      // Manual accordion toggle fallback (if it still exists in header/footer or other sections)
      $('.faq-accord-btn').on('click', function(e) {
        const targetId = $(this).attr('data-bs-target');
        const $target = $(targetId);
        const $btn = $(this);
        const isExpanded = !$btn.hasClass('collapsed');
        const $parent = $('#bulkOrderAccordion');
        $parent.find('.accordion-collapse').not($target).slideUp(300).removeClass('show');
        $parent.find('.faq-accord-btn').not($btn).addClass('collapsed').attr('aria-expanded', 'false');
        if (isExpanded) {
          $target.slideUp(300, function() { $(this).removeClass('show'); });
          $btn.addClass('collapsed').attr('aria-expanded', 'false');
        } else {
          $target.slideDown(300, function() { $(this).addClass('show'); });
          $btn.removeClass('collapsed').attr('aria-expanded', 'true');
        }
      });

      // Login Guard for Guests
      @if(Auth::guest())
        $('.guest-guard').on('click focus change', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).blur();
            Swal.fire({
                title: "{{ gt('Login Required') }}",
                text: "{{ gt('Please log in to your account to place a bulk order inquiry.') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1C30A3',
                cancelButtonColor: '#ccc',
                confirmButtonText: "{{ gt('Login Now') }}",
                cancelButtonText: "{{ gt('Maybe Later') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
            return false;
        });

        // Prevent form submission for guests
        $('#bulkOrderForm').on('submit', function(e) {
            e.preventDefault();
            return false;
        });
      @endif

      // Dynamic Quantity Limits from DB
      const appSettings = @json($appSettings);
      
      function updateQuantityLimits() {
          const userType = $('#user_type_field').val();
          const productType = $('#product_type').val();
          
          if(!userType || !productType) return;
          
          // Mapping for DB values
          const utMap = { 'Normal User': 'Normal', 'B2B': 'B2B' };
          const ptMap = { 'own_design': 'Own Design', 'custom_design': 'Bulk Custom', 'own_custom': 'Own Custom' };
          
          const dbUT = utMap[userType] || userType;
          const dbPT = ptMap[productType] || productType;
          
          const setting = appSettings.find(s => s.user_type === dbUT && s.product_type === dbPT);
          
          if (setting) {
              const minQ = setting.min_quantity;
              const maxQ = setting.max_quantity;
              
              $('#quantity_input').attr('min', minQ).attr('max', maxQ);
              $('#quantity_limit_badge').text(`(${minQ}-${maxQ} units)`);
              
              // Validate current value
              const currentVal = parseInt($('#quantity_input').val());
              if(currentVal < minQ) $('#quantity_input').val(minQ);
              if(currentVal > maxQ) $('#quantity_input').val(maxQ);
          } else {
              $('#quantity_input').attr('min', 1).removeAttr('max');
              $('#quantity_limit_badge').text('');
          }
      }

      $('#product_type, #user_type_field').on('change', updateQuantityLimits);
      
      // Initialize on load if values exist
      updateQuantityLimits();
    });
  </script>

  @endpush

@endsection