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
    Samples
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
                                            data-bs-toggle="modal" data-bs-target="#addSamplesModal"><i
                                                class="mdi mdi-plus me-1"></i> Add Sample</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="samples-gridjs"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Sample Modal -->
    <div class="modal fade" id="addSamplesModal" tabindex="-1" aria-labelledby="addSamplesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSamplesModalLabel">Add Sample</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addSamplesForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title*</label>
                                <input type="text" class="form-control" name="title" placeholder="Title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category*</label>
                                <input type="text" class="form-control" name="category" placeholder="Category" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge*</label>
                                <input type="text" class="form-control" name="badge" placeholder="Badge (e.g. Popular)" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge Type*</label>
                                <input type="text" class="form-control" name="badge_type" placeholder="Badge Type (e.g. popular)" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" class="form-control" name="price" placeholder="Price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sizes* (Comma separated)</label>
                                <input type="text" class="form-control" name="sizes" placeholder="e.g. S,M,L,XL" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cloth Types*</label>
                                <input type="text" class="form-control" name="cloth_types" placeholder="Cloth Types" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order*</label>
                                <input type="number" class="form-control" name="sort_order" placeholder="Sort Order" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSM Options* (Comma separated)</label>
                                <input type="text" class="form-control" name="gsm" placeholder="e.g. 160,180,200" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Color Options*</label>
                                <div id="add-colors-container">
                                    <div class="d-flex align-items-center gap-2 mb-2 color-row">
                                        <input type="color" class="form-control form-control-color color-picker-tool" value="#000000" title="Choose color" style="width: 60px; height: 38px; padding: 0;">
                                        <input type="text" class="form-control color-input-value" name="colors[]" placeholder="Color Hex/Name" required>
                                        <button type="button" class="btn btn-danger remove-color">Delete</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-1 add-color-btn" data-target="add-colors-container">Add Another Color</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status*</label>
                                <select class="form-select" name="is_active" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features* (Comma separated)</label>
                                <input type="text" class="form-control" name="features" placeholder="e.g. Durable,Soft" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description*</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Sample Image*</label>
                                <input type="file" class="form-control" name="image" accept=".png, .jpg, .jpeg" required>
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

    <!-- Edit Sample Modal -->
    <div class="modal fade" id="editSamplesModal" tabindex="-1" aria-labelledby="editSamplesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSamplesModalLabel">Edit Sample</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editSamplesForm" novalidate>
                        <input type="hidden" id="edit_sample_id" />
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title*</label>
                                <input type="text" class="form-control" id="edit_sample_title" name="title" placeholder="Title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category*</label>
                                <input type="text" class="form-control" id="edit_sample_category" name="category" placeholder="Category" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge*</label>
                                <input type="text" class="form-control" id="edit_sample_badge" name="badge" placeholder="Badge" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge Type*</label>
                                <input type="text" class="form-control" id="edit_sample_badge_type" name="badge_type" placeholder="Badge Type" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" class="form-control" id="edit_sample_price" name="price" placeholder="Price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sizes* (Comma separated)</label>
                                <input type="text" class="form-control" id="edit_sample_sizes" name="sizes" placeholder="Sizes" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cloth Types*</label>
                                <input type="text" class="form-control" id="edit_sample_cloth_types" name="cloth_types" placeholder="Cloth Types" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order*</label>
                                <input type="number" class="form-control" id="edit_sample_sort_order" name="sort_order" placeholder="Sort Order" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSM Options* (Comma separated)</label>
                                <input type="text" class="form-control" id="edit_sample_gsm" name="gsm" placeholder="GSM Options" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Color Options*</label>
                                <div id="edit-colors-container">
                                    <!-- Dynamic rows will be appended here -->
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-1 add-color-btn" data-target="edit-colors-container">Add Another Color</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status*</label>
                                <select class="form-select" id="edit_sample_is_active" name="is_active" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features* (Comma separated)</label>
                                <input type="text" class="form-control" id="edit_sample_features" name="features" placeholder="Features" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description*</label>
                                <textarea class="form-control" id="edit_sample_description" name="description" rows="3" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Sample Image</label>
                                <input type="file" class="form-control" name="image" accept=".png, .jpg, .jpeg">
                                <div class="mt-2">
                                    <label>Previous Image:</label><br>
                                    <img src="" id="edit_sample_preview" class="gridImage" alt="Preview">
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
        window.samples = @json($samples);
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ URL::asset('assets/js/app/SamplesPage.js') }}"></script>
@endsection
