@extends('layouts.master')

@section('title')
    Contact Information Settings
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Contact Details Management
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h5 class="card-title text-white mb-0">
                        <i class="bx bx-phone-call me-2"></i> Edit Contact Details
                    </h5>
                    <span class="badge bg-light text-primary fw-bold">Live Storefront Settings</span>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bx bx-check-circle me-2 fs-4"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-2 fs-5"></i> Please correct the highlighted errors below:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.settings.update') }}" method="POST" id="contactSettingsForm">
                        @csrf
                        
                        {{-- 1. Store Address --}}
                        <div class="mb-4">
                            <label for="store_address" class="form-label fw-bold">
                                <i class="bx bx-map me-1 text-primary"></i> Store / Office Address 
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="store_address" 
                                      id="store_address" 
                                      rows="4" 
                                      maxlength="500"
                                      class="form-control @error('store_address') is-invalid @enderror" 
                                      placeholder="Enter physical store / office address..." 
                                      required>{{ old('store_address', $contactSetting->store_address ?? '') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Displays under "Offline store" on the contact page.</small>
                                <small class="text-muted"><span id="address_count">0</span> / 500 characters</small>
                            </div>
                            @error('store_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Email Address --}}
                        <div class="mb-4">
                            <label for="email_address" class="form-label fw-bold">
                                <i class="bx bx-envelope me-1 text-primary"></i> Email Address 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email_address" 
                                   id="email_address" 
                                   maxlength="255"
                                   value="{{ old('email_address', $contactSetting->email_address ?? '') }}" 
                                   class="form-control @error('email_address') is-invalid @enderror" 
                                   placeholder="e.g. info@saaluvesa.com" 
                                   required>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Displays under "Email address" on the contact page.</small>
                                <small class="text-muted"><span id="email_count">0</span> / 255 characters</small>
                            </div>
                            @error('email_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Live Support Phone --}}
                        <div class="mb-4">
                            <label for="phone_number" class="form-label fw-bold">
                                <i class="bx bx-phone me-1 text-primary"></i> Live Support Phone / Mobile Number 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="phone_number" 
                                   id="phone_number" 
                                   maxlength="50"
                                   value="{{ old('phone_number', $contactSetting->phone_number ?? '') }}" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   placeholder="e.g. +91 9655482775" 
                                   required>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Displays under "Live support" on the contact page.</small>
                                <small class="text-muted"><span id="phone_count">0</span> / 50 characters</small>
                            </div>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <button type="reset" class="btn btn-light px-4">
                                <i class="bx bx-undo me-1"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="bx bx-save me-1"></i> Save & Update Contact Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Live Preview Sidebar --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px;">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="bx bx-show me-1 text-info"></i> Storefront Preview
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Below is how your updated contact information will instantly appear on <code>/contact</code> page:</p>

                    <div class="p-3 bg-white rounded border mb-3">
                        <div class="d-flex align-items-start">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary fs-5">
                                    <i class="bx bx-map-pin"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark">Offline store</h6>
                                <p class="text-muted small mb-0 text-break" id="preview_address">
                                    {!! nl2br(e($contactSetting->store_address ?? '')) !!}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-white rounded border mb-3">
                        <div class="d-flex align-items-start">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title rounded-circle bg-success-subtle text-success fs-5">
                                    <i class="bx bx-envelope"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark">Email address</h6>
                                <p class="text-muted small mb-0 text-break" id="preview_email">
                                    {{ $contactSetting->email_address ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-white rounded border">
                        <div class="d-flex align-items-start">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title rounded-circle bg-warning-subtle text-warning fs-5">
                                    <i class="bx bx-phone-call"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark">Live support</h6>
                                <p class="text-muted small mb-0 text-break" id="preview_phone">
                                    {{ $contactSetting->phone_number ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addressInput = document.getElementById('store_address');
            const emailInput = document.getElementById('email_address');
            const phoneInput = document.getElementById('phone_number');

            const addressCount = document.getElementById('address_count');
            const emailCount = document.getElementById('email_count');
            const phoneCount = document.getElementById('phone_count');

            const previewAddress = document.getElementById('preview_address');
            const previewEmail = document.getElementById('preview_email');
            const previewPhone = document.getElementById('preview_phone');

            function updateCountsAndPreview() {
                if (addressInput) {
                    addressCount.textContent = addressInput.value.length;
                    previewAddress.innerHTML = addressInput.value.replace(/\n/g, '<br>') || '<em class="text-muted">Not specified</em>';
                }
                if (emailInput) {
                    emailCount.textContent = emailInput.value.length;
                    previewEmail.textContent = emailInput.value || 'Not specified';
                }
                if (phoneInput) {
                    phoneCount.textContent = phoneInput.value.length;
                    previewPhone.textContent = phoneInput.value || 'Not specified';
                }
            }

            addressInput?.addEventListener('input', updateCountsAndPreview);
            emailInput?.addEventListener('input', updateCountsAndPreview);
            phoneInput?.addEventListener('input', updateCountsAndPreview);

            // Initial calculation
            updateCountsAndPreview();
        });
    </script>
@endsection
