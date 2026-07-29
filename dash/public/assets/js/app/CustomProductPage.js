// Initialize Grid.js
const gridNew = new gridjs.Grid({
    columns: [
        "Name",
        "Description",
        "Base Price",
        "Product Type",
        "Mockups",
        "Status",
        {
            name: "Action",
            sort: false,
        },
    ],
    pagination: {
        limit: 10,
    },
    sort: true,
    search: true,
    data: customProducts.map((product) => {
        return [
            product.name,
            product.description,
            product.base_price,
            product.product_type,
            gridjs.html(
                `
                <div style="display: flex; gap: 5px;">
                    <img src="${product.front_mockup}" alt="Front" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ccc;">
                    <img src="${product.back_mockup ? product.back_mockup : ''}" alt="Back" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ccc; display: ${product.back_mockup ? 'block' : 'none'};">
                </div>
                `
            ),
            product.status,
            gridjs.html(
                `<div style="display: flex; gap: 4px; justify-content: center;">
                    <button class="btn btn-secondary btn-sm edit_btn" data-id="${product.id}">Edit</button>
                    <button class="btn btn-info btn-sm placement_btn" data-id="${product.id}" style="background-color: #038edc; border-color: #038edc; color: #fff;">🎯 Placement</button>
                    <button class="btn btn-danger btn-sm delete_btn" data-id="${product.id}">Delete</button>
                </div>`
            ),
        ];
    }),
    style: {
        table: {
            border: "1px solid #ccc",
        },
        th: {
            "background-color": "rgba(0, 0, 0, 0.1)",
            color: "#000",
            "border-bottom": "3px solid #ccc",
            "text-align": "center",
            "border-right": "0.5px solid #ccc",
        },
        td: {
            "text-align": "center",
            "border-right": "0.5px solid #ccc",
            "border-bottom": "0.5px solid #ccc",
        },
    },
});

gridNew.render(document.getElementById("table-gridjs"));

function gridjsReRender(products) {
    window.customProducts = products;
    gridNew.updateConfig({
        data: products.map((product) => {
            return [
                product.name,
                product.description,
                product.base_price,
                product.product_type,
                gridjs.html(
                    `
                    <div style="display: flex; gap: 5px;">
                        <img src="${product.front_mockup}" alt="Front" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ccc;">
                        <img src="${product.back_mockup ? product.back_mockup : ''}" alt="Back" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ccc; display: ${product.back_mockup ? 'block' : 'none'};">
                    </div>
                    `
                ),
                product.status,
                gridjs.html(
                    `<div style="display: flex; gap: 4px; justify-content: center;">
                        <button class="btn btn-secondary btn-sm edit_btn" data-id="${product.id}">Edit</button>
                        <button class="btn btn-info btn-sm placement_btn" onclick="openPlacementStudio(${product.id})" data-id="${product.id}" style="background-color: #038edc; border-color: #038edc; color: #fff;">🎯 Placement</button>
                        <button class="btn btn-danger btn-sm delete_btn" data-id="${product.id}">Delete</button>
                    </div>`
                ),
            ];
        })
    }).forceRender();
}

// Global state for dynamic rows
let colorIndex = 0;
let editColorIndex = 0;

// Helper to close modal and backdrop
function closeModal(modalId) {
    const modalElement = document.getElementById(modalId);
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) modal.hide();

    // Clean up if needed
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.style.overflowY = "scroll";
    document.body.classList.remove('modal-open');
}

