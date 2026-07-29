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

    <!-- Interactive Placement Studio Modal -->
    <style>
        .ps-handle {
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: #0d6efd;
            border: 2px solid #ffffff;
            border-radius: 50%;
            z-index: 15;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .ps-handle-nw { top: -6px; left: -6px; cursor: nwse-resize; }
        .ps-handle-ne { top: -6px; right: -6px; cursor: nesw-resize; }
        .ps-handle-sw { bottom: -6px; left: -6px; cursor: nesw-resize; }
        .ps-handle-se { bottom: -6px; right: -6px; cursor: nwse-resize; }
    </style>

    <div class="modal fade" id="placementModal" tabindex="-1" aria-labelledby="placementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white" id="placementModalLabel">
                        <i class="bx bx-target-lock text-primary me-2"></i> Interactive Embroidery & Logo Placement Studio
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <input type="hidden" id="ps_variant_id">
                    <div class="row g-4">
                        <!-- Left Mockup Preview Area -->
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm p-3 text-center bg-white h-100" style="border-radius: 12px;">
                                <h6 class="fw-bold text-muted mb-3">Live Image & Placement Preview</h6>
                                <div id="placement-canvas-area" class="position-relative mx-auto overflow-hidden rounded bg-white" style="width: 100%; max-width: 460px; height: 480px; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center;">
                                    <img id="placement-garment-img" src="" class="img-fluid w-100 h-100" style="object-fit: contain;" alt="Garment Preview">
                                    
                                    <div id="draggable-placement-box" class="position-absolute d-flex flex-column align-items-center justify-content-center" 
                                         style="top: 25%; left: 28%; width: 44%; height: 55%; border: 2px dashed #038edc; background: rgba(3, 142, 220, 0.18); cursor: move; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); user-select: none; z-index: 10;">
                                        <span id="placement-box-label" class="badge bg-danger mb-1 shadow-sm" style="font-size: 11px; pointer-events: none;">LEFT CHEST</span>
                                        <small class="text-primary fw-bold" style="font-size: 10px; pointer-events: none;">🖐 Drag / Resize Box</small>

                                        <!-- 4 Corner Resizing Handles -->
                                        <div class="ps-handle ps-handle-nw" data-handle="nw" title="Drag to Resize"></div>
                                        <div class="ps-handle ps-handle-ne" data-handle="ne" title="Drag to Resize"></div>
                                        <div class="ps-handle ps-handle-sw" data-handle="sw" title="Drag to Resize"></div>
                                        <div class="ps-handle ps-handle-se" data-handle="se" title="Drag to Resize"></div>
                                    </div>
                                </div>
                                <small class="text-primary mt-2 d-block fw-bold" style="font-size: 12px;">💡 <strong>User Friendly:</strong> Click & Drag the blue box anywhere on the image, or drag any corner dot to resize!</small>
                            </div>
                        </div>

                        <!-- Right Control Panel -->
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm p-4 bg-white h-100" style="border-radius: 12px;">
                                <!-- View Switcher -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select View to Position:</label>
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-outline-primary active placement-view-tab" data-view="front">Front View</button>
                                        <button type="button" class="btn btn-outline-primary placement-view-tab" data-view="back">Back View</button>
                                        <button type="button" class="btn btn-outline-primary placement-view-tab" data-view="left">Left Sleeve</button>
                                        <button type="button" class="btn btn-outline-primary placement-view-tab" data-view="right">Right Sleeve</button>
                                    </div>
                                </div>

                                <!-- Enable Toggle Switch -->
                                <div class="form-check form-switch mb-3 bg-light p-3 rounded border">
                                    <input class="form-check-input" type="checkbox" id="ps_enable_view" checked>
                                    <label class="form-check-label fw-bold" for="ps_enable_view">Enable Customization for this View</label>
                                </div>

                                <!-- Zone Label Input -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Zone Label Name:</label>
                                    <input type="text" class="form-control" id="placement_zone_label" value="LEFT CHEST" placeholder="e.g. LEFT CHEST, UPPER BACK">
                                    <small class="text-muted" style="font-size: 11px;">e.g. LEFT CHEST, UPPER BACK, SLEEVE LOGO</small>
                                </div>

                                <div class="mb-3 bg-light p-3 rounded border">
                                    <h6 class="fw-bold text-primary mb-3"><i class="bx bx-slider-alt me-1"></i> Precision Side & Size Controls</h6>

                                    <!-- Top Y -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 fw-bold small">Top Side (Y %):</label>
                                            <span class="small fw-bold text-primary" id="val_top_y">25%</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_top_y" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_top_y" min="0" max="90" value="25">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_top_y" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <!-- Left X -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 fw-bold small">Left Side (X %):</label>
                                            <span class="small fw-bold text-primary" id="val_left_x">28%</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_left_x" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_left_x" min="0" max="90" value="28">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_left_x" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <!-- Width -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 fw-bold small">Width (Reduce/Increase %):</label>
                                            <span class="small fw-bold text-primary" id="val_width">44%</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_width" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_width" min="10" max="80" value="44">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_width" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <!-- Height -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 fw-bold small">Height (Reduce/Increase %):</label>
                                            <span class="small fw-bold text-primary" id="val_height">55%</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_height" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_height" min="10" max="80" value="55">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold nudge-btn" data-field="range_height" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <!-- Corner Rounding (px) -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 text-muted small">Corner Rounding (px):</label>
                                            <span class="small fw-bold text-secondary" id="val_radius">4px</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 nudge-btn" data-field="range_radius" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_radius" min="0" max="30" value="4">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 nudge-btn" data-field="range_radius" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <!-- Rotation (deg) -->
                                    <div class="mb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label mb-0 text-muted small">Box Tilt / Rotation (°):</label>
                                            <span class="small fw-bold text-secondary" id="val_rotation">0°</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 nudge-btn" data-field="range_rotation" data-step="-1">-</button>
                                            <input type="range" class="form-range flex-grow-1" id="range_rotation" min="-45" max="45" value="0">
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 nudge-btn" data-field="range_rotation" data-step="1">+</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Position Presets -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Quick Position Presets:</label>
                                    <div class="d-flex flex-wrap gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary preset-btn" data-preset="left_chest">Left Chest</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary preset-btn" data-preset="right_chest">Right Chest</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary preset-btn" data-preset="center_chest">Center Chest</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary preset-btn" data-preset="upper_back">Upper Back</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary preset-btn" data-preset="sleeve">Sleeve Center</button>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-success btn-lg w-100 fw-bold shadow-sm" id="save-placement-btn">
                                    <i class="bx bx-save me-1"></i> Save Placement Settings
                                </button>
                            </div>
                        </div>
                    </div>
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
