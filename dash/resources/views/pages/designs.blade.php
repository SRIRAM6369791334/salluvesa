@extends('layouts.master')
@section('title')
    Saaluvesa
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
    <style>
        .modal-button {
            position: static !important;
            text-align: end;
        }
        .gridImage {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
    @slot('li_1')
    Home
    @endslot
    @slot('title')
    Designs
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
                                    <div>
                                        <button type="button" class="btn btn-success mb-4"
                                            data-bs-toggle="modal" data-bs-target="#addDesignModal"><i
                                                class="mdi mdi-plus me-1"></i> Add Design</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="table-designs-gridjs"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Design Modal -->
    <div class="modal fade" id="addDesignModal" tabindex="-1" aria-labelledby="addDesignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDesignModalLabel">Add Design</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addDesignForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title*</label>
                                <input type="text" class="form-control" id="add_designTitle" name="title" placeholder="Title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tag*</label>
                                <input type="text" class="form-control" id="add_designTag" name="tag" placeholder="Tag" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type*</label>
                                <input type="text" class="form-control" id="add_designType" name="type" placeholder="Type" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" class="form-control" id="add_designPrice" name="price" placeholder="Price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Size*</label>
                                <input type="text" class="form-control" id="add_designSize" name="size" placeholder="Size (e.g. S, M, L, XL)" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cloth Types*</label>
                                <input type="text" class="form-control" id="add_designClothTypes" name="cloth_types" placeholder="Cloth Types" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge</label>
                                <input type="text" class="form-control" id="add_designBadge" name="badge" placeholder="Badge (e.g. Popular)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge Type</label>
                                <input type="text" class="form-control" id="add_designBadgeType" name="badge_type" placeholder="Badge Type (e.g. popular)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSM Options (Comma separated)</label>
                                <input type="text" class="form-control" id="add_designGsm" name="gsm" placeholder="e.g. 160,180,200">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="add_designSortOrder" name="sort_order" placeholder="Sort Order" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="add_designIsActive" name="is_active">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Features (Comma separated)</label>
                                <input type="text" class="form-control" id="add_designFeatures" name="features" placeholder="e.g. Durable,Soft">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Color Options</label>
                                <div id="add-colors-container-designs">
                                    <div class="d-flex align-items-center gap-2 mb-2 color-row">
                                        <input type="color" class="form-control form-control-color color-picker-tool" value="#000000" title="Choose color" style="width: 60px; height: 38px; padding: 0;">
                                        <input type="text" class="form-control color-input-value" name="colors[]" placeholder="Color Hex/Name">
                                        <button type="button" class="btn btn-danger remove-color">Delete</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-1 add-color-btn" data-target="add-colors-container-designs">Add Another Color</button>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description*</label>
                                <textarea class="form-control" id="add_designDescription" name="description" rows="3" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Design Image*</label>
                                <input type="file" class="form-control" id="add_designImage" name="image" accept=".png, .jpg, .jpeg" required>
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

    <!-- Edit Design Modal -->
    <div class="modal fade" id="editDesignModal" tabindex="-1" aria-labelledby="editDesignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDesignModalLabel">Edit Design</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editDesignForm" novalidate>
                        <input type="hidden" id="edit_design_id" />
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title*</label>
                                <input type="text" class="form-control" id="edit_designTitle" name="title" placeholder="Title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tag*</label>
                                <input type="text" class="form-control" id="edit_designTag" name="tag" placeholder="Tag" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type*</label>
                                <input type="text" class="form-control" id="edit_designType" name="type" placeholder="Type" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" class="form-control" id="edit_designPrice" name="price" placeholder="Price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Size*</label>
                                <input type="text" class="form-control" id="edit_designSize" name="size" placeholder="Size" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cloth Types*</label>
                                <input type="text" class="form-control" id="edit_designClothTypes" name="cloth_types" placeholder="Cloth Types" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge</label>
                                <input type="text" class="form-control" id="edit_designBadge" name="badge" placeholder="Badge">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge Type</label>
                                <input type="text" class="form-control" id="edit_designBadgeType" name="badge_type" placeholder="Badge Type">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSM Options (Comma separated)</label>
                                <input type="text" class="form-control" id="edit_designGsm" name="gsm" placeholder="GSM Options">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="edit_designSortOrder" name="sort_order" placeholder="Sort Order">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="edit_designIsActive" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Features (Comma separated)</label>
                                <input type="text" class="form-control" id="edit_designFeatures" name="features" placeholder="Features">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Color Options</label>
                                <div id="edit-colors-container-designs">
                                    <!-- Dynamic rows -->
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-1 add-color-btn" data-target="edit-colors-container-designs">Add Another Color</button>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description*</label>
                                <textarea class="form-control" id="edit_designDescription" name="description" rows="3" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Design Image</label>
                                <input type="file" class="form-control" id="edit_designImage" name="image" accept=".png, .jpg, .jpeg">
                                <div class="mt-2">
                                    <label>Previous Image:</label><br>
                                    <img src="" class="edit_preview_image gridImage" alt="Preview">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary edit_submit_btn mt-3" type="submit">Update</button>
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
        window.designs = @json($designs);
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ URL::asset('assets/js/app/DesignsPage.js') }}"></script>
@endsection
