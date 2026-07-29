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
    Category
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
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <div class="row align-items-start">
                                <div class="col-sm">
                                    <div>
                                        <button type="button" class="btn btn-success  add_btn_top_el mb-4"
                                            data-bs-toggle="modal" data-bs-target="#addCategoriesModal"><i
                                                class="mdi mdi-plus me-1"></i> Add
                                            Category</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div id="table-gridjs"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCategoriesModal" tabindex="-1" aria-labelledby="addCategoriesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoriesModalLabel">Add Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="addCategoriesForm" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add_categoriesname">Category Name</label><span
                                        class="dark-asterisk">*</span>
                                    <input type="text" class="form-control" id="add_categoriesname" name="category_name"
                                        placeholder="Categories name" maxlength="50" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add_categoryImage">Category Image</label>
                                    <span class="dark-asterisk">*(948 * 560)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="add_categoryImage"
                                        placeholder="Category Image" accept=".png, .jpg, .jpeg" name="category_image"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="add_categoryImage" class="preview-container">
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
                            {{-- <div class="col-md-12 mt-5">
                                <div class="mb-3">
                                    <label class="form-label" for="add_categorybanner">Category Banner</label>
                                    <span class="dark-asterisk">*(1320 * 250)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="add_categorybanner"
                                        placeholder="Category Banner" accept=".png, .jpg, .jpeg" name="category_banner"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="add_categorybanner" class="banner_preview-container">
                                    <div class="flex justify-content-center">
                                        <div class="text-center">
                                            <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                        </div>
                                        <div>
                                            <span class="col-12">Upload Image</span>
                                        </div>
                                    </div>
                                </label>
                            </div> --}}
                            {{-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add_categoryImage">Collection Image</label>
                                    <span class="dark-asterisk">*(512* 512)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="add_collectionImage"
                                        placeholder="Collection Image" accept=".png, .jpg, .jpeg" name="collection_image"
                                        required>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-12">
                                <label for="add_collectionImage" class="icon_preview-container">
                                    <div class="flex justify-content-center">
                                        <div class="text-center">
                                            <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                        </div>
                                        <div>
                                            <span class="col-12">Upload Image</span>
                                        </div>
                                    </div>
                                </label>
                            </div> --}}

                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary add_submit_btn mt-3" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editCategoriesModal" tabindex="-1" aria-labelledby="editCategoriesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoriesModalLabel">Edit Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="editCategoriesForm" novalidate>
                        <input type="hidden" id="edit_categories_id" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_categoriesname">Category Name*</label>
                                    <input type="text" class="form-control" id="edit_categoriesname" name="category_name"
                                        placeholder="Categories name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_categoryImage">Category Image*</label>
                                    <span class="dark-asterisk">*(948 * 560)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="edit_categoryImage"
                                        placeholder="CategoryImage" name="category_image" accept=".png, .jpg, .jpeg"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex">
                                <div class="col-6">
                                    <div class="mb-2">Previous Image</div>
                                    <label class="edit_show_preview-container">
                                        <img src="" alt="edit_category_image" class="edit_preview_image"></label>
                                </div>

                                <div class="col-6">
                                    <div class="mb-2">New Image</div>
                                    <label for="edit_categoryImage" class="edit_preview-container">
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
                            {{-- <div class="col-md-12 mt-5">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_categorybanner">Category Banner*</label>
                                    <span class="dark-asterisk">*(1320 * 250)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="edit_categorybanner"
                                        placeholder="Categorybanner" name="category_banner" accept=".png, .jpg, .jpeg"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="col-6">
                                    <div class="mb-2">Previous Banner</div>
                                    <label class="edit_show_banner-container">
                                        <img src="" alt="edit_category_banner" class="edit_preview_banner"></label>
                                </div>

                                <div class="col-6">
                                    <div class="mb-2">New Banner</div>
                                    <label for="edit_categorybanner" class="edit_banner-container">
                                        <div class="flex justify-content-center">
                                            <div class="text-center">
                                                <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
                                            </div>
                                            <div>
                                                <span class="col-12">Upload Banner</span>
                                            </div>
                                        </div>
                                    </label>

                                </div>

                            </div> --}}

                            {{-- <div class="col-md-12 mt-5">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_collectionImage">Collection Image*</label>
                                    <span class="dark-asterisk">*(512 * 512)(Only png,jpg,jpeg)</span>
                                    <input type="file" class="form-control" id="edit_collectionImage"
                                        placeholder="Collection Image" name="collection_image" accept=".png, .jpg, .jpeg"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex">
                                <div class="col-6">
                                    <div class="mb-2">Previous Image</div>
                                    <label class="edit_icon_preview-container">
                                        <img src="" alt="edit_collection_image" class="edit_preview_icon"></label>
                                </div>

                                <div class="col-6">
                                    <div class="mb-2">New Image</div>
                                    <label for="edit_collectionImage" class="edit_icon-container">
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

                            </div> --}}

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
        window.categories = @json($categories);
    </script>

    <script src="{{ URL::asset('assets/js/app/CategoriesPage.js') }}"></script>
@endsection