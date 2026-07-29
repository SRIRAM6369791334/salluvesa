<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/favicon1.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/favicon1.png') }}" alt="" height="22"> <span
                            class="logo-txt">@lang('translation.Saaluvesa')</span>
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/favicon1.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/favicon1.png') }}" alt="" height="22"> <span
                            class="logo-txt">@lang('translation.Saaluvesa')</span>
                    </span>
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <a href="{{ route('lowstock') }}">
                    <button type="button" class="btn header-item noti-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bell icon-sm">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="noti-dot bg-danger rounded-pill">{{ $stockscount }}</span>
                    </button>
                </a>
                {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications Stock </h5>
                            </div>

                        </div>
                    </div>
                    <div data-simplebar="init" style="max-height: 250px;">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper"
                                        style="height: auto; overflow: hidden; padding-right: 0px; padding-bottom: 0px;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex border-bottom align-items-start bg-light">
                                                    <div class="flex-shrink-0">
                                                        <img src="assets/images/users/avatar-3.jpg"
                                                            class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Justin Verduzco</h6>
                                                        <div class="text-muted">
                                                            <p class="mb-1 font-size-13">Your task changed an issue from
                                                                "In Progress" to <span
                                                                    class="badge badge-soft-success">Review</span></p>
                                                            <p class="mb-0 font-size-10 text-uppercase fw-bold"><i
                                                                    class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex border-bottom align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar-sm me-3">
                                                            <span
                                                                class="avatar-title bg-primary rounded-circle font-size-16">
                                                                <i class="bx bx-shopping-bag"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">New order has been placed</h6>
                                                        <div class="text-muted">
                                                            <p class="mb-1 font-size-13">Open the order confirmation or
                                                                shipment confirmation.</p>
                                                            <p class="mb-0 font-size-10 text-uppercase fw-bold"><i
                                                                    class="mdi mdi-clock-outline"></i> 5 hours ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex border-bottom align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar-sm me-3">
                                                            <span
                                                                class="avatar-title bg-soft-success text-success rounded-circle font-size-16">
                                                                <i class="bx bx-cart"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Your item is shipped</h6>
                                                        <div class="text-muted">
                                                            <p class="mb-1 font-size-13">Here is somthing that you
                                                                might light like to know.</p>
                                                            <p class="mb-0 font-size-10 text-uppercase fw-bold"><i
                                                                    class="mdi mdi-clock-outline"></i> 1 day ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex border-bottom align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <img src="assets/images/users/avatar-4.jpg"
                                                            class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Salena Layfield</h6>
                                                        <div class="text-muted">
                                                            <p class="mb-1 font-size-13">Yay ! Everything worked!</p>
                                                            <p class="mb-0 font-size-10 text-uppercase fw-bold"><i
                                                                    class="mdi mdi-clock-outline"></i> 3 days ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar"
                                style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                            <div class="simplebar-scrollbar"
                                style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                        </div>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-decoration-underline fw-bold text-center"
                            href="javascript:void(0)">
                            <span>View All <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                </div> --}}
            </div>
            <div class="dropdown " style="display: none;">
                @php
                    $currencyService = app(\App\Services\CurrencyService::class);
                    $supported = (new \App\Services\CurrencyService())->getSupportedCurrencies();
                    $currentCurrency = session('currency', 'INR');
                    $currentSymbol = $supported[$currentCurrency]['symbol'] ?? '$';
                @endphp
                <button type="button" class="btn header-item waves-effect" id="page-header-currency-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle">{{ $currentCurrency }} ({{ $currentSymbol }})</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach($supported as $code => $info)
                        <a href="{{ route('currency.switch.get', $code) }}" class="dropdown-item notify-item">
                            <span class="align-middle">{{ $info['name'] }} ({{ $info['symbol'] }})</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Language Switcher --}}
            <!-- @php
                $currentLang = session('lang', 'en');
                $languages = [
                    'en' => ['name' => 'English',  'flag' => '🇬🇧'],
                    'ta' => ['name' => 'தமிழ்',    'flag' => '🇮🇳'],
                    'hi' => ['name' => 'हिंदी',     'flag' => '🇮🇳'],
                    'ar' => ['name' => 'العربية',   'flag' => '🇸🇦'],
                    'zh' => ['name' => '中文',       'flag' => '🇨🇳'],
                    'fr' => ['name' => 'Français',  'flag' => '🇫🇷'],
                    'de' => ['name' => 'Deutsch',   'flag' => '🇩🇪'],
                    'es' => ['name' => 'Español',   'flag' => '🇪🇸'],
                    'ja' => ['name' => '日本語',     'flag' => '🇯🇵'],
                ];
                $currentLangName = $languages[$currentLang]['name'] ?? 'English';
                $currentFlag     = $languages[$currentLang]['flag'] ?? '🌐';
            @endphp
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-lang-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="align-middle">{{ $currentFlag }} {{ $currentLangName }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach($languages as $code => $info)
                        <a href="{{ url('lang/' . $code) }}" class="dropdown-item notify-item {{ $currentLang === $code ? 'active' : '' }}">
                            <span class="align-middle">{{ $info['flag'] }} {{ $info['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('/assets/images/Saaluvesa_log_trans.png') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">Admin</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item " href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                            key="t-logout">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
