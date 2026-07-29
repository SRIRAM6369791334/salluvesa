@extends('layouts.app')

@section('content')
<section class="premium-hero-section position-relative overflow-hidden">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    <div class="container position-relative text-center" style="z-index:2">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-icon">🏦</span><span>{{ gt('Payment') }}</span>
            </div>
            <h1 class="premium-hero-title">{{ gt('Bank Details') }}</h1>
            <p class="hero-subtitle">{{ gt('Complete your payment using the details below') }}</p>
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

<section style="background:#f8f9fa; padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cs_shop-card" style="background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 40px;">
                    
                    @if($order)
                    <div class="order-alert-box mb-5">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <span class="d-block text-uppercase text-muted fs-12 fw-bold mb-1">{{ gt('Order Reference') }}</span>
                                <span class="fs-20 fw-bold text-primary">#{{ $order->order_id }}</span>
                            </div>
                            <div class="text-center px-4">
                                <span class="d-block text-uppercase text-muted fs-12 fw-bold mb-1">{{ gt('Printing Method') }}</span>
                                <span class="fs-20 fw-bold text-primary">{{ $order->printing_method ?? 'CTF' }}</span>
                            </div>
                            <div class="text-end">
                                <span class="d-block text-uppercase text-muted fs-12 fw-bold mb-1">{{ gt('Total Amount to Pay') }}</span>
                                <span class="fs-24 fw-bold text-dark">{{ format_currency($order->grand_total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bank-info-container">
                        <!-- Bank Country -->
                        <div class="country-display mb-4">
                            <span class="label text-uppercase text-muted fw-bold">{{ gt('Bank Country') }}:</span>
                            <span class="value fs-20 fw-bold text-primary ms-2">{{ $bankDetails->bank_country ?? 'N/A' }}</span>
                        </div>

                        <!-- Description -->
                        <div class="description-container p-4 bg-light border rounded-4 mb-5">
                            <div class="description-content">
                                {!! $bankDetails->description ?? gt('No instructions provided.') !!}
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex gap-3 align-items-start" role="alert" style="background-color: #f0f7ff; border-color: #cfe2ff; color: #084298;">
                        <span class="fs-24">ℹ️</span>
                        <div>
                            <h4 class="alert-heading fs-18 fw-bold">{{ gt('After Payment') }}</h4>
                            <p class="mb-0">{{ gt('Your payment will be confirmed within') }} <strong>{{ $bankDetails->payment_confirmation_time ?? '24-48 Hours' }}</strong>. {{ gt('Please keep your transaction reference ID safe for future correspondence.') }}</p>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        @if($order && $order->payment_method == 'mp' && $order->delivery_status == 0)
                            <div class="order-alert-box mt-4 text-start">
                                <h4 class="cs_fs_21 cs_semibold mb-3"><i class="fa-solid fa-cloud-arrow-up me-2"></i>{{ gt('Upload Payment Proof') }}</h4>
                                <form id="proof-upload-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-8">
                                            <div class="premium-form-group mb-0">
                                                <label class="premium-form-label mb-2"><i class="fa-solid fa-file-image me-2"></i>{{ gt('Select Payment Receipt') }}</label>
                                                <input type="file" name="payment_proof" id="payment_proof" class="premium-form-input" accept="image/*" required>
                                                <small class="text-muted d-block mt-2">{{ gt('Supported formats: JPG, PNG, WebP (Max 5MB)') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="cs_btn cs_style_1 cs_fs_14 cs_medium w-100 py-3" id="upload-btn" style="height: 54px;">
                                                {{ gt('Submit Proof') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div id="proof-preview-container" class="mt-3 {{ $order->payment_proof ? '' : 'd-none' }}">
                                    <label class="text-muted small d-block mb-2">{{ gt('Already Uploaded:') }}</label>
                                    <img src="{{ $order->payment_proof ? env('MAIN_URL').'uploads/proof/'.$order->payment_proof : '' }}" 
                                         id="proof-preview" 
                                         style="max-width: 150px; border-radius: 8px; border: 1px solid #ddd;" 
                                         alt="Proof">
                                </div>
                            </div>
                        @endif

                        <div class="mt-5">
                            <a href="{{ route('myaccount') }}" class="cs_btn cs_style_1 cs_fs_16 cs_medium px-5">
                                {{ gt('Back to My Account') }}
                            </a>
                        </div>
                        <div class="mt-3 text-muted fs-12">
                             @if($bankDetails)
                                <small>Ref ID: {{ $bankDetails->id }} | Updated: {{ $bankDetails->updated_at->format('d M Y') }}</small>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Styles reused from other pages */
.premium-hero-section { min-height: 350px; display: flex; align-items: center; background: linear-gradient(135deg, #1C30A3 0%, #2541C8 50%, #3B5FE0 100%); position: relative; padding: 100px 0 140px; }
.hero-particles { position: absolute; top:0; left:0; width:100%; height:100%; overflow:hidden; z-index:1; }
.hero-gradient-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.3) 0%, transparent 50%); z-index:1; }
.hero-content { position: relative; z-index:2; }
.hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); padding: 8px 20px; border-radius: 50px; color: white; font-size: 14px; font-weight: 500; margin-bottom: 20px; }
.premium-hero-title { font-size: 48px; font-weight: 900; font-family: 'Merriweather', serif; color: white; margin: 0 0 15px 0; line-height: 1.2; }
.hero-subtitle { font-size: 18px; color: rgba(255,255,255,0.9); margin: 0; max-width: 600px; margin-left: auto; margin-right: auto; }
.hero-wave { position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg); }
.wave-fill { fill: #f8f9fa; }

/* Bank Details Specific Styles */
.order-alert-box {
    background: #eef2ff;
    border: 2px dashed #1C30A3;
    border-radius: 12px;
    padding: 20px 25px;
}

.description-content p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.description-content {
    color: #2d3748;
    font-size: 15px;
}

.detail-card {
    background: #fcfcfc;
    border: 1px solid #eee;
    padding: 20px;
    border-radius: 12px;
    height: 100%;
    display: flex;
    gap: 15px;
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    border-color: #1C30A3;
}

.detail-card.highlight {
    background: #fff;
    border-color: #c3cfe2;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}

.icon-wrapper {
    width: 45px;
    height: 45px;
    background: #f0f2f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.detail-card .content {
    flex-grow: 1;
    overflow: hidden;
}

.detail-card label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    color: #8898aa;
    font-weight: 700;
    margin-bottom: 5px;
    letter-spacing: 0.5px;
}

.detail-card .value {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    word-break: break-word;
}

.detail-card .sub-value {
    font-size: 13px;
    color: #718096;
    margin-top: 2px;
}

.value-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.copy-btn {
    background: transparent;
    border: 1px solid #e2e8f0;
    color: #718096;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 600;
    white-space: nowrap;
}

.copy-btn:hover {
    background: #1C30A3;
    color: white;
    border-color: #1C30A3;
}

.fs-12 { font-size: 12px; }
.fs-18 { font-size: 18px; }
.fs-20 { font-size: 20px; }
.fs-24 { font-size: 24px; }
</style>

<script>
function copyText(text) {
    if(!text) return;
    navigator.clipboard.writeText(text).then(function() {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> {{ gt("Copied!") }}';
        btn.classList.add('btn-success');
        btn.style.color = '#28a745';
        btn.style.borderColor = '#28a745';
        
        setTimeout(function() {
            btn.innerHTML = originalContent;
            btn.classList.remove('btn-success');
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2000);
    });
}

// Particle Effect (Reused from other pages)
document.addEventListener('DOMContentLoaded',function(){
    const e=document.getElementById('heroParticles');
    if(e){
        for(let t=0;t<30;t++){
            const o=document.createElement('div');
            o.style.cssText=`position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*.5+.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`;
            e.appendChild(o);
        }
        const t=document.createElement('style');
        t.textContent=`@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`;
        document.head.appendChild(t);
    }
});

// Payment Proof Upload Handling
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('proof-upload-form');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = document.getElementById('upload-btn');
            const originalText = btn.innerText;

            btn.disabled = true;
            btn.innerText = "{{ gt('Uploading...') }}";
            showLoader("{{ gt('Uploading payment proof...') }}");

            fetch("{{ route('order.upload_proof') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({
                        title: "{{ gt('Success!') }}",
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#1C30A3'
                    }).then(() => {
                        hideLoader();
                        const preview = document.getElementById('proof-preview');
                        const container = document.getElementById('proof-preview-container');
                        if (preview && container) {
                            preview.src = res.proof_url;
                            container.classList.remove('d-none');
                        }
                        btn.disabled = false;
                        btn.innerText = originalText;
                        uploadForm.reset();
                    });
                } else {
                    hideLoader();
                    Swal.fire("{{ gt('Error') }}", res.message, 'error');
                    btn.disabled = false;
                    btn.innerText = originalText;
                }
            })
            .catch(error => {
                hideLoader();
                Swal.fire("{{ gt('Error') }}", "{{ gt('Upload failed.') }}", 'error');
                btn.disabled = false;
                btn.innerText = originalText;
            });
        });
    }
});
</script>
@endsection
