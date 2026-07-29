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
                `<div style="display: flex; gap: 5px;">
                    <button class="btn btn-secondary btn-sm edit_btn" data-id="${product.id}">Edit</button>
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
                    `<div style="display: flex; gap: 5px;">
                        <button class="btn btn-secondary btn-sm edit_btn" data-id="${product.id}">Edit</button>
                        <button class="btn btn-anger btn-sm delete_btn" data-id="${product.id}">Delete</button>
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
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Product';
                    console.error('Error:', error);
                });
        });
    }
});