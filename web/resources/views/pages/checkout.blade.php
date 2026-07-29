@extends('layouts.app')
@section('content')
<section class="premium-hero-section position-relative overflow-hidden">
  <div class="hero-particles" id="heroParticles"></div>
  <div class="hero-gradient-overlay"></div>
  <div class="container position-relative text-center" style="z-index:2">
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-icon">💳</span>
        <span>{{ gt('Secure Payment') }}</span>
      </div>
      <h1 class="premium-hero-title">{{ gt('Checkout') }}</h1>
      <p class="hero-subtitle">{{ gt('Complete your order securely') }}</p>
    </div>
  </div>
  <div class="hero-wave">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" width="100%" height="80">
      <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path>
      <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path>
      <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path>
    </svg>
  </div>
</section>
<section style="background:#fff">
  <div class="cs_height_100 cs_height_lg_60"></div>
  <div class="container">
    <div class="row">
      <div class="col-xl-7">
        <!-- <p class="cs_checkout-alert m-0">Have a coupon? <a href="">Click here to enter your code</a></p> -->
        <div class="cs_height_40 cs_height_lg_40"></div>
        <h2 class="cs_checkout-title cs_fs_28">{{ gt('Billing Details') }}</h2>
        <div class="cs_height_45 cs_height_lg_40"></div>
        <div class="row">
          <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <label class="cs_shop-label mb-0">{{ gt('Select Shipping Address') }} *</label>
            <a href="{{ route('myaccount') }}#address" class="cs_btn_link text-primary fw-bold" style="font-size: 13px;">+ {{ gt('Add New Address') }}</a>
          </div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Select Shipping Address') }} *</label>
              <select id="address-selector" class="premium-form-input premium-form-select" name="address_id">
                @foreach($addresses as $addr)
                  <option value="{{ $addr->id }}" {{ $defaultAddress && $defaultAddress->id == $addr->id ? 'selected' : '' }}
                    data-details="{{ json_encode($addr) }}">
                    {{ $addr->address_type_name }}: {{ $addr->address_line_one }}, {{ $addr->city }}
                  </option>
                @endforeach
                @if($addresses->isEmpty())
                  <option value="">{{ gt('No addresses found. Click "Add New Address" above.') }}</option>
                @endif
              </select>
            </div>
          </div>
          <div class="cs_height_20"></div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('First Name') }} *</label>
              <input type="text" id="billing-first-name" class="premium-form-input" readonly style="background-color: #f9fafb !important;">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Phone') }} *</label>
              <input type="text" id="billing-phone" class="premium-form-input" readonly style="background-color: #f9fafb !important;">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Street address') }} *</label>
              <input type="text" id="billing-address" class="premium-form-input" readonly style="background-color: #f9fafb !important;">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('Town / City') }} *</label>
              <input type="text" id="billing-city" class="premium-form-input" readonly style="background-color: #f9fafb !important;">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="premium-form-group">
              <label class="premium-form-label">{{ gt('ZIP Code') }} *</label>
              <input type="text" id="billing-pincode" class="premium-form-input" readonly style="background-color: #f9fafb !important;">
            </div>
          </div>
        </div>
        <div class="cs_height_45 cs_height_lg_45"></div>
        <h2 class="cs_checkout-title">{{ gt('Additional information') }}</h2>
        <div class="cs_height_25 cs_height_lg_25"></div>
        <div class="premium-form-group">
          <label class="premium-form-label">{{ gt('Order notes (optional)') }}</label>
          <textarea cols="30" rows="6" class="premium-form-input" placeholder="{{ gt('Special instructions for delivery...') }}"></textarea>
        </div>
        <div class="cs_height_30 cs_height_lg_30"></div>
        <h2 class="cs_checkout-title">{{ gt('Printing Method') }} *</h2>
        <div class="cs_height_20"></div>
        <div class="d-flex gap-4">
          <div class="form-check custom-radio">
            <input class="form-check-input" type="radio" name="printing_method" id="method_ctf" value="CTF" checked>
            <label class="form-check-label fw-bold" for="method_ctf">
              <span class="d-block">CTF</span>
              <small class="text-muted" style="font-size: 11px;">(Detailed/Complex prints)</small>
            </label>
          </div>
          <div class="form-check custom-radio">
            <input class="form-check-input" type="radio" name="printing_method" id="method_dtg" value="DTG">
            <label class="form-check-label fw-bold" for="method_dtg">
              <span class="d-block">DTG</span>
              <small class="text-muted" style="font-size: 11px;">(Direct to Garment)</small>
            </label>
          </div>
        </div>
        <div class="cs_height_30 cs_height_lg_30"></div>
      </div>
      <div class="col-xl-5">
        <div class="cs_shop-side-spacing">
          <div class="auth-card" style="padding: 2rem;">
            <h2 class="cs_fs_21">{{ gt('Your order') }}</h2>
            <table>
              <tbody id="checkout-order-items">
                <tr class="cs_semi_bold">
                  <td>{{ gt('Products') }}</td>
                  <td class="text-end">{{ gt('Amount') }}</td>
                </tr>
                @foreach($cartItems as $item)
                  <tr>
                    <td>
                      <div class="d-flex align-items-start gap-3">
                        @if($item->design_id && $item->design)
                           <x-design-preview :design="$item->design" width="40" />
                        @endif
                        <div>
                           {{ $item->product_name }} <br>
                           @if($item->product_type === 'own')
                             <small style='color: #666; font-size: 11px;'>{{ gt('Cloth Type') }}: {{ $item->product_color }} | {{ gt('Size') }}: {{ $item->product_size }} | {{ gt('Qty') }}: {{ $item->product_quantity }}</small>
                           @else
                             <small style='color: #666; font-size: 11px;'>{{ gt('Color') }}: <span style="display:inline-block; width:12px; height:12px; border-radius:50%; border:1px solid rgba(0,0,0,0.1); vertical-align:middle; background-color:{{ $item->product_color }}; box-shadow:0 1px 3px rgba(0,0,0,0.1);" title="{{ $item->product_color }}"></span> | {{ gt('Size') }}: {{ $item->product_size }} | {{ gt('Qty') }}: {{ $item->product_quantity }}</small>
                           @endif
                        </div>
                      </div>
                    </td>
                    <td class='text-end'>{{ format_currency($item->price * $item->product_quantity) }}</td>
                  </tr>
                @endforeach
                <tr class='cs_semi_bold'>
                  <td>{{ gt('Total') }}</td>
                  <td class='text-end'>{{ format_currency($subtotal) }}</td>
                </tr>
              </tbody>
            </table>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <!-- <button id="place-order-btn" class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100">{{ gt('Place Order (COD)') }}</button> -->
            <div class="cs_height_15"></div>
            @if(isset($totalQuantity) && isset($paypalMaxQty) && $totalQuantity <= $paypalMaxQty)
                <button id="paypal-btn" class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100" style="background:#0070BA">💳 {{ gt('Pay with PayPal') }}</button>
                <div class="cs_height_15"></div>
            @else
                <div class="alert alert-warning mb-3" style="font-size: 14px; background-color: #fff3cd; color: #856404; border-color: #ffeeba; padding: 10px; border-radius: 5px;">
                    <i class="fas fa-info-circle me-1"></i> {{ gt('PayPal is only available for orders up to') }} {{ $paypalMaxQty ?? 10 }} {{ gt('items. For larger orders, please use Bank Transfer.') }}
                </div>
            @endif
            <button id="bank-transfer-btn" class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100" style="background:#2E5DD8">🏦 {{ gt('Bank Transfer') }}</button>
            
            <!-- Bank Country Selection (Hidden by default, shown for Bank Transfer) -->
            <div id="bank-country-container" class="mt-3" style="display:none;">
              <label class="premium-form-label mb-1" style="font-size: 12px; color: #4a5568;">{{ gt('Select Bank Country') }} *</label>
              <select id="bank-country-selector" class="premium-form-input premium-form-select" style="padding: 8px 12px; height: auto;">
                <option value="">-- {{ gt('Choose Country') }} --</option>
                @foreach($bankDetails->pluck('bank_country')->unique() as $country)
                  <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
              </select>
            </div>

            <!-- Dynamic Bank Info Container -->
            <div id="dynamic-bank-info" class="mt-3 p-3 rounded shadow-sm" style="background:#f8f9fa; border:1px solid #e2e8f0; display:none; font-size:13px; color:#4a5568;">
              <h6 class="mb-2 fw-bold text-dark"><i class="fas fa-university me-1"></i> {{ gt('Bank Account Details') }}</h6>
              <div id="bank-info-content" class="mb-2"></div>
              <small class="text-muted d-block border-top pt-2 mt-2"><i class="fas fa-info-circle"></i> {{ gt('Please transfer the exact amount and save the transaction receipt.') }}</small>
              <div class="mt-3">
                <button id="confirm-bank-transfer-btn" class="cs_btn cs_style_1 cs_fs_14 cs_medium w-100" style="background:#1a202c; height:40px; line-height:40px;">{{ gt('Place Order & Get Details') }}</button>
              </div>
            </div>

          </div>
          <div class="cs_height_50 cs_height_lg_30"></div>
          <!-- <div class="cs_shop-card">
            <h2 class="cs_fs_21">Payment</h2>
            <table>
              <tbody>
                <tr>
                  <td>
                    <div class="form-check cs_fs_16">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="">
                      <label class="form-check-label m-0 cs_semi_bold" for="flexCheckDefault">
                        Cash on delivery
                      </label>
                    </div>
                    <p class="m-0 cs_payment_text">Pay with cash upon delivery.</p>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="cs_height_20 cs_height_lg_20"></div>
            <p class="m-0 cs_payment_text">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="">privacy policy</a>.</p>
            <div class="cs_height_20 cs_height_lg_20"></div>
            <button class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100">Pay Now</button>
          </div> -->
          <div class="cs_height_30 cs_height_lg_30"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="cs_height_140 cs_height_lg_80"></div>
