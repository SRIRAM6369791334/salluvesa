@extends('layouts.app')

@section('content')
  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section">
    <div id="heroParticles"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="container position-relative text-center" style="z-index: 2;">
      <div class="hero-content">
        <div class="hero-badge reveal-text">
          <i class="fa-solid fa-box-archive badge-icon me-2"></i>
          <span>{{ gt('Premium Bulk Solutions') }}</span>
        </div>
        <h1 class="hero-title reveal-text">{{ gt('Scale Your Vision with Ease') }}</h1>
        <p class="hero-desc reveal-text">{{ gt('From corporate apparel to event merchandise, we deliver premium quality at scale with unmatched precision.') }}</p>
        
        <!-- Hero Quick Stats -->
        <div class="hero-stats-container mt-5">
          <div class="row g-3 justify-content-center">
            <div class="col-6 col-md-3">
              <div class="hero-stat-card">
                <div class="stat-num">500+</div>
                <div class="stat-label">{{ gt('Corporate Clients') }}</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="hero-stat-card">
                <div class="stat-num">99.8%</div>
                <div class="stat-label">{{ gt('On-Time Delivery') }}</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="hero-stat-card">
                <div class="stat-num">100k+</div>
                <div class="stat-label">{{ gt('Units Crafted') }}</div>
              </div>
            </div>
          </div>
        </div>
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
                    <div class="benefit-icon-badge">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h4 class="benefit-title">{{ gt('Best Rates') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Guaranteed wholesale pricing') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon-badge">
                        <i class="fa-solid fa-pen-ruler"></i>
                    </div>
                    <h4 class="benefit-title">{{ gt('Custom Art') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Your vision, our creation') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon-badge">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <h4 class="benefit-title">{{ gt('Express') }}</h4>
                    <p class="small text-muted mb-0">{{ gt('Swift production & shipping') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="benefit-box">
                    <div class="benefit-icon-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
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
                <span class="section-badge"><i class="fa-solid fa-star me-1"></i> {{ gt('Why Saaluvesa?') }}</span>
                <h2 class="section-title">{{ gt('Premium Quality, Every Single Thread') }}</h2>
                <div class="title-underline"></div>
                <p class="text-muted section-desc">
                    {{ gt('We combine traditional craftsmanship with modern technology to produce merchandise that stands out. Whether it\'s for corporate branding, sports teams, or special events, we ensure every thread counts.') }}
                </p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="info-item-card">
                        <h6 class="info-item-title"><i class="fa-solid fa-gem text-primary me-2"></i>{{ gt('Premium Fabrics') }}</h6>
                        <p class="info-item-desc">{{ gt('100% Combed cotton & biowashed fabric for maximum comfort and durability.') }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="info-item-card">
                        <h6 class="info-item-title"><i class="fa-solid fa-palette text-primary me-2"></i>{{ gt('Vibrant Printing') }}</h6>
                        <p class="info-item-desc">{{ gt('High-definition DTF, Screen, and durable Embroidery options that never fade.') }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="expert-guide-box">
                        <div class="expert-icon"><i class="fa-solid fa-headset"></i></div>
                        <h5 class="expert-title">{{ gt('One-on-One Expert Guidance') }}</h5>
                        <p class="expert-desc">{{ gt('Our dedicated account managers guide you through every step, from design refinements to final logistics.') }}</p>
                        <a href="https://wa.me/919597538270" target="_blank" rel="noopener noreferrer" class="custom-cta-btn">
                            <i class="fab fa-whatsapp me-2"></i> {{ gt('Chat on WhatsApp') }}
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
                    <span class="form-label-badge"><i class="fa-solid fa-paper-plane me-1"></i> {{ gt('Get Started') }}</span>
                    <h2 class="form-main-title">{{ gt('Tailor Your Bulk Order') }}</h2>
                    <p class="text-muted form-subtitle">{{ gt('Fill in your specs and our specialist will handle the rest.') }}</p>
                </div>

                <!-- Form Step Pills Indicator -->
                <div class="form-steps-indicator mb-5">
                  <div class="step-pill active" id="stepPill1">
                    <span class="pill-number">1</span>
                    <span class="pill-text">{{ gt('Contact Details') }}</span>
                  </div>
                  <div class="step-pill-line"></div>
                  <div class="step-pill" id="stepPill2">
                    <span class="pill-number">2</span>
                    <span class="pill-text">{{ gt('Order Specs') }}</span>
                  </div>
                  <div class="step-pill-line"></div>
                  <div class="step-pill" id="stepPill3">
                    <span class="pill-number">3</span>
                    <span class="pill-text">{{ gt('Customization') }}</span>
                  </div>
                </div>
                
                <form id="bulkOrderForm" action="{{ route('bulk.order.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> <i class="fa-solid fa-user me-1 text-primary"></i> {{ gt('Full Name') }} *</label>
                          <div class="form-icon-wrapper">
                            <input type="text" name="name" class="premium-form-input guest-guard" value="{{ Auth::check() ? Auth::user()->name : '' }}" {{ Auth::check() ? 'readonly' : '' }} required placeholder="{{ gt('Enter your full name') }}">
                            <i class="fa-solid fa-id-badge input-icon"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> <i class="fa-solid fa-envelope me-1 text-primary"></i> {{ gt('Email Address') }} *</label>
                          <div class="form-icon-wrapper">
                            <input type="email" name="email" class="premium-form-input guest-guard" value="{{ Auth::check() ? Auth::user()->email : '' }}" {{ Auth::check() ? 'readonly' : '' }} required placeholder="{{ gt('name@company.com') }}">
                            <i class="fa-solid fa-envelope-open input-icon"></i>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"><i class="fa-solid fa-building me-1 text-primary"></i> {{ gt('Account Type') }} *</label>
                          <div class="form-icon-wrapper">
                            @if(Auth::check())
                              <select class="premium-form-input premium-form-select" disabled style="background: #f8f9fa;">
                                <option value="Normal User" {{ Auth::user()->user_type == 'Normal User' ? 'selected' : '' }}>{{ gt('Normal User') }}</option>
                                <option value="B2B" {{ Auth::user()->user_type == 'B2B' ? 'selected' : '' }}>{{ gt('B2B Enterprise') }}</option>
                              </select>
                              <input type="hidden" name="user_type" id="user_type_field" value="{{ Auth::user()->user_type }}">
                            @else
                              <select name="user_type" id="user_type_field" class="premium-form-input premium-form-select guest-guard" required>
                                <option value="Normal User">{{ gt('Normal User') }}</option>
                                <option value="B2B">{{ gt('B2B Enterprise') }}</option>
                              </select>
                            @endif
                            <i class="fa-solid fa-user-gear input-icon"></i>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> <i class="fa-solid fa-layer-group me-1 text-primary"></i> {{ gt('Approximate Quantity') }} <span id="quantity_limit_badge" class="badge bg-primary-soft text-primary ms-2" style="font-size: 11px;"></span> *</label>
                          <div class="form-icon-wrapper">
                            <input type="number" name="quantity" id="quantity_input" class="premium-form-input guest-guard" min="1" required placeholder="{{ gt('e.g. 50') }}">
                            <i class="fa-solid fa-boxes-stacked input-icon"></i>
                          </div>
                        </div>
                      </div>
          
                      <div class="col-12">
                        <div class="premium-form-group">
                          <label class="premium-form-label"><i class="fa-solid fa-paintbrush me-1 text-primary"></i> {{ gt('Customization Style') }} *</label>
                          
                          <!-- Visual Style Selector Cards -->
                          <div class="style-cards-grid mb-3">
                            <div class="style-choice-card active" data-value="own_design">
                              <div class="card-icon"><i class="fa-solid fa-shirt"></i></div>
                              <div class="card-title">{{ gt('Our Catalog') }}</div>
                              <div class="card-sub">{{ gt('Choose existing design') }}</div>
                            </div>
                            <div class="style-choice-card" data-value="custom_design">
                              <div class="card-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                              <div class="card-title">{{ gt('My Custom Designs') }}</div>
                              <div class="card-sub">{{ gt('Pick saved creations') }}</div>
                            </div>
                            <!-- <div class="style-choice-card" data-value="own_custom">
                              <div class="card-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                              <div class="card-title">{{ gt('Upload Image/Logo') }}</div>
                              <div class="card-sub">{{ gt('Upload custom reference') }}</div>
                            </div> -->
                          </div>

                          <!-- Native Select Field (Hidden/Synced) -->
                          <select name="product_type" id="product_type" class="premium-form-input premium-form-select guest-guard visually-hidden" required>
                            <option value="">{{ gt('Select Option') }}</option>
                            <option value="own_design" selected>{{ gt('Our Catalog (Our Design)') }}</option>
                            <option value="custom_design">{{ gt('My Custom Designs') }}</option>
                            <option value="own_custom">{{ gt('Upload My Own Image/Logo') }}</option>
                          </select>
                        </div>
                      </div>
       
                        <!-- Conditional Fields -->
                        <div class="col-12 product-selection-div" id="own_design_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label"><i class="fa-solid fa-list-check me-1 text-primary"></i> {{ gt('Select from Catalog') }} *</label>
                            <div class="form-icon-wrapper">
                              <select name="product_id" class="premium-form-input premium-form-select">
                                  <option value="">{{ gt('Select a product') }}</option>
                                  @foreach($ownDesigns as $design)
                                      <option value="{{ $design->id }}">{{ $design->title }}</option>
                                  @endforeach
                              </select>
                              <i class="fa-solid fa-store input-icon"></i>
                            </div>
                          </div>
                        </div>
          
                        <div class="col-12 product-selection-div" id="custom_design_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label"><i class="fa-solid fa-palette me-1 text-primary"></i> {{ gt('Your Saved Design') }} *</label>
                            @if(Auth::check())
                              @if(count($userCustomDesigns) > 0)
                                <div class="form-icon-wrapper">
                                  <select name="product_id" class="premium-form-input premium-form-select">
                                      <option value="">{{ gt('Select design') }}</option>
                                      @foreach($userCustomDesigns as $custom)
                                          <option value="{{ $custom->id }}">{{ $custom->customproduct->name ?? gt('Unknown Product') }} ({{ $custom->created_at->format('M d') }})</option>
                                      @endforeach
                                  </select>
                                  <i class="fa-solid fa-folder-open input-icon"></i>
                                </div>
                              @else
                                <div class="alert alert-info d-flex align-items-center py-3" style="border-radius: 14px; font-size: 14px;">
                                    <i class="fa-solid fa-circle-info fa-lg me-3"></i>
                                    <div>
                                      {{ gt('No custom designs found.') }} <a href="{{ route('customize-products.index') }}" class="alert-link text-decoration-underline ms-1">{{ gt('Create one now') }}</a>
                                    </div>
                                </div>
                              @endif
                            @else
                              <div class="alert alert-warning d-flex align-items-center py-3" style="border-radius: 14px; font-size: 14px;">
                                  <i class="fa-solid fa-lock fa-lg me-3"></i>
                                  <div>
                                    {{ gt('Authentication required:') }} <a href="{{ route('login') }}" class="alert-link text-decoration-underline mx-1">{{ gt('Login') }}</a> {{ gt('to pick your designs.') }}
                                  </div>
                              </div>
                            @endif
                          </div>
                        </div>
          
                        <div class="col-12 product-selection-div" id="own_custom_div" style="display: none;">
                          <div class="premium-form-group">
                            <label class="premium-form-label"><i class="fa-solid fa-file-arrow-up me-1 text-primary"></i> {{ gt('Upload Your Reference Art') }} *</label>
                            <div class="upload-zone position-relative">
                              <input type="file" name="custom_image" id="custom_image_input" accept="image/*" class="guest-guard upload-input-hidden">
                              <div class="upload-zone-content">
                                  <div class="upload-icon-circle mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                  </div>
                                  <span class="upload-main-text font-weight-bold" id="upload_file_name">{{ gt('Drag & drop or browse files') }}</span>
                                  <span class="upload-sub-text text-muted mt-1">{{ gt('Supports JPG, PNG, SVG (Max 5MB)') }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
          
                      <div class="col-12 mt-2">
                        <div class="premium-form-group">
                          <label class="premium-form-label"> <i class="fa-solid fa-clipboard-list me-1 text-primary"></i> {{ gt('Requirement Details') }}</label>
                          <textarea name="notes" class="premium-form-input guest-guard" rows="4" placeholder="{{ gt('Tell us about sizes, fabric weights, specific colors or event deadlines...') }}" style="resize: vertical;"></textarea>
                        </div>
                      </div>
                    </div>
                    
                    <button type="submit" class="submit-query-btn w-100 mt-4 guest-guard">
                      <i class="fa-solid fa-paper-plane me-2"></i> {{ gt('Send My Inquiry') }}
                    </button>
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
            <span class="lifecycle-badge"><i class="fa-solid fa-route me-1"></i> {{ gt('The Journey') }}</span>
            <h2 class="lifecycle-title">{{ gt('How We Fulfill Your Order') }}</h2>
            <div class="lifecycle-underline"></div>
            <p class="lifecycle-desc">{{ gt('A transparent, streamlined process from your initial inquiry to final doorstep delivery.') }}</p>
        </div>
        <div class="row g-4 g-lg-5 px-lg-4">
            <div class="col-6 col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        <i class="fa-solid fa-file-pen"></i>
                        <span class="step-number">1</span>
                    </div>
                    <h5 class="step-title">{{ gt('Inquiry') }}</h5>
                    <p class="step-desc">{{ gt('Submit your requirements through our integrated bulk form.') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        <i class="fa-solid fa-comments-dollar"></i>
                        <span class="step-number">2</span>
                    </div>
                    <h5 class="step-title">{{ gt('Proposal') }}</h5>
                    <p class="step-desc">{{ gt('Dedicated managers send mockups & quotes within 24 hours.') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        <i class="fa-solid fa-shirt"></i>
                        <span class="step-number">3</span>
                    </div>
                    <h5 class="step-title">{{ gt('Production') }}</h5>
                    <p class="step-desc">{{ gt('High-quality fabric sourcing & precision printing begins.') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="process-step-container">
                    <div class="step-circle">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span class="step-number">4</span>
                    </div>
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
                    <a href="#bulkOrderFormSection" class="cta-btn-primary"><i class="fa-solid fa-paper-plane me-2"></i> {{ gt('Inquire Now') }}</a>
                    <a href="/sample" class="cta-btn-outline"><i class="fa-solid fa-table-cells me-2"></i> {{ gt('Explore Catalog') }}</a>
                </div>
          </div>
      </div>
  </section>

  @push('scripts')
  <script>
    $(document).ready(function() {
      // Style Cards Click Handler
      $('.style-choice-card').on('click', function() {
        $('.style-choice-card').removeClass('active');
        $(this).addClass('active');
        const selectedVal = $(this).data('value');
        $('#product_type').val(selectedVal).trigger('change');
      });

      // File upload zone name display
      $('#custom_image_input').on('change', function() {
        if(this.files && this.files[0]) {
          $('#upload_file_name').text(this.files[0].name);
        } else {
          $('#upload_file_name').text("{{ gt('Drag & drop or browse files') }}");
        }
      });

      // Step pills indicator update on focus
      $('input[name="name"], input[name="email"], select[name="user_type"]').on('focus', function() {
        $('.step-pill').removeClass('active');
        $('#stepPill1').addClass('active');
      });
      $('input[name="quantity"]').on('focus', function() {
        $('.step-pill').removeClass('active');
        $('#stepPill2').addClass('active');
      });
      $('#product_type, textarea[name="notes"]').on('focus', function() {
        $('.step-pill').removeClass('active');
        $('#stepPill3').addClass('active');
      });

      // Toggle logic for product selection
      $('#product_type').on('change', function() {
        const val = $(this).val();
        
        // Sync active style card
        $('.style-choice-card').removeClass('active');
        $(`.style-choice-card[data-value="${val}"]`).addClass('active');

        $('.product-selection-div').hide();
        // Disable and un-require all conditional inputs to prevent multiple 'product_id' fields being sent
        $('.product-selection-div select, .product-selection-div input').attr('required', false).attr('disabled', true);
        
        if (val) {
          const targetDiv = $(`#${val}_div`);
          targetDiv.fadeIn(400);
          // Enable and require only the active inputs
          targetDiv.find('select, input').attr('required', true).attr('disabled', false);
        }
      });

      // Initialize on load to ensure correct state if product_type is pre-selected
      $('#product_type').trigger('change');

      // Submit form
      $('#bulkOrderForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let submitBtn = $(this).find('button[type="submit"]');
        let originalBtnHtml = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> {{ gt("Submitting...") }}');
        showLoader("{{ gt('Submitting your inquiry...') }}");
        
        $.ajax({
          url: "{{ route('bulk.order.post') }}",
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            hideLoader();
            submitBtn.prop('disabled', false).html(originalBtnHtml);
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
            submitBtn.prop('disabled', false).html(originalBtnHtml);
            let errorMessage = "{{ gt('Error processing your request.') }}";
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
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
    /* Global Section Foundations */
    .faq-accord-btn { cursor: pointer !important; position: relative; width: 100%; display: flex; align-items: center; justify-content: space-between; }
    
    /* Hero Section Styles */
    .premium-hero-section {
        min-height: 540px; padding: 120px 0 130px; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #0F172A 0%, #1C30A3 50%, #2541C8 100%); position: relative; overflow: hidden;
    }
    .hero-particles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1; }
    .hero-overlay-gradient {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 20% 40%, rgba(37,99,235,0.25) 0%, transparent 60%), radial-gradient(circle at 80% 80%, rgba(139,92,246,0.25) 0%, transparent 60%); z-index: 1;
    }
    .hero-badge {
        display: inline-flex; align-items: center; background: rgba(255,255,255,0.12); backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.25); padding: 10px 24px; border-radius: 50px; color: white; font-size: 14px; font-weight: 600; margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .hero-title { font-size: clamp(38px, 5.5vw, 64px); font-weight: 900; font-family: 'Playfair Display', serif; color: white; margin: 0 0 20px 0; line-height: 1.15; letter-spacing: -0.5px; }
    .hero-desc { font-size: clamp(16px, 2.2vw, 20px); color: rgba(255,255,255,0.88); margin: 0 auto; max-width: 720px; line-height: 1.65; }
    
    .hero-stats-container { max-width: 800px; margin: 0 auto; }
    .hero-stat-card {
        background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 18px; padding: 16px 20px; transition: all 0.3s ease;
    }
    .hero-stat-card:hover { transform: translateY(-4px); background: rgba(255, 255, 255, 0.15); }
    .stat-num { font-size: 26px; font-weight: 800; color: #60A5FA; line-height: 1; margin-bottom: 4px; }
    .stat-label { font-size: 12px; color: rgba(255,255,255,0.8); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

    .hero-wave-container { position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg); }
    .hero-wave-svg { position: relative; display: block; width: calc(100% + 1.3px); height: 80px; }

    /* Features Overlay */
    .features-overlay-section { margin-top: -50px; position: relative; z-index: 10; padding-bottom: 20px; padding-top: 70px; }
    .benefit-box {
        background: white; padding: 35px 20px; border-radius: 24px; box-shadow: 0 10px 40px rgba(15,23,42,0.06); 
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .benefit-box:hover { transform: translateY(-10px); box-shadow: 0 20px 45px rgba(28,48,163,0.12) !important; border-bottom: 4px solid #1C30A3 !important; }
    .benefit-icon-badge {
        width: 64px; height: 64px; background: #EBF0FF; color: #1C30A3; border-radius: 50%; display: inline-flex;
        align-items: center; justify-content: center; font-size: 26px; margin-bottom: 18px; transition: all 0.3s ease;
    }
    .benefit-box:hover .benefit-icon-badge { background: #1C30A3; color: white; transform: scale(1.1); }
    .benefit-title { font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 8px; }

    /* Why Choose Section */
    .why-choose-section { padding: 110px 0 80px; background: #fff; }
    .section-header { margin-bottom: 35px; }
    .section-badge {
        display: inline-block; padding: 6px 18px; background: #EBF0FF; color: #1C30A3; border-radius: 50px;
        font-size: 13px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;
    }
    .section-title { font-size: clamp(32px, 4.5vw, 48px); font-weight: 900; color: #0F172A; margin-bottom: 22px; line-height: 1.2; }
    .title-underline { width: 80px; height: 5px; background: #1C30A3; border-radius: 10px; margin-bottom: 25px; }
    .section-desc { font-size: 17px; line-height: 1.8; margin-bottom: 35px; color: #475569; }
    
    .info-item-card { background: #F8FAFC; border-radius: 20px; padding: 28px; border-left: 5px solid #1C30A3; border-top: 1px solid #F1F5F9; border-right: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; transition: all 0.3s ease; }
    .info-item-card:hover { transform: translateY(-4px); background: white !important; box-shadow: 0 12px 30px rgba(0,0,0,0.06); }
    .info-item-title { font-weight: 700; margin-bottom: 10px; font-size: 16px; color: #0F172A; }
    .info-item-desc { font-size: 14px; color: #64748B; margin: 0; line-height: 1.6; }

    .expert-guide-box { background: linear-gradient(135deg, #1C30A3, #2541C8); color: white; border-radius: 24px; padding: 35px; box-shadow: 0 15px 35px rgba(28,48,163,0.2); position: relative; overflow: hidden; }
    .expert-icon { position: absolute; right: -15px; top: -15px; font-size: 90px; opacity: 0.12; color: white; transform: rotate(12deg); }
    .expert-title { font-weight: 700; margin-bottom: 12px; color: white; }
    .expert-desc { font-size: 14px; color: rgba(255,255,255,0.85); margin-bottom: 22px; max-width: 85%; }

    .custom-cta-btn { display: inline-flex; align-items: center; gap: 8px; background: white; color: #1C30A3; padding: 12px 26px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 14px; transition: all 0.3s ease;}
    .custom-cta-btn:hover { background: #f8fafc !important; color: #1C30A3 !important; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

    .hero-image-container { position: relative; border-radius: 36px; overflow: hidden; box-shadow: 0 25px 50px rgba(15,23,42,0.14); }
    .why-choose-img { width: 100%; height: auto; display: block; filter: brightness(0.96); }
    .floating-badge {
        position: absolute; bottom: 25px; left: 25px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 22px 35px; border-radius: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid rgba(255,255,255,0.8); animation: float 3s ease-in-out infinite;
    }
    .floating-badge-num { font-weight: 900; color: #1C30A3; font-size: 32px; margin-bottom: 2px; }
    .floating-badge-text { margin: 0; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase; letter-spacing: 0.8px; }

    /* Form Styles */
    .form-section { padding: 110px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0; }
    .form-card { background: white; border-radius: 36px; overflow: hidden; box-shadow: 0 25px 70px rgba(15,23,42,0.08); border: 1px solid #E2E8F0; }
    .form-content { padding: clamp(30px, 6vw, 65px); }
    .form-header-center { text-align: center; margin-bottom: 40px; }
    .form-label-badge { color: #1C30A3; font-weight: 700; font-size: 13px; letter-spacing: 1.5px; text-transform: uppercase; }
    .form-main-title { font-size: clamp(30px, 4.5vw, 42px); font-weight: 800; margin: 12px 0; color: #0F172A; }
    .form-subtitle { font-size: 16px; max-width: 520px; margin: 0 auto; color: #64748B; }
    
    /* Step Pills */
    .form-steps-indicator { display: flex; align-items: center; justify-content: center; max-width: 600px; margin: 0 auto; }
    .step-pill { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 30px; background: #F1F5F9; color: #64748B; font-weight: 600; font-size: 13px; transition: all 0.3s ease; }
    .step-pill.active { background: #EBF0FF; color: #1C30A3; font-weight: 700; }
    .step-pill .pill-number { width: 22px; height: 22px; border-radius: 50%; background: #CBD5E1; color: white; font-size: 11px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; }
    .step-pill.active .pill-number { background: #1C30A3; }
    .step-pill-line { flex: 1; height: 2px; background: #E2E8F0; margin: 0 10px; }

    /* Inputs */
    .premium-form-group { margin-bottom: 0; }
    .premium-form-label { font-weight: 700; margin-bottom: 10px; font-size: 14px; color: #1E293B; display: block; }
    .form-icon-wrapper { position: relative; }
    .form-icon-wrapper .input-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 15px; pointer-events: none; transition: color 0.3s ease; }
    .premium-form-input { 
        border-radius: 16px; border: 1.5px solid #E2E8F0; padding: 14px 20px 14px 48px; width: 100%; font-size: 15px; 
        transition: all 0.3s ease; outline: none; background: #F8FAFC; color: #0F172A;
    }
    .premium-form-input:focus { border-color: #1C30A3; background: #fff; box-shadow: 0 0 0 4px rgba(28,48,163,0.1); }
    .form-icon-wrapper:focus-within .input-icon { color: #1C30A3; }
    select.premium-form-input { height: 52px; cursor: pointer; }
    
    /* Custom Style Cards */
    .style-cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; }
    .style-choice-card {
        border: 2px solid #E2E8F0; background: #F8FAFC; border-radius: 18px; padding: 18px 14px; text-align: center;
        cursor: pointer; transition: all 0.3s ease; user-select: none;
    }
    .style-choice-card:hover { border-color: #93C5FD; background: white; transform: translateY(-2px); }
    .style-choice-card.active { border-color: #1C30A3; background: #EBF0FF; box-shadow: 0 6px 20px rgba(28,48,163,0.12); }
    .style-choice-card .card-icon { font-size: 24px; color: #64748B; margin-bottom: 8px; transition: color 0.3s ease; }
    .style-choice-card.active .card-icon { color: #1C30A3; }
    .style-choice-card .card-title { font-weight: 700; font-size: 14px; color: #0F172A; margin-bottom: 2px; }
    .style-choice-card .card-sub { font-size: 11px; color: #64748B; }

    /* Upload Zone */
    .upload-zone { border: 2px dashed #CBD5E1; padding: 35px 20px; border-radius: 20px; text-align: center; background: #F8FAFC; transition: all 0.3s ease; cursor: pointer; }
    .upload-zone:hover { background: #EFF6FF; border-color: #1C30A3; }
    .upload-input-hidden { position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; z-index:10; }
    .upload-icon-circle { width: 50px; height: 50px; background: #EBF0FF; color: #1C30A3; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; }

    .submit-query-btn {
        margin-top: 30px; width: 100%; padding: 18px; border-radius: 16px; font-size: 17px; font-weight: 800;
        background: linear-gradient(135deg, #1C30A3, #2541C8); color: white; border: none; box-shadow: 0 12px 25px rgba(28,48,163,0.25); transition: all 0.3s ease; cursor: pointer;
    }
    .submit-query-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(28,48,163,0.38) !important; filter: brightness(1.05); }

    /* Lifecycle Section */
    .lifecycle-section { padding: 110px 0; background: #fff; }
    .lifecycle-header { margin-bottom: 60px; }
    .lifecycle-badge { display: inline-block; padding: 6px 20px; background: #EBF0FF; color: #1C30A3; border-radius: 50px; font-size: 13px; font-weight: 700; margin-bottom: 18px; text-transform: uppercase; }
    .lifecycle-title { font-size: clamp(32px, 4.5vw, 46px); font-weight: 900; margin-bottom: 18px; color: #0F172A; }
    .lifecycle-underline { width: 70px; height: 4px; background: #1C30A3; border-radius: 10px; margin: 0 auto 22px;}
    .lifecycle-desc { color: #64748B; max-width: 650px; margin: 0 auto; font-size: 17px; line-height: 1.7; }
    
    .process-step-container { transition: all 0.3s ease; padding: 15px 10px; border-radius: 20px; }
    .process-step-container:hover { background: #F8FAFC; transform: translateY(-4px); }
    .step-circle {
        width: 80px; height: 80px; background: #1C30A3; color: white; border-radius: 50%; display: flex; 
        align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 22px; 
        box-shadow: 0 12px 25px rgba(28,48,163,0.25); border: 6px solid #F8FAFC; position: relative;
    }
    .step-number { position: absolute; top: -5px; right: -5px; width: 26px; height: 26px; background: #2563EB; color: white; border-radius: 50%; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 2px solid white; }
    .step-title { font-weight: 800; margin-bottom: 10px; color: #0F172A; font-size: 18px; }
    .step-desc { font-size: 14px; color: #64748B; line-height: 1.6; margin: 0; }

    /* Final CTA */
    .final-cta-section { padding: 0 0 110px; background: #F8FAFC; }
    .cta-card { padding: clamp(50px, 8vw, 90px); background: linear-gradient(135deg, #0F172A, #1C30A3, #2541C8); border-radius: 44px; position: relative; overflow: hidden; text-align: center; box-shadow: 0 25px 60px rgba(15,23,42,0.2); }
    .cta-pattern-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.08; background: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px; pointer-events: none; }
    .cta-decor-circle-lg { position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.04); border-radius: 50%; top: -100px; right: -100px; }
    .cta-decor-circle-sm { position: absolute; width: 200px; height: 200px; background: rgba(255,255,255,0.04); border-radius: 50%; bottom: -50px; left: -50px; }
    
    .cta-title { color: white; font-size: clamp(30px, 5vw, 52px); font-weight: 900; margin-bottom: 20px; position: relative; z-index: 2; line-height: 1.15; font-family: 'Playfair Display', serif; }
    .cta-desc { color: rgba(255,255,255,0.85); margin-bottom: 40px; max-width: 650px; margin-left: auto; margin-right: auto; position: relative; z-index: 2; font-size: 18px; line-height: 1.6; }
    .cta-btns-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; position: relative; z-index: 2; }
    
    .cta-btn-primary { padding: 16px 42px; background: white; color: #1C30A3; font-weight: 800; border-radius: 14px; text-decoration: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); font-size: 15px; transition: all 0.3s ease; }
    .cta-btn-primary:hover { background: #f8fafc; color: #1C30A3; transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,0.22); }
    .cta-btn-outline { padding: 16px 42px; background: transparent; border: 2px solid rgba(255,255,255,0.35); color: white; font-weight: 800; border-radius: 14px; text-decoration: none; font-size: 15px; transition: all 0.3s ease; }
    .cta-btn-outline:hover { background: rgba(255,255,255,0.1); color: white; border-color: white; transform: translateY(-2px); }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    @media (max-width: 991px) {
        .premium-hero-section { min-height: 440px; padding: 80px 0 100px; }
        .hero-wave-svg { height: 45px; }
        .features-overlay-section { padding-top: 50px; }
    }
    @media (max-width: 576px) {
        .style-cards-grid { grid-template-columns: 1fr; }
        .step-pill-line { display: none; }
        .form-steps-indicator { gap: 8px; flex-wrap: wrap; }
    }
  </style>
  <script>
    $(document).ready(function() {
      // Manual accordion toggle fallback
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