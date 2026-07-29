@extends('layouts.app')
@section('content')
<section style="background:#fff; min-height:100vh; display:flex; align-items:center; justify-content:center;">
  <div class="container text-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
      <span class="visually-hidden">Loading...</span>
    </div>
    <h3 class="mt-4">{{ gt('Processing your payment...') }}</h3>
    <p>{{ gt('Please wait while we confirm your PayPal payment') }}</p>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const paypalOrderId = "{{ $paypal_order_id }}";
  showLoader("{{ gt('Confirming your PayPal payment...') }}");
  
  // Capture the payment
  $.ajax({
    url: "{{ route('order.place') }}",
    method: 'POST',
    data: {
      _token: "{{ csrf_token() }}",
      payment_method: 'paypal',
      paypal_order_id: paypalOrderId,
      address_id: "{{ session('checkout_data.address_id') }}"
    },
    success: function(res) {
      if (res.success) {
        showLoader("{{ gt('Payment successful! Redirecting...') }}");
        window.location.href = res.redirect;
      } else {
        hideLoader();
        Swal.fire("{{ gt('Error') }}", res.message, 'error').then(() => {
          window.location.href = "{{ route('checkout') }}";
        });
      }
    },
    error: function(xhr) {
      hideLoader();
      Swal.fire("{{ gt('Error') }}", xhr.responseJSON?.message || "{{ gt('Payment failed') }}", 'error').then(() => {
        window.location.href = "{{ route('checkout') }}";
      });
    }
  });
});
</script>
@endsection
