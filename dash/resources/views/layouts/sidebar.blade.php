<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    {{--

    <body data-layout="horizontal" data-sidebar="dark"> --}}
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="{{ url('/') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/Saaluvesa_log_trans.png') }}" alt="" style="width:22px">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/Saaluvesa_log_trans.png') }}" alt="" height=""
                        style="width: 76px;height: 63px;">
                </span>
            </a>

            <a href="{{ url('/') }}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/Saaluvesa_log_trans.png') }}" alt="" style="width:100px">
                </span>
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/Saaluvesa_log_trans.png') }}" alt="" height="22" style="width:40px">
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        <div data-simplebar class="sidebar-menu-scroll">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">



                    @if (Auth::user()->role == 1)
                        <li class="menu-title" data-key="t-menu">Menu</li>
                        <li>
                            <a href="{{ url('/') }}">
                                <i class="bx bx-tachometer icon nav-icon"></i>
                                <span class="menu-item" data-key="t-dashboards">@lang('translation.Dashboard')</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('users.index') }}">

                                <i class="mdi mdi-18px mdi-account-circle icon nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Dashboard Users</span>
                            </a>
                        </li> --}}


                        <li class="menu-title" data-key="t-applications">Web Banner</li>

                        <li>
                            <a href="{{ route('bannerImages.index') }}">
                                <i class="mdi mdi-image-area nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Banner Images</span>
                            </a>
                        </li>

                        <li class="menu-title" data-key="t-applications">Users</li>
                        <li>
                            <a href="{{ route('customers.index') }}">
                                <i class="bx bxs-user icon nav-icon"></i>
                                <span class="menu-item" data-key="t-calendar">Customers</span>
                            </a>
                        </li>

                        <li class="menu-title" data-key="t-applications">Products</li>
                        <li>
                            <a href="{{ route('designs.index') }}">
                                <i class="mdi mdi-palette nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Own Designs</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('samples.index') }}">
                                <i class="mdi mdi-flask-outline nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Samples Product</span>
                            </a>
                        </li>

                        <!-- <li>
                            <a href="{{ route('categories.index') }}">
                                <i class="bx bx-store icon nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Category</span>
                                {{-- <span class="badge rounded-pill bg-danger"
                                    data-key="t-hot">@lang('translation.Hot')</span> --}}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('subcategories.index') }}">
                                <i class="bx bx-store icon nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Sub Category</span>
                                {{-- <span class="badge rounded-pill bg-danger"
                                    data-key="t-hot">@lang('translation.Hot')</span> --}}
                            </a>
                        </li> -->

                        <!-- <li>
                            <a href="{{ route('products.index') }}">
                                <i class="bx bxs-basket nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Products</span>
                                {{-- <span class="badge rounded-pill bg-danger"
                                    data-key="t-hot">@lang('translation.Hot')</span> --}}
                            </a>
                        </li> -->

                        <li>
                            <a href="{{ route('custom-products.index') }}">
                                <i class="mdi mdi-brush nav-icon"></i>
                                <span class="menu-item" data-key="t-custom-products">Custom Products</span>
                            </a>
                        </li>
<!-- 
                        <li>
                            <a href="{{ route('productvarient.index') }}">
                                <i class="mdi mdi-timer-sand-empty nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Variant</span>

                            </a>
                        </li> -->

                        

                        <!-- <li>
                            <a href="{{ route('stocks.index') }}">
                                <i class="bx bxs-report nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Stock</span>
                            </a>
                        </li> -->

                        {{-- <li>
                            <a href="{{ route('todaydeals.index') }}">
                                <i class="bx bx-store icon nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Today Deals</span>

                            </a>
                        </li>--}}

                        <!-- <li>
                            <a href="{{ route('coupons.index') }}">
                                <i class="bx bxs-report nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Coupons</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="/shipping">
                                <i class="bx bxs-report nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Shipping</span>
                            </a>
                        </li> -->
                        {{-- <li>
                            <a href="{{ route('combostock.index') }}">
                                <i class="mdi mdi-clipboard-plus nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Combo Stock</span>
                            </a>
                        </li> --}}

                        <li class="menu-title" data-key="t-applications">Orders</li>

                        <li>
                            <a href="{{ route('bulk-orders.index') }}">
                                <i class="mdi mdi-package-variant nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Bulk Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productOrders.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">New Orders</span>
                                @if ($productOrderBIllingCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderBIllingCount }}</span>
                                @endif

                            </a>
                        </li>

                        {{-- <li>
                            <a href="/viewProducts">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Orders</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ route('productpacking.index') }}">
                                <i class="mdi mdi-gift nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Package Orders</span>
                                @if ($productOrderPendingCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderPendingCount }}</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productdispatch.index') }}">
                                <i class="mdi mdi-motorbike nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Dispatched Orders</span>
                                @if ($productOrderDispatchCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderDispatchCount }}</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productdelivery.index') }}">
                                <i class="mdi mdi-truck-delivery nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Out for Delivery Orders</span>
                                @if ($productOrderDeliveryCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderDeliveryCount }}</span>
                                @endif

                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('productreturn.index') }}">
                                <i class="mdi mdi-truck-delivery-outline nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Return</span>
                                @if ($productreturn)
                                <span class="badge rounded-pill bg-success">{{ $productreturn }}</span>
                                @endif

                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ route('productcomplete.index') }}">
                                <i class="mdi mdi-dns nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Delivered Order</span>

                            </a>
                        </li>

                        {{-- <li class="menu-title" data-key="t-applications">Refund</li>

                        <li>
                            <a href="{{ route('cancelproduct.index') }}">
                                <i class="mdi mdi-bell-ring nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Request Cancel</span>

                                @if ($cancelreq)
                                <span class="badge rounded-pill bg-success">{{ $cancelreq }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productRefunds.index') }}">
                                <i class="mdi mdi-cash-100 nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Refund</span>

                                @if ($productRefundPendingCount)
                                <span class="badge rounded-pill bg-success">{{ $productRefundPendingCount }}</span>
                                @endif
                            </a>
                        </li> --}}


                        <li class="menu-title" data-key="t-applications">Reports</li>
                        {{-- <li>
                            <a href="/productwisereport">
                                <i class="mdi mdi-autorenew nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Product Wise Report</span>

                            </a>
                        </li> --}}
                        <li>
                            <a href="/orderwisereport">
                                <i class="mdi mdi-autorenew nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Orders Report</span>

                            </a>
                        </li>


                        {{-- Account User Permission --}}
                        <li class="menu-title" data-key="t-applications">Settings</li>
                        <li>
                            <a href="{{ route('bank-details.index') }}">
                                <i class="mdi mdi-bank nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Bank Details</span>
                            </a>
                        </li>
                      
                        <li>
                            <a href="{{ route('settings.index') }}">
                                <i class="mdi mdi-cog nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Global Settings</span>
                            </a>
                        </li>

                    @elseif(Auth::user()->role == 2)
                        <li class="menu-title" data-key="t-applications">Orders</li>


                        <li>
                            <a href="{{ route('productOrders.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Billing Products</span>
                                @if ($productOrderBIllingCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderBIllingCount }}</span>
                                @endif

                            </a>
                        </li>
                    @elseif (Auth::user()->role == 3)
                        <li class="menu-title" data-key="t-applications">Orders</li>
                        <li>
                            <a href="{{ route('productpacking.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Package Orders</span>
                                @if ($productOrderPendingCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderPendingCount }}</span>
                                @endif

                            </a>
                        </li>
                    @elseif (Auth::user()->role == 4)
                        <li class="menu-title" data-key="t-applications">Orders</li>
                        <li>
                            <a href="{{ route('productdispatch.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Dispatched Orders</span>
                                @if ($productOrderDispatchCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderDispatchCount }}</span>
                                @endif

                            </a>
                        </li>
                    @elseif (Auth::user()->role == 5)
                        <li class="menu-title" data-key="t-applications">Orders</li>
                        <li>
                            <a href="{{ route('productdelivery.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Out For Delivery Orders</span>
                                @if ($productOrderDeliveryCount)
                                    <span class="badge rounded-pill bg-success">{{ $productOrderDeliveryCount }}</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productcomplete.index') }}">
                                <i class="mdi mdi-food nav-icon"></i>
                                <span class="menu-item" data-key="t-chat">Delivered Order</span>
                                {{-- @if ($productOrdercompleteCount)
                                <span class="badge rounded-pill bg-success">{{ $productOrdercompleteCount}}</span>
                                @endif --}}

                            </a>
                        </li>
                    @endif
                    <!-- <li class="menu-title" data-key="t-applications">Product Reviews</li>
                    <li>
                        <a href="{{ route('review.index') }}">
                            <i class="mdi mdi-comment-text-multiple nav-icon"></i>
                            <span class="menu-item" data-key="t-chat">Reviews</span>
                        </a>
                    </li> -->
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
</div>
<!-- Left Sidebar End -->