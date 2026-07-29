const addValidator = new JustValidate("#addSamplesForm", {
    validateBeforeSubmitting: true,
});
const editValidator = new JustValidate("#editSamplesForm", {
    validateBeforeSubmitting: true,
});

// Custom Validator for Image Dimensions (1024x1536)
const imageDimensionValidator = (file) => {
    return new Promise((resolve) => {
        if (!file || !file.type.startsWith("image/")) {
            resolve(true); // Let other validators handle type/presence
            return;
        }
        const img = new Image();
        img.onload = () => {
            resolve(img.width === 1024 && img.height === 1536);
        };
        img.onerror = () => {
            resolve(false);
        };
        img.src = URL.createObjectURL(file);
    });
};

// Add Form Validation
addValidator
    .addField('[name="title"]', [{ rule: "required", errorMessage: "Title is required" }])
    .addField('[name="category"]', [{ rule: "required", errorMessage: "Category is required" }])
    .addField('[name="badge"]', [{ rule: "required", errorMessage: "Badge is required" }])
    .addField('[name="badge_type"]', [{ rule: "required", errorMessage: "Badge Type is required" }])
    .addField('[name="price"]', [{ rule: "required", errorMessage: "Price is required" }])
    .addField('[name="sizes"]', [{ rule: "required", errorMessage: "Sizes are required" }])
    .addField('[name="cloth_types"]', [{ rule: "required", errorMessage: "Cloth Types are required" }])
    .addField('[name="sort_order"]', [{ rule: "required", errorMessage: "Sort Order is required" }])
    .addField('[name="features"]', [{ rule: "required", errorMessage: "Features are required" }])
    .addField('[name="gsm"]', [{ rule: "required", errorMessage: "GSM Options are required" }])
    .addField('[name="description"]', [{ rule: "required", errorMessage: "Description is required" }])
    .addField('[name="image"]', [
        { rule: "required", errorMessage: "Image is required" },
        {
            rule: "files",
            value: { files: { extensions: ["jpeg", "jpg", "png", "webp"] } },
            errorMessage: "Only images are allowed (jpeg, jpg, png, webp)",
        },
        {
            validator: (value, fields) => {
                const element = document.querySelector('[name="image"]');
                const file = element.files[0];
                return imageDimensionValidator(file);
            },
            errorMessage: "Image must be exactly 1024x1536 pixels",
        },
    ])
    .onSuccess((event) => {
        addSamplesFormSubmit(event);
    });

// Edit Form Validation
editValidator
    .addField('#edit_sample_title', [{ rule: "required", errorMessage: "Title is required" }])
    .addField('#edit_sample_category', [{ rule: "required", errorMessage: "Category is required" }])
    .addField('#edit_sample_badge', [{ rule: "required", errorMessage: "Badge is required" }])
    .addField('#edit_sample_badge_type', [{ rule: "required", errorMessage: "Badge Type is required" }])
    .addField('#edit_sample_price', [{ rule: "required", errorMessage: "Price is required" }])
    .addField('#edit_sample_sizes', [{ rule: "required", errorMessage: "Sizes are required" }])
    .addField('#edit_sample_cloth_types', [{ rule: "required", errorMessage: "Cloth Types are required" }])
    .addField('#edit_sample_sort_order', [{ rule: "required", errorMessage: "Sort Order is required" }])
    .addField('#edit_sample_features', [{ rule: "required", errorMessage: "Features are required" }])
    .addField('#edit_sample_gsm', [{ rule: "required", errorMessage: "GSM Options are required" }])
    .addField('#edit_sample_description', [{ rule: "required", errorMessage: "Description is required" }])
    .addField('[name="image"]', [
        {
            rule: "files",
            value: { files: { extensions: ["jpeg", "jpg", "png", "webp"] } },
            errorMessage: "Only images are allowed (jpeg, jpg, png, webp)",
        },
        {
            validator: (value, fields) => {
                const element = document.querySelector('#editSamplesForm [name="image"]');
                const file = element.files[0];
                if (!file) return true;
                return imageDimensionValidator(file);
            },
            errorMessage: "Image must be exactly 1024x1536 pixels",
        },
    ])
    .onSuccess((event) => {
        editSamplesFormSubmit(event);
    });

const grid = new gridjs.Grid({
    columns: [
        {
            name: "Image",
            formatter: (cell) => gridjs.html(`<img src="images/${cell}" class="gridImage" />`)
        },
        "Title",
        "Category",
        "Price",
        {
            name: "Status",
            formatter: (cell) => gridjs.html(cell == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>')
        },
        {
            name: "Action",
            formatter: (cell) => {
                return gridjs.html(`
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary btn-sm edit_btn" data-id="${cell}">Edit</button>
                        <button class="btn btn-danger btn-sm delete_btn" data-id="${cell}">Delete</button>
                    </div>
                `);
            }
        }
    ],
    pagination: { limit: 10 },
    sort: true,
    search: true,
    data: samples.map(s => [
        s.image,
        s.title,
        s.category,
        s.price,
        s.is_active,
        s.id // Action column cell value
    ]),
    style: {
        table: { border: "1px solid #ccc" },
        th: { "background-color": "rgba(0, 0, 0, 0.1)", color: "#000", "text-align": "center" },
        td: { "text-align": "center" },
    },
}).render(document.getElementById("samples-gridjs"));

function gridjsReRender(updatedSamples) {
    window.samples = updatedSamples;
    grid.updateConfig({
        data: updatedSamples.map(s => [
            s.image,
            s.title,
            s.category,
            s.price,
            s.is_active,
            s.id
        ])
    }).forceRender();
}

function addSamplesFormSubmit(e) {
    const formData = new FormData(e.target);
    formData.append("_token", csrfToken);

    $.ajax({
        url: "all-samples",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#addSamplesForm")[0].reset();
            $("#addSamplesModal").modal("hide");
            Swal.fire("Added!", response.message, "success");
            gridjsReRender(response.samples);
        },
        error: function (xhr) {
            Swal.fire("Error", "Something went wrong", "error");
        }
    });
}

function editSamplesFormSubmit(e) {
    const id = $("#edit_sample_id").val();
    const formData = new FormData(e.target);
    formData.append("_token", csrfToken);

    $.ajax({
        url: "updateSamples/" + id,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#editSamplesModal").modal("hide");
            Swal.fire("Updated!", response.message, "success");
            gridjsReRender(response.samples);
        },
        error: function (xhr) {
            Swal.fire("Error", "Something went wrong", "error");
        }
    });
}

$(document).on("click", ".edit_btn", function () {
    const id = $(this).data("id");
    const item = samples.find(s => s.id == id);
    if (item) {
        $("#edit_sample_id").val(item.id);
        $("#edit_sample_title").val(item.title);
        $("#edit_sample_category").val(item.category);
        $("#edit_sample_badge").val(item.badge);
        $("#edit_sample_badge_type").val(item.badge_type);
        $("#edit_sample_price").val(item.price);
        $("#edit_sample_sort_order").val(item.sort_order);
        $("#edit_sample_is_active").val(item.is_active);
        $("#edit_sample_cloth_types").val(item.cloth_types);
        $("#edit_sample_description").val(item.description);

        // Handle JSON array fields
        let sizes = item.sizes;
        if (typeof sizes === 'string') {
            try { sizes = JSON.parse(sizes); } catch (e) { }
        }
        $("#edit_sample_sizes").val(Array.isArray(sizes) ? sizes.join(',') : sizes);

        let features = item.features;
        if (typeof features === 'string') {
            try { features = JSON.parse(features); } catch (e) { }
        }
        $("#edit_sample_features").val(Array.isArray(features) ? features.join(',') : features);
        
        let gsm = item.gsm;
        if (typeof gsm === 'string') {
            try { gsm = JSON.parse(gsm); } catch (e) { }
        }
        $("#edit_sample_gsm").val(Array.isArray(gsm) ? gsm.join(',') : gsm);
        
        // Handle JSON array fields for Colors (Dynamic Rows)
        let colors = item.colors;
        if (typeof colors === 'string') {
            try { colors = JSON.parse(colors); } catch (e) { }
        }
        
        const container = $("#edit-colors-container");
        container.empty();
        
        if (Array.isArray(colors) && colors.length > 0) {
            colors.forEach(color => {
                appendColorRow(container, color);
            });
        } else {
            appendColorRow(container, "#000000");
        }

        $("#edit_sample_preview").attr("src", "images/" + item.image);
        $("#editSamplesModal").modal("show");
    }
});

$(document).on("click", ".delete_btn", function () {
    const id = $(this).data("id");
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
            $.ajax({
                url: "destroySamples/" + id,
                method: "POST",
                data: { _token: csrfToken },
                success: function (response) {
                    Swal.fire("Deleted!", response.message, "success");
                    gridjsReRender(response.samples);
                }
            });
        }
    });
});

// --- Dynamic Color Management ---

function appendColorRow(container, value = "#000000") {
    const isHex = /^#([0-9A-F]{3}){1,2}$/i.test(value);
    const pickerValue = isHex ? value : "#000000";
    
    const row = `
        <div class="d-flex align-items-center gap-2 mb-2 color-row">
            <input type="color" class="form-control form-control-color color-picker-tool" value="${pickerValue}" title="Choose color" style="width: 60px; height: 38px; padding: 0;">
            <input type="text" class="form-control color-input-value" name="colors[]" value="${value}" placeholder="Color Hex/Name" required>
            <button type="button" class="btn btn-danger remove-color">Delete</button>
        </div>
    `;
    $(container).append(row);
}

$(document).on("click", ".add-color-btn", function () {
    const target = $(this).data("target");
    appendColorRow($("#" + target));
});

$(document).on("click", ".remove-color", function () {
    const container = $(this).closest('.color-row').parent();
    if (container.find('.color-row').length > 1) {
        $(this).closest(".color-row").remove();
    } else {
        Swal.fire("Info", "At least one color is required.", "info");
    }
});

$(document).on("input", ".color-picker-tool", function () {
    $(this).next(".color-input-value").val($(this).val());
});

$(document).on("input", ".color-input-value", function () {
    const val = $(this).val();
    if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
        $(this).prev(".color-picker-tool").val(val);
    }
});
