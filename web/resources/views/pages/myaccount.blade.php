@extends('layouts.app')
@section('content')
<section class="premium-hero-section position-relative overflow-hidden">
  <div class="hero-particles" id="heroParticles"></div>
  <div class="hero-gradient-overlay"></div>
  <div class="container position-relative text-center" style="z-index: 2;">
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-icon">👤</span>
        <span>{{ gt('Dashboard') }}</span>
      </div>
      <h1 class="premium-hero-title">{{ gt('My Account') }}</h1>
      <p class="hero-subtitle">{{ gt('Manage your orders, profile, and preferences') }}</p>
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
  <div class="container-fluid">
    <div class="row cs_gap_y_70">
      <div class="col-lg-3">
        <div class="cs_filter_sidebar">
          <div class="cs_filter_sidebar_heading cs_medium">
            <div class="cs_filter_sidebar_heading_in">
              <i class="fa-regular fa-user"></i>
              <span>{{ gt('Account Menu') }}</span>
            </div>
          </div>
          <div class="cs_filter_sidebar_in">
            <div class="cs_filter_widget">
              <ul class="cs_filter_category cs_mp0 account-menu-list">
                <li>
                  <a href="#dashboard" class="cs_medium account-menu-item active" data-tab="dashboard">
                    <i class="fa-solid fa-chart-line"></i>{{ gt('Dashboard') }}
                  </a>
                </li>
                <li>
                  <a href="#profile" class="cs_medium account-menu-item" data-tab="profile">
                    <i class="fa-solid fa-user"></i>{{ gt('My Profile') }}
                  </a>
                </li>
                <li>
                  <a href="#orders" class="cs_medium account-menu-item" data-tab="orders">
                    <i class="fa-solid fa-bag-shopping"></i>{{ gt('My Orders') }}
                  </a>
                </li>
                <li>
                  <a href="#bulk-orders" class="cs_medium account-menu-item" data-tab="bulk-orders">
                    <i class="fa-solid fa-boxes-stacked"></i>{{ gt('Bulk Orders') }}
                  </a>
                </li>
                <li class="desktop-only-designs" style="display: none !important;">
                  <a href="#designs" class="cs_medium account-menu-item" data-tab="designs">
                    <i class="fa-solid fa-palette"></i>{{ gt('My Designs') }}
                  </a>
                </li>
                <li>
                  <a href="#address" class="cs_medium account-menu-item" data-tab="address">
                    <i class="fa-solid fa-location-dot"></i>{{ gt('Delivery Address') }}
                  </a>
                </li>
                <li>
                  <a href="#settings" class="cs_medium account-menu-item" data-tab="settings">
                    <i class="fa-solid fa-gear"></i>{{ gt('Account Settings') }}
                  </a>
                </li>
                <li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                  <a href="#" class="cs_medium account-menu-item logout-link" onclick="confirmLogout(event)">
                    <i class="fa-solid fa-right-from-bracket"></i>{{ gt('Logout') }}
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <!-- Dashboard Tab -->
        <div id="tab-dashboard" class="tab-content-panel active">
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold">{{ gt('Welcome') }}, {{ Auth::user()->name }}!</h2>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <div class="row cs_gap_y_30">
              <div class="col-md-4">
                <div class="cs_shop-card" style="background: #F9F9F9; border: 1px solid #E5E5E5;">
                  <div style="text-align: center; padding: 20px;">
                    <i class="fa-solid fa-bag-shopping" style="font-size: 36px; color: #1C30A3; margin-bottom: 15px;"></i>
                    <h3 class="cs_fs_21 cs_semibold mb-2">{{ gt('Total Orders') }}</h3>
                    <p class="cs_fs_28 cs_bold mb-0">{{ $user->orders->count() }}</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cs_shop-card" style="background: #F9F9F9; border: 1px solid #E5E5E5;">
                  <div style="text-align: center; padding: 20px;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 36px; color: #1C30A3; margin-bottom: 15px;"></i>
                    <h3 class="cs_fs_21 cs_semibold mb-2">{{ gt('Cart Items') }}</h3>
                    <p class="cs_fs_28 cs_bold mb-0">{{ $user->cartItems->count() }}</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="cs_shop-card" style="background: #F9F9F9; border: 1px solid #E5E5E5;">
                  <div style="text-align: center; padding: 20px;">
                    <i class="fa-solid fa-location-dot" style="font-size: 36px; color: #1C30A3; margin-bottom: 15px;"></i>
                    <h3 class="cs_fs_21 cs_semibold mb-2">{{ gt('Saved Address') }}</h3>
                    <p class="cs_fs_28 cs_bold mb-0">{{ $user->addresses->count() }}</p>
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
          $fullDetail = \App\Models\SampleOrderFullDetail::where('order_primary_id', $mpOrder->id)->first();
          if ($fullDetail && $fullDetail->country) {
          $country = trim($fullDetail->country);
          // Match country partially with bank_country
          $bankDetails = $allBankDetails->first(function($bank) use ($country) {
          return stripos($bank->bank_country, $country) !== false;
          });
          }

          // Fallback if no specific bank details for the country
          if (!$bankDetails) {
          $bankDetails = $allBankDetails->first();
          }
          }
          @endphp

          @if($mpOrder && $bankDetails)
          <div class="cs_height_30 cs_height_lg_30"></div>
          <div class="cs_shop-card" style="border: 2px solid #1C30A3; background: #f8faff;">
            <div class="d-flex align-items-center gap-3 mb-4">
              <div style="width: 50px; height: 50px; background: #1C30A3; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                🏦
              </div>
              <div>
                <h3 class="cs_fs_24 cs_semibold mb-0">{{ gt('Payment Information') }} (Order #{{ $mpOrder->order_id }})</h3>
                <p class="mb-0 text-muted">{{ gt('Manual Bank Transfer Details for') }} {{ $bankDetails->bank_country ?? '' }}</p>
              </div>
            </div>

            @if($mpOrder->delivery_status == 0)
            <div class="alert alert-warning mb-4">
              <i class="fa-solid fa-clock-rotate-left me-2"></i>
              {{ gt('Your order is pending. Please complete the payment using the bank details below and upload/send the proof.') }}
            </div>

            <div class="bank-info-container mb-4">
              <!-- Bank Country -->
              <div class="country-display mb-3">
                <span class="label text-uppercase text-muted fw-bold" style="font-size: 11px;">{{ gt('Bank Country') }}:</span>
                <span class="value fw-bold text-primary ms-2">{{ $bankDetails->bank_country ?? 'N/A' }}</span>
              </div>

              <!-- Description -->
              <div class="description-container p-3 bg-white border rounded-3 mb-3" style="font-size: 13px; line-height: 1.6;">
                <div class="description-content">
                  {!! $bankDetails->description ?? gt('No instructions provided.') !!}
                </div>
              </div>
            </div>

            <div class="mt-4 p-4" style="background: white; border-radius: 12px; border: 1px dashed #1C30A3;">
              <form id="proof-upload-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $mpOrder->order_id }}">

                <div class="row align-items-end g-3">
                  <div class="col-lg-7">
                    <div class="premium-form-group mb-0">
                      <label class="premium-form-label mb-2">{{ gt('Upload Transfer Proof') }}</label>
                      <p class="text-muted small mb-3">{{ gt('Upload a screenshot or photo of your transaction receipt (JPG, PNG, WebP up to 5MB).') }}</p>
                      <input type="file" name="payment_proof" id="payment_proof" class="premium-form-input" accept="image/*" required>
                    </div>
                  </div>
                  <div class="col-lg-5 text-lg-end pt-lg-4">
                    <button type="submit" class="cs_btn cs_style_1 cs_fs_16 cs_medium px-5 w-100 luxury_btn" id="upload-btn" style="height: 55px;">
                      {{ gt('Confirm & Upload') }}
                    </button>
                  </div>
                </div>
              </form>

              <div id="proof-preview-container" class="mt-3 {{ $mpOrder->payment_proof ? '' : 'd-none' }}">
                <label class="text-muted small d-block mb-2">{{ gt('Uploaded Proof:') }}</label>
                <div class="position-relative d-inline-block">
                  <img src="{{ $mpOrder->payment_proof ? env('MAIN_URL').'uploads/proof/'.$mpOrder->payment_proof : '' }}"
                    id="proof-preview"
                    style="max-width: 200px; border-radius: 8px; border: 1px solid #ddd;"
                    alt="Payment Proof">
                  <div class="mt-2">
                    <span class="badge bg-success">{{ gt('Already Submitted') }}</span>
                  </div>
                </div>
              </div>
            </div>
            @else
            <div class="alert alert-success d-flex align-items-center gap-3 py-4 border-0" style="background: #e7f5ed; color: #0a7c44;">
              <div style="font-size: 40px;">✅</div>
              <div>
                <h4 class="mb-1 fw-bold" style="color: #0a7c44;">{{ gt('Payment Verified!') }}</h4>
                <p class="mb-0">{{ gt('Your manual payment has been confirmed. Your order is now in the processing/packing stage.') }}</p>
              </div>
            </div>
            @endif
          </div>
          @endif
          <div class="cs_height_40 cs_height_lg_40"></div>
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold">{{ gt('Recent Orders') }}</h2>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Order ID') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Date') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Total') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Status') }}</th>
                    <th style="padding: 15px; text-align: center;" class="cs_medium">{{ gt('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($user->orders->take(3) as $order)
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <td style="padding: 15px; font-weight: 500;">{{ $order->order_id }}</td>
                    <td style="padding: 15px;">{{ $order->date_ordered_on ? $order->date_ordered_on->format('M d, Y') : $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 15px;">{{ format_currency($order->grand_total_amount) }}</td>
                    <td style="padding: 15px;">
                      <span style="color: {{ $order->status_color }}; font-weight: 500;">
                        {{ $order->delivery_status_text }}
                      </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                      <a href="javascript:void(0)" onclick="viewOrderDetails('{{ $order->order_id }}')" style="color: #1C30A3; text-decoration: underline;">{{ gt('View') }}</a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" style="padding: 40px; text-align: center;">{{ gt('No orders found.') }}</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Profile Tab -->
        <div id="tab-profile" class="tab-content-panel">
          <div class="cs_shop-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
              <h2 class="cs_fs_28 cs_semibold mb-0">{{ gt('Profile Information') }}</h2>
              <button type="button" id="edit-profile-btn" class="cs_btn cs_style_1 cs_fs_16 cs_medium" style="padding: 12px 30px;" onclick="toggleProfileEdit()">{{ gt('Edit Profile') }}</button>
            </div>
            <form id="profile-form">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('Customer Name') }}</label>
                    <input type="text" name="name" class="premium-form-input profile-input" value="{{ Auth::user()->name }}" readonly style="background-color: #f5f5f5;">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('Email ID (Cannot be changed)') }}</label>
                    <input type="email" class="premium-form-input" value="{{ Auth::user()->email }}" readonly style="background-color: #f5f5f5;">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('Contact Number') }}</label>
                    <input type="tel" name="phone_number" class="premium-form-input profile-input" value="{{ Auth::user()->phone_number }}" readonly style="background-color: #f5f5f5;">
                  </div>
                </div>
                <!-- <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('Gender') }}</label>
                    <select name="gender" class="premium-form-input premium-form-select profile-input" disabled style="background-color: #f5f5f5;">
                      <option value="">{{ gt('Select Gender') }}</option>
                      <option value="1" {{ Auth::user()->gender == 1 ? 'selected' : '' }}>{{ gt('Male') }}</option>
                      <option value="2" {{ Auth::user()->gender == 2 ? 'selected' : '' }}>{{ gt('Female') }}</option>
                      <option value="3" {{ Auth::user()->gender == 3 ? 'selected' : '' }}>{{ gt('Other') }}</option>
                    </select>
                  </div>
                </div> -->
                <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('User Type (Cannot be changed)') }}</label>
                    <input type="text" class="premium-form-input" value="{{ Auth::user()->user_type == 'B2B' ? gt('B2B') : gt('Normal User') }}" readonly style="background-color: #f5f5f5;">
                  </div>
                </div>
                @if(Auth::user()->user_type == 'B2B')
                <div class="col-lg-6">
                  <div class="premium-form-group">
                    <label class="premium-form-label">{{ gt('GST Number (Cannot be changed)') }}</label>
                    <input type="text" class="premium-form-input" value="{{ Auth::user()->gst_number }}" readonly style="background-color: #f5f5f5;">
                  </div>
                </div>
                @endif
              </div>
              <div id="profile-save-container" style="display: none; margin-top: 20px;">
                <button type="submit" class="cs_btn cs_style_1 cs_fs_16 cs_medium" style="background-color: #28a745;">{{ gt('Save Changes') }}</button>
                <button type="button" class="cs_btn cs_style_1 cs_fs_16 cs_medium" style="background-color: #6c757d; margin-left:10px;" onclick="toggleProfileEdit(false)">{{ gt('Cancel') }}</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Orders Tab -->
        <div id="tab-orders" class="tab-content-panel">
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold">{{ gt('My Orders') }}</h2>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Order ID') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Date') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Total') }}</th>
                    <th style="padding: 15px; text-align: left;" class="cs_medium">{{ gt('Status') }}</th>
                    <th style="padding: 15px; text-align: center;" class="cs_medium">{{ gt('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($user->orders as $order)
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <td style="padding: 15px; font-weight: 500;">{{ $order->order_id }}</td>
                    <td style="padding: 15px;">{{ $order->date_ordered_on ? $order->date_ordered_on->format('M d, Y') : $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 15px;">{{ format_currency($order->grand_total_amount) }}</td>
                    <td style="padding: 15px;">
                      <span style="color: {{ $order->status_color }}; font-weight: 500;">
                        {{ $order->delivery_status_text }}
                      </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                      <a href="javascript:void(0)" onclick="viewOrderDetails('{{ $order->order_id }}')" style="color: #1C30A3; text-decoration: underline;">{{ gt('View Details') }}</a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" style="padding: 40px; text-align: center;">
                      <p class="mb-3">{{ gt("You haven't placed any orders yet.") }}</p>
                      <a href="/shop" class="cs_btn cs_style_1 cs_fs_14 cs_medium" style="padding: 8px 20px;">{{ gt('Start Shopping') }}</a>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Bulk Orders Tab -->
        <div id="tab-bulk-orders" class="tab-content-panel">
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold">{{ gt('Bulk Orders') }}</h2>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
                <thead>
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Request ID') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Date') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Name') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Email') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('User Type') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Product Type') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Product ID') }}</th>
                    <th style="padding: 15px; text-align: left; white-space: nowrap;" class="cs_medium">{{ gt('Quantity') }}</th>
                    <th style="padding: 15px; text-align: left; min-width: 200px;" class="cs_medium">{{ gt('Notes') }}</th>
                    <th style="padding: 15px; text-align: center; white-space: nowrap;" class="cs_medium">{{ gt('Attachment') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($bulkOrders as $bulk)
                  <tr style="border-bottom: 1px solid #E5E5E5;">
                    <td style="padding: 15px; font-weight: 500; white-space: nowrap;">{{ $bulk->order_id }}</td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->created_at ? $bulk->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->name }}</td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->email }}</td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->user_type }}</td>
                    <td style="padding: 15px; white-space: nowrap;">
                      @if($bulk->product_type == 'own_design') {{ gt('Own Design') }}
                      @elseif($bulk->product_type == 'custom_design') {{ gt('Bulk Custom') }}
                      @elseif($bulk->product_type == 'own_custom') {{ gt('Own Custom') }}
                      @else {{ $bulk->product_type ?: 'N/A' }} @endif
                    </td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->product_id ?: 'N/A' }}</td>
                    <td style="padding: 15px; white-space: nowrap;">{{ $bulk->quantity }}</td>
                    <td style="padding: 15px;">{{ $bulk->notes ?: 'N/A' }}</td>
                    <td style="padding: 15px; text-align: center; white-space: nowrap;">
                      @if($bulk->custom_image)
                      <a href="{{ asset('storage/' . $bulk->custom_image) }}" target="_blank" style="color: #1C30A3; text-decoration: underline;">{{ gt('View Image') }}</a>
                      @else
                      <span class="text-muted">N/A</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="10" style="padding: 40px; text-align: center;">
                      <p class="mb-3">{{ gt("You haven't requested any bulk orders yet.") }}</p>
                      <a href="/bulk-order" class="cs_btn cs_style_1 cs_fs_14 cs_medium" style="padding: 8px 20px;">{{ gt('Request Bulk Order') }}</a>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Designs Tab -->
        <div id="tab-designs" class="tab-content-panel desktop-only-designs" style="display: none !important;">
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold">{{ gt('My Saved Designs') }}</h2>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <div class="row cs_gap_y_30">
              @forelse($user->designs->sortByDesc('updated_at') as $customproduct_designs)
              <div class="col-lg-4 col-md-6">
                <div class="cs_shop-card" style="border: 1px solid #E5E5E5; padding: 15px; border-radius: 12px; transition: transform 0.3s ease;">
                  <div class="design-preview-box mb-3" style="background: #f8f9ff; border-radius: 8px; overflow: hidden; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; position: relative;">
                    @if($customproduct_designs->thumbnail_path || $customproduct_designs->preview_image_front)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('shared')->url($customproduct_designs->thumbnail_path ?: $customproduct_designs->preview_image_front) }}" alt="{{ $customproduct_designs->design_name }}" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                    <div class="text-muted"><i class="fa-solid fa-image fa-3x"></i></div>
                    @endif
                    <div class="design-overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
                      <a href="{{ route('customize.design', ['product_id' => $customproduct_designs->customproduct_id]) }}?design_id={{ $customproduct_designs->id }}" class="cs_btn cs_style_1 cs_fs_12 px-3">{{ gt('Edit Design') }}</a>
                    </div>
                  </div>
                  <style>
                    .design-preview-box:hover .design-overlay {
                      opacity: 1 !important;
                    }

                    .design-preview-box:hover {
                      transform: translateY(-5px);
                    }
                  </style>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="cs_fs_16 cs_semibold mb-1">{{ $customproduct_designs->design_name ?: 'Untitled Design' }}</h4>
                      <p class="small text-muted mb-0">{{ gt('Last edited') }}: {{ $customproduct_designs->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="dropdown">
                      <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('customize.design', ['product_id' => $customproduct_designs->customproduct_id]) }}?design_id={{ $customproduct_designs->id }}">{{ gt('Edit') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('order-assets.zip', ['orderId' => $customproduct_designs->id]) }}">{{ gt('Download Original Assets') }}</a></li>
                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteDesign('{{ $customproduct_designs->id }}')">{{ gt('Delete') }}</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @empty
              <div class="col-12">
                <div class="text-center py-5">
                  <p class="mb-3">{{ gt("You haven't saved any designs yet.") }}</p>
                  <a href="{{ route('customize-products.index') }}" class="cs_btn cs_style_1 cs_fs_14 cs_medium">{{ gt('Create a Design') }}</a>
                </div>
              </div>
              @endforelse
            </div>
          </div>
        </div>

        <div id="tab-address" class="tab-content-panel">
          <div class="cs_shop-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
              <h2 class="cs_fs_28 cs_semibold mb-0">{{ gt('Delivery Addresses') }}</h2>
              <button type="button" class="cs_btn cs_style_1 cs_fs_16 cs_medium" style="padding: 12px 30px;" onclick="openAddressModal()">+ {{ gt('Add New Address') }}</button>
            </div>
            <div class="row cs_gap_y_30">
              @forelse($user->addresses as $address)
              <div class="col-lg-6">
                <div class="cs_shop-card" style="background: #F9F9F9; border: 1px solid #E5E5E5; position: relative; min-height: 250px;">
                  @if($user->user_default_address_id == $address->id)
                  <span style="position: absolute; top: 15px; right: 15px; background: #1C30A3; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">{{ gt('Default') }}</span>
                  @endif

                  <h4 class="cs_fs_18 cs_semibold mb-2">
                    @if($address->address_type_id == 1) {{ gt('Home') }}
                    @elseif($address->address_type_id == 2) {{ gt('Work') }}
                    @else {{ gt('Others') }}
                    @endif
                  </h4>

                  <p class="mb-2"><strong>{{ $address->address_username }}</strong></p>
                  <p class="mb-1">{{ $address->address_line_one }}</p>
                  @if($address->address_line_two)<p class="mb-1">{{ $address->address_line_two }}</p>@endif
                  @if($address->landmark)<p class="mb-1">{{ gt('Landmark') }}: {{ $address->landmark }}</p>@endif
                  <p class="mb-1">{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}</p>
                  <p class="mb-1">{{ $address->country }}</p>
                  <p class="mb-3">{{ gt('Phone') }}: {{ $address->address_phone_number }}</p>

                  <div style="display: flex; gap: 15px; margin-top: auto;">
                    <a href="javascript:void(0)" onclick='openAddressModal({{ json_encode($address) }})' style="color: #1C30A3; text-decoration: underline;">{{ gt('Edit') }}</a>
                    <a href="javascript:void(0)" onclick="deleteAddress({{ $address->id }})" style="color: #dc3545; text-decoration: underline;">{{ gt('Delete') }}</a>
                    @if($user->user_default_address_id != $address->id)
                    <a href="javascript:void(0)" onclick="setDefaultAddress({{ $address->id }})" style="color: #1C30A3; text-decoration: underline;">{{ gt('Set as Default') }}</a>
                    @endif
                  </div>
                </div>
              </div>
              @empty
              <div class="col-lg-12">
                <p class="text-center py-5">{{ gt('No addresses found. Click "+ Add New Address" to add one.') }}</p>
              </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Settings Tab -->
        <div id="tab-settings" class="tab-content-panel">
          <div class="cs_shop-card">
            <h2 class="cs_fs_28 cs_semibold mb-4">{{ gt('Account Settings') }}</h2>

            <!-- Change Password Section -->
            <div class="auth-card" style="margin-bottom: 30px;">
              <h4 class="cs_fs_21 cs_semibold mb-4"><i class="fa-solid fa-lock" style="margin-right: 10px; color: #1C30A3;"></i>{{ gt('Change Password') }}</h4>
              <form id="change-password-form">
                @csrf
                <div class="row">
                  <div class="col-lg-6">
                    <div class="premium-form-group">
                      <label class="premium-form-label">{{ gt('Current Password') }}</label>
                      <input type="password" name="current_password" class="premium-form-input" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="premium-form-group">
                      <label class="premium-form-label">{{ gt('New Password') }}</label>
                      <input type="password" name="password" class="premium-form-input" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="premium-form-group">
                      <label class="premium-form-label">{{ gt('Confirm New Password') }}</label>
                      <input type="password" name="password_confirmation" class="premium-form-input" required>
                    </div>
                  </div>
                </div>
                <button type="submit" class="cs_btn cs_style_1 cs_fs_14 cs_medium" style="padding: 12px 30px;">{{ gt('Update Password') }}</button>
              </form>
            </div>

            <!-- Notification Preferences -->
            <!-- <div style="margin-bottom: 40px;">
              <h4 class="cs_fs_21 cs_semibold mb-3">Notification Preferences</h4>
              <div style="display: flex; flex-direction: column; gap: 15px;">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                  <input type="checkbox" checked style="width: 18px; height: 18px; accent-color: #1C30A3;">
                  <span>Order updates via Email</span>
                </label>
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                  <input type="checkbox" checked style="width: 18px; height: 18px; accent-color: #1C30A3;">
                  <span>Order updates via SMS</span>
                </label>
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                  <input type="checkbox" style="width: 18px; height: 18px; accent-color: #1C30A3;">
                  <span>Promotional offers and newsletters</span>
                </label>
              </div>
            </div> -->

            <!-- Delete Account -->
            <div style="padding: 20px; background: #fff5f5; border: 1px solid #ffcccc; border-radius: 10px;">
              <h4 class="cs_fs_21 cs_semibold mb-2" style="color: #dc3545;">{{ gt('Delete Account') }}</h4>
              <p class="mb-3">{{ gt('Once you delete your account, there is no going back. Please be certain.') }}</p>
              <button type="button" class="cs_btn cs_style_1 cs_fs_16 cs_medium" style="padding: 12px 30px; background-color: #dc3545;" onclick="confirmDeleteAccount()">{{ gt('Delete My Account') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
</section>

<style>
  /* Premium Hero Section */
  .premium-hero-section {
    min-height: 400px;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%);
    position: relative;
    padding: 120px 0 180px
  }

  .hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1
  }

  .hero-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, .3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(240, 147, 251, .3) 0%, transparent 50%);
    z-index: 1
  }

  .hero-content {
    position: relative;
    z-index: 2
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, .2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, .3);
    padding: 10px 24px;
    border-radius: 50px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 30px
  }

  .premium-hero-title {
    font-size: 56px;
    font-weight: 900;
    font-family: 'Merriweather', serif;
    color: white;
    margin: 0 0 20px 0;
    line-height: 1.2
  }

  .hero-subtitle {
    font-size: 18px;
    color: rgba(255, 255, 255, .9);
    margin: 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto
  }

  .hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg)
  }

  .hero-wave svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 80px
  }

  .wave-fill {
    fill: #fff
  }

  .cs_height_100 {
    height: 100px
  }

  .cs_height_140 {
    height: 140px
  }

  /* Premium Contact Section - Animated Gradient Background */
  .premium-contact-section {
    position: relative;
    overflow: hidden
  }

  .animated-gradient-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 25%, #f0f4ff 50%, #e8f0ff 75%, #f8faff 100%);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    z-index: 0
  }

  .premium-contact-section>*:not(.animated-gradient-bg) {
    position: relative;
    z-index: 1
  }

  @keyframes gradientShift {
    0% {
      background-position: 0% 50%
    }

    50% {
      background-position: 100% 50%
    }

    100% {
      background-position: 0% 50%
    }
  }

  /* Account Menu Tab Styles */
  .account-menu-list {
    list-style: none;
    padding: 0;
    margin: 0
  }

  .account-menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    color: #5E5E5E;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
    margin-bottom: 4px
  }

  .account-menu-item i {
    width: 20px;
    text-align: center;
    font-size: 16px;
    transition: all 0.3s ease
  }

  .account-menu-item:hover {
    background: linear-gradient(135deg, rgba(28, 48, 163, 0.08) 0%, rgba(37, 65, 200, 0.08) 100%);
    color: #1C30A3;
    transform: translateX(5px)
  }

  .account-menu-item:hover i {
    color: #1C30A3
  }

  .account-menu-item.active {
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(28, 48, 163, 0.3)
  }

  .account-menu-item.active i {
    color: #fff
  }

  .account-menu-item.logout-link:hover {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.15) 100%);
    color: #dc3545
  }

  .account-menu-item.logout-link:hover i {
    color: #dc3545
  }

  /* Tab Content Panels */
  .tab-content-panel {
    display: none;
    animation: fadeIn 0.4s ease
  }

  .tab-content-panel.active {
    display: block
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px)
    }

    to {
      opacity: 1;
      transform: translateY(0)
    }
  }

  @media(max-width:991px) {
    .cs_height_lg_60 {
      height: 60px !important
    }

    .cs_height_lg_80 {
      height: 80px !important
    }
  }

  @media (max-width: 1300px) {
    .desktop-only-designs {
      display: none !important;
    }
  }
