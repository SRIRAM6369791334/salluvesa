@extends('layouts.app')

@section('content')
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center" style="z-index:2">
      <div class="hero-content">
        <div class="hero-badge"><span class="badge-icon">🛒</span><span>{{ gt('Shopping') }}</span></div>
        <h1 class="premium-hero-title">{{ gt('Shopping Cart') }}</h1>
        <p class="hero-subtitle">{{ gt('Review your items and proceed to checkout') }}</p>
      </div>
    </div>
    <div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path></svg></div>
  </section>
  <section class="premium-contact-section">
    <div class="animated-gradient-bg"></div>
    <div class="cs_height_100 cs_height_lg_60"></div>
    <div class="container">
    <div class="row">
      <div class="col-xl-8">
        <div class="table-responsive">
          <table class="cs_cart_table">
            <thead>
              <tr>
                <th>{{ gt('Product') }}</th>
                <th>{{ gt('Price') }}</th>
                <th>{{ gt('Quantity') }}</th>
                <th>{{ gt('Subtotal') }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="cart-items">
              @forelse($cartItems as $item)
                <tr id="cart-row-{{ $item->id }}">
                  <td>
                    <div class="cs_cart_table_media">
                      @if($item->design_id && $item->design)
                        {{-- Custom design preview with accurate overlay --}}
                        <x-design-preview :design="$item->design" width="80" />
                      @else
                        {{-- Regular product image --}}
                        <img src="{{ env('MAIN_URL') . 'images/' . $item->product_image }}" alt="{{ $item->product_name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                      @endif
                      <h3>{{ $item->product_name }}</h3>
                      <div style="font-size: 12px; color: #666; margin-top: 4px;">
                        @if($item->design_id)
                          <span class="badge bg-primary">{{ gt('Custom Design') }}</span><br>
                        @endif
                        @if($item->product_type === 'own')
                          {{ gt('Cloth Type') }}: {{ $item->product_color }} | {{ gt('Size') }}: {{ $item->product_size }}
                        @else
                          {{ gt('Color') }}: <span class="cs_cart_color_swatch" style="background-color: {{ $item->product_color }};" title="{{ $item->product_color }}"></span> | {{ gt('Size') }}: {{ $item->product_size }}
                        @endif
                        @if($item->roster_data && count($item->roster_data) > 0)
                          <div class="mt-1">
                            <span class="badge bg-info text-dark"><i class="fa-solid fa-users"></i> {{ count($item->roster_data) }} {{ gt('Team Members') }}</span>
                          </div>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>{{ format_currency($item->price) }}</td>
                  <td>
                    <div class="cs_quantity_controls">
                      <button class="cs_qty_btn cs_qty_minus" onclick="updateQuantity({{ $item->id }}, -1)">
                        <i class="fa-solid fa-minus"></i>
                      </button>
                      <span class="cs_quantity_display" id="qty-val-{{ $item->id }}">{{ $item->product_quantity }}</span>
                      <button class="cs_qty_btn cs_qty_plus" onclick="updateQuantity({{ $item->id }}, 1)">
                        <i class="fa-solid fa-plus"></i>
                      </button>
                    </div>
                  </td>
                  <td id="item-subtotal-{{ $item->id }}">{{ format_currency($item->price * $item->product_quantity) }}</td>
                  <td class="text-center">
                    <button class="cs_cart-table-close" onclick="removeCartItem({{ $item->id }})">
                      <i class="fa-solid fa-xmark"></i>
                    </button>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" style="text-align: center; padding: 50px;">{{ gt('Your cart is empty') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="cs_height_30 cs_height_lg_30"></div>
      </div>
      <div class="col-xl-4">
        <div class="cs_shop-side-spacing">
          <div class="cs_shop-card">
            <!-- <h2 class="cs_fs_21 cs_medium">Coupon Code</h2>
            <form action="#" class="cs_coupon-doce-form">
              <input type="text" placeholder="Coupon Code">
              <button class="cs_product_btn cs_color1 cs_semi_bold">Apply</button>
            </form> -->
            <div class="cs_height_30 cs_height_lg_30"></div>
            <h2 class="cs_fs_21 cs_medium">{{ gt('Cart Totals') }}</h2>
            <table class="cs_medium">
              <tbody>
                <tr>
                  <td>{{ gt('Subtotal') }}</td>
                  <td class="text-end" id="cart-subtotal">{{ format_currency($cartItems->sum(function($item){ return $item->price * $item->product_quantity; })) }}</td>
                </tr>
                <tr>
                  <td>{{ gt('Total') }}</td>
                  <td class="text-end" id="cart-total">{{ format_currency($cartItems->sum(function($item){ return $item->price * $item->product_quantity; })) }}</td>
                </tr>
              </tbody>
            </table>
            <div class="cs_height_30 cs_height_lg_30"></div>
            <a href="{{ route('checkout') }}" class="cs_btn cs_style_1 cs_fs_16 cs_medium w-100">{{ gt('Proceed To Checkout') }}</a>
          </div>
          <div class="cs_height_30 cs_height_lg_30"></div>
        </div>
      </div>
    </div>
    </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
  </section>
  <style>
    .premium-hero-section{min-height:400px;display:flex;align-items:center;background:linear-gradient(135deg,#1C30A3 0%,#2541C8 50%,#3B5FE0 100%);position:relative;padding:120px 0 180px}.hero-particles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:1}.hero-gradient-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(circle at 20% 50%,rgba(102,126,234,.3) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(240,147,251,.3) 0%,transparent 50%);z-index:1}.hero-content{position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);padding:10px 24px;border-radius:50px;color:white;font-size:14px;font-weight:500;margin-bottom:30px}.premium-hero-title{font-size:56px;font-weight:900;font-family:'Merriweather',serif;color:white;margin:0 0 20px 0;line-height:1.2}.hero-subtitle{font-size:18px;color:rgba(255,255,255,.9);margin:0;max-width:600px;margin-left:auto;margin-right:auto}.hero-wave{position:absolute;bottom:0;left:0;width:100%;overflow:hidden;line-height:0;transform:rotate(180deg)}.hero-wave svg{position:relative;display:block;width:calc(100% + 1.3px);height:80px}.wave-fill{fill:#fff}.cs_height_100{height:100px}.cs_height_140{height:140px}
   
    /* Quantity Control Styles */
    .cs_quantity_controls {
      display: inline-flex;
      align-items: center;
      background: #f8f9fa;
      border: 1px solid #e1e8ed;
      border-radius: 50px;
      padding: 4px;
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .cs_qty_btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: none;
      background: white;
      color: #1C30A3;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .cs_qty_btn:hover {
      background: #1C30A3;
      color: white;
      transform: scale(1.1);
    }
    .cs_quantity_display {
      min-width: 40px;
      text-align: center;
      font-weight: 700;
      color: #1a1a2e;
      font-size: 15px;
    }

    .cs_cart_color_swatch {
      display: inline-block;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 1px solid rgba(0,0,0,0.1);
      vertical-align: middle;
      margin-left: 5px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    @media(max-width:991px){.cs_height_lg_60{height:60px!important}.cs_height_lg_80{height:80px!important}}
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Particle effect for hero section
      const e = document.getElementById('heroParticles');
      if (e) {
        for (let t = 0; t < 50; t++) {
          const o = document.createElement('div');
          o.style.cssText = `position:absolute;width:${Math.random() * 4 + 2}px;height:${Math.random() * 4 + 2}px;background:rgba(255,255,255,${Math.random() * .5 + .2});border-radius:50%;left:${Math.random() * 100}%;top:${Math.random() * 100}%;animation:float ${Math.random() * 10 + 10}s infinite ease-in-out;animation-delay:${Math.random() * 5}s`;
          e.appendChild(o);
        }
        const t = document.createElement('style');
        t.textContent = `@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random() * 100 - 50}px,${Math.random() * 100 - 50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random() * 100 - 50}px,${Math.random() * 100 - 50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random() * 100 - 50}px,${Math.random() * 100 - 50}px) scale(1.1);opacity:.5}}`;
        document.head.appendChild(t);
      }
    });

    function updateQuantity(itemId, change) {
      const display = document.getElementById(`qty-val-${itemId}`);
      let currentQty = parseInt(display.textContent);
      let newQty = currentQty + change;

      if (newQty < 1) return;

      $.ajax({
        url: `/cart/update/${itemId}`,
        method: 'PUT',
        data: {
          _token: "{{ csrf_token() }}",
          quantity: newQty
        },
        success: function(res) {
          // Update the quantity display
          display.textContent = res.new_quantity;
          
          // Update the item subtotal
          document.getElementById(`item-subtotal-${itemId}`).textContent = res.item_subtotal;
          
          // Update the overall cart total and subtotal
          document.getElementById('cart-subtotal').textContent = res.cart_total;
          document.getElementById('cart-total').textContent = res.cart_total;
          
          // Optional: Show a small toast instead of a big alert
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          Toast.fire({
            icon: 'success',
            title: res.message
          });
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            Swal.fire("{{ gt('Stock Limit') }}", xhr.responseJSON.message, 'warning');
          } else {
            Swal.fire("{{ gt('Error') }}", "{{ gt('Failed to update quantity') }}", 'error');
          }
        }
      });
    }

    function removeCartItem(itemId) {
      Swal.fire({
        title: "{{ gt('Remove item?') }}",
        text: "{{ gt('Are you sure you want to remove this item from your cart?') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1C30A3',
        cancelButtonColor: '#dc3545',
        confirmButtonText: "{{ gt('Yes, remove it!') }}"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/cart/remove/${itemId}`,
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
              Swal.fire("{{ gt('Removed!') }}", res.message, 'success').then(() => {
                location.reload();
              });
            },
            error: function(xhr) {
              Swal.fire("{{ gt('Error') }}", "{{ gt('Failed to remove item') }}", 'error');
            }
          });
        }
      });
    }
  </script>

@endsection
