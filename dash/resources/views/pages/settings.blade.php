@extends('layouts.master')
@section('title')
    Global Settings
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Global Settings
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Quantity Constraints (Min/Max)</h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>User Type</th>
                                        <th>Product Type</th>
                                        <th>Min Quantity</th>
                                        <th>Max Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                    @foreach($settings as $userType => $userSettings)
                                        @foreach($userSettings as $setting)
                                            <tr>
                                                @if($loop->first)
                                                    <td rowspan="{{ count($userSettings) }}" class="text-center align-middle">
                                                        <span class="badge {{ $userType == 'B2B' ? 'bg-primary' : 'bg-info' }} font-size-14">
                                                            {{ $userType }}
                                                        </span>
                                                    </td>
                                                @endif
                                                <td class="text-center"><strong>{{ $setting->product_type }}</strong></td>
                                                <td>
                                                    <input type="hidden" name="settings[{{ $counter }}][id]" value="{{ $setting->id }}">
                                                    <input type="number" class="form-control text-center" name="settings[{{ $counter }}][min_quantity]" value="{{ $setting->min_quantity }}" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="settings[{{ $counter }}][max_quantity]" value="{{ $setting->max_quantity }}" min="0" required>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bx bx-save me-1"></i> Update Quantity Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Size Charts Management</h4>
                    
                    <form action="{{ route('settings.sizechart.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>Serial No</th>
                                        <th>USA/UK</th>
                                        <th>EU</th>
                                        <th>Japan</th>
                                        <th>Korea</th>
                                        <th>Chest (cm)</th>
                                        <th>Chest (Inches)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sizeCharts as $index => $chart)
                                        <tr>
                                            <td class="text-center">
                                                <input type="hidden" name="size_charts[{{ $index }}][id]" value="{{ $chart->id }}">
                                                <input type="hidden" name="size_charts[{{ $index }}][serial_no]" value="{{ $chart->serial_no }}">
                                                <input type="hidden" name="size_charts[{{ $index }}][is_active]" value="{{ $chart->is_active }}">
                                                <strong>{{ $chart->serial_no }}</strong>
                                            </td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][usa_uk]" value="{{ $chart->usa_uk }}" required></td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][eu]" value="{{ $chart->eu }}" required></td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][japan]" value="{{ $chart->japan }}" required></td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][korea]" value="{{ $chart->korea }}" required></td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][chest_cm]" value="{{ $chart->chest_cm }}" required></td>
                                            <td><input type="text" class="form-control text-center" name="size_charts[{{ $index }}][chest_inches]" value="{{ $chart->chest_inches }}" required></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bx bx-save me-1"></i> Update Size Charts
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Settings section -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Checkout Settings</h4>
                    <form action="{{ route('settings.checkout.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="paypal_max_quantity" class="form-label">PayPal Max Quantity Limit (Triggers Bank Transfer)</label>
                            <input type="number" class="form-control" id="paypal_max_quantity" name="paypal_max_quantity" value="{{ $checkoutSettings->paypal_max_quantity ?? 10 }}" required min="1">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bx bx-save me-1"></i> Update Limit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection
