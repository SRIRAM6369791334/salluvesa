const grid = new gridjs.Grid({
    columns: [
        "S.NO",
        "Design Name",
        "Variant Image",
        "Size",
        "Color",
        "Qty",
        "MRP Price",
        "Offer Price",
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
    data: designVariants.map((variant, index) => {
        return [
            index + 1,
            variant.design_title,
            gridjs.html(`<img src="images/${variant.varient_img}" alt="img" style="height: 50px; width: 50px;">`),
            variant.size_value,
            variant.color_value,
            variant.design_qty,
            variant.mrp_price,
            variant.offer_price,
            gridjs.html(
                `<div>
                    <button data-bs-toggle="modal"
                        data-id="${variant.id}"
                        data-design-id="${variant.design_id}"
                        data-size="${variant.size_value}"
                        data-color="${variant.color_value}"
                        data-qty="${variant.design_qty}"
                        data-mrp="${variant.mrp_price}"
                        data-offer="${variant.offer_price}"
                        data-image="${variant.varient_img}"
                        data-bs-target="#editDesignVariantModal"
                        class="btn btn-secondary edit_btn">Edit</button>
                    <button class="btn btn-danger mt-1 delete_btn" data-id="${variant.id}">Delete</button>
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
        },
        td: {
            "text-align": "center",
            "border-right": "0.5px solid #ccc",
            "border-bottom": "0.5px solid #ccc",
        },
    },
});

grid.render(document.getElementById("table-design-variants"));

function gridjsReRender(variants) {
    grid.updateConfig({
        data: variants.map((variant, index) => {
            return [
                index + 1,
                variant.design_title,
                gridjs.html(`<img src="images/${variant.varient_img}" alt="img" style="height: 50px; width: 50px;">`),
                variant.size_value,
                variant.color_value,
                variant.design_qty,
                variant.mrp_price,
                variant.offer_price,
                gridjs.html(
                    `<div>
                        <button data-bs-toggle="modal"
                            data-id="${variant.id}"
                            data-design-id="${variant.design_id}"
                            data-size="${variant.size_value}"
                            data-color="${variant.color_value}"
                            data-qty="${variant.design_qty}"
                            data-mrp="${variant.mrp_price}"
                            data-offer="${variant.offer_price}"
                            data-image="${variant.varient_img}"
                            data-bs-target="#editDesignVariantModal"
                            class="btn btn-secondary edit_btn">Edit</button>
                        <button class="btn btn-danger mt-1 delete_btn" data-id="${variant.id}">Delete</button>
                    </div>`
                ),
            ];
        }),
    }).forceRender();
}

const addValidator = new JustValidate("#addDesignVariantForm", {
    validateBeforeSubmitting: true,
});

addValidator
    .addField("#add_design_id", [{ rule: "required", errorMessage: "*Design is required" }])
    .addField("#add_size_value", [{ rule: "required", errorMessage: "*Size is required" }])
    .addField("#add_color_value", [
        { rule: "required", errorMessage: "*Color is required" },
        { rule: "minLength", value: 3, errorMessage: "*Min 3 chars" },
        { rule: "maxLength", value: 20, errorMessage: "*Max 20 chars" }
    ])
    .addField("#add_mrp_price", [
        { rule: "required", errorMessage: "*MRP is required" },
        { rule: "number", errorMessage: "*Must be number" },
        { rule: "minNumber", value: 0, errorMessage: "*Must be positive" }
    ])
    .addField("#add_offer_price", [
        { rule: "required", errorMessage: "*Offer Price is required" },
        { rule: "number", errorMessage: "*Must be number" },
        { rule: "minNumber", value: 0, errorMessage: "*Must be positive" },
        {
            validator: (value) => {
                const mrp = parseFloat($("#add_mrp_price").val());
                return parseFloat(value) <= mrp;
            },
            errorMessage: "*Offer price cannot exist MRP",
        }
    ])
    .addField("#add_design_qty", [
        { rule: "required", errorMessage: "*Quantity is required" },
        { rule: "number", errorMessage: "*Must be number" },
        { rule: "minNumber", value: 0, errorMessage: "*Must be positive" }
    ])
    .addField("#add_variant_image", [
        { rule: "required", errorMessage: "*Image is required" },
        {
            rule: "files",
            value: { files: { extensions: ["jpg", "jpeg", "png", "webp"], maxSize: 5242880 } },
            errorMessage: "*Invalid file (Max 5MB)"
        }
    ])
    .onSuccess((event) => {
        addDesignVariantFormSubmit(event);
    });

function addDesignVariantFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "design-variants", // Route to store
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#addDesignVariantForm")[0].reset();
            $("#addDesignVariantModal").modal("hide");
            gridjsReRender(response.designVariants);
            Swal.fire("Added", response.message, "success");
        },
        error: function (xhr) {
            console.error(xhr);
            Swal.fire("Error", "Failed to add variant", "error");
        },
    });
}

const editValidator = new JustValidate("#editDesignVariantForm", {
    validateBeforeSubmitting: true,
});

editValidator
    .addField("#edit_design_id", [{ rule: "required", errorMessage: "*Design is required" }])
    .addField("#edit_size_value", [{ rule: "required", errorMessage: "*Size is required" }])
    .addField("#edit_color_value", [{ rule: "required", errorMessage: "*Color is required" }])
    .addField("#edit_mrp_price", [{ rule: "required" }, { rule: "number" }, { rule: "minNumber", value: 0 }])
    .addField("#edit_offer_price", [
        { rule: "required" }, { rule: "number" }, { rule: "minNumber", value: 0 },
        {
            validator: (value) => {
                const mrp = parseFloat($("#edit_mrp_price").val());
                return parseFloat(value) <= mrp;
            },
            errorMessage: "*Offer price cannot exist MRP",
        }
    ])
    .addField("#edit_design_qty", [{ rule: "required" }, { rule: "number" }, { rule: "minNumber", value: 0 }])
    .onSuccess((event) => {
        editDesignVariantFormSubmit(event);
    });


$(document).on("click", ".edit_btn", function () {
    const id = $(this).data("id");
    const designId = $(this).data("design-id");
    const size = $(this).data("size");
    const color = $(this).data("color");
    const qty = $(this).data("qty");
    const mrp = $(this).data("mrp");
    const offer = $(this).data("offer");
    const image = $(this).data("image");

    $("#edit_variant_id").val(id);
    $("#edit_design_id").val(designId);
    $("#edit_size_value").val(size);
    $("#edit_color_value").val(color);
    $("#edit_color_picker").val(color.startsWith('#') && color.length === 7 ? color : "#000000");
    $("#edit_design_qty").val(qty);
    $("#edit_mrp_price").val(mrp);
    $("#edit_offer_price").val(offer);
    $("#edit_preview_image").attr("src", "images/" + image);
});

function editDesignVariantFormSubmit(e) {
    const id = $("#edit_variant_id").val();
    const formdata = new FormData(e.target);
    formdata.append("_method", "PUT"); // Laravel method spoofing

    $.ajax({
        url: "design-variants/" + id,
        method: "POST", // Use POST with _method=PUT
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#editDesignVariantModal").modal("hide");
            gridjsReRender(response.designVariants);
            Swal.fire("Updated", response.message, "success");
        },
        error: function (xhr) {
            console.error(xhr);
            Swal.fire("Error", "Failed to update variant", "error");
        },
    });
}

$(document).on("click", ".delete_btn", function () {
    const id = $(this).data("id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "design-variants/" + id,
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    gridjsReRender(response.designVariants);
                    Swal.fire("Deleted!", response.message, "success");
                },
                error: function (xhr) {
                    console.error(xhr);
                    Swal.fire("Error", "Failed to delete variant", "error");
                },
            });
        }
    });
});
