@extends('layouts.master')
@section('title')
    Custom Products
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
            Custom Products
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <div class="row align-items-start">
                                <div class="col-sm">
                                    <div style="position: relative; top: 26px;">
                                        <button type="button" class="btn btn-success add_btn_top_el mb-4"
                                            data-bs-toggle="modal" data-bs-target="#addCustomProductModal"
                                            style="width:130px"><i class="mdi mdi-plus me-1"></i> Add Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="table-gridjs" class="mt-5"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Custom Product Modal -->
    <div class="modal fade" id="addCustomProductModal" tabindex="-1" aria-labelledby="addCustomProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomProductModalLabel">Add Custom Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="addCustomProductForm" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="base_price" class="form-label">Base Price</label>
                                <input type="number" step="0.01" class="form-control" id="base_price" name="base_price" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="product_type" class="form-label">Product Type</label>
                                <select class="form-select" id="product_type" name="product_type" required>
                                    <option value="tshirt">T-Shirt</option>
                                    <option value="hoodie">Hoodie</option>
                                    <option value="mug">Mug</option>
                                    <option value="cap">Cap</option>
                                    <option value="bag">Bag</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="front_mockup" class="form-label">Front Mockup (Base)</label>
                                <input type="file" class="form-control" id="front_mockup" name="front_mockup" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="back_mockup" class="form-label">Back Mockup (Base)</label>
                                <input type="file" class="form-control" id="back_mockup" name="back_mockup">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="right_shoulder_mockup" class="form-label">Right Shoulder Mockup (Base)</label>
                                <input type="file" class="form-control" id="right_shoulder_mockup" name="right_shoulder_mockup">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="left_shoulder_mockup" class="form-label">Left Shoulder Mockup (Base)</label>
                                <input type="file" class="form-control" id="left_shoulder_mockup" name="left_shoulder_mockup">
                            </div>
                        </div>

                        <!-- Colors Section -->
                        <!-- <div class="mb-3">
                            <label class="form-label">Color Variants</label>
                            <div id="colors_container">
                                <!-- Colors will be added here dynamically -->
                            <!-- </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add_color_btn">
                                <i class="mdi mdi-plus"></i> Add Color
                            </button>
                        </div> --> 
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Custom Product Modal -->
    <div class="modal fade" id="editCustomProductModal" tabindex="-1" aria-labelledby="editCustomProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomProductModalLabel">Edit Custom Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="editCustomProductForm" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_product_id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_base_price" class="form-label">Base Price</label>
                                <input type="number" step="0.01" class="form-control" id="edit_base_price" name="base_price" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_product_type" class="form-label">Product Type</label>
                                <select class="form-select" id="edit_product_type" name="product_type" required>
                                    <option value="tshirt">T-Shirt</option>
                                    <option value="hoodie">Hoodie</option>
                                    <option value="mug">Mug</option>
                                    <option value="cap">Cap</option>
                                    <option value="bag">Bag</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_front_mockup" class="form-label">Front Mockup (Leave empty to keep current)</label>
                                <input type="file" class="form-control" id="edit_front_mockup" name="front_mockup">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_back_mockup" class="form-label">Back Mockup (Leave empty to keep current)</label>
                                <input type="file" class="form-control" id="edit_back_mockup" name="back_mockup">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_right_shoulder_mockup" class="form-label">Right Shoulder Mockup (Leave empty to keep current)</label>
                                <input type="file" class="form-control" id="edit_right_shoulder_mockup" name="right_shoulder_mockup">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_left_shoulder_mockup" class="form-label">Left Shoulder Mockup (Leave empty to keep current)</label>
                                <input type="file" class="form-control" id="edit_left_shoulder_mockup" name="left_shoulder_mockup">
                            </div>
                        </div>

                        <!-- Edit Colors Section -->
                         <!-- <div class="mb-3">
                            <label class="form-label">Color Variants</label>
                            <div id="edit_colors_container">
                                <!-- Colors will be added here dynamically -->
                            <!-- </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="edit_add_color_btn">
                                <i class="mdi mdi-plus"></i> Add Color
                            </button> 
                        </div> -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script>
        window.customProducts = @json($customProducts);
    </script>
    <script src="{{ URL::asset('assets/js/app/CustomProductPage.js') }}"></script>
@endsection
