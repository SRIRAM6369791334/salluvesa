@extends('layouts.master')
@section('title')
    Bulk Orders
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
            Bulk Order Requests
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <!-- <button class="btn btn-primary btn-sm filter-btn me-2" data-status="all">All</button>
                        <button class="btn btn-outline-warning btn-sm filter-btn me-2" data-status="0">Pending</button>
                        <button class="btn btn-outline-success btn-sm filter-btn me-2" data-status="1">Approved</button>
                        <button class="btn btn-outline-danger btn-sm filter-btn" data-status="2">Rejected</button> -->
                    </div>
                    <div id="bulk-orders-grid"></div>
                </div>
            </div>
        </div>
    </div>

    @include('components.export_doc_modal')

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Bulk Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm">
                    <div class="modal-body">
                        <input type="hidden" id="reject_order_id">
                        <div class="mb-3">
                            <label for="reject_reason" class="form-label">Reason for Rejection (This will be sent to the user)*</label>
                            <textarea class="form-control" id="reject_reason" rows="4" required placeholder="Enter why this order is being rejected..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Final Details Modal -->
    <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDetailsModalLabel">Edit Final Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDetailsForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_order_id">
                        
                        <div class="alert alert-info font-size-13">
                            Set the final negotiated details here. These will be reflected on the invoice.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="final_size" class="form-label">Final Size(s)</label>
                                <input type="text" class="form-control" id="final_size" placeholder="e.g. M, L, XL or Assorted">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="final_color" class="form-label">Final Color(s)</label>
                                <input type="text" class="form-control" id="final_color" placeholder="e.g. Navy Blue, Red">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="final_qty" class="form-label">Final Quantity</label>
                                <input type="number" class="form-control" id="final_qty" placeholder="Total units">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="final_rate" class="form-label">Agreed Rate (₹) per unit</label>
                                <input type="number" step="0.01" class="form-control" id="final_rate" placeholder="e.g. 250.00">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Custom Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custom Design Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="preview_image" src="" alt="Custom Design" style="max-width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="download_link" href="" download class="btn btn-primary">
                        <i class="bx bx-download me-1"></i> Download Image
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script>
        window.bulkOrders = @json($bulkOrders);
    </script>
    <script src="{{ URL::asset('assets/js/app/BulkOrdersPage.js') }}"></script>
@endsection
