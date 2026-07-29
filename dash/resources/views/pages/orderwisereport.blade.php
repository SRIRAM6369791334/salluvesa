@extends('layouts.master')
@section('title')
    Saaluvesa
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
@endsection


@section('content')
    @component('components.breadcrumb')
    @slot('li_1')
    Home
    @endslot
    @slot('title')
    Orders Reports
    @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Orders Report</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <button id="export-excel" class="btn btn-success w-100">Export Excel</button>
                        </div>
                        <div class="col-md-2">
                            <button id="export-pdf" class="btn btn-danger w-100">Export PDF</button>
                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filter">Filter by:</label>
                            <select id="filter" class="form-control">
                                <option value="this_month" {{ $filter == 'this_month' ? 'selected' : '' }}>This Month
                                </option>
                                <option value="last_month">Last Month</option>
                                <option value="this_week">This Week</option>
                                <option value="custom">Custom Date</option>
                            </select>
                        </div>
                        <div class="col-md-3 custom-date d-none">
                            <label for="from-date">From:</label>
                            <input type="date" id="from-date" class="form-control">
                        </div>
                        <div class="col-md-3 custom-date d-none">
                            <label for="to-date">To:</label>
                            <input type="date" id="to-date" class="form-control">
                        </div>
                        <div class="col-md-2 custom-date d-none">
                            <label>&nbsp;</label>
                            <button id="apply-filter" class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                    <div class="row mb-3" id="summary-section">
                        <div class="col-md-3">
                            <div class="alert alert-info">
                                <strong>Total Orders:</strong> <span
                                    id="total-orders">{{ $initialResults['summary']['total_orders'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success">
                                <strong>Total Order Value:</strong> $<span
                                    id="total-value">{{ number_format($initialResults['summary']['total_value'] ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="order-report">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Customer Name</th>
                                    <th>Country</th>
                                   
                                    <th>Total Items</th>
                                    <th>Total Quantity</th>
                                    <th>Total Value</th>
                                    <th>Payment Method</th>
                                    <!-- <th>Order Type</th> -->
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($initialResults['orders'] as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->date_ordered_on)->format('d-m-Y') }}</td>
                                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $order->country ?? '-' }}</td>
                                      
                                        <td>{{ $order->total_items }}</td>
                                        <td>{{ $order->total_quantity }}</td>
                                        <td> ${{ number_format($order->grand_total_amount, 2) }}</td>
                                        <td>
                                            @if($order->payment_method == 'cod') Cash on Delivery
                                            @elseif($order->payment_method == 'paypal') PayPal
                                            @elseif($order->payment_method == 'mp') Bank Transfer
                                            @else {{ $order->payment_method }} @endif
                                        </td>
                                        <!-- <td>
                                            @if($order->order_type == 0) COD
                                            @elseif($order->order_type == 1) Sample order
                                            @elseif($order->order_type == 2) Bank Transfer
                                            @else {{ $order->order_type }} @endif
                                        </td> -->
                                        <!-- <td>{{ $order->payment_status == 1 ? 'Paid' : 'Not Paid' }}</td> -->
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="viewProductdetail/{{ $order->order_id }}" target="_blank">
                                                    <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </a>
                                                <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('{{ $order->order_id }}')">
                                                    <i class="bx bx-receipt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            function loadReport(filter, from = '', to = '') {
                $.ajax({
                    url: '{{ route('order.wise.report.filter') }}',
                    data: {
                        filter: filter,
                        from: from,
                        to: to
                    },
                    success: function (data) {
                        let tbody = $('#order-report tbody');
                        tbody.empty();

                        // Update summary
                        $('#total-orders').text(data.summary.total_orders);
                        $('#total-value').text(parseFloat(data.summary.total_value).toFixed(2));

                        let orders = data.orders;

                        if (orders.length > 0) {
                            $.each(orders, function (index, item) {
                                tbody.append(`
                                                                                        <tr>
                                                                                            <td>${index + 1}</td>
                                                                                            <td>${item.order_id}</td>
                                                                                            <td>${new Date(item.date_ordered_on).toLocaleDateString('en-GB')}</td>
                                                                                            <td>${item.customer_name ?? 'N/A'}</td>
                                                                                            <td>${item.country ?? '-'}</td>
                                                                                           
                                                                                            <td>${item.total_items}</td>
                                                                                            <td>${item.total_quantity}</td>
                                                                                             <td>$${parseFloat(item.grand_total_amount).toFixed(2)}</td>
                                                                                             <td>
                                                                                                ${item.payment_method === 'cod' ? 'Cash on Delivery' : 
                                                                                                  item.payment_method === 'razorpay' ? 'PayPal' : 
                                                                                                  item.payment_method === 'mp' ? 'Bank Transfer' : (item.payment_method ?? 'N/A')}
                                                                                             </td>
                                                                                             <!-- <td>
                                                                                                ${item.order_type == 0 ? 'COD' : 
                                                                                                  item.order_type == 1 ? 'Razorpay' : 
                                                                                                  item.order_type == 2 ? 'Bank Transfer' : (item.order_type ?? 'N/A')}
                                                                                             </td> -->
                                                                                    <!-- <td>${item.payment_status == 1 ? 'Paid' : 'Not Paid'}</td> -->
                                                                                    <td>
                                                                                        <div class="d-flex gap-1 justify-content-center">
                                                                                            <a href="viewProductdetail/${item.order_id}" target="_blank">
                                                                                                <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                                                                                    <i class="bx bx-show"></i>
                                                                                                </button>
                                                                                            </a>
                                                                                            <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${item.order_id}')">
                                                                                                <i class="bx bx-receipt"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                        </tr>
                                                                                    `);
                            });
                        } else {
                            tbody.append('<tr><td colspan="12" class="text-center">No Data Found</td></tr>');
                        }
                    }
                });
            }

            // Load initial data from the default selected filter
            const initialFilter = $('#filter').val();
            if (initialFilter !== 'custom') {
                loadReport(initialFilter);
            }

            // Handle filter change
            $('#filter').on('change', function () {
                const selected = $(this).val();

                if (selected === 'custom') {
                    $('.custom-date').removeClass('d-none');
                } else {
                    $('.custom-date').addClass('d-none');
                    loadReport(selected); // Load only when user manually changes
                }
            });

            // Apply custom filter
            $('#apply-filter').on('click', function () {
                const from = $('#from-date').val();
                const to = $('#to-date').val();

                if (!from || !to) {
                    alert("Please select both From and To dates.");
                    return;
                }

                loadReport('custom', from, to);
            });

            // Export buttons
            $('#export-excel').click(function () {
                const filter = $('#filter').val();
                const from = $('#from-date').val();
                const to = $('#to-date').val();
                let url = '{{ route('order.wise.report.export.excel') }}' + '?filter=' + filter;

                if (filter === 'custom') {
                    url += '&from=' + from + '&to=' + to;
                }

                window.location.href = url;
            });

            $('#export-pdf').click(function () {
                const filter = $('#filter').val();
                const from = $('#from-date').val();
                const to = $('#to-date').val();
                let url = '{{ route('order.wise.report.export.pdf') }}' + '?filter=' + filter;

                if (filter === 'custom') {
                    url += '&from=' + from + '&to=' + to;
                }

                window.location.href = url;
            });
        });
    </script>


    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection