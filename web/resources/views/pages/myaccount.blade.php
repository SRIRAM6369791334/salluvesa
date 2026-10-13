@extends('layouts.app')
@section('content')

<style>
  /* Premium Hero Section */
  .premium-hero-section {
    min-height: 420px;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #0F172A 0%, #1C30A3 50%, #2541C8 100%);
    position: relative;
    padding: 120px 0 160px;
    overflow: hidden;
  }

  .hero-particles {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1;
  }

  .hero-gradient-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(ellipse at 0% 50%, rgba(15, 23, 42, 0.6) 0%, transparent 60%),
                radial-gradient(ellipse at 100% 50%, rgba(37, 65, 200, 0.35) 0%, transparent 60%);
    z-index: 1;
  }

  .hero-content { position: relative; z-index: 3; }

  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 8px 24px; border-radius: 50px; color: white;
    font-size: 13.5px; font-weight: 600; margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .premium-hero-title {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    font-family: 'Playfair Display', serif;
    color: white; margin: 0 0 16px 0; line-height: 1.2;
  }

  .hero-subtitle {
    font-size: 17px; color: rgba(255, 255, 255, 0.9);
    margin: 0 auto; max-width: 580px; font-style: italic;
  }

  .hero-wave {
    position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg);
  }
  .hero-wave svg { position: relative; display: block; width: calc(100% + 1.3px); height: 75px; }
  .wave-fill { fill: #F8FAFC; }

  .premium-account-section {
    position: relative; background: #F8FAFC; padding: 60px 0 120px;
  }

  /* User Profile Sidebar Card */
  .user-sidebar-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px 20px;
    text-align: center;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    margin-bottom: 20px;
  }

  .user-avatar-circle {
    width: 76px; height: 76px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
    color: #ffffff;
    font-size: 30px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    box-shadow: 0 8px 20px rgba(28, 48, 163, 0.25);
    border: 3px solid #ffffff;
  }

  .user-name-title {
    font-size: 19px; font-weight: 800; color: #0F172A; margin-bottom: 4px;
  }

  .user-email-text {
    font-size: 13px; color: #64748B; margin-bottom: 12px;
    word-break: break-all;
  }

  .user-type-pill {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #EBF0FF;
    color: #1C30A3;
  }

  /* Account Navigation Menu */
  .cs_filter_sidebar {
    background: #ffffff;
    border-radius: 20px;
    padding: 16px;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
  }

  .account-menu-list {
    list-style: none; padding: 0; margin: 0;
  }

  .account-menu-item {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 18px; color: #475569;
    text-decoration: none; border-radius: 14px;
    transition: all 0.3s ease; font-weight: 600; font-size: 14px;
    margin-bottom: 6px;
  }

  .account-menu-item i {
    width: 22px; text-align: center; font-size: 16px;
    transition: all 0.3s ease; color: #64748B;
  }

  .account-menu-item:hover {
    background: #F1F5F9; color: #1C30A3; transform: translateX(4px);
  }

  .account-menu-item:hover i { color: #1C30A3; }

  .account-menu-item.active {
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
    color: #ffffff; box-shadow: 0 6px 18px rgba(28, 48, 163, 0.25);
  }

  .account-menu-item.active i { color: #ffffff; }

  .account-menu-item.logout-link:hover {
    background: #FEF2F2; color: #EF4444;
  }

  .account-menu-item.logout-link:hover i { color: #EF4444; }

  /* Tab Content Panels & Cards */
  .tab-content-panel {
    display: none; animation: fadeIn 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
  }

  .tab-content-panel.active { display: block; }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .cs_portal_card {
    background: #ffffff;
    border-radius: 24px;
    padding: 32px;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    margin-bottom: 30px;
  }

  .portal-card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #F1F5F9;
  }

  .portal-card-title {
    font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;
    display: flex; align-items: center; gap: 10px;
  }

  /* KPI Stat Cards */
  .cs_kpi_card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.03);
    transition: all 0.35s ease;
    display: flex; align-items: center; gap: 18px;
  }

  .cs_kpi_card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
    border-color: #93C5FD;
  }

  .kpi-icon-box {
    width: 58px; height: 58px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
  }

  .kpi-icon-blue { background: #EBF0FF; color: #1C30A3; }
  .kpi-icon-amber { background: #FEF3C7; color: #D97706; }
  .kpi-icon-emerald { background: #D1FAE5; color: #059669; }

  .kpi-title { font-size: 13px; font-weight: 700; color: #64748B; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
  .kpi-number { font-size: 28px; font-weight: 900; color: #0F172A; margin: 0; line-height: 1; }

  /* Modern Custom Tables */
  .cs_custom_table_wrapper {
    overflow-x: auto; border-radius: 16px; border: 1px solid #E2E8F0;
  }

  .cs_custom_table {
    width: 100%; border-collapse: collapse; background: #ffffff; text-align: left;
  }

  .cs_custom_table th {
    background: #F8FAFC; padding: 16px 20px; font-size: 12.5px;
    font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;
    border-bottom: 1.5px solid #E2E8F0;
  }

  .cs_custom_table td {
    padding: 16px 20px; font-size: 14px; color: #1E293B;
    border-bottom: 1px solid #F1F5F9; vertical-align: middle;
  }

  .cs_custom_table tr:last-child td { border-bottom: none; }

  .cs_custom_table tr:hover td { background: #F8FAFC; }

  /* Status Badges */
  .status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700;
  }

  .status-delivered { background: #DCFCE7; color: #15803D; }
  .status-pending { background: #FEF3C7; color: #B45309; }
  .status-processing { background: #E0F2FE; color: #0369A1; }
  .status-cancelled { background: #FEE2E2; color: #B91C1C; }

  /* Address Cards */
  .cs_address_card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    border: 1.5px solid #E2E8F0;
    transition: all 0.3s ease;
    height: 100%;
    display: flex; flex-direction: column; justify-content: space-between;
    position: relative;
  }

  .cs_address_card:hover {
    border-color: #1C30A3; box-shadow: 0 10px 25px rgba(28, 48, 163, 0.08);
  }

  .cs_address_card.is-default {
    border-color: #1C30A3; background: #FAFDF8;
  }

  .address-default-badge {
    position: absolute; top: 18px; right: 18px;
    background: #1C30A3; color: white; padding: 4px 12px;
    border-radius: 50px; font-size: 11px; font-weight: 700;
    letter-spacing: 0.5px; text-transform: uppercase;
  }

  .address-type-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 16px; font-weight: 800; color: #0F172A; margin-bottom: 12px;
  }

  /* Form Elements Polish */
  .premium-form-label {
    font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;
  }

  .premium-form-input {
    width: 100%; height: 46px; border-radius: 12px;
    border: 1.5px solid #E2E8F0; background: #ffffff;
    padding: 0 16px; font-size: 14px; color: #0F172A;
    transition: all 0.3s ease; outline: none;
  }

  .premium-form-input:focus {
    border-color: #1C30A3; box-shadow: 0 0 0 4px rgba(28, 48, 163, 0.1);
  }

  .premium-form-input[readonly], .premium-form-input[disabled] {
    background-color: #F8FAFC !important; color: #64748B !important; cursor: not-allowed;
  }

  /* Danger Zone */
  .danger-zone-card {
    background: #FEF2F2; border: 1.5px solid #FCA5A5;
    border-radius: 20px; padding: 24px; margin-top: 30px;
  }

  .btn-danger-custom {
    background: #DC2626; color: white; border: none;
    padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px;
    transition: all 0.3s ease; cursor: pointer;
  }
  .btn-danger-custom:hover {
    background: #B91C1C; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(220, 38, 38, 0.25);
  }

  @media (max-width: 991px) {
    .cs_portal_card { padding: 20px; border-radius: 18px; }
    .user-sidebar-card { margin-bottom: 15px; }
    .cs_filter_sidebar { margin-bottom: 25px; }
  }
</style>

  <!-- Hero Section -->
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center">
      <div class="hero-content">
        <div class="hero-badge">
          <i class="fa-solid fa-user-gear"></i>
          <span>{{ gt('User Command Center') }}</span>
        </div>
        <h1 class="premium-hero-title">{{ gt('My Account') }}</h1>
        <p class="hero-subtitle">{{ gt('Manage your orders, profile settings, and delivery preferences') }}</p>
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

  <!-- Main Section -->
  <section class="premium-account-section">
    <div class="container-fluid container-lg">
      <div class="row g-4">
        
        <!-- Left Sidebar Navigation -->
        <div class="col-lg-3">
          <!-- User Profile Card -->
          <div class="user-sidebar-card">
            <div class="user-avatar-circle">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <h3 class="user-name-title">{{ Auth::user()->name }}</h3>
            <p class="user-email-text">{{ Auth::user()->email }}</p>
            <span class="user-type-pill">
              <i class="fa-solid fa-crown me-1" style="color: #D4A574;"></i>
              {{ Auth::user()->user_type == 'B2B' ? gt('B2B Partner') : gt('Standard Account') }}
            </span>
          </div>

          <!-- Sidebar Menu -->
          <div class="cs_filter_sidebar">
            <ul class="account-menu-list">
              <li>
                <a href="#dashboard" class="account-menu-item active" data-tab="dashboard">
                  <i class="fa-solid fa-chart-pie"></i>
                  <span>{{ gt('Dashboard Overview') }}</span>
                </a>
              </li>
              <li>
                <a href="#profile" class="account-menu-item" data-tab="profile">
                  <i class="fa-solid fa-id-card"></i>
                  <span>{{ gt('My Profile') }}</span>
                </a>
              </li>
              <li>
                <a href="#orders" class="account-menu-item" data-tab="orders">
                  <i class="fa-solid fa-bag-shopping"></i>
                  <span>{{ gt('My Orders') }}</span>
                </a>
              </li>
              <li>
                <a href="#bulk-orders" class="account-menu-item" data-tab="bulk-orders">
                  <i class="fa-solid fa-boxes-stacked"></i>
                  <span>{{ gt('Bulk Orders') }}</span>
                </a>
              </li>
              <li class="desktop-only-designs" style="display: none !important;">
                <a href="#designs" class="account-menu-item" data-tab="designs">
                  <i class="fa-solid fa-palette"></i>
                  <span>{{ gt('Saved Designs') }}</span>
                </a>
              </li>
              <li>
                <a href="#address" class="account-menu-item" data-tab="address">
                  <i class="fa-solid fa-location-dot"></i>
                  <span>{{ gt('Delivery Addresses') }}</span>
                </a>
              </li>
              <li>
                <a href="#settings" class="account-menu-item" data-tab="settings">
                  <i class="fa-solid fa-shield-halved"></i>
                  <span>{{ gt('Account Settings') }}</span>
                </a>
              </li>
              <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                <a href="#" class="account-menu-item logout-link" onclick="confirmLogout(event)">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <span>{{ gt('Logout') }}</span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Right Content Area -->
        <div class="col-lg-9">
          
          <!-- TAB 1: DASHBOARD -->
          <div id="tab-dashboard" class="tab-content-panel active">
            <div class="cs_portal_card">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div>
                  <h2 class="portal-card-title">
                    {{ gt('Welcome back') }}, {{ Auth::user()->name }}! 👋
                  </h2>
                  <p class="text-muted mb-0" style="font-size: 14px;">{{ gt('Here is an overview of your account activity and orders.') }}</p>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-weight-bold" style="font-size: 12px;">
                  <i class="fa-solid fa-calendar-day me-1 text-primary"></i> {{ date('M d, Y') }}
                </span>
              </div>

              <!-- KPI Metrics Grid -->
              <div class="row g-3">
                <div class="col-md-4">
                  <div class="cs_kpi_card">
                    <div class="kpi-icon-box kpi-icon-blue">
                      <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div>
                      <div class="kpi-title">{{ gt('Total Orders') }}</div>
                      <div class="kpi-number">{{ $user->orders->count() }}</div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="cs_kpi_card">
                    <div class="kpi-icon-box kpi-icon-amber">
                      <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                      <div class="kpi-title">{{ gt('Cart Items') }}</div>
                      <div class="kpi-number">{{ $user->cartItems->count() }}</div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="cs_kpi_card">
                    <div class="kpi-icon-box kpi-icon-emerald">
                      <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                      <div class="kpi-title">{{ gt('Saved Addresses') }}</div>
                      <div class="kpi-number">{{ $user->addresses->count() }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Bank Details Section for Manual Payment Orders --}}
            @php
            $mpOrder = $user->orders->where('payment_method', 'mp')->first();
            $bankDetails = null;
            if ($mpOrder) {
                $country = $mpOrder->bank_country;
                if (!$country) {
                    $fullDetail = \App\Models\SampleOrderFullDetail::where('order_primary_id', $mpOrder->id)->first();
                    $country = $fullDetail?->bank_country ?? $fullDetail?->country;
                }
                if ($country) {
                    $country = trim($country);
                    $bankDetails = $allBankDetails->first(function($bank) use ($country) {
                        return strcasecmp($bank->bank_country, $country) === 0 || stripos($bank->bank_country, $country) !== false || stripos($country, $bank->bank_country) !== false;
                    });
                }
                if (!$bankDetails) {
                    $bankDetails = $allBankDetails->first();
                }
            }
            @endphp

            @if($mpOrder && $bankDetails)
            <div class="cs_portal_card" style="border: 2px solid #1C30A3; background: #F8FAFF;">
              <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width: 48px; height: 48px; background: #1C30A3; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px;">
                  <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                  <h3 class="h5 font-weight-bold mb-0 text-dark">{{ gt('Payment Instructions') }} (Order #{{ $mpOrder->order_id }})</h3>
                  <p class="mb-0 text-muted small">{{ gt('Bank Transfer Details for') }} {{ $bankDetails->bank_country ?? '' }}</p>
                </div>
              </div>

              @if($mpOrder->delivery_status == 0)
              <div class="alert alert-warning mb-4 rounded-3 border-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left fs-5 me-1"></i>
                <span>{{ gt('Your order is pending. Please complete the bank transfer below and upload your receipt proof.') }}</span>
              </div>

              <div class="bank-info-container mb-4 p-3 bg-white border rounded-3">
                <div class="mb-2">
                  <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px;">{{ gt('Bank Country') }}:</span>
                  <span class="font-weight-bold text-primary ms-2">{{ $bankDetails->bank_country ?? 'N/A' }}</span>
                </div>
                <div class="description-content" style="font-size: 13.5px; line-height: 1.6;">
                  {!! $bankDetails->description ?? gt('No instructions provided.') !!}
                </div>
              </div>

              <div class="p-4 bg-white rounded-3 border border-dashed border-primary">
                <form id="proof-upload-form" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="order_id" value="{{ $mpOrder->order_id }}">

                  <div class="row align-items-end g-3">
                    <div class="col-lg-7">
                      <label class="premium-form-label mb-1">{{ gt('Upload Transfer Proof') }}</label>
                      <p class="text-muted small mb-2">{{ gt('Upload receipt image (JPG, PNG, WebP up to 5MB).') }}</p>
                      <input type="file" name="payment_proof" id="payment_proof" class="premium-form-input p-2" accept="image/*" required>
                    </div>
                    <div class="col-lg-5">
                      <button type="submit" class="cs_btn cs_style_1 w-100 font-weight-bold py-3 rounded-3" id="upload-btn" style="background: #1C30A3; color: white;">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> {{ gt('Confirm & Upload') }}
                      </button>
                    </div>
                  </div>
                </form>

                <div id="proof-preview-container" class="mt-3 {{ $mpOrder->payment_proof ? '' : 'd-none' }}">
                  <label class="text-muted small d-block mb-2">{{ gt('Uploaded Proof:') }}</label>
                  <div class="position-relative d-inline-block">
                    <img src="{{ $mpOrder->payment_proof ? rtrim(env('MAIN_URL'), '/').'/uploads/proof/'.$mpOrder->payment_proof : '' }}"
                      id="proof-preview" style="max-width: 180px; border-radius: 10px; border: 1px solid #E2E8F0;" alt="Proof">
                    <div class="mt-2">
                      <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> {{ gt('Submitted') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="alert alert-success d-flex align-items-center gap-3 py-3 border-0 rounded-3" style="background: #DCFCE7; color: #15803D;">
                <i class="fa-solid fa-circle-check fs-2"></i>
                <div>
                  <h5 class="mb-1 font-weight-bold" style="color: #15803D;">{{ gt('Payment Verified!') }}</h5>
                  <p class="mb-0 small">{{ gt('Your manual payment has been confirmed and order is in progress.') }}</p>
                </div>
              </div>
              @endif
            </div>
            @endif

            <!-- Recent Orders Card -->
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                  <span>{{ gt('Recent Orders') }}</span>
                </h3>
                <a href="#orders" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold px-3" onclick="document.querySelector('[data-tab=\'orders\']').click();">
                  {{ gt('View All') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </div>

              <div class="cs_custom_table_wrapper">
                <table class="cs_custom_table">
                  <thead>
                    <tr>
                      <th>{{ gt('Order ID') }}</th>
                      <th>{{ gt('Date') }}</th>
                      <th>{{ gt('Total') }}</th>
                      <th>{{ gt('Status') }}</th>
                      <th class="text-center">{{ gt('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($user->orders->take(3) as $order)
                    <tr>
                      <td class="font-weight-bold text-dark">#{{ $order->order_id }}</td>
                      <td>{{ $order->date_ordered_on ? $order->date_ordered_on->format('M d, Y') : $order->created_at->format('M d, Y') }}</td>
                      <td class="font-weight-bold text-primary">{{ format_currency($order->grand_total_amount) }}</td>
                      <td>
                        <span class="status-badge" style="background-color: rgba(28, 48, 163, 0.08); color: {{ $order->status_color }};">
                          <i class="fa-solid fa-circle text-xs" style="font-size: 8px;"></i>
                          {{ $order->delivery_status_text }}
                        </span>
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-light border rounded-pill font-weight-bold text-primary px-3" onclick="viewOrderDetails('{{ $order->order_id }}')">
                          <i class="fa-solid fa-eye me-1"></i> {{ gt('View') }}
                        </button>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center py-4 text-muted">{{ gt('No recent orders found.') }}</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- TAB 2: MY PROFILE -->
          <div id="tab-profile" class="tab-content-panel">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-user-pen text-primary"></i>
                  <span>{{ gt('Profile Information') }}</span>
                </h3>
                <button type="button" id="edit-profile-btn" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;" onclick="toggleProfileEdit()">
                  <i class="fa-solid fa-pen-to-square me-1"></i> {{ gt('Edit Profile') }}
                </button>
              </div>

              <form id="profile-form">
                @csrf
                <div class="row g-3">
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('Customer Name') }}</label>
                    <input type="text" name="name" class="premium-form-input profile-input" value="{{ Auth::user()->name }}" readonly>
                  </div>
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('Email Address') }}</label>
                    <input type="email" class="premium-form-input" value="{{ Auth::user()->email }}" readonly>
                  </div>
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('Contact Number') }}</label>
                    <input type="tel" name="phone_number" class="premium-form-input profile-input" value="{{ Auth::user()->phone_number }}" readonly>
                  </div>
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('User Type') }}</label>
                    <input type="text" class="premium-form-input" value="{{ Auth::user()->user_type == 'B2B' ? gt('B2B Partner') : gt('Standard Customer') }}" readonly>
                  </div>
                  @if(Auth::user()->user_type == 'B2B')
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('GST Number') }}</label>
                    <input type="text" class="premium-form-input" value="{{ Auth::user()->gst_number }}" readonly>
                  </div>
                  @endif
                </div>

                <div id="profile-save-container" class="mt-4 pt-3 border-top" style="display: none;">
                  <button type="submit" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3 me-2" style="background: #059669; color: white;">
                    <i class="fa-solid fa-check me-1"></i> {{ gt('Save Changes') }}
                  </button>
                  <button type="button" class="btn btn-secondary font-weight-bold px-4 py-2 rounded-3" onclick="toggleProfileEdit(false)">
                    {{ gt('Cancel') }}
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- TAB 3: MY ORDERS -->
          <div id="tab-orders" class="tab-content-panel">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-bag-shopping text-primary"></i>
                  <span>{{ gt('My Orders History') }}</span>
                </h3>
              </div>

              <div class="cs_custom_table_wrapper">
                <table class="cs_custom_table">
                  <thead>
                    <tr>
                      <th>{{ gt('Order ID') }}</th>
                      <th>{{ gt('Date') }}</th>
                      <th>{{ gt('Total') }}</th>
                      <th>{{ gt('Status') }}</th>
                      <th class="text-center">{{ gt('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($user->orders as $order)
                    <tr>
                      <td class="font-weight-bold text-dark">#{{ $order->order_id }}</td>
                      <td>{{ $order->date_ordered_on ? $order->date_ordered_on->format('M d, Y') : $order->created_at->format('M d, Y') }}</td>
                      <td class="font-weight-bold text-primary">{{ format_currency($order->grand_total_amount) }}</td>
                      <td>
                        <span class="status-badge" style="background-color: rgba(28, 48, 163, 0.08); color: {{ $order->status_color }};">
                          <i class="fa-solid fa-circle text-xs" style="font-size: 8px;"></i>
                          {{ $order->delivery_status_text }}
                        </span>
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-light border rounded-pill font-weight-bold text-primary px-3" onclick="viewOrderDetails('{{ $order->order_id }}')">
                          <i class="fa-solid fa-eye me-1"></i> {{ gt('View Details') }}
                        </button>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        <i class="fa-solid fa-box-open fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">{{ gt("You haven't placed any orders yet.") }}</p>
                        <a href="/shop" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;">
                          {{ gt('Explore Shop') }}
                        </a>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- TAB 4: BULK ORDERS -->
          <div id="tab-bulk-orders" class="tab-content-panel">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-boxes-stacked text-primary"></i>
                  <span>{{ gt('Bulk Order Requests') }}</span>
                </h3>
              </div>

              <div class="cs_custom_table_wrapper">
                <table class="cs_custom_table">
                  <thead>
                    <tr>
                      <th>{{ gt('Request ID') }}</th>
                      <th>{{ gt('Date') }}</th>
                      <th>{{ gt('Product Type') }}</th>
                      <th>{{ gt('Quantity') }}</th>
                      <th>{{ gt('Notes') }}</th>
                      <th class="text-center">{{ gt('Attachment') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($bulkOrders as $bulk)
                    <tr>
                      <td class="font-weight-bold text-dark">#{{ $bulk->order_id }}</td>
                      <td>{{ $bulk->created_at ? $bulk->created_at->format('M d, Y') : 'N/A' }}</td>
                      <td>
                        <span class="badge bg-light text-primary border px-3 py-1 rounded-pill">
                          @if($bulk->product_type == 'own_design') {{ gt('Our Design') }}
                          @elseif($bulk->product_type == 'custom_design') {{ gt('Bulk Custom') }}
                          @elseif($bulk->product_type == 'own_custom') {{ gt('Own Custom') }}
                          @else {{ $bulk->product_type ?: 'N/A' }} @endif
                        </span>
                      </td>
                      <td class="font-weight-bold">{{ $bulk->quantity }}</td>
                      <td style="max-width: 200px;" class="text-truncate">{{ $bulk->notes ?: 'N/A' }}</td>
                      <td class="text-center">
                        @if($bulk->custom_image)
                        <a href="{{ asset('storage/' . $bulk->custom_image) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold px-3">
                          <i class="fa-solid fa-paperclip me-1"></i> {{ gt('Attachment') }}
                        </a>
                        @else
                        <span class="text-muted small">N/A</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center py-5">
                        <i class="fa-solid fa-truck-ramp-box fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">{{ gt("You haven't requested any bulk orders yet.") }}</p>
                        <a href="/bulk-order" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;">
                          {{ gt('Request Bulk Quote') }}
                        </a>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- TAB 5: DESIGNS -->
          <div id="tab-designs" class="tab-content-panel desktop-only-designs" style="display: none !important;">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-palette text-primary"></i>
                  <span>{{ gt('Saved Designs') }}</span>
                </h3>
              </div>

              <div class="row g-3">
                @forelse($user->designs->sortByDesc('updated_at') as $customproduct_designs)
                <div class="col-lg-4 col-md-6">
                  <div class="border rounded-4 p-3 bg-white shadow-sm position-relative">
                    <div class="design-preview-box mb-3 bg-light rounded-3 overflow-hidden position-relative" style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center;">
                      @if($customproduct_designs->thumbnail_path || $customproduct_designs->preview_image_front)
                      <img src="{{ route('image.proxy', ['url' => \Illuminate\Support\Facades\Storage::disk('shared')->url($customproduct_designs->thumbnail_path ?: $customproduct_designs->preview_image_front)]) }}" alt="{{ $customproduct_designs->design_name }}" style="width: 100%; height: 100%; object-fit: contain;">
                      @else
                      <div class="text-muted"><i class="fa-solid fa-image fa-3x"></i></div>
                      @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h5 class="h6 font-weight-bold text-dark mb-1">{{ $customproduct_designs->design_name ?: 'Untitled Design' }}</h5>
                        <p class="small text-muted mb-0">{{ $customproduct_designs->updated_at->diffForHumans() }}</p>
                      </div>
                      <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('customize.design', ['product_id' => $customproduct_designs->customproduct_id]) }}?design_id={{ $customproduct_designs->id }}">{{ gt('Edit') }}</a></li>
                          <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteDesign('{{ $customproduct_designs->id }}')">{{ gt('Delete') }}</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                  <p class="text-muted">{{ gt("No saved designs found.") }}</p>
                </div>
                @endforelse
              </div>
            </div>
          </div>

          <!-- TAB 6: DELIVERY ADDRESS -->
          <div id="tab-address" class="tab-content-panel">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-location-dot text-primary"></i>
                  <span>{{ gt('Delivery Addresses') }}</span>
                </h3>
                <button type="button" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;" onclick="openAddressModal()">
                  <i class="fa-solid fa-plus me-1"></i> {{ gt('Add New Address') }}
                </button>
              </div>

              <div class="row g-3">
                @forelse($user->addresses as $address)
                <div class="col-lg-6">
                  <div class="cs_address_card {{ $user->user_default_address_id == $address->id ? 'is-default' : '' }}">
                    @if($user->user_default_address_id == $address->id)
                    <span class="address-default-badge"><i class="fa-solid fa-check me-1"></i> {{ gt('Default') }}</span>
                    @endif

                    <div>
                      <div class="address-type-badge">
                        @if($address->address_type_id == 1)<i class="fa-solid fa-house text-primary"></i> {{ gt('Home') }}
                        @elseif($address->address_type_id == 2)<i class="fa-solid fa-briefcase text-primary"></i> {{ gt('Work') }}
                        @else<i class="fa-solid fa-location-arrow text-primary"></i> {{ gt('Other') }}
                        @endif
                      </div>

                      <h5 class="h6 font-weight-bold text-dark mb-2">{{ $address->address_username }}</h5>
                      <p class="text-muted small mb-1">{{ $address->address_line_one }}</p>
                      @if($address->address_line_two)<p class="text-muted small mb-1">{{ $address->address_line_two }}</p>@endif
                      @if($address->landmark)<p class="text-muted small mb-1">{{ gt('Landmark') }}: {{ $address->landmark }}</p>@endif
                      <p class="text-muted small mb-1">{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                      <p class="text-muted small mb-3"><i class="fa-solid fa-phone me-1 text-primary"></i> {{ $address->address_phone_number }}</p>
                    </div>

                    <div class="pt-3 border-top d-flex gap-3 align-items-center">
                      <button type="button" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold px-3" onclick='openAddressModal({{ json_encode($address) }})'>
                        <i class="fa-solid fa-pen me-1"></i> {{ gt('Edit') }}
                      </button>
                      <button type="button" class="btn btn-sm btn-outline-danger rounded-pill font-weight-bold px-3" onclick="deleteAddress({{ $address->id }})">
                        <i class="fa-solid fa-trash me-1"></i> {{ gt('Delete') }}
                      </button>
                      @if($user->user_default_address_id != $address->id)
                      <button type="button" class="btn btn-sm btn-link text-primary font-weight-bold ms-auto" onclick="setDefaultAddress({{ $address->id }})">
                        {{ gt('Set Default') }}
                      </button>
                      @endif
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                  <i class="fa-solid fa-map-location-dot fs-1 text-muted mb-3 d-block"></i>
                  <p class="text-muted mb-3">{{ gt('No addresses found.') }}</p>
                  <button type="button" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;" onclick="openAddressModal()">
                    <i class="fa-solid fa-plus me-1"></i> {{ gt('Add Your First Address') }}
                  </button>
                </div>
                @endforelse
              </div>
            </div>
          </div>

          <!-- TAB 7: SETTINGS -->
          <div id="tab-settings" class="tab-content-panel">
            <div class="cs_portal_card">
              <div class="portal-card-header">
                <h3 class="portal-card-title">
                  <i class="fa-solid fa-lock text-primary"></i>
                  <span>{{ gt('Change Password') }}</span>
                </h3>
              </div>

              <form id="change-password-form">
                @csrf
                <div class="row g-3">
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('Current Password') }}</label>
                    <input type="password" name="current_password" class="premium-form-input" required>
                  </div>
                </div>
                <div class="row g-3 mt-1">
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('New Password') }}</label>
                    <input type="password" name="password" class="premium-form-input" required>
                  </div>
                  <div class="col-lg-6">
                    <label class="premium-form-label">{{ gt('Confirm New Password') }}</label>
                    <input type="password" name="password_confirmation" class="premium-form-input" required>
                  </div>
                </div>
                <div class="mt-4">
                  <button type="submit" class="cs_btn cs_style_1 font-weight-bold px-4 py-2 rounded-3" style="background: #1C30A3; color: white;">
                    <i class="fa-solid fa-key me-1"></i> {{ gt('Update Password') }}
                  </button>
                </div>
              </form>

              <!-- Danger Zone -->
              <div class="danger-zone-card">
                <h4 class="h6 font-weight-bold text-danger mb-1">
                  <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ gt('Delete Account') }}
                </h4>
                <p class="small text-muted mb-3">{{ gt('Once you delete your account, all associated order history and data will be removed.') }}</p>
                <button type="button" class="btn-danger-custom" onclick="confirmDeleteAccount()">
                  <i class="fa-solid fa-trash-can me-1"></i> {{ gt('Delete My Account') }}
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Hero Particles
    const e = document.getElementById('heroParticles');
    if (e) {
      for (let t = 0; t < 50; t++) {
        const o = document.createElement('div');
        o.style.cssText = `position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*.5+.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`;
        e.appendChild(o);
      }
      const t = document.createElement('style');
      t.textContent = `@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`;
      document.head.appendChild(t);
    }

    // Tab Navigation Functionality
    const menuItems = document.querySelectorAll('.account-menu-item[data-tab]');
    const tabPanels = document.querySelectorAll('.tab-content-panel');

    menuItems.forEach(item => {
      item.addEventListener('click', function(e) {
        if (this.classList.contains('logout-link')) return;
        e.preventDefault();

        menuItems.forEach(mi => mi.classList.remove('active'));
        this.classList.add('active');

        const targetTab = this.getAttribute('data-tab');

        tabPanels.forEach(panel => panel.classList.remove('active'));

        const targetPanel = document.getElementById('tab-' + targetTab);
        if (targetPanel) {
          targetPanel.classList.add('active');
        }

        history.replaceState(null, null, '#' + targetTab);
      });
    });

    const hash = window.location.hash.substring(1);
    if (hash) {
      const targetMenuItem = document.querySelector('.account-menu-item[data-tab="' + hash + '"]');
      if (targetMenuItem) {
        targetMenuItem.click();
      }
    }
  });

  function confirmLogout(e) {
    e.preventDefault();
    Swal.fire({
      title: "{{ gt('Ready to leave?') }}",
      text: "{{ gt('You will need to login again to access your account!') }}",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#1C30A3',
      cancelButtonColor: '#dc3545',
      confirmButtonText: "{{ gt('Yes, logout!') }}",
      cancelButtonText: "{{ gt('Stay here') }}"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }

  function openAddressModal(address = null) {
    const isEdit = address !== null;
    const title = isEdit ? "{{ gt('Edit Address') }}" : "{{ gt('Add New Address') }}";
    const submitText = isEdit ? "{{ gt('Update Address') }}" : "{{ gt('Save Address') }}";

    Swal.fire({
      title: title,
      html: `
          <form id="addressForm" class="text-start">
            <div class="mb-3">
              <label class="form-label">{{ gt('Full Name') }} *</label>
              <input type="text" id="swal-name" class="swal2-input m-0 w-100" placeholder="{{ gt('e.g. John Doe') }}" value="${isEdit ? address.address_username : ''}">
            </div>
            <div class="mb-3">
              <label class="form-label">{{ gt('Contact Number') }} *</label>
              <input type="tel" id="swal-phone" class="swal2-input m-0 w-100" placeholder="{{ gt('e.g. 9876543210') }}" value="${isEdit ? address.address_phone_number : ''}">
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label">{{ gt('Address Type') }} *</label>
                <select id="swal-type" class="swal2-input m-0 w-100">
                  <option value="1" ${isEdit && address.address_type_id == 1 ? 'selected' : ''}>{{ gt('Home') }}</option>
                  <option value="2" ${isEdit && address.address_type_id == 2 ? 'selected' : ''}>{{ gt('Work') }}</option>
                  <option value="3" ${isEdit && address.address_type_id == 3 ? 'selected' : ''}>{{ gt('Others') }}</option>
                </select>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">{{ gt('Country') }} *</label>
                <input type="text" id="swal-country" class="swal2-input m-0 w-100" value="${isEdit ? address.country : '{{ gt('India') }}'}">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">{{ gt('House No / Building') }} *</label>
              <input type="text" id="swal-line1" class="swal2-input m-0 w-100" value="${isEdit ? address.address_line_one : ''}">
            </div>
            <div class="mb-3">
              <label class="form-label">{{ gt('Street / Colony') }} *</label>
              <input type="text" id="swal-line2" class="swal2-input m-0 w-100" value="${isEdit ? address.address_line_two || '' : ''}">
            </div>
            <div class="mb-3">
              <label class="form-label">{{ gt('Landmark') }}</label>
              <input type="text" id="swal-landmark" class="swal2-input m-0 w-100" value="${isEdit ? address.landmark || '' : ''}">
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label">{{ gt('City') }} *</label>
                <input type="text" id="swal-city" class="swal2-input m-0 w-100" value="${isEdit ? address.city : ''}">
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">{{ gt('State') }} *</label>
                <input type="text" id="swal-state" class="swal2-input m-0 w-100" value="${isEdit ? address.state : ''}">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">{{ gt('Pincode') }} *</label>
              <input type="text" id="swal-pincode" class="swal2-input m-0 w-100" value="${isEdit ? address.pincode : ''}">
            </div>
          </form>
          <style>
            .swal2-input { font-size: 14px; height: 45px; border-radius: 8px; margin-bottom: 5px !important; }
            .form-label { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 5px; display: block; }
          </style>
        `,
      showCancelButton: true,
      confirmButtonText: submitText,
      confirmButtonColor: '#1C30A3',
      cancelButtonColor: '#dc3545',
      focusConfirm: false,
      preConfirm: () => {
        const data = {
          address_username: document.getElementById('swal-name').value,
          address_phone_number: document.getElementById('swal-phone').value,
          address_type_id: document.getElementById('swal-type').value,
          country: document.getElementById('swal-country').value,
          address_line_one: document.getElementById('swal-line1').value,
          address_line_two: document.getElementById('swal-line2').value,
          landmark: document.getElementById('swal-landmark').value,
          city: document.getElementById('swal-city').value,
          state: document.getElementById('swal-state').value,
          pincode: document.getElementById('swal-pincode').value,
          _token: "{{ csrf_token() }}"
        };

        if (!data.address_username || !data.address_phone_number || !data.address_line_one || !data.city || !data.state || !data.pincode) {
          Swal.showValidationMessage("{{ gt('Please fill all required fields') }} (*)");
          return false;
        }
        return data;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const url = isEdit ? `/addresses/${address.id}` : '/addresses';
        const method = isEdit ? 'PUT' : 'POST';

        $.ajax({
          url: url,
          method: method,
          data: result.value,
          success: function(res) {
            Swal.fire("{{ gt('Saved!') }}", res.message, 'success').then(() => {
              location.reload();
            });
          },
          error: function(xhr) {
            Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error', 'error');
          }
        });
      }
    });
  }

  function deleteAddress(id) {
    Swal.fire({
      title: "{{ gt('Are you sure?') }}",
      text: "{{ gt('This address will be removed permanently!') }}",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#5E5E5E',
      confirmButtonText: "{{ gt('Yes, delete it!') }}"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/addresses/${id}`,
          method: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(res) {
            Swal.fire("{{ gt('Deleted!') }}", res.message, 'success').then(() => {
              location.reload();
            });
          }
        });
      }
    });
  }

  function setDefaultAddress(id) {
    $.ajax({
      url: `/addresses/${id}/set-default`,
      method: 'POST',
      data: {
        _token: "{{ csrf_token() }}"
      },
      success: function(res) {
        Swal.fire('Success', res.message, 'success').then(() => {
          location.reload();
        });
      }
    });
  }

  function toggleProfileEdit(enable = true) {
    const inputs = document.querySelectorAll('.profile-input');
    const editBtn = document.getElementById('edit-profile-btn');
    const saveContainer = document.getElementById('profile-save-container');

    inputs.forEach(input => {
      if (input.tagName === 'SELECT') {
        input.disabled = !enable;
      } else {
        input.readOnly = !enable;
      }
    });

    editBtn.style.display = enable ? 'none' : 'block';
    saveContainer.style.display = enable ? 'block' : 'none';
  }

  $(document).ready(function() {
    $('#profile-form').on('submit', function(e) {
      e.preventDefault();
      const btn = $(this).find('button[type="submit"]');
      const originalText = btn.text();
      btn.prop('disabled', true).text("{{ gt('Saving...') }}");
      showLoader("{{ gt('Updating your profile...') }}");

      $.ajax({
        url: "{{ route('profile.update') }}",
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
          Swal.fire('Success', res.message, 'success').then(() => {
            hideLoader();
            location.reload();
          });
        },
        error: function(xhr) {
          hideLoader();
          console.error('Profile Update Error:', xhr);
          const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
          Swal.fire('Error', msg, 'error');
          btn.prop('disabled', false).text(originalText);
        }
      });
    });

    $('#change-password-form').on('submit', function(e) {
      e.preventDefault();
      const btn = $(this).find('button[type="submit"]');
      const originalText = btn.text();
      btn.prop('disabled', true).text("{{ gt('Updating...') }}");
      showLoader("{{ gt('Updating your password...') }}");

      $.ajax({
        url: "{{ route('password.change') }}",
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
          Swal.fire('Success', res.message, 'success').then(() => {
            hideLoader();
            location.reload();
          });
        },
        error: function(xhr) {
          hideLoader();
          console.error('Password Change Error:', xhr);
          const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Verification failed';
          Swal.fire('Error', msg, 'error');
          btn.prop('disabled', false).text(originalText);
        }
      });
    });

    const hash = window.location.hash;
    if (hash) {
      const tabName = hash.replace('#', '');
      const targetTab = $(`.account-menu-item[data-tab="${tabName}"]`);
      if (targetTab.length) {
        targetTab.click();
      }
    }

    $('.account-menu-item').on('click', function() {
      const tab = $(this).data('tab');
      if (tab && tab !== 'logout') {
        window.location.hash = tab;
      }
    });
  });

  function viewOrderDetails(orderId) {
    Swal.fire({
      title: "{{ gt('Fetching Order Details...') }}",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
        $.ajax({
          url: `/order/details/${orderId}`,
          method: 'GET',
          success: function(res) {
            const order = res.order;
            const cSymbol = window.__currency?.symbol || '$';
            const cRate = window.__currency?.rate || 1;
            let itemsHtml = '';

            if (order.items && order.items.length > 0) {
              order.items.forEach(item => {
                let imgSrc = item.product_image;
                if (!imgSrc) {
                  imgSrc = 'https://placehold.co/60x60?text=No+Img';
                } else if (!imgSrc.startsWith('http')) {
                  if (imgSrc.startsWith('/')) imgSrc = imgSrc.substring(1);
                  if (item.design_id) {
                    imgSrc = `{{ env('MAIN_URL') }}uploads/${imgSrc}`;
                  } else {
                    imgSrc = `{{ env('MAIN_URL') }}images/${imgSrc}`;
                  }
                }

                itemsHtml += `
                    <div style="display: flex; gap: 15px; padding: 10px 0; border-bottom: 1px solid #eee; align-items: center;">
                      <img src="${imgSrc}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" alt="${item.product_name}">
                      <div style="flex: 1; text-align: left;">
                        <h5 style="margin: 0; font-size: 14px; font-weight: 600;">${item.product_name}</h5>
                        <p style="margin: 2px 0; font-size: 12px; color: #666;">{{ gt('Size') }}: ${item.size_value || '{{ gt('N/A') }}'} | {{ gt('Color') }}: ${item.color_value ? `<span style="display:inline-block; width:15px; height:15px; border-radius:50%; background-color:${item.color_value}; border:1px solid #ccc; vertical-align:text-bottom; margin-left:3px;" title="${item.color_value}"></span>` : '{{ gt('N/A') }}'}</p>
                        <p style="margin: 0; font-size: 13px; font-weight: 500;">${cSymbol}${(parseFloat(item.product_rate) * cRate).toFixed(2)} x ${item.quantity}</p>
                      </div>
                      <div style="text-align: right;">
                        <p style="margin: 0; font-size: 14px; font-weight: 600;">${cSymbol}${(parseFloat(item.product_total) * cRate).toFixed(2)}</p>
                      </div>
                    </div>
                  `;
              });
            } else {
              itemsHtml = '<p style="text-align: center; padding: 20px; color: #999;">{{ gt("No items found for this order.") }}</p>';
            }

            const address = order.shipping_address;
            const addressHtml = address ? `
                <div style="text-align: left; padding: 15px; background: #f9f9f9; border-radius: 10px; margin-top: 15px;">
                  <h4 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600; color: #1C30A3;">{{ gt('Shipping Address') }}</h4>
                  <p style="margin: 0; font-size: 13px;">${address.address_line_one}</p>
                  ${address.address_line_two ? `<p style="margin: 2px 0; font-size: 13px;">${address.address_line_two}</p>` : ''}
                  <p style="margin: 2px 0; font-size: 13px;">${address.city}, ${address.state} - ${address.pincode}</p>
                  <p style="margin: 2px 0; font-size: 13px;">{{ gt('Phone') }}: ${address.address_phone_number}</p>
                </div>
              ` : '';

            let bankDetailsHtml = '';
            if (order.payment_method === 'mp' && order.bank_details) {
              const bankString = encodeURIComponent(JSON.stringify(order.bank_details));
              bankDetailsHtml = `
                    <div style="margin-top: 15px; padding: 15px; background: #eef2ff; border: 1px dashed #1C30A3; border-radius: 8px; text-align: center;">
                        <p style="margin: 0 0 10px 0; font-size: 13px; color: #1C30A3; font-weight: 600;"><i class="fas fa-university"></i> {{ gt('Awaiting Manual Bank Transfer') }}</p>
                        <button onclick="window.openBankDetailsModal('${bankString}', '${order.order_id}')" style="padding: 8px 15px; background: #1C30A3; font-size: 12px; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            {{ gt('View Full Bank Details') }}
                        </button>
                    </div>
                  `;
            }

            const contentHtml = `
                <div style="padding: 10px;">
                  <div style="display: flex; justify-content: space-between; margin-bottom: 20px; text-align: left;">
                    <div>
                      <p style="margin: 0; color: #666; font-size: 12px;">{{ gt('Order Date') }}</p>
                      <p style="margin: 0; font-weight: 600; font-size: 13px;">${order.formatted_date}</p>
                    </div>
                    <div style="text-align: right;">
                      <p style="margin: 0; color: #666; font-size: 12px;">{{ gt('Status') }}</p>
                      <span style="color: ${order.status_color}; font-weight: 600; font-size: 13px;">${order.status_text}</span>
                    </div>
                  </div>

                  <div style="margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; background: #f0f4ff; border-radius: 12px; padding: 15px; text-align: left;">
                    <div>
                      <p style="margin: 0; color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ gt('Order Type') }}</p>
                      <p style="margin: 0; font-weight: 700; font-size: 13px; color: #1C30A3;">${order.order_type_text}</p>
                    </div>
                    <div style=display:none;>
                      <p style="margin: 0; color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ gt('Printing Method') }}</p>
                      <p style="margin: 0; font-weight: 700; font-size: 13px; color: #1C30A3;">${order.printing_method || 'CTF'}</p>
                    </div>
                  </div>

                  <div style="max-height: 250px; overflow-y: auto; margin-bottom: 20px;">
                    <h4 style="text-align: left; margin: 0 0 10px 0; font-size: 14px; font-weight: 600; color: #1C30A3;">{{ gt('Ordered Items') }}</h4>
                    ${itemsHtml}
                  </div>

                  <div style="display: flex; flex-direction: column; gap: 8px; border-top: 2px solid #eee; padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                      <span>{{ gt('Subtotal') }}</span>
                      <span>${cSymbol}${(parseFloat(order.total_amount) * cRate).toFixed(2)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                       <span>{{ gt('Payment Method') }}</span>
                       <span style="font-weight: 600;">${order.payment_method_text} ${order.bank_country ? `(${order.bank_country})` : ''}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: ${order.payment_status == 1 ? '#28a745' : '#dc3545'};">
                       <span>{{ gt('Payment Status') }}</span>
                       <span style="font-weight: 600;">${order.payment_status_text}</span>
                    </div>
                     <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; margin-top: 5px; color: #1C30A3;">
                       <span>{{ gt('Total Amount') }}</span>
                       <span>${cSymbol}${(parseFloat(order.grand_total_amount) * cRate).toFixed(2)}</span>
                     </div>
                  </div>

                  ${addressHtml}
                  ${bankDetailsHtml}
                </div>
              `;

            Swal.fire({
              title: "{{ gt('Order ID') }}: " + orderId,
              html: contentHtml,
              width: '550px',
              confirmButtonText: "{{ gt('Close') }}",
              confirmButtonColor: '#1C30A3'
            });
          },
          error: function(xhr) {
            Swal.fire("{{ gt('Error') }}", xhr.responseJSON ? xhr.responseJSON.message : "{{ gt('Could not fetch details') }}", 'error');
          }
        });
      }
    });
  }

  window.openBankDetailsModal = function(bankJson, orderId) {
    let bank = JSON.parse(decodeURIComponent(bankJson));
    let html = `
            <div style="text-align: left; font-size: 14px; line-height: 1.6; color: #333; padding: 10px;">
                <div style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                    <strong style="color: #666; text-transform: uppercase; font-size: 11px;">{{ gt('Bank Country') }}:</strong> 
                    <span style="font-weight: 700; color: #1C30A3; margin-left: 5px;">${bank.bank_country || 'N/A'}</span>
                </div>
                
                <div style="background: #f8f9fa; border-radius: 12px; padding: 20px; border: 1px solid #e9ecef;">
                    <div class="description-content">
                        ${bank.description || '{{ gt('No instructions provided.') }}'}
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                  <a href="{{ route('bank.details') }}?order_id=${orderId}" style="display:inline-block; padding: 12px 30px; background: #28a745; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);">
                     <i class="fa-solid fa-cloud-arrow-up"></i> {{ gt('Upload Payment Proof') }}
                  </a>
                </div>
            </div>
        `;

    Swal.fire({
      title: "{{ gt('Payment Instructions') }}",
      html: html,
      width: '550px',
      confirmButtonColor: '#1C30A3',
      confirmButtonText: "{{ gt('Close') }}"
    });
  };

  function confirmDeleteAccount() {
    Swal.fire({
      title: "{{ gt('Are you absolutely sure?') }}",
      text: "{{ gt('This will permanently delete your account and all associated data. This action cannot be undone!') }}",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: "{{ gt('Yes, delete my account') }}",
      cancelButtonText: "{{ gt('No, keep it') }}"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "{{ gt('Please Contact Support') }}",
          text: "{{ gt('For security reasons, account deletion must be processed by our admin team. Please email support@saaluvesa.com') }}",
          icon: 'info',
          confirmButtonColor: '#1C30A3'
        });
      }
    });
  }

  $(document).ready(function() {
    $('#proof-upload-form').on('submit', function(e) {
      e.preventDefault();
      const form = $(this)[0];
      const formData = new FormData(form);
      const btn = $('#upload-btn');
      const originalText = btn.text();

      btn.prop('disabled', true).text("{{ gt('Uploading...') }}");
      showLoader("{{ gt('Uploading payment proof...') }}");

      $.ajax({
        url: "{{ route('order.upload_proof') }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
          if (res.success) {
            Swal.fire({
              title: "{{ gt('Success!') }}",
              text: res.message,
              icon: 'success',
              confirmButtonColor: '#1C30A3'
            }).then(() => {
              hideLoader();
              $('#proof-preview').attr('src', res.proof_url);
              $('#proof-preview-container').removeClass('d-none');
              btn.prop('disabled', false).text(originalText);
              form.reset();
            });
          } else {
            hideLoader();
            Swal.fire("{{ gt('Error') }}", res.message, 'error');
            btn.prop('disabled', false).text(originalText);
          }
        },
        error: function(xhr) {
          hideLoader();
          const msg = xhr.responseJSON ? xhr.responseJSON.message : "{{ gt('Upload failed.') }}";
          Swal.fire("{{ gt('Error') }}", msg, 'error');
          btn.prop('disabled', false).text(originalText);
        }
      });
    });
  });

  function deleteDesign(id) {
    Swal.fire({
      title: "{{ gt('Are you sure?') }}",
      text: "{{ gt('This design will be deleted forever!') }}",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: "{{ gt('Yes, delete it!') }}"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/api/designs/${id}`,
          method: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(res) {
            Swal.fire("{{ gt('Deleted!') }}", res.message, 'success').then(() => {
              location.reload();
            });
          },
          error: function(xhr) {
            Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error', 'error');
          }
        });
      }
    });
  }
</script>
@endpush
@endsection