@extends('layouts.master')
@section('title')
    Saaluvesa
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
    @slot('li_1')
    Home
    @endslot
    @slot('title')
    Product Out For Delivery Orders
    @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <p style="position: relative;
                                        top: 33px;
                                        left: 25px;
                                        font-weight: bold;">
                    Search:</p>
                <div class="card-body">
                    <div id="table-gridjs"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="DeliveryModal" tabindex="-1" aria-labelledby="DeliveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeliveryModalLabel">Out For Delivery Status </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" method="POST" id="changestatus3" novalidate="novalidate">
                        <input type="hidden" name="user_id" id="cusiddelive">
                        <input type="hidden" name=phone_number id="cusnumer">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="order_id_input2">Order Id*</label>
                                    <input type="text" name="order_id" class="form-control " value="" id="order_id_input2"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="customer_name_input2">Customer Name*</label>
                                    <input type="text" name="customer_name" class="form-control " value=""
                                        id="customer_name_input2" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="add_status_select">Select Status*</label>
                                    <select class="form-select" name="select_status" id="add_status_select2">
                                        <option value="">Select Status</option>
                                        <option value="4">Delivered</option>
                                        {{-- <option value="6">Product Return</option> --}}
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-12 mt-3" id="tracking_id_container">
                                <div class="form-group">
                                    <label class="label-control" for="tracking_id_input">Tracking ID*</label>
                                    <input type="text" class="form-control" name="tracking_id" id="tracking_id_input"
                                        placeholder="Enter Tracking ID">
                                </div>
                            </div> -->

                        </div>


                        <div class="text-center">
                            <button class="btn btn-primary mt-3 adddelivery_submit_btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- collect cash --}}

    <div class="modal fade" id="CollectModal" tabindex="-1" aria-labelledby="CollectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CollectModalLabel">Out Of Delivery Status </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" method="POST" id="collectstatus3" novalidate="novalidate">
                        <input type="hidden" name="user_id" id="cusiddelive1">
                        <input type="hidden" name=phone_number id="cusnumer1">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="order_id_input2">Order Id*</label>
                                    <input type="text" name="order_id" class="form-control " value="" id="order_id_input21"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="customer_name_input2">Customer Name*</label>
                                    <input type="text" name="customer_name" class="form-control " value=""
                                        id="customer_name_input21" readonly>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12" id="codamt">
                                <div class="form-group">
                                    <label class="label-control" for="customer_name_input2">COD Amount*</label>
                                    <input type="text" name="total_amount" class="form-control " value="" id="cod_input21"
                                        readonly>
                                </div>
                            </div> --}}
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="label-control" for="add_status_select">Select Status*</label>
                                    <select class="form-select" name="select_status" id="add_status_select21">
                                        <option value="">Select Status</option>
                                        <option value="4">Delivered</option>
                                        {{-- <option value="6">Product Return</option> --}}
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="text-center">
                            <button class="btn btn-primary mt-3 collectdelivery_submit_btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

    @section('script')
        <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/app.js') }}"></script>
        <script>
            window.productDeliverys = @json($productDeliverys);
        </script>
        {{--
        <script src="{{ URL::asset('assets/libs/flatpickr/f    latpickr.min.js') }}"></script> --}}

        <script src="{{ URL::asset('assets/js/app/ProductdeliveryPage.js') }}"></script>
    @endsection