</style>
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

        // Remove active class from all menu items
        menuItems.forEach(mi => mi.classList.remove('active'));
        // Add active class to clicked item
        this.classList.add('active');

        // Get target tab
        const targetTab = this.getAttribute('data-tab');

        // Hide all tab panels
        tabPanels.forEach(panel => panel.classList.remove('active'));

        // Show target tab panel
        const targetPanel = document.getElementById('tab-' + targetTab);
        if (targetPanel) {
          targetPanel.classList.add('active');
        }

        // Update URL hash without scrolling
        history.replaceState(null, null, '#' + targetTab);
      });
    });

    // Check URL hash on load
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

  // --- Profile & Settings Management --- //

  function toggleProfileEdit(enable = true) {
    const inputs = document.querySelectorAll('.profile-input');
    const editBtn = document.getElementById('edit-profile-btn');
    const saveContainer = document.getElementById('profile-save-container');

    inputs.forEach(input => {
      if (input.tagName === 'SELECT') {
        input.disabled = !enable;
        input.style.backgroundColor = enable ? '#fff' : '#f5f5f5';
        input.style.border = enable ? '1px solid #1C30A3' : '1px solid #E5E5E5';
      } else {
        input.readOnly = !enable;
        input.style.backgroundColor = enable ? '#fff' : '#f5f5f5';
        input.style.border = enable ? '1px solid #1C30A3' : '1px solid #E5E5E5';
      }
    });

    editBtn.style.display = enable ? 'none' : 'block';
    saveContainer.style.display = enable ? 'block' : 'none';
  }

  // --- Active Tab Hash Handling & Form Submissions --- //
  $(document).ready(function() {
    // Profile Update Submission
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

    // Change Password Submission
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

    // Check for hash in URL on load
    const hash = window.location.hash;
    if (hash) {
      const tabName = hash.replace('#', '');
      const targetTab = $(`.account-menu-item[data-tab="${tabName}"]`);
      if (targetTab.length) {
        targetTab.click();
      }
    }

    // Update hash on tab click
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
            // Use current session currency for display (prices stored in USD)
            const cSymbol = window.__currency?.symbol || '$';
            const cRate = window.__currency?.rate || 1;
            let itemsHtml = '';

            if (order.items && order.items.length > 0) {
              order.items.forEach(item => {
                let imgSrc = item.product_image;
                if (!imgSrc) {
                  imgSrc = 'https://placehold.co/60x60?text=No+Img';
                } else if (!imgSrc.startsWith('http')) {
                  // Remove leading slash if present to avoid double slash with env(APP_URL)
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
              // Encode bank details safely for transmission to the other modal
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
                    <div>
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
                  
                  ${order.items && order.items.some(item => item.design_id) ? `
                    <div style="display: none; margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="/order-assets/zip/${order.order_id}" class="cs_btn cs_style_1 cs_fs_13 px-4 py-2" style="background-color: #28a745; border-color: #28a745;">
                            <i class="fa-solid fa-file-zipper"></i> {{ gt('Download All Design Assets (ZIP)') }}
                        </a>
                        <p style="margin-top: 5px; font-size: 11px; color: #666;">{{ gt('Includes original high-quality images and icons used in your designs.') }}</p>
                    </div>
                  ` : ''}
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

  // --- Payment Proof Upload Handling --- //
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