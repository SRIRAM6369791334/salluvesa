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
    Product
    @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <p style="position: relative;
                                                        top:82px;
                                                        left: 25px;
                                                        font-weight: bold;">
                    Search:</p>
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <form class="needs-validation" id="productfilterForm" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-start">
                                    <div class="col-sm" style="width: 280px">
                                        <label class="form-label" for="select_category_select">Choose Category*</label>
                                        <select class="form-select" name="category_id" id="select_category_select">
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <div>
                                            <button type="submit" class="btn btn-success product_filter_btn mb-4" style="position: relative;
                                                                                top: 29px;">submit</button>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div style="position: relative;
                                                                            top: 26px;">
                                            <button type="button" class="btn btn-success  add_btn_top_el mb-4"
                                                data-bs-toggle="modal" data-bs-target="#addProductModal"
                                                style="width:130px"><i class="mdi mdi-plus me-1"></i> Add
                                                Product</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- end row -->
                        </div>
                    </div>
                    <div id="table-gridjs" class="mt-5"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="addProductForm" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="add_category_select">Choose Category*</label>
                                    <select class="form-select" name="category_id" id="add_category_select">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="add_category_select">Choose Sub Category*</label>
                                    <select class="form-select" name="subcategory_id" id="add_subcategory_select">
                                        <option value="" disabled selected>Select Sub Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_name">Product Name*</label>
                                    <input type="text" class="form-control" id="add_product_name" name="product_name"
                                        placeholder="Product name" maxlength="50" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="subcate_size_append mt-3 mb-3">

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_description">Product Feature Title*</label>
                                    <input type="text" class="form-control" id="add_product_description"
                                        name="product_description" placeholder="Product Feature Title" maxlength="100"
                                        required>


                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_image">Product Image*(526 *
                                        789)</label>
                                    <input type="file" class="form-control image_el dropzone needsclick"
                                        id="add_product_image" placeholder="Product Image" accept="image/*"
                                        name="product_image" required>
                                </div>
                            </div>

                            <label for="add_product_image" class="preview-container" id="preview-container">
                                <div class="flex justify-content-center">
                                    <div class="text-center">
                                        <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                    </div>
                                    <div>
                                        <span class="col-12">Upload Image</span>
                                    </div>
                                </div>
                            </label>


                            <!--end::Input group-->
                            <!--<div class="col-md-3">-->
                            <!--    <div class="mb-3">-->
                            <!--        <label class="form-label" for="add_brand_name">Brand-->
                            <!--            Name*</label>-->
                            <!--        <input type="text" class="form-control" id="add_brand_name" name="brand_name"-->
                            <!--            placeholder="Brand Name" maxlength="200" required>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="col-md-3">-->
                            <!--    <div class="mb-3">-->
                            <!--        <label class="form-label" for="add_material_name">Material*</label>-->
                            <!--        <input type="text" class="form-control" id="add_material_name" name="brand_material"-->
                            <!--            placeholder="Brand Material" maxlength="200" required>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_specification">Product
                                        Description*</label>
                                    <textarea type="text" class="form-control" id="add_product_specification"
                                        name="product_specification" placeholder="Product Description" maxlength="600"
                                        required></textarea>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_material_color">Size Chart*</label>
                                    <input type="file" class="form-control" id="add_size_chart_image"
                                        placeholder="Size Chart" accept="image/*" name="add_size_chart_image" required>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="approval_days">Return Approval Date*</label>
                                    <input type="text" class="form-control" id="approval_days" name="approval_days"
                                        placeholder="Enter approval days (max 30)" maxlength="2" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value > 30) this.value = 30;">
                                </div>
                            </div> --}}

                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="card" style="padding: 20px;border: 1px solid;">
                                    <h5>Product Variant</h5>
                                    <div class="col-lg-12">
                                        <div id="dynamic-inputs">


                                            <div class="d-flex product_fields">
                                                <div class="row">

                                                    <label for="add_varient_image" class="preview-container"
                                                        id="preview-container1">
                                                        <div class="flex justify-content-center">
                                                            <div class="text-center">
                                                                <i
                                                                    class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                                            </div>
                                                            <div>
                                                                <span class="col-12">Upload Image</span>
                                                            </div>
                                                        </div>
                                                    </label>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="add_varient_image">Variant
                                                                Image*(526 *
                                                                789)</label>
                                                            <input type="file"
                                                                class="form-control image_el dropzone needsclick"
                                                                id="add_varient_image" placeholder="Varient Image"
                                                                accept="image/*" name="Varient_image[]" required>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="add_prod_size_select">Product
                                                                Size*</label>
                                                            <select class="form-select" name="prod_size_value[]"
                                                                id="add_prod_size_select">
                                                                <option value="" selected>Select Varieat Size
                                                                </option>

                                                                <option value="S">S</option>
                                                                <option value="M">M</option>
                                                                <option value="L">L</option>
                                                                <option value="XL">XL</option>
                                                                <option value="XXL">XXL</option>
                                                                <option value="XXXL">XXXL</option>


                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="add_varient_color">Variant
                                                                Color*</label>
                                                            <input type="color" class="form-control" id="add_varient_color"
                                                                name="varient_color[]" placeholder="Varient Color" required
                                                                style="width: 56px;height:50px;">
                                                        </div>
                                                    </div>

                                                    <div class="initially_hidden">
                                                        <div class="row">


                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="add_product_quantity">Stock
                                                                        Quantity*</label>
                                                                    <input type="text" class="form-control"
                                                                        id="add_product_quantity" name="product_quantity[]"
                                                                        placeholder="Product Quantity" required>
                                                                </div>
                                                            </div>



                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="product_mrp_price">Product
                                                                        MRP
                                                                        Price(ORIGINAL
                                                                        PRICE)*</label>
                                                                    <input type="text" class="form-control"
                                                                        id="product_mrp_price" name="product_mrp_price[]"
                                                                        placeholder="Product MRP price" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="product_offer_price">Product
                                                                        Selling Price(OFFER
                                                                        PRICE)*</label>
                                                                    <input type="text" class="form-control"
                                                                        id="product_offer_price"
                                                                        name="product_offer_price[]"
                                                                        placeholder="Product Selling price" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="product_low_stock">Low
                                                                        Stock
                                                                        *</label>
                                                                    <input type="text" class="form-control"
                                                                        id="product_low_stock" name="low_stock[]"
                                                                        placeholder="Product low stock" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="">Product
                                                                        GST</label>
                                                                    <select class="form-select" name="product_gst[]"
                                                                        id="product_gst">
                                                                        <option value="" selected>Select GST</option>
                                                                        <option value="0">0</option>
                                                                        {{-- <option value="5">5</option>
                                                                        <option value="12">12</option>
                                                                        <option value="18">18</option>
                                                                        <option value="28">28</option> --}}


                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3" style="">
                                                                <h5>Product Thump Images</h5>
                                                                <input type="hidden" name="product_image_count[]"
                                                                    class="product_image_count" value="1">
                                                                <div class="col-lg-12">
                                                                    <div id="dynamic-inputs1" class="dynamic-inputs1">


                                                                        <div class="d-flex product_fields1">
                                                                            <div class="row">
                                                                                <div class="col-lg-8">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label"
                                                                                            for="add_product_image">Product
                                                                                            Image*(526 *
                                                                                            789)</label>
                                                                                        <input type="file"
                                                                                            class="form-control image_el dropzone needsclick"
                                                                                            id="add_product_thump_image"
                                                                                            placeholder="Product Image"
                                                                                            name="product_image1[]" required
                                                                                            accept="image/*">
                                                                                    </div>
                                                                                </div>
                                                                                {{-- <div class="col-lg-4 col-sm-12 mt-4">
                                                                                    <div class="input-group-append">
                                                                                        <button
                                                                                            class="btn btn-danger delete-input1"
                                                                                            type="button">Delete</button>
                                                                                    </div>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mt-3">
                                                                    <button id="add-input1"
                                                                        class="btn btn-success add-input1" type="button">Add
                                                                        Another Images</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <br>
                                                    <hr>
                                                    <div class="col-lg-3 col-sm-12 mt-4">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-danger delete-input" type="button">Delete
                                                                Varient</button>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- <div class="col-lg-3 mt-3">
                                        <button id="add-input" class="btn btn-success" type="button">Add
                                            Another Varient</button>
                                    </div> --}}
                                </div>


                                {{-- <div class="card" style="padding: 20px;">
                                    <h5>Product Thump Images</h5>
                                    <div class="col-lg-12">
                                        <div id="dynamic-inputs1">


                                            <div class="d-flex product_fields1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="add_product_image">Product
                                                                Image*(526 *
                                                                789)</label>
                                                            <input type="file"
                                                                class="form-control image_el dropzone needsclick"
                                                                id="add_product_image" placeholder="Product Image"
                                                                name="product_image1[]" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-12 mt-4">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-danger delete-input1"
                                                                type="button">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <button id="add-input1" class="btn btn-success" type="button">Add
                                            Another Images</button>
                                    </div>
                                </div> --}}


                            </div>



                        </div>



                        <div class="text-center">
                            <button class="btn btn-primary add_submit_btn mt-3" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="editProductForm" novalidate>
                        <input type="hidden" id="edit_product_id" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_category_select">Choose Category*</label>
                                    <select class="form-select" name="category_id" id="edit_category_select">
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_category_select">Choose Sub Category*</label>
                                    <select class="form-select" name="subcategory_id" id="edit_subcategory_select">
                                        <option value="" disabled selected>Select Sub Category</option>
                                        @foreach ($subcategories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->subcategory_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_name">Product Name*</label>
                                    <input type="text" class="form-control" id="edit_product_name" name="product_name"
                                        placeholder="Product name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_description">Product Feature
                                        Title*</label>
                                    <input type="text" class="form-control" id="edit_product_description"
                                        name="product_description" placeholder="Product Feature Title" required>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_quantity">Product Quantity*</label>
                                    <input type="text" class="form-control" id="edit_product_quantity"
                                        name="product_quantity" placeholder="Product Quantity" required>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_unit">Product Unit*</label>
                                    <select class="form-select" name="unit_value" id="edit_unit_select">
                                        <option value="0" selected>Select Units</option>

                                        <option value="1">l</option>
                                        <option value="2">ml</option>
                                        <option value="3">g</option>
                                        <option value="4">kg</option>

                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_value">Value*</label>
                                    <input type="text" class="form-control" id="edit_product_value" name="product_value"
                                        placeholder="Product Value" required>
                                </div>
                            </div> --}}
                            {{--
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_regular_price">Product MRP
                                        Price(Original Price)*</label>
                                    <input type="text" class="form-control" id="edit_product_regular_price"
                                        name="product_regular_price" placeholder="Product MRP
                                                                                Price" required>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_mrp_price">Product Selling Price(Offer
                                        Price)*</label>
                                    <input type="text" class="form-control" id="edit_product_mrp_price"
                                        name="product_mrp_price" placeholder="Product Selling Price" required>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_image">Product Image*(526 *
                                        789)</label>
                                    <input type="file" class="form-control image_el" id="edit_product_image"
                                        placeholder="Product Image" name="product_image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex mb-4">
                                <div class="col-6">
                                    <div class="mb-2">Previous Image</div>
                                    <label class="edit_show_preview-container">
                                        <img src="" alt="edit_product_image" class="edit_preview_image"></label>
                                </div>

                                <div class="col-6 ">
                                    <div class="mb-2">New Image</div>
                                    <label for="edit_product_image" class="edit_preview-container">
                                        <div class="flex justify-content-center">
                                            <div class="text-center">
                                                <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                            </div>
                                            <div>
                                                <span class="col-12">Upload Image</span>
                                            </div>
                                        </div>
                                    </label>

                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_specification">Product
                                        Description*</label>
                                    <textarea type="text" class="form-control" id="edit_product_specification"
                                        name="product_specification" placeholder="Product Description" required
                                        maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary mt-3 edit_submit_btn" type="submit">Update</button>
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
        window.products = @json($products);
    </script>
    <script src="{{ URL::asset('assets/js/app/ProductPage.js') }}"></script>
@endsection