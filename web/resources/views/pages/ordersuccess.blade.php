@extends('layouts.app')
@section('content')
  <section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center" style="z-index:2">
      <div class="hero-content">
        <div class="hero-badge"><span class="badge-icon">✅</span><span>{{ gt('Order Complete') }}</span></div>
        <h1 class="premium-hero-title">{{ gt('Order Success') }}</h1>
        <p class="hero-subtitle">{{ gt('Thank you! Your order has been received') }}</p>
      </div>
    </div>
    <div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path></svg></div>
  </section>
  <section style="background:#fff">
    <div class="cs_height_100 cs_height_lg_60"></div>
    <div class="container">
    <p class="m-0 text-center cs_primary_color cs_medium">{{ gt('Thank you! Your order has been received.') }}</p>
    <div class="cs_height_95 cs_height_lg_50"></div>
    <ul class="cs_order-summery">
      <li>
        <p>{{ gt('Order Number:') }}</p>
        <h3 id="order-number">{{ $order->order_id }}</h3>
      </li>
      <li>
        <p>{{ gt('Date:') }}</p>
        <h3 id="order-date">{{ $order->created_at->format('F d, Y') }}</h3>
      </li>
      <li>
        <p>{{ gt('Total:') }}</p>
        <h3 id="order-total">{{ format_currency($order->grand_total_amount) }}</h3>
      </li>
      <li>
        <p>{{ gt('Payment method:') }}</p>
        <h3 id="payment-method">{{ strtoupper($order->payment_method) }}</h3>
      </li>
      @if($order->printing_method)
      <li>
        <p>{{ gt('Printing Method:') }}</p>
        <h3 id="printing-method">{{ $order->printing_method }}</h3>
      </li>
      @endif
    </ul>
    <div class="cs_height_50 cs_height_lg_30"></div>
    <div class="cs_shop-card">
      <h2 class="cs_fs_21">{{ gt('Order details') }}</h2>
      <table class="border-bottom-0">
        <tbody>
          <tr class="cs_semi_bold">
            <td>{{ gt('Products') }}</td>
            <td class="text-end">{{ gt('Amount') }}</td>
          </tr>
          @foreach($details->order_items as $item)
            <tr>
              <td>{{ $item['product_name'] }} x {{ $item['product_quantity'] }}</td>
              <td class="text-end">{{ format_currency($item['price'] * $item['product_quantity']) }}</td>
            </tr>
          @endforeach
          <tr>
            <td class="cs_semi_bold">{{ gt('Subtotal') }}</td>
            <td class="text-end">{{ format_currency($details->total_amount) }}</td>
          </tr>
          <tr>
            <td class="cs_semi_bold">{{ gt('Payment method') }}</td>
            <td class="text-end" id="payment-method-table">{{ $details->payment_status_text }} ({{ strtoupper($order->payment_method) }})</td>
          </tr>
          <tr class="cs_semi_bold">
            <td class="pb-0">{{ gt('Total') }}</td>
            <td class="text-end pb-0">{{ format_currency($details->grand_total_amount) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
  </section>
  <style>.premium-hero-section{min-height:400px;display:flex;align-items:center;background:linear-gradient(135deg,#1C30A3 0%,#2541C8 50%,#3B5FE0 100%);position:relative;padding:120px 0 180px}.hero-particles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:1}.hero-gradient-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(circle at 20% 50%,rgba(102,126,234,.3) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(240,147,251,.3) 0%,transparent 50%);z-index:1}.hero-content{position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);padding:10px 24px;border-radius:50px;color:white;font-size:14px;font-weight:500;margin-bottom:30px}.premium-hero-title{font-size:56px;font-weight:900;font-family:'Merriweather',serif;color:white;margin:0 0 20px 0;line-height:1.2}.hero-subtitle{font-size:18px;color:rgba(255,255,255,.9);margin:0;max-width:600px;margin-left:auto;margin-right:auto}.hero-wave{position:absolute;bottom:0;left:0;width:100%;overflow:hidden;line-height:0;transform:rotate(180deg)}.hero-wave svg{position:relative;display:block;width:calc(100% + 1.3px);height:80px}.wave-fill{fill:#fff}.cs_height_100{height:100px}.cs_height_140{height:140px}@media(max-width:991px){.cs_height_lg_60{height:60px!important}.cs_height_lg_80{height:80px!important}}</style>
  <script>document.addEventListener('DOMContentLoaded',function(){
    // Particle effect functionality
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
  });</script>
@endsection