</section>


<style>.premium-hero-section{min-height:400px;display:flex;align-items:center;background:linear-gradient(135deg,#1C30A3 0%,#2541C8 50%,#3B5FE0 100%);position:relative;padding:120px 0 180px}.hero-particles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:1}.hero-gradient-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(circle at 20% 50%,rgba(102,126,234,.3) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(240,147,251,.3) 0%,transparent 50%);z-index:1}.hero-content{position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);padding:10px 24px;border-radius:50px;color:white;font-size:14px;font-weight:500;margin-bottom:30px}.premium-hero-title{font-size:56px;font-weight:900;font-family:'Merriweather',serif;color:white;margin:0 0 20px 0;line-height:1.2}.hero-subtitle{font-size:18px;color:rgba(255,255,255,.9);margin:0;max-width:600px;margin-left:auto;margin-right:auto}.hero-wave{position:absolute;bottom:0;left:0;width:100%;overflow:hidden;line-height:0;transform:rotate(180deg)}.hero-wave svg{position:relative;display:block;width:calc(100% + 1.3px);height:80px}.wave-fill{fill:#fff}.cs_height_100{height:100px}.cs_height_140{height:140px}@media(max-width:991px){.cs_height_lg_60{height:60px!important}.cs_height_lg_80{height:80px!important}}</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const addressSelector = document.getElementById('address-selector');
    
    function updateBillingDisplay() {
      if (!addressSelector) return;
      const selectedOption = addressSelector.options[addressSelector.selectedIndex];
      if (selectedOption && selectedOption.dataset.details) {
        const details = JSON.parse(selectedOption.dataset.details);
        const fullName = details.address_username || ((details.address_first_name || '') + ' ' + (details.address_last_name || '')).trim();
        const fNameEl = document.getElementById('billing-first-name');
        if (fNameEl) fNameEl.value = details.address_username || details.address_first_name || '';

        const lNameEl = document.getElementById('billing-last-name');
        if (lNameEl) lNameEl.value = details.address_username ? '' : (details.address_last_name || '');

        const phoneEl = document.getElementById('billing-phone');
        if (phoneEl) phoneEl.value = details.address_phone_number || '';

        const addrEl = document.getElementById('billing-address');
        if (addrEl) addrEl.value = details.address_line_one || '';

        const cityEl = document.getElementById('billing-city');
        if (cityEl) cityEl.value = details.city || '';

        const pinEl = document.getElementById('billing-pincode');
        if (pinEl) pinEl.value = details.pincode || '';
        
        // Show matching bank details by country
        updateBankDetailsPreview(details.country);
      }
    }

    const bankDetailsData = @json($bankDetails ?? []);

    if (addressSelector) {
      addressSelector.addEventListener('change', updateBillingDisplay);
      updateBillingDisplay();
    }

    // Toggle Bank Country Container
    const bankTransferBtn = document.getElementById('bank-transfer-btn');
    const bankCountryContainer = document.getElementById('bank-country-container');
    const bankCountrySelector = document.getElementById('bank-country-selector');
    
    if (bankTransferBtn) {
      bankTransferBtn.addEventListener('click', function() {
        if (bankCountryContainer.style.display === 'none') {
           bankCountryContainer.style.display = 'block';
           bankTransferBtn.innerHTML = "🏦 {{ gt('Cancel Bank Transfer') }}";
           bankTransferBtn.style.background = "#4a5568";
        } else {
           bankCountryContainer.style.display = 'none';
           bankTransferBtn.innerHTML = "🏦 {{ gt('Bank Transfer') }}";
           bankTransferBtn.style.background = "#2E5DD8";
           document.getElementById('dynamic-bank-info').style.display = 'none';
        }
      });
    }

    if (bankCountrySelector) {
      bankCountrySelector.addEventListener('change', function() {
        updateBankDetailsPreview(this.value);
      });
    }

    // COD Place Order
    const placeOrderBtn = document.getElementById('place-order-btn');
    if (placeOrderBtn) {
      placeOrderBtn.addEventListener('click', function() {
        submitOrder('cod');
      });
    }

    // PayPal Payment
    const paypalBtn = document.getElementById('paypal-btn');
    if (paypalBtn) {
      paypalBtn.addEventListener('click', function() {
        startPayPalPayment();
      });
    }

    function submitOrder(method, paymentData = {}) {
      const addressId = addressSelector.value;
      if (!addressId) {
        Swal.fire("{{ gt('Warning') }}", "{{ gt('Please select an address') }}", 'warning');
        return;
      }

      if (placeOrderBtn) placeOrderBtn.disabled = true;
      if (paypalBtn) paypalBtn.disabled = true;
      if (document.getElementById('bank-transfer-btn')) document.getElementById('bank-transfer-btn').disabled = true;

      showLoader("{{ gt('Placing your order...') }}");

      $.ajax({
        url: "{{ route('order.place') }}",
        method: 'POST',
        data: {
          _token: "{{ csrf_token() }}",
          address_id: addressId,
          payment_method: method,
          printing_method: document.querySelector('input[name="printing_method"]:checked')?.value,
          bank_country: method === 'mp' ? document.getElementById('bank-country-selector').value : null,
          ...paymentData
        },
        success: function(res) {
          if (res.success) {
            showLoader("{{ gt('Redirecting...') }}");
            if (method === 'mp') {
              window.location.href = "{{ route('bank.details') }}?order_id=" + res.order_id;
            } else {
              window.location.href = res.redirect;
            }
          } else {
            hideLoader();
            Swal.fire("{{ gt('Error') }}", res.message, 'error');
            if (placeOrderBtn) placeOrderBtn.disabled = false;
            if (paypalBtn) paypalBtn.disabled = false;
            if (document.getElementById('bank-transfer-btn')) document.getElementById('bank-transfer-btn').disabled = false;
          }
        },
        error: function(xhr) {
          hideLoader();
          Swal.fire("{{ gt('Error') }}", xhr.responseJSON.message || "{{ gt('Something went wrong') }}", 'error');
          if (placeOrderBtn) placeOrderBtn.disabled = false;
          if (paypalBtn) paypalBtn.disabled = false;
          if (document.getElementById('bank-transfer-btn')) document.getElementById('bank-transfer-btn').disabled = false;
        }
      });
    }


    function updateBankDetailsPreview(country) {
        const infoDiv = document.getElementById('dynamic-bank-info');
        const contentDiv = document.getElementById('bank-info-content');
        
        if (!country) {
            if (infoDiv) infoDiv.style.display = 'none';
            return;
        }

        const details = bankDetailsData.find(b => 
            b.bank_country && b.bank_country.toLowerCase().trim() === country.toLowerCase().trim()
        );

        if (details) {
            contentDiv.innerHTML = `
                <div class="bank-details-description">
                    ${details.description || '<p class="text-muted">No details provided.</p>'}
                </div>
            `;
            infoDiv.style.display = 'block';
        } else {
            if (infoDiv) infoDiv.style.display = 'none';
        }
    }

    // Confirm Bank Transfer Order
    const confirmBankBtn = document.getElementById('confirm-bank-transfer-btn');
    if (confirmBankBtn) {
      confirmBankBtn.addEventListener('click', function() {
        submitOrder('mp');
      });
    }

    function startPayPalPayment() {
      const addressId = addressSelector.value;
      if (!addressId) {
        Swal.fire("{{ gt('Warning') }}", "{{ gt('Please select an address') }}", 'warning');
        return;
      }

      paypalBtn.disabled = true;
      showLoader("{{ gt('Connecting to PayPal...') }}");

      $.ajax({
        url: "{{ route('paypal.create') }}",
        method: 'POST',
        data: {
          _token: "{{ csrf_token() }}",
          address_id: addressId,
          printing_method: document.querySelector('input[name="printing_method"]:checked')?.value
        },
        success: function(res) {
          if (res.success && res.approval_url) {
            showLoader("{{ gt('Redirecting to PayPal...') }}");
            window.location.href = res.approval_url;
          } else {
            hideLoader();
            Swal.fire("{{ gt('Error') }}", res.message || "{{ gt('Failed to create payment') }}", 'error');
            paypalBtn.disabled = false;
          }
        },
        error: function(xhr) {
          hideLoader();
          Swal.fire("{{ gt('Error') }}", xhr.responseJSON?.message || "{{ gt('Failed to create payment') }}", 'error');
          paypalBtn.disabled = false;
        }
      });
    }

  });
</script>
@endsection
