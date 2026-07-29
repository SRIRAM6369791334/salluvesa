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
    Product Variant
    @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <p style="position: relative;
                                                            top: 79px;
                                                            left: 25px;
                                                            font-weight: bold;">
                    Search:</p>
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <form class="needs-validation" id="productverfilterForm" novalidate
                                enctype="multipart/form-data">
                                <div class="row align-items-start">

                                    <div class="col-sm" style="width: 280px">
                                        <label class="form-label" for="select_category_select">Choose Category*</label>
                                        <select class="form-select custid" name="category_id" id="sel_category_select">
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-sm" style="width: 280px">
                                        <label class="form-label " for="select_category_select">Choose Product*</label>
                                        {{-- <select class="form-select produ1" name="product_id" id="select_product">
                                            <option value="" disabled selected>Select Product</option>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->product_name }}</option>
                                            @endforeach

                                        </select> --}}

                                        <select class="form-select proname product2" name="product_id" id="select_product">
                                            <option value="" disabled selected>Select Product.</option>

                                        </select>

                                    </div>
                                    <div class="col-sm">
                                        <div>
                                            <button type="submit" class="btn btn-success productver_filter_btn mb-4" style="position: relative;
                                                                                            top: 29px;">submit</button>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div style="position: relative;
                                                                                top: 26px;">
                                            <button type="button" class="btn btn-success  add_btn_top_el mb-4"
                                                data-bs-toggle="modal" data-bs-target="#addProductvariModal"><i
                                                    class="mdi mdi-plus me-1"></i> Add
                                                Product Variant</button>
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

    <div class="modal fade" id="addProductvariModal" tabindex="-1" aria-labelledby="addProductvariModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductvariModalLabel">Add Product Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="addProductvarientForm" novalidate enctype="multipart/form-data">
                        @csrf


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="select_category_select">Choose Category*</label>
                                    <select class="form-select custid" name="categoryid" id="select_category_select">
                                        <option value="" disabled selected>Select Category</option>
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
                                    <label class="form-label" for="select_subcategory_select">Choose Sub Category*</label>
                                    <select class="form-select custid" name="subcategoryid" id="select_subcategory_select">
                                        <option value="" disabled selected>Select Sub Category</option>
                                        {{-- @foreach ($subcategories as $st)
                                        <option value="{{ $st->id }}">
                                            {{ $st->subcategory_name }}</option>
                                        @endforeach --}}

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_name">Product Name*</label>
                                    <select class="form-select proname product2" name="product_id" id="add_product_name">
                                        <option value="" disabled selected>Select Product.</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_prod_size_select">Product Size*</label>
                                    <select class="form-select" name="add_prod_size_select" id="add_prod_size_select">
                                        <option value="" selected>Select Product Size</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="XXXL">XXXL</option>


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_color_value">Product Color*</label>

                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Color Picker -->
                                        <input type="color" class="form-control form-control-color" id="add_color_picker"
                                            value="#000000" title="Choose color"
                                            style="width: 60px; height: 38px; padding: 0;">

                                        <!-- Text Input -->
                                        <input type="text" class="form-control" id="add_product_color_value"
                                            name="add_product_color_value" placeholder="Product color" required>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_mrp_price">Product MRP Price(ORIGINAL
                                        PRICE)*</label>
                                    <input type="text" class="form-control" id="add_product_mrp_price" name="mrp_price"
                                        placeholder="Product MRP price" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_offer_price">Product Selling Price(OFFER
                                        PRICE)*</label>
                                    <input type="text" class="form-control" id="add_product_offer_price" name="offer_price"
                                        placeholder="Product Selling price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_product_quantity">Stock Quantity*</label>
                                    <input type="text" class="form-control" id="add_product_quantity" name="product_qty"
                                        placeholder="Product Quantity" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="add_Low_Stock">Low Stock*</label>
                                    <input type="text" class="form-control" id="add_Low_Stock" name="low_stock"
                                        placeholder="Low Stock" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Select Product GST</label>
                                    <select class="form-select" name="product_gst" id="product_gst">
                                        <option value="" selected>Select Gst</option>
                                        <option value="0">0</option>
                                        {{-- <option value="5">5</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="28">28</option> --}}



                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="mb-3">

                                    <input type="checkbox" name="hot_deals" class="hot_value" value="0"
                                        id="edit_hot_product"> <label class="form-label" for="add_product_mrp_price">Popular
                                        Products</label>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <h5>Product Thump Images</h5>
                                <input type="hidden" name="product_image_count[]" class="product_image_count2" value="1">
                                <div class="col-lg-12">
                                    <div id="dynamic-inputs1" class="dynamic-inputs2">


                                        <div class="d-flex product_fields2">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="add_product_image">Product
                                                            Image*(526 *
                                                            789)</label>
                                                        <input type="file" class="form-control image_el  needsclick"
                                                            id="add_product_image" placeholder="Product Image"
                                                            name="product_image2[]" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-12 mt-4">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-danger delete-input2"
                                                            type="button">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-3">
                                    <button id="add-input2" class="btn btn-success add-input2" type="button">Add
                                        Another Images</button>
                                </div>
                            </div>
                        </div>



                        <div class="text-center">
                            <button class="btn btn-primary addvari_submit_btn mt-3" type="submit">Submit</button>
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
                    <form class="needs-validation" id="editProductVarientForm" novalidate>
                        <input type="hidden" id="edit_productvar_id" />
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="select_category_select">Choose Category*</label>
                                    <select class="form-select custid" name="categoryid" id="edit_category_select">
                                        <option value="" disabled selected>Select Category</option>
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
                                    <label class="form-label" for="select_category_select">Choose Category*</label>
                                    <select class="form-select custid" name="subcategoryid" id="edit_subcategory_select">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($subcategories as $st)
                                            <option value="{{ $st->id }}">
                                                {{ $st->subcategory_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_name">Product Name*</label>
                                    <select class="form-select" name="product_id" id="edit_product_name">
                                        <option value="" selected>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_prod_size_select">Product Size*</label>
                                    <select class="form-select" name="edit_prod_size_select" id="edit_prod_size_select">
                                        <option value="" selected>Select Product Size</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="XXXL">XXXL</option>


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_color_value">Product Color*</label>

                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Color Picker -->
                                        <input type="color" class="form-control form-control-color" id="color_picker"
                                            value="" title="Choose color" style="width: 60px; height: 38px; padding: 0;">

                                        <!-- Text Input for Color Name/Code -->
                                        <input type="text" class="form-control" id="edit_product_color_value"
                                            name="edit_product_color_value" placeholder="Product color" required>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_mrp_price">Product MRP Price(ORIGINAL
                                        PRICE)*</label>
                                    <input type="text" class="form-control" id="edit_product_mrp_price" name="mrp_price"
                                        placeholder="Product MRP price" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_offer_price">Product Selling Price(OFFER
                                        PRICE)*</label>
                                    <input type="text" class="form-control" id="edit_product_offer_price" name="offer_price"
                                        placeholder="Product Selling price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_product_quantity">Stock Quantity*</label>
                                    <input type="text" class="form-control" id="edit_product_quantity" name="product_qty"
                                        placeholder="Product Quantity" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_Low_Stock">Low Stock*</label>
                                    <input type="text" class="form-control" id="edit_Low_Stock" name="low_stock"
                                        placeholder="Low Stock" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Select Product GST</label>
                                    <select class="form-select" name="product_gst" id="edit_product_gst">
                                        <option value="" selected>Select Gst</option>
                                        <option value="0">0</option>
                                        {{-- <option value="5">5</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="28">28</option> --}}



                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="mb-3">

                                    <input type="checkbox" name="hot_deals" class="hot_value" value="0"
                                        id="edit_hot_product"> <label class="form-label" for="add_product_mrp_price">Popular
                                        Products</label>
                                </div>
                            </div> --}}

                            <div class="card" style="padding: 20px;border: 1px solid;">
                                <h5>Product Thump Images</h5>
                                <div class="col-lg-12">
                                    <div id="dynamic-inputsedit">


                                        <div class="d-flex product_fieldsedit">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="edit_productthum_image">Product
                                                            Image*(526 *
                                                            789)</label>
                                                        <input type="file" class="form-control image_el  needsclick"
                                                            id="edit_productthum_image" placeholder="Product Image"
                                                            name="product_image1[]" accept="image/*" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 d-flex mb-4">
                                                    <div class="col-6">
                                                        <div class="mb-2">Previous Image</div>
                                                        <label class="edit_show_preview-containernew">
                                                            <img src="" alt="image" class="edit_preview_image"></label>
                                                    </div>

                                                    <div class="col-6 ">
                                                        <div class="mb-2">New Image</div>
                                                        <label for="edit_productthum_image"
                                                            class="edit_preview-containernew123">
                                                            <div class="flex justify-content-center">
                                                                <div class="text-center">
                                                                    <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"
                                                                        style="font-size: 20px"></i>
                                                                </div>
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 mt-4">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-danger delete-inputdeit"
                                                            type="button">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-3">
                                    <button id="add-inputedit" class="btn btn-success" type="button">Add
                                        Another Images</button>
                                </div>
                            </div>


                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary mt-3 editver_submit_btn" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorPicker = document.getElementById('color_picker');
        const colorInput = document.getElementById('edit_product_color_value');

        // Sync color picker value to text input
        colorPicker.addEventListener('input', function () {
            colorInput.value = colorPicker.value;
        });

        // Sync text input value to color picker if it's a valid hex color
        colorInput.addEventListener('input', function () {
            const value = colorInput.value.trim();
            const isValidHex = /^#([0-9A-F]{3}){1,2}$/i.test(value);
            if (isValidHex) {
                colorPicker.value = value;
            }
        });
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Edit color sync
        const editColorPicker = document.getElementById('color_picker');
        const editColorInput = document.getElementById('edit_product_color_value');

        if (editColorPicker && editColorInput) {
            editColorPicker.addEventListener('input', function () {
                editColorInput.value = editColorPicker.value;
            });

            editColorInput.addEventListener('input', function () {
                const value = editColorInput.value.trim();
                const isValidHex = /^#([0-9A-F]{3}){1,2}$/i.test(value);
                if (isValidHex) {
                    editColorPicker.value = value;
                }
            });
        }

        // Add color sync
        const addColorPicker = document.getElementById('add_color_picker');
        const addColorInput = document.getElementById('add_product_color_value');

        if (addColorPicker && addColorInput) {
            addColorPicker.addEventListener('input', function () {
                addColorInput.value = addColorPicker.value;
            });

            addColorInput.addEventListener('input', function () {
                const value = addColorInput.value.trim();
                const isValidHex = /^#([0-9A-F]{3}){1,2}$/i.test(value);
                if (isValidHex) {
                    addColorPicker.value = value;
                }
            });
        }
    });
</script>


@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script>
        window.productvarient = @json($productvarient);
    </script>
    <script src="{{ URL::asset('assets/js/app/ProductVarientPage.js') }}"></script>
@endsection