// Event Delegation for Table Actions
document.addEventListener('click', function (e) {
    // Delete Action
    if (e.target.closest('.delete_btn')) {
        const id = e.target.closest('.delete_btn').getAttribute('data-id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/custom-products/destroy/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            gridjsReRender(data.products);
                            Swal.fire("Deleted!", "Product has been deleted.", "success");
                        } else {
                            Swal.fire("Error!", data.message || "Failed to delete product.", "error");
                        }
                    });
            }
        });
    }

    // Copy Action
    if (e.target.closest('.copy_btn')) {
        const id = e.target.closest('.copy_btn').getAttribute('data-id');
        Swal.fire({
            title: "Duplicate Product?",
            text: "This will create a copy of this product with all its variants.",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Yes, duplicate!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/custom-products/duplicate/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            gridjsReRender(data.products);
                            Swal.fire("Duplicated!", "Product copy created successfully.", "success");
                        } else {
                            Swal.fire("Error!", data.message || "Failed to duplicate product.", "error");
                        }
                    });
            }
        });
    }

    // Edit Action (Show Modal)
    if (e.target.closest('.edit_btn')) {
        const id = e.target.closest('.edit_btn').getAttribute('data-id');
        fetch(`/custom-products/edit/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.product;
                    const editColorsContainer = document.getElementById('edit_colors_container');

                    document.getElementById('edit_product_id').value = product.id;
                    document.getElementById('edit_name').value = product.name;
                    document.getElementById('edit_base_price').value = product.base_price;
                    document.getElementById('edit_description').value = product.description;
                    document.getElementById('edit_product_type').value = product.product_type;

                    // Populate Colors
                    if (editColorsContainer) {
                        editColorsContainer.innerHTML = '';
                        editColorIndex = 0;

                        if (product.colors && product.colors.length > 0) {
                            product.colors.forEach(color => {
                                let formattedViews = {};
                                if (color.images) {
                                    color.images.forEach(img => {
                                        formattedViews[img.view_type] = '/' + img.image_path;
                                    });
                                }
                                color.views = formattedViews;
                                addEditColorRow(color);
                            });
                        }
                    }

                    const modal = new bootstrap.Modal(document.getElementById('editCustomProductModal'));
                    modal.show();
                } else {
                    Swal.fire("Error!", "Failed to fetch product details.", "error");
                }
            });
    }
});

// Dynamic Color Row Helper for ADD
function addColorRow() {
    const colorsContainer = document.getElementById('colors_container');
    const colorRow = document.createElement('div');
    colorRow.classList.add('row', 'mb-3', 'color-row', 'border', 'p-3', 'rounded');
    colorRow.setAttribute('data-index', colorIndex);

    colorRow.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6>Color Variant #${colorIndex + 1}</h6>
            <button type="button" class="btn btn-danger btn-sm remove-color-btn">&times;</button>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Color Name</label>
            <input type="text" class="form-control" name="colors[${colorIndex}][name]" placeholder="e.g. Red" required>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Color Code</label>
            <input type="color" class="form-control form-control-color" name="colors[${colorIndex}][code]" value="#563d7c" title="Choose your color" required>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Front Image (Optional)</label>
            <input type="file" class="form-control" name="colors[${colorIndex}][images][front]">
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Back Image (Optional)</label>
            <input type="file" class="form-control" name="colors[${colorIndex}][images][back]">
        </div>
    `;

    colorsContainer.appendChild(colorRow);

    colorRow.querySelector('.remove-color-btn').addEventListener('click', function () {
        colorRow.remove();
    });

    colorIndex++;
}

// Dynamic Color Row Helper for EDIT
function addEditColorRow(color = null) {
    const editColorsContainer = document.getElementById('edit_colors_container');
    const colorRow = document.createElement('div');
    colorRow.classList.add('row', 'mb-3', 'color-row', 'border', 'p-3', 'rounded');
    colorRow.setAttribute('data-index', editColorIndex);

    const colorIdInput = color ? `<input type="hidden" name="colors[${editColorIndex}][id]" value="${color.id}">` : '';

    colorRow.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6>Color Variant #${editColorIndex + 1}</h6>
            <button type="button" class="btn btn-danger btn-sm remove-color-btn">&times;</button>
        </div>
        ${colorIdInput}
        <div class="col-md-3 mb-2">
            <label class="form-label">Color Name</label>
            <input type="text" class="form-control" name="colors[${editColorIndex}][name]" value="${color ? color.color_name : ''}" placeholder="e.g. Red" required>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Color Code</label>
            <input type="color" class="form-control form-control-color" name="colors[${editColorIndex}][code]" value="${color ? color.color_code : '#563d7c'}" title="Choose your color" required>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Front Image ${color ? '(Keep Empty to Keep)' : '(Optional)'}</label>
            <input type="file" class="form-control" name="colors[${editColorIndex}][images][front]">
             ${color && color.views && color.views.front ? `<small><a href="${color.views.front}" target="_blank">View Current</a></small>` : ''}
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Back Image ${color ? '(Keep Empty to Keep)' : '(Optional)'}</label>
            <input type="file" class="form-control" name="colors[${editColorIndex}][images][back]">
             ${color && color.views && color.views.back ? `<small><a href="${color.views.back}" target="_blank">View Current</a></small>` : ''}
        </div>
    `;

    editColorsContainer.appendChild(colorRow);

    colorRow.querySelector('.remove-color-btn').addEventListener('click', function () {
        colorRow.remove();
    });

    editColorIndex++;
}

// Initial Listeners
document.addEventListener('DOMContentLoaded', function () {
    const addColorBtn = document.getElementById('add_color_btn');
    if (addColorBtn) {
        addColorBtn.addEventListener('click', addColorRow);
    }

    const editAddColorBtn = document.getElementById('edit_add_color_btn');
    if (editAddColorBtn) {
        editAddColorBtn.addEventListener('click', () => addEditColorRow());
    }

    // Add Form Submit
    const addForm = document.getElementById('addCustomProductForm');
    if (addForm) {
        addForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

            fetch('/custom-products/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Product';
                    if (data.success) {
                        Swal.fire("Success!", "Product created successfully.", "success");
                        addForm.reset();
                        if (document.getElementById('colors_container')) {
                            document.getElementById('colors_container').innerHTML = '';
                        }
                        colorIndex = 0;
                        gridjsReRender(data.products);
                        closeModal('addCustomProductModal');
                    } else {
                        Swal.fire("Error!", data.message || "Failed to create product.", "error");
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Product';
                    console.error('Error:', error);
                });
        });
    }

    // Edit Form Submit
    const editForm = document.getElementById('editCustomProductForm');
    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = document.getElementById('edit_product_id').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';

            fetch(`/custom-products/update/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Product';
                    if (data.success) {
                        Swal.fire("Success!", "Product updated successfully.", "success");
                        gridjsReRender(data.products);
                        closeModal('editCustomProductModal');
                    } else {
                        Swal.fire("Error!", data.message || "Failed to update product.", "error");
                    }
                })
        });
    }

    // ─────────────────────────────────────────────────────────────
    // Interactive Embroidery & Logo Placement Studio JS Engine
    // ─────────────────────────────────────────────────────────────
    let currentPlacementProductId = null;
    let currentPlacementProduct = null;
    let currentPlacementView = 'front';
    let placementConfigData = {
        front: { enabled: true, top: 25, left: 28, width: 44, height: 55, radius: 4, rotation: 0, label: 'LEFT CHEST' },
        back: { enabled: true, top: 20, left: 20, width: 60, height: 60, radius: 4, rotation: 0, label: 'UPPER BACK' },
        left: { enabled: true, top: 30, left: 30, width: 40, height: 40, radius: 4, rotation: 0, label: 'LEFT SLEEVE' },
        right: { enabled: true, top: 30, left: 30, width: 40, height: 40, radius: 4, rotation: 0, label: 'RIGHT SLEEVE' }
    };

    window.openPlacementStudio = function(id) {
        currentPlacementProductId = id;
        const productsList = window.customProducts || (typeof customProducts !== 'undefined' ? customProducts : []);
        currentPlacementProduct = productsList.find(p => p.id == id);
        
        if (!currentPlacementProduct) {
            console.error('Custom product not found for ID:', id);
            return;
        }
        
        // Parse existing printable_rect if available
        if (currentPlacementProduct.printable_rect) {
            try {
                const parsed = typeof currentPlacementProduct.printable_rect === 'string' ? JSON.parse(currentPlacementProduct.printable_rect) : currentPlacementProduct.printable_rect;
                if (parsed && typeof parsed === 'object') {
                    placementConfigData = Object.assign(placementConfigData, parsed);
                }
            } catch(err) { console.error('Error parsing placement_config:', err); }
        }

        currentPlacementView = 'front';
        loadPlacementView('front');
        
        const modalEl = document.getElementById('placementModal');
        if (modalEl) {
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.show();
        } else {
            console.error('placementModal element not found');
        }
    };

    document.addEventListener('click', function(e) {
        const btn = e.target ? e.target.closest('.placement_btn') : null;
        if (btn) {
            e.preventDefault();
            const id = btn.getAttribute('data-id');
            window.openPlacementStudio(id);
        }
    });

    function loadPlacementView(view) {
        currentPlacementView = view;
        document.querySelectorAll('.placement-view-tab').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === view);
        });

        // Set mockup image
        const imgEl = document.getElementById('placement-garment-img');
        let imgSrc = currentPlacementProduct.front_mockup;
        if (view === 'back' && currentPlacementProduct.back_mockup) imgSrc = currentPlacementProduct.back_mockup;
        if (view === 'left' && currentPlacementProduct.left_shoulder_mockup) imgSrc = currentPlacementProduct.left_shoulder_mockup;
        if (view === 'right' && currentPlacementProduct.right_shoulder_mockup) imgSrc = currentPlacementProduct.right_shoulder_mockup;

        imgEl.src = imgSrc ? '/' + imgSrc.replace(/^\//, '') : 'https://placehold.co/600x600?text=No+Mockup';

        // Load config values for view
        const conf = placementConfigData[view] || { enabled: true, top: 25, left: 28, width: 44, height: 55, radius: 4, rotation: 0, label: 'ZONE' };
        document.getElementById('ps_enable_view').checked = conf.enabled !== false;
        document.getElementById('range_top_y').value = conf.top || 25;
        document.getElementById('range_left_x').value = conf.left || 28;
        document.getElementById('range_width').value = conf.width || 44;
        document.getElementById('range_height').value = conf.height || 55;
        document.getElementById('range_radius').value = conf.radius || 4;
        document.getElementById('range_rotation').value = conf.rotation || 0;
        document.getElementById('placement_zone_label').value = conf.label || (view === 'front' ? 'LEFT CHEST' : (view === 'back' ? 'UPPER BACK' : view.toUpperCase() + ' SLEEVE'));

        updatePlacementBoxUI();
    }

    function updatePlacementBoxUI() {
        const enabled = document.getElementById('ps_enable_view').checked;
        const top = document.getElementById('range_top_y').value;
        const left = document.getElementById('range_left_x').value;
        const width = document.getElementById('range_width').value;
        const height = document.getElementById('range_height').value;
        const radius = document.getElementById('range_radius').value;
        const rotation = document.getElementById('range_rotation').value;
        const label = document.getElementById('placement_zone_label').value;

        document.getElementById('val_top_y').innerText = top + '%';
        document.getElementById('val_left_x').innerText = left + '%';
        document.getElementById('val_width').innerText = width + '%';
        document.getElementById('val_height').innerText = height + '%';
        document.getElementById('val_radius').innerText = radius + 'px';
        document.getElementById('val_rotation').innerText = rotation + '°';
        document.getElementById('placement-box-label').innerText = label || 'ZONE';

        const box = document.getElementById('draggable-placement-box');
        if (box) {
            if (enabled) {
                box.style.display = 'flex';
                box.style.top = top + '%';
                box.style.left = left + '%';
                box.style.width = width + '%';
                box.style.height = height + '%';
                box.style.borderRadius = radius + 'px';
                box.style.transform = `rotate(${rotation}deg)`;
            } else {
                box.style.display = 'none';
            }
        }

        // Save to local object
        placementConfigData[currentPlacementView] = {
            enabled: enabled,
            top: parseInt(top),
            left: parseInt(left),
            width: parseInt(width),
            height: parseInt(height),
            radius: parseInt(radius),
            rotation: parseInt(rotation),
            label: label
        };
    }

    // Attach Slider listeners & toggle switch
    ['range_top_y', 'range_left_x', 'range_width', 'range_height', 'range_radius', 'range_rotation', 'placement_zone_label', 'ps_enable_view'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updatePlacementBoxUI);
            el.addEventListener('change', updatePlacementBoxUI);
        }
    });

    // Nudge +/- Buttons Handler
    document.addEventListener('click', function(e) {
        const nudgeBtn = e.target.closest('.nudge-btn');
        if (nudgeBtn) {
            const fieldId = nudgeBtn.dataset.field;
            const step = parseInt(nudgeBtn.dataset.step || 1);
            const el = document.getElementById(fieldId);
            if (el) {
                let val = parseInt(el.value || 0) + step;
                val = Math.max(parseInt(el.min || 0), Math.min(parseInt(el.max || 100), val));
                el.value = val;
                updatePlacementBoxUI();
            }
        }

        // Preset Buttons Handler
        const presetBtn = e.target.closest('.preset-btn');
        if (presetBtn) {
            const preset = presetBtn.dataset.preset;
            if (preset === 'left_chest') {
                document.getElementById('placement_zone_label').value = 'LEFT CHEST';
                document.getElementById('range_top_y').value = 35;
                document.getElementById('range_left_x').value = 28;
                document.getElementById('range_width').value = 28;
                document.getElementById('range_height').value = 22;
            } else if (preset === 'right_chest') {
                document.getElementById('placement_zone_label').value = 'RIGHT CHEST';
                document.getElementById('range_top_y').value = 35;
                document.getElementById('range_left_x').value = 52;
                document.getElementById('range_width').value = 28;
                document.getElementById('range_height').value = 22;
            } else if (preset === 'center_chest') {
                document.getElementById('placement_zone_label').value = 'CENTER CHEST';
                document.getElementById('range_top_y').value = 32;
                document.getElementById('range_left_x').value = 34;
                document.getElementById('range_width').value = 32;
                document.getElementById('range_height').value = 25;
            } else if (preset === 'upper_back') {
                document.getElementById('placement_zone_label').value = 'UPPER BACK';
                document.getElementById('range_top_y').value = 28;
                document.getElementById('range_left_x').value = 32;
                document.getElementById('range_width').value = 36;
                document.getElementById('range_height').value = 28;
            } else if (preset === 'sleeve') {
                document.getElementById('placement_zone_label').value = currentPlacementView.toUpperCase() + ' SLEEVE';
                document.getElementById('range_top_y').value = 38;
                document.getElementById('range_left_x').value = 32;
                document.getElementById('range_width').value = 28;
                document.getElementById('range_height').value = 22;
            }
            updatePlacementBoxUI();
        }
    });

    // Attach View Tab Listeners
    document.querySelectorAll('.placement-view-tab').forEach(btn => {
        btn.addEventListener('click', function() {
            loadPlacementView(this.dataset.view);
        });
    });

    // ===== MOUSE DRAG & CORNER HANDLE RESIZE LOGIC =====
    (function initDragAndResize() {
        const box = document.getElementById('draggable-placement-box');
        const container = document.getElementById('placement-canvas-area');
        if (!box || !container) return;

        let isDragging = false;
        let isResizing = false;
        let resizeHandle = '';
        let startX, startY, startLeft, startTop, startWidth, startHeight;

        box.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('ps-handle')) {
                isResizing = true;
                resizeHandle = e.target.dataset.handle;
            } else {
                isDragging = true;
            }
            startX = e.clientX;
            startY = e.clientY;

            const rect = box.getBoundingClientRect();
            const parentRect = container.getBoundingClientRect();

            startLeft = rect.left - parentRect.left;
            startTop = rect.top - parentRect.top;
            startWidth = rect.width;
            startHeight = rect.height;

            e.stopPropagation();
            e.preventDefault();
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging && !isResizing) return;
            const parentRect = container.getBoundingClientRect();
            if (!parentRect || parentRect.width === 0) return;

            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            if (isDragging) {
                let newLeft = Math.max(0, Math.min(parentRect.width - startWidth, startLeft + dx));
                let newTop = Math.max(0, Math.min(parentRect.height - startHeight, startTop + dy));

                let leftPct = Math.round((newLeft / parentRect.width) * 100);
                let topPct = Math.round((newTop / parentRect.height) * 100);

                document.getElementById('range_left_x').value = Math.min(90, Math.max(0, leftPct));
                document.getElementById('range_top_y').value = Math.min(90, Math.max(0, topPct));
                updatePlacementBoxUI();
            } else if (isResizing) {
                let newWidth = startWidth;
                let newHeight = startHeight;

                if (resizeHandle.includes('e')) newWidth = Math.max(30, startWidth + dx);
                if (resizeHandle.includes('s')) newHeight = Math.max(30, startHeight + dy);
                if (resizeHandle.includes('w')) newWidth = Math.max(30, startWidth - dx);
                if (resizeHandle.includes('n')) newHeight = Math.max(30, startHeight - dy);

                let widthPct = Math.round((newWidth / parentRect.width) * 100);
                let heightPct = Math.round((newHeight / parentRect.height) * 100);

                document.getElementById('range_width').value = Math.min(80, Math.max(10, widthPct));
                document.getElementById('range_height').value = Math.min(80, Math.max(10, heightPct));
                updatePlacementBoxUI();
            }
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
            isResizing = false;
        });
    })();

    // Save Button Click
    document.getElementById('save-placement-btn')?.addEventListener('click', function() {
        if (!currentPlacementProductId) return;

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Saving...';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/custom-products/${currentPlacementProductId}/save-placement`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ placement_config: placementConfigData })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> Save Placement Settings';
            if (data.success) {
                Swal.fire("Success!", data.message || "Placement settings saved successfully!", "success");
                const modalEl = document.getElementById('placementModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                if (data.products) gridjsReRender(data.products);
            } else {
                Swal.fire("Error!", "Failed to save placement settings.", "error");
            }
        })
        .catch(err => {
            console.error('Error saving placement:', err);
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> Save Placement Settings';
            Swal.fire("Error!", "Error saving placement settings.", "error");
        });
    });
});