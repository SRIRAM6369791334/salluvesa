// Initialize Validators
const addValidator = new JustValidate("#addProductForm", {
    validateBeforeSubmitting: true,
});
const editValidator = new JustValidate("#editProductForm", {
    validateBeforeSubmitting: true,
});

// Register static validation rules for Add Form
addValidator
    .addField("#add_category_select", [
        { rule: "required", errorMessage: "*Category Field is required" },
    ])
    .addField("#add_subcategory_select", [
        { rule: "required", errorMessage: "*Sub Category Field is required" },
    ])
    .addField("#add_product_name", [
        { rule: "required", errorMessage: "*Product Name Field is required" },
        {
            rule: "minLength",
            value: 3,
            errorMessage: "*Product Name should be at least 3 character long",
        },
        {
            rule: "maxLength",
            value: 50,
            errorMessage:
                "*Product Name should be at Maximum 50 character long",
        },
    ])

    .addField("#add_product_description", [
        {
            rule: "required",
            errorMessage: "*Product Description Field is required",
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage:
                "*Product Description should be at least 3 character long",
        },
        {
            rule: "maxLength",
            value: 100,
            errorMessage:
                "*Product Description should be at Maximum 100 character long",
        },
    ])
    .addField("#add_product_image", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Product Image Upload Field is required",
        },
    ])
    .addField("#add_size_chart_image", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Size Chart Image Upload Field is required",
        },
    ])
    .addField("#add_product_specification", [
        {
            rule: "required",
            errorMessage: "*Product Specfication Field is required",
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage:
                "*Product Specfication should be at least 3 character long",
        },
        {
            rule: "maxLength",
            value: 4000,
            errorMessage:
                "*Product Specfication should be at Maximum 4000 character long",
        },
    ])
    .addField("#add_varient_image", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Variant Image Upload Field is required",
        },
    ])
    .addField("#add_prod_size_select", [
        {
            rule: "required",
            errorMessage: "*Product Size Select Field is required",
        },
    ])
    .addField("#add_varient_color", [
        { rule: "required", errorMessage: "*Variant Color Field is required" },
    ])
    .addField("#add_product_quantity", [
        {
            rule: "required",
            errorMessage: "*Product Quantity Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product Quantity Field should be in number",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage:
                "*Product Quantity should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage:
                "*Product Quantity should be at Maximum 5 character long",
        },
    ])
    .addField("#product_mrp_price", [
        { rule: "required", errorMessage: "*Product MRP Field is required" },
        {
            rule: "number",
            errorMessage: "*Product Mrp Field should be in number",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage: "*Product Mrp should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage: "*Product Mrp should be at Maximum 5 character long",
        },
    ])
    .addField("#product_offer_price", [
        {
            rule: "required",
            errorMessage: "*Product Regular Price Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product Regular Price should be in number",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage:
                "*Product Regular Price should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage:
                "*Product Regular Price should be at Maximum 5 character long",
        },
        {
            validator: (value) => {
                const mrp = parseInt($("#product_mrp_price").val() || "0");
                return parseInt(value) <= mrp;
            },
            errorMessage: "Should not be above MRP Price",
        },
    ])
    .addField("#product_low_stock", [
        {
            rule: "required",
            errorMessage: "*Product Low Stock Field is required",
        },
    ])
    .addField("#product_gst", [
        { rule: "required", errorMessage: "*Product GST Field is required" },
    ])
    .addField("#add_product_thump_image", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Product Thump Image Upload Field is required",
        },
    ])
    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", true).html("Uploading.....");
        addProductFormSubmit(event);
    });

// Dynamic Variant Fields Validator Registration
function registerDynamicFieldsValidation(index) {
    const suffix = `_${index}`;

    addValidator
        .addField(`#add_varient_image${suffix}`, [
            {
                rule: "minFilesCount",
                value: 1,
                errorMessage: "*Variant Image is required",
            },
        ])
        .addField(`#add_prod_size_select${suffix}`, [
            { rule: "required", errorMessage: "*Product Size is required" },
        ])
        .addField(`#add_varient_color${suffix}`, [
            { rule: "required", errorMessage: "*Variant Color is required" },
        ])
        .addField(`#add_product_quantity${suffix}`, [
            { rule: "required", errorMessage: "*Quantity is required" },
            { rule: "number", errorMessage: "*Must be a number" },
        ])
        .addField(`#product_mrp_price${suffix}`, [
            { rule: "required", errorMessage: "*MRP Price is required" },
            { rule: "number", errorMessage: "*Must be a number" },
        ])
        .addField(`#product_offer_price${suffix}`, [
            { rule: "required", errorMessage: "*Selling Price is required" },
            { rule: "number", errorMessage: "*Must be a number" },
        ])
        .addField(`#product_low_stock${suffix}`, [
            { rule: "required", errorMessage: "*Low stock is required" },
            { rule: "number", errorMessage: "*Must be a number" },
        ])
        .addField(`#product_gst${suffix}`, [
            { rule: "required", errorMessage: "*GST is required" },
        ])
        .addField(`#add_product_thump_image${suffix}`, [
            {
                rule: "minFilesCount",
                value: 1,
                errorMessage: "*Thumb image is required",
            },
        ]);
}

// Edit form validator
editValidator
    .addField("#edit_category_select", [
        { rule: "required", errorMessage: "*Category Field is required" },
    ])
    .addField("#edit_subcategory_select", [
        { rule: "required", errorMessage: "*Sub Category Field is required" },
    ])
    .addField("#edit_product_name", [
        { rule: "required", errorMessage: "*Product Name Field is required" },
    ])
    .addField("#edit_product_description", [
        {
            rule: "required",
            errorMessage: "*Product Description Field is required",
        },
    ])
    .addField("#edit_product_specification", [
        {
            rule: "required",
            errorMessage: "*Product Specfication Field is required",
        },
    ])
    .onSuccess((event) => {
        $(".edit_submit_btn").attr("disabled", true).html("Uploading.....");
        editProductFormSubmit(event);
    });

const gridNew = new gridjs.Grid({
    columns: [
        "S.NO",
        "Category Name",
        "Subcategory Name",
        "Product Name",
        "Product Image",
        "Product Feature",

        {
            name: "Action",
            sort: false,
        },
    ],
    pagination: {
        limit: 10,
    },
    sort: !0,
    search: !0,
    data: products.map((product, index) => {
        return [
            index + 1,
            product.category ? product.category.category_name : "N/A",
            product.subcategory ? product.subcategory.subcategory_name : "N/A",
            product.product_name,

            gridjs.html(
                `

                <img class="bannerImage_image_el gridImage" src="images/${product.product_image}"  alt ="categgory_image${index}"/>


            `
            ),
            product.product_description,

            gridjs.html(
                `<div> <button data-bs-toggle="modal"
                data-productid ="${product.id}"
                data-categoryid = "${product.category_id}"
                data-subcategoryid = "${product.subcategory_id}"
                data-productname="${product.product_name}"
                data-productquantity ="${product.product_quantity}"
                data-productregularprice="${product.product_regular_price}"
                data-productmrpprice="${product.product_mrp_price}"
                data-productdescription="${product.product_description}"
                data-productimage="${product.product_image}"
                data-productspecification="${product.product_specification}"
                data-productunit="${product.unit_value}"
                data-bs-target="#editProductModal"  class="btn btn-secondary edit_btn ">Edit</button>
                <button class="btn btn-danger delete_btn" data-productid = ${product.id} >Delete</button> </div>`
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
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: products.map((product, index) => {
                return [
                    index + 1,
                    product.category ? product.category.category_name : "N/A",
                    product.subcategory ? product.subcategory.subcategory_name : "N/A",
                    product.product_name,
                    gridjs.html(
                        `

                        <img class="bannerImage_image_el gridImage" src="images/${product.product_image}"  alt ="categgory_image${index}"/>


                    `
                    ),
                    product.product_description,

                    gridjs.html(
                        `<div> <button data-bs-toggle="modal"
                        data-productid ="${product.id}"
                        data-categoryid = "${product.category_id}"
                        data-subcategoryid = "${product.subcategory_id}"
                        data-productname="${product.product_name}"
                        data-productquantity ="${product.product_quantity}"
                        data-productregularprice="${product.product_regular_price}"
                        data-productmrpprice="${product.product_mrp_price}"
                        data-productdescription="${product.product_description}"
                        data-productimage="${product.product_image}"
                        data-productspecification="${product.product_specification}"
                        data-productunit="${product.unit_value}"
                        data-bs-target="#editProductModal"  class="btn btn-secondary edit_btn ">Edit</button>
                        <button class="btn btn-danger delete_btn" data-productid =${product.id}>Delete</button> </div>`
                    ),
                ];
            }),
        })
        .forceRender();
}

function addProductFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "products",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".add_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").html("Submit");

            const updatedProducts = response.products;
            $("#addProductForm")[0].reset();
            $("#addProductModal").hide();
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";

            console.log(updatedProducts);

            gridjsReRender(updatedProducts);
            Swal.fire("Added", "Records Added Successfully.", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".edit_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            $(".add_submit_btn").html("Submit");
            console.log(textStatus + ": " + errorThrown);

            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

function editProductFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "updateProducts/" + $("#edit_product_id").val(),
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProduct = response.products;
            $("#editProductForm")[0].reset();
            $("#editProductModal").hide();
            $(".modal-backdrop").remove();
            $(".edit_product_remove_btn ").trigger("click");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProduct);
            $(".edit_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            Swal.fire("Updated", "Records Updated  Successfully.", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".edit_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            $(".add_submit_btn").html("Submit");
            console.log(textStatus + ": " + errorThrown);

            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

$(function () {
    $(".bx-show").hide();
    $(".icon").on("click", function () {
        const parentEl = $(this).closest(".input-group");
        var input = $(this).closest(".input-group").find("input");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $(parentEl).find(".bx-hide").hide();
            $(parentEl).find(".bx-show").show();
        } else {
            input.attr("type", "password");
            $(parentEl).find(".bx-show").hide();
            $(parentEl).find(".bx-hide").show();
        }
    });

    $(document).on("click", ".edit_btn", function () {
        const catId = $(this).attr("data-categoryid");
        const subCatId = $(this).attr("data-subcategoryid");
        const imagePath = $(this).attr("data-productimage");
        $(".edit_preview_image").attr("src", `images/${imagePath}`);
        $("#edit_product_id").val($(this).attr("data-productid"));
        $("#edit_category_select")
            .find(`option[value="${catId}"]`)
            .prop("selected", true);
        $("#edit_subcategory_select")
            .find(`option[value="${subCatId}"]`)
            .prop("selected", true);
        $("#edit_product_name").val($(this).attr("data-productname"));
        $("#edit_product_quantity").val($(this).attr("data-productquantity"));
        $("#edit_product_mrp_price").val($(this).attr("data-productmrpprice"));
        $("#edit_product_regular_price").val(
            $(this).attr("data-productregularprice")
        );
        $("#edit_product_description").val(
            $(this).attr("data-productdescription")
        );
        $("#edit_product_value").val($(this).attr("data-productvalue"));

        $("#edit_product_specification").val(
            $(this).attr("data-productspecification")
        );
        // Replace 3 with the value you want to select
        $("#edit_unit_select").val($(this).attr("data-productunit"));
    });
});

$(document).on("click", ".delete_btn", function () {
    const id = $(this).attr("data-productid");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "destroyProducts/" + id,
                method: "post",
                dataType: "json",
                success: function (response) {
                    const updatedProduct = response.products;
                    gridjsReRender(updatedProduct);
                    Swal.fire(
                        "Deleted!",
                        "Records Deleted Successfully.",
                        "success"
                    );
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".edit_submit_btn").removeAttr("disabled");
                    $(".add_submit_btn").removeAttr("disabled");
                    $(".edit_submit_btn").html("Update");
                    $(".add_submit_btn").html("Submit");
                    console.log(textStatus + ": " + errorThrown);

                    Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
                },
            });
        }
    });
});

// Wait for the document to be ready
// $(function () {
//     const backupHtml = $("#preview-container1").html();

//     // Listen for changes to the input field
//     $("#add_varient_image").on("change", function () {
//         // Get the selected file
//         var file = $(this)[0].files[0];

//         // Check if the file is an image
//         if (file.type.match("image.*")) {
//             // Create a new FileReader object
//             var reader = new FileReader();

//             // Set up the FileReader to load the image
//             reader.onload = function (e) {
//                 // Create a new image element
//                 var img = $("<img>").attr("src", e.target.result);

//                 // Create a remove button
//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger product_remove_btn mt-2")
//                     .text("Remove");

//                 // Add the image and remove button to the preview container
//                 $("#preview-container1").empty().append(img).append(removeBtn);

//                 // Listen for clicks on the remove button
//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();

//                     // Remove the image from the preview container
//                     $("#preview-container1").html(backupHtml);
//                     // Clear the input field
//                     $("#add_varient_image").val("");
//                 });
//             };

//             // Read the selected file as a data URL
//             reader.readAsDataURL(file);
//         }
//     });
// });

// $(function () {
//     const backupHtml = $("#preview-container").html();

//     // Listen for changes to the input field
//     $("#add_product_image").on("change", function () {
//         // Get the selected file
//         var file = $(this)[0].files[0];

//         // Check if the file is an image
//         if (file.type.match("image.*")) {
//             // Create a new FileReader object
//             var reader = new FileReader();

//             // Set up the FileReader to load the image
//             reader.onload = function (e) {
//                 // Create a new image element
//                 var img = $("<img>").attr("src", e.target.result);

//                 // Create a remove button
//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger product_remove_btn mt-2")
//                     .text("Remove");

//                 // Add the image and remove button to the preview container
//                 $("#preview-container").empty().append(img).append(removeBtn);

//                 // Listen for clicks on the remove button
//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();

//                     // Remove the image from the preview container
//                     $("#preview-container").html(backupHtml);
//                     // Clear the input field
//                     $("#add_product_image").val("");
//                 });
//             };

//             // Read the selected file as a data URL
//             reader.readAsDataURL(file);
//         }
//     });
// });

// $(function () {
//     const backupHtml = $(".edit_preview-container").html();

//     // Listen for changes to the input field
//     $("#edit_product_image").on("change", function () {
//         // Get the selected file
//         var file = $(this)[0].files[0];

//         // Check if the file is an image
//         if (file.type.match("image.*")) {
//             // Create a new FileReader object
//             var reader = new FileReader();

//             // Set up the FileReader to load the image
//             reader.onload = function (e) {
//                 // Create a new image element
//                 var img = $("<img>").attr("src", e.target.result);

//                 // Create a remove button
//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger edit_product_remove_btn mt-2")
//                     .text("Remove");

//                 // Add the image and remove button to the preview container
//                 $(".edit_preview-container")
//                     .empty()
//                     .append(img)
//                     .append(removeBtn);

//                 // Listen for clicks on the remove button
//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();
//                     // Remove the image from the preview container
//                     $(".edit_preview-container").html(backupHtml);
//                     // Clear the input field
//                     $("#edit_product_image").val("");
//                 });
//             };

//             // Read the selected file as a data URL
//             reader.readAsDataURL(file);
//         }
//     });
// });
function validateAndPreviewImage(inputSelector, previewSelector, buttonClass) {
    const backupHtml = $(previewSelector).html();

    $(inputSelector).on("change", function () {
        const file = this.files[0];
        if (file && file.type.match("image.*")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    if (img.width === 526 && img.height === 789) {
                        const previewImg = $("<img>").attr(
                            "src",
                            e.target.result
                        );
                        const removeBtn = $("<button>")
                            .addClass(`btn btn-danger ${buttonClass} mt-2`)
                            .text("Remove");

                        $(previewSelector)
                            .empty()
                            .append(previewImg)
                            .append(removeBtn);

                        removeBtn.on("click", function (e) {
                            e.preventDefault();
                            $(previewSelector).html(backupHtml);
                            $(inputSelector).val("");
                        });
                    } else {
                        alert("Only 526x789px images are allowed.");
                        $(inputSelector).val("");
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            alert("Only image files are allowed.");
            $(inputSelector).val("");
        }
    });
}

// Initialize for all image upload fields
$(function () {
    validateAndPreviewImage(
        "#add_varient_image",
        "#preview-container1",
        "product_remove_btn"
    );
    validateAndPreviewImage(
        "#add_product_image",
        "#preview-container",
        "product_remove_btn"
    );
    validateAndPreviewImage(
        "#edit_product_image",
        ".edit_preview-container",
        "edit_product_remove_btn"
    );
    validateAndPreviewImage(
        "#add_product_thump_image_",
        "#thump-preview-container",
        "thump_product_remove_btn"
    );
});

// $(document).ready(function () {
//     let variantIndex = 1;

//     $("#add-input").click(function () {
//         const variantId = variantIndex++; // Unique index for each appended variant

//         const inputGroup = `
//             <hr><br>
//             <h5>Product Varient</h5>
//             <div class="d-flex product_fields mt-3">
//                 <div class="row">
//                     <label for="add_varient_image_${variantId}" class="preview-container" id="preview-container-${variantId}">
//                         <div class="flex justify-content-center">
//                             <div class="text-center">
//                                 <i class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
//                             </div>
//                             <div>
//                                 <span class="col-12">Upload Image</span>
//                             </div>
//                         </div>
//                     </label>
//                     <div class="col-md-4">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_varient_image_${variantId}">Variant Image (750x600)*</label>
//                             <input type="file" class="form-control image_el dropzone needsclick"
//                                 id="add_varient_image_${variantId}" name="Varient_image[]" accept="image/*" required>
//                         </div>
//                     </div>
//                     <div class="col-md-4">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_prod_size_select_${variantId}">Product Unit*</label>
//                             <select class="form-select" name="prod_size_value[]" id="add_prod_size_select_${variantId}" required>
//                                 <option value="" selected>Select Variant Size</option>
//                                 <option value="S">S</option>
//                                 <option value="M">M</option>
//                                 <option value="L">L</option>
//                                 <option value="XL">XL</option>
//                                 <option value="XXL">XXL</option>
//                                 <option value="XXXL">XXXL</option>
//                             </select>
//                         </div>
//                     </div>
//                     <div class="col-md-4">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_varient_color_${variantId}">Variant Color*</label>
//                             <input type="text" class="form-control" id="add_varient_color_${variantId}" name="varient_color[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-4">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_product_quantity_${variantId}">Stock Quantity*</label>
//                             <input type="text" class="form-control" id="add_product_quantity_${variantId}" name="product_quantity[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-4">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_product_value_${variantId}">Variant Value*</label>
//                             <input type="text" class="form-control" id="add_product_value_${variantId}" name="product_value[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-3">
//                         <div class="mb-3">
//                             <label class="form-label" for="product_mrp_price_${variantId}">Product MRP Price*</label>
//                             <input type="text" class="form-control" id="product_mrp_price_${variantId}" name="product_mrp_price[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-3">
//                         <div class="mb-3">
//                             <label class="form-label" for="product_offer_price_${variantId}">Selling Price*</label>
//                             <input type="text" class="form-control" id="product_offer_price_${variantId}" name="product_offer_price[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-3">
//                         <div class="mb-3">
//                             <label class="form-label" for="product_low_stock_${variantId}">Low Stock*</label>
//                             <input type="text" class="form-control" id="product_low_stock_${variantId}" name="low_stock[]" required>
//                         </div>
//                     </div>
//                     <div class="col-md-3">
//                         <div class="mb-3">
//                             <label class="form-label" for="product_gst_${variantId}">GST</label>
//                             <select class="form-select" name="product_gst[]" id="product_gst_${variantId}" required>
//                                 <option value="" selected>Select GST</option>
//                                 <option value="0">0%</option>
//                                 <option value="5">5%</option>
//                                 <option value="12">12%</option>
//                                 <option value="18">18%</option>
//                                 <option value="28">28%</option>
//                             </select>
//                         </div>
//                     </div>
//                     <div class="col-lg-12">
//                         <h5>Product Thumb Images</h5>
//                         <input type="hidden" name="product_image_count[]" class="product_image_count" value="1">
//                         <div class="dynamic-inputs1">
//                             <div class="d-flex product_fields1">
//                                 <div class="row">
//                                     <div class="col-lg-8">
//                                         <div class="mb-3">
//                                             <label class="form-label" for="add_product_thump_image_${variantId}">Product Image*</label>
//                                             <input type="file" class="form-control image_el dropzone needsclick"
//                                                 id="add_product_thump_image_${variantId}" name="product_image1[]" required>
//                                         </div>
//                                     </div>
//                                     <div class="col-lg-4 col-sm-12 mt-4">
//                                         <div class="input-group-append">
//                                             <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="col-lg-3 mt-3 mb-3">
//                             <button class="btn btn-success add-input2" type="button">Add Another Image</button>
//                         </div>
//                     </div>
//                     <div class="col-lg-3 col-sm-12 mt-4">
//                         <div class="input-group-append">
//                             <button class="btn btn-danger delete-input" type="button">Delete Variant</button>
//                         </div>
//                     </div>
//                 </div>
//             </div>`;

//         $("#dynamic-inputs").append(inputGroup);

//         // ✅ Register validation for the new fields
//         registerDynamicFieldsValidation(variantId);
//     });

//     // Delete variant block
//     $(document).on("click", ".delete-input", function () {
//         $(this).closest(".product_fields").remove();
//     });

//     // Delete thumb image block
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//     });
// });
// ✅ Dynamically add more thumb images inside each variant block
// $(document).on("click", ".add-input2", function () {
//     const thumbInput = `
//         <div class="d-flex product_fields1">
//             <div class="row">
//                 <div class="col-lg-8">
//                     <div class="mb-3">
//                         <label class="form-label">Product Image (600x600)*</label>
//                         <input type="file" class="form-control image_el dropzone needsclick"
//                             name="product_image1[]" accept="image/*" required>
//                     </div>
//                 </div>
//                 <div class="col-lg-4 col-sm-12 mt-4">
//                     <div class="input-group-append">
//                         <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     `;
//     $(this).closest(".col-lg-12").find(".dynamic-inputs1").append(thumbInput);
// });
// // 🔁 Reusable function to validate image dimensions
// function validateImage600x600(file, callback) {
//     const reader = new FileReader();
//     reader.onload = function (e) {
//         const img = new Image();
//         img.onload = function () {
//             if (img.width === 600 && img.height === 600) {
//                 callback(true, e.target.result);
//             } else {
//                 callback(false, null);
//             }
//         };
//         img.src = e.target.result;
//     };
//     reader.readAsDataURL(file);
// }

// $(document).ready(function () {
//     // ✅ Image validation for ALL 600x600 inputs (delegated for dynamic too)
//     $(document).on(
//         "change",
//         "input[id^='add_product_thump_image'], #add_product_thump_image",
//         function () {
//             const input = this;
//             const file = input.files[0];
//             if (!file || !file.type.match("image.*")) {
//                 alert("Only image files are allowed.");
//                 input.value = "";
//                 return;
//             }

//             validateImage600x600(file, function (isValid, dataUrl) {
//                 if (!isValid) {
//                     alert("Only 600x600px images are allowed.");
//                     input.value = "";
//                 }
//             });
//         }
//     );

//     // ✅ Support adding more product variant blocks
//     let variantIndex = 1;
//     $("#add-input").click(function () {
//         const variantId = variantIndex++;
//         const inputGroup = `
//         <hr><br>
//         <h5>Product Varient</h5>
//         <div class="d-flex product_fields mt-3">
//             <div class="row">
//                 ...
//                 <input type="file" class="form-control image_el dropzone needsclick"
//                     id="add_product_thump_image_${variantId}" name="product_image1[]" accept="image/*" required>
//                 ...
//             </div>
//         </div>`;
//         $("#dynamic-inputs").append(inputGroup);
//     });

//     // ✅ Add more thumb image fields (outside variants)
//     $("#add-input1").on("click", function () {
//         const newInput = `
//             <div class="d-flex product_fields1">
//                 <div class="row">
//                     <div class="col-lg-8">
//                         <div class="mb-3">
//                             <label class="form-label">Product Image (600x600)*</label>
//                             <input type="file" class="form-control image_el dropzone needsclick"
//                                 id="add_product_thump_image" name="product_image1[]" accept="image/*" required>
//                         </div>
//                     </div>
//                     <div class="col-lg-4 col-sm-12 mt-4">
//                         <div class="input-group-append">
//                             <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                         </div>
//                     </div>
//                 </div>
//             </div>`;
//         $("#dynamic-inputs1").append(newInput);
//     });

//     // 🗑️ Delete individual thumb image inputs
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//     });

//     // 🗑️ Delete full variant block
//     $(document).on("click", ".delete-input", function () {
//         $(this).closest(".product_fields").remove();
//     });
// });

// $(document).ready(function () {
//     let variantIndex = 1;

//     // ✅ Reusable function to validate image dimensions
//     function validateImage600x600(file, callback) {
//         const reader = new FileReader();
//         reader.onload = function (e) {
//             const img = new Image();
//             img.onload = function () {
//                 if (img.width === 600 && img.height === 600) {
//                     callback(true, e.target.result);
//                 } else {
//                     callback(false, null);
//                 }
//             };
//             img.src = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     }

//     // ✅ Validate image dimensions on file change (delegated for dynamic)
//     $(document).on(
//         "change",
//         "input[type='file'][name='product_image1[]']",
//         function () {
//             const file = this.files[0];
//             if (!file || !file.type.match("image.*")) {
//                 alert("Only image files are allowed.");
//                 this.value = "";
//                 return;
//             }

//             validateImage600x600(file, (isValid) => {
//                 if (!isValid) {
//                     alert("Only 600x600px images are allowed.");
//                     this.value = "";
//                 }
//             });
//         }
//     );

//     // ✅ Add new product variant block
//     $("#add-input").click(function () {
//         const variantId = variantIndex++;
//         const inputGroup = `
//         <hr><br>
//         <h5>Product Variant</h5>
//         <div class="d-flex product_fields mt-3">
//             <div class="row">
//                 <div class="col-lg-8">
//                     <div class="mb-3">
//                         <label class="form-label">Product Image (600x600)*</label>
//                         <input type="file" class="form-control image_el dropzone needsclick"
//                             name="product_image1[]" accept="image/*" required>
//                     </div>
//                 </div>
//                 <div class="col-lg-4 col-sm-12 mt-4">
//                     <div class="input-group-append">
//                         <button class="btn btn-danger delete-input" type="button">Delete</button>
//                     </div>
//                 </div>
//             </div>
//         </div>`;
//         $("#dynamic-inputs").append(inputGroup);
//     });

//     // ✅ Add more individual product image inputs
//     $("#add-input1").click(function () {
//         const newInput = `
//         <div class="d-flex product_fields1 mt-3">
//             <div class="row">
//                 <div class="col-lg-8">
//                     <div class="mb-3">
//                         <label class="form-label">Product Image (600x600)*</label>
//                         <input type="file" class="form-control image_el dropzone needsclick"
//                             name="product_image1[]" accept="image/*" required>
//                     </div>
//                 </div>
//                 <div class="col-lg-4 col-sm-12 mt-4">
//                     <div class="input-group-append">
//                         <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                     </div>
//                 </div>
//             </div>
//         </div>`;
//         $("#dynamic-inputs1").append(newInput);
//     });

//     // ✅ Add thumb input inside dynamic section via button
//     $(document).on("click", ".add-input2", function () {
//         const thumbInput = `
//         <div class="d-flex product_fields1 mt-3">
//             <div class="row">
//                 <div class="col-lg-8">
//                     <div class="mb-3">
//                         <label class="form-label">Product Image (600x600)*</label>
//                         <input type="file" class="form-control image_el dropzone needsclick"
//                             name="product_image1[]" accept="image/*" required>
//                     </div>
//                 </div>
//                 <div class="col-lg-4 col-sm-12 mt-4">
//                     <div class="input-group-append">
//                         <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                     </div>
//                 </div>
//             </div>
//         </div>`;
//         $(this)
//             .closest(".col-lg-12")
//             .find(".dynamic-inputs1")
//             .append(thumbInput);
//     });

//     // 🗑️ Delete a thumb image input
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//     });

//     // 🗑️ Delete an entire variant block
//     $(document).on("click", ".delete-input", function () {
//         $(this).closest(".product_fields").remove();
//     });
// });

$(document).ready(function () {
    let variantIndex = 1;

    // ✅ Reusable function to validate image dimensions
    function validateImage526x789(file, callback) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                if (img.width === 526 && img.height === 789) {
                    callback(true, e.target.result);
                } else {
                    callback(false, null);
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // ✅ Validate image dimensions on file change (delegated for dynamic)
    $(document).on(
        "change",
        "input[type='file'][name='product_image1[]']",
        function () {
            const file = this.files[0];
            if (!file || !file.type.match("image.*")) {
                alert("Only image files are allowed.");
                this.value = "";
                return;
            }

            validateImage528x789(file, (isValid) => {
                if (!isValid) {
                    alert("Only 526x789px images are allowed.");
                    this.value = "";
                }
            });

            this.setCustomValidity(""); // Clear required message when file is selected
        }
    );

    // ✅ Add new product variant block
    $("#add-input").click(function () {
        const variantId = variantIndex++;
        const inputGroup = `
        <hr><br>
        <h5>Product Variant</h5>
        <div class="d-flex product_fields mt-3">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Product Image (526x789)*</label>
                        <input type="file" class="form-control image_el dropzone needsclick"
                            name="product_image1[]" accept="image/*" required>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 mt-4">
                    <div class="input-group-append">
                        <button class="btn btn-danger delete-input" type="button">Delete</button>
                    </div>
                </div>
            </div>
        </div>`;
        $("#dynamic-inputs").append(inputGroup);
    });

    // ✅ Add more individual product image inputs
    // $("#add-input1").click(function () {
    //     const newInput = `
    //     <div class="d-flex product_fields1 mt-3">
    //         <div class="row">
    //             <div class="col-lg-8">
    //                 <div class="mb-3">
    //                     <label class="form-label">Product Image (600x600)*</label>
    //                     <input type="file" class="form-control image_el dropzone needsclick"
    //                         name="product_image1[]" accept="image/*" required>
    //                 </div>
    //             </div>
    //             <div class="col-lg-4 col-sm-12 mt-4">
    //                 <div class="input-group-append">
    //                     <button class="btn btn-danger delete-input1" type="button">Delete</button>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>`;
    //     $("#dynamic-inputs1").append(newInput);
    // });

    // ✅ Add thumb input inside dynamic section via button
    $(document).on("click", ".add-input1", function () {
        const thumbInput = `
        <div class="d-flex product_fields1 mt-3">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                         <label class="form-label">Product Image (526x789)*</label>
                        <input type="file" class="form-control image_el dropzone needsclick"
                            name="product_image1[]" accept="image/*" required>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 mt-4">
                    <div class="input-group-append">
                        <button class="btn btn-danger delete-input1" type="button">Delete</button>
                    </div>
                </div>
            </div>
        </div>`;

        const $variantContainer = $(this).closest(".initially_hidden");
        const $imageCountField = $variantContainer.find(".product_image_count");
        let count = parseInt($imageCountField.val());
        $imageCountField.val(count + 1);

        $variantContainer.find(".dynamic-inputs1").append(thumbInput);
    });

    // 🗑️ Delete a thumb image input
    $(document).on("click", ".delete-input1", function () {
        $(this).closest(".product_fields1").remove();
    });

    // 🗑️ Delete an entire variant block
    $(document).on("click", ".delete-input", function () {
        $(this).closest(".product_fields").remove();
    });

    // ✅ Custom required validation message on form submit
    $("form").on("submit", function (e) {
        let isValid = true;

        $("input[type='file'][name='product_image1[]']").each(function () {
            if (!this.value) {
                this.setCustomValidity(
                    "Please upload a 600x600px product image."
                );
                isValid = false;
            } else {
                this.setCustomValidity(""); // Clear if already filled
            }
        });

        if (!isValid) {
            e.preventDefault(); // Prevent submission
            this.reportValidity(); // Show error
        }
    });
});

// $(document).ready(function () {
//     // Add input
//     $("#add-input").click(function () {
//         var inputGroup = `
//         <hr>
//         <br>
//         <h5>Product Varient</h5>
//         <div class="d-flex product_fields mt-3">
//         <div class="row">
//                                             <label for="add_varient_image-${
//                                                 $(".dynamic-inputs1").length + 1
//                                             }" class="preview-container" id="preview-container-${
//             $(".dynamic-inputs1").length + 1
//         }" >
//                                                         <div class="flex justify-content-center">
//                                                             <div class="text-center">
//                                                                 <i
//                                                                     class="display-4 col-12 text-muted mdi mdi-cloud-upload"></i>
//                                                             </div>
//                                                             <div>
//                                                                 <span class="col-12">Upload Image</span>
//                                                             </div>
//                                                         </div>
//                                                     </label>
//                                                     <div class="col-md-4">
//                                                         <div class="mb-3">
//                                                             <label class="form-label" for="add_varient_image-${
//                                                                 $(
//                                                                     ".dynamic-inputs1"
//                                                                 ).length + 1
//                                                             }">Varient
//                                                                 Image*(750 *
//                                                                 600)</label>
//                                                             <input type="file"
//                                                                 class="form-control image_el dropzone needsclick"
//                                                                 id="add_varient_image-${
//                                                                     $(
//                                                                         ".dynamic-inputs1"
//                                                                     ).length + 1
//                                                                 }" placeholder="Varient Image"
//                                                                 accept="image/*" name="Varient_image[]" required data-var_button = "add_varient_image-${
//                                                                     $(
//                                                                         ".dynamic-inputs1"
//                                                                     ).length + 1
//                                                                 }" data-container ="preview-container-${
//             $(".dynamic-inputs1").length + 1
//         }">
//                                                         </div>
//                                                     </div>
//                                                      <div class="col-md-4">
//                                                         <div class="mb-3">
//                                                             <label class="form-label" for="add_prod_size_select">Product
//                                                                 Unit*</label>
//                                                             <select class="form-select" name="prod_size_value[]"
//                                                                 id="add_prod_size_select">
//                                                                 <option value="" selected>Select Varient Size
//                                                                 </option>

//                                                                 <option value="S">S</option>
//                                                                 <option value="M">M</option>
//                                                                 <option value="L">L</option>
//                                                                 <option value="XL">XL</option>
//                                                                 <option value="XXL">XXL</option>
//                                                                 <option value="XXXL">XXXL</option>

//                                                             </select>
//                                                         </div>
//                                                     </div>
//                                                     <div class="col-md-4">
//                                                         <div class="mb-3">
//                                                             <label class="form-label" for="add_varient_color">Varient
//                                                                 Color*</label>
//                                                             <input type="text" class="form-control"
//                                                                 id="add_varient_color" name="varient_color[]"
//                                                                 placeholder="Varient Color" required>
//                                                         </div>
//                                                     </div>
//             <div class="col-md-4">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_quantity">Stock Quantity*</label>
//                     <input type="text" class="form-control" id="add_product_quantity"
//                         name="product_quantity[]" placeholder="Product Quantity" required>
//                 </div>
//             </div>
//             <div class="col-md-4">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_quantity">Varient Value*</label>
//                     <input type="text" class="form-control" id="add_product_value"
//                         name="product_value[]" placeholder="Product Value" required>
//                 </div>
//             </div>

//             <div class="col-md-3">
//                 <div class="mb-3">
//                     <label class="form-label" for="product_mrp_price">Product MRP Price(ORIGINAL
//                         PRICE)*</label>
//                     <input type="text" class="form-control" id="product_mrp_price"
//                         name="product_mrp_price[]" placeholder="Product MRP price" required>
//                 </div>
//             </div>

//             <div class="col-md-3">
//                 <div class="mb-3">
//                     <label class="form-label" for="product_offer_price">Product Selling Price(OFFER
//                         PRICE)*</label>
//                     <input type="text" class="form-control" id="product_offer_price"
//                         name="product_offer_price[]" placeholder="Product Selling price" required>
//                 </div>
//             </div>
//             <div class="col-md-3">
//                                                         <div class="mb-3">
//                                                             <label class="form-label"
//                                                                 for="product_low_stock">Low Stock *</label>
//                                                             <input type="text" class="form-control"
//                                                                 id="product_low_stock" name="low_stock[]"
//                                                                 placeholder="Product MRP price" required>
//                                                         </div>
//                                                     </div>
//             <div class="col-md-3">
//             <div class="mb-3">
//                 <label class="form-label" for="">Product
//                     GST</label>
//                 <select class="form-select" name="product_gst[]"
//                     id="">
//                     <option value="" selected>Select GST</option>
//                     <option value="0">0</option>
//                     <option value="5">5</option>
//                     <option value="12">12</option>
//                     <option value="18">18</option>
//                     <option value="28">28</option>

//                 </select>
//             </div>
//         </div>
//          <div class="" style="">
//                                                         <h5>Product Thump Images</h5>
//                                                         <input type="hidden" name="product_image_count[]" id="product_image_count-${
//                                                             $(
//                                                                 ".product_image_count"
//                                                             ).length + 1
//                                                         }" value="1" class="product_image_count">
//                                                         <div class="col-lg-12">
//                                                             <div id="dynamic-inputs1-${
//                                                                 $(
//                                                                     ".dynamic-inputs1"
//                                                                 ).length + 1
//                                                             }" class="dynamic-inputs1">

//                                                                 <div class="d-flex product_fields1">
//                                                                     <div class="row">
//                                                                         <div class="col-lg-8">
//                                                                             <div class="mb-3">
//                                                                                 <label class="form-label"
//                                                                                     for="add_product_image">Product
//                                                                                     Image*(750 *
//                                                                                     600)</label>
//                                                                                 <input type="file"
//                                                                                     class="form-control image_el dropzone needsclick"
//                                                                                     id="add_product_image"
//                                                                                     placeholder="Product Image"
//                                                                                     name="product_image1[]" required>
//                                                                             </div>
//                                                                         </div>
//                                                                         <div class="col-lg-4 col-sm-12 mt-4">
//                                                                             <div class="input-group-append">
//                                                                                 <button
//                                                                                     class="btn btn-danger delete-input1"
//                                                                                     type="button">Delete</button>
//                                                                             </div>
//                                                                         </div>
//                                                                     </div>
//                                                                 </div>
//                                                             </div>
//                                                         </div>
//                                                         <div class="col-lg-3 mt-3 mb-3">
//                                                             <button id="add-input1" class="btn btn-success add-input2"
//                                                                 type="button" data-target="dynamic-inputs1-${
//                                                                     $(
//                                                                         ".dynamic-inputs1"
//                                                                     ).length + 1
//                                                                 }" data-input= "product_image_count-${
//             $(".product_image_count").length + 1
//         }">Add
//                                                                 Another Images</button>
//                                                         </div>
//                                                         <br>
//                                                         <hr>
//                                                     </div>

//             <div class="col-lg-3 col-sm-12 mt-4">
//                 <div class="input-group-append">
//                     <button class="btn btn-danger delete-input"
//                         type="button">Delete Varient</button>
//                 </div>
//             </div>
//         </div>
//     </div>`;
//         $("#dynamic-inputs").append(inputGroup);
//     });

//     // Delete input
//     $(document).on("click", ".delete-input", function () {
//         $(this).closest(".product_fields").remove();
//     });

//     $(document).ready(function () {
//         $(document).on("change", ".hot_value", function () {
//             var isChecked = $(this).prop("checked");
//             if (isChecked == true) {
//                 $(this).val(1);
//             } else {
//                 $(this).val(0);
//             }
//         });

//         // ... Your existing code ...
//     });

//     $(document).ready(function () {
//         $(document).on("change", ".pop_prod", function () {
//             var isChecked = $(this).prop("checked");
//             if (isChecked == true) {
//                 $(this).val(1);
//             } else {
//                 $(this).val(0);
//             }
//         });

//         // ... Your existing code ...
//     });
// });

// $(document).ready(function () {
//     // Add input
//     $(".add-input1").click(function () {
//         var inputField = $(".product_image_count");
//         var currentValue = parseInt(inputField.val());
//         inputField.val(currentValue + 1);
//         var inputGroup = `
//         <div class="d-flex product_fields1">
//         <div class="row">
//             <div class="col-lg-8">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_image">Product Image*(750 *
//                         600)</label>
//                     <input type="file" class="form-control image_el dropzone needsclick"
//                         id="add_product_image" placeholder="Product Image" name="product_image1[]" required>
//                 </div>
//             </div>
//             <div class="col-lg-4 col-sm-12 mt-4">
//                 <div class="input-group-append">
//                     <button class="btn btn-danger delete-input1"
//                         type="button">Delete</button>
//                 </div>
//             </div>
//         </div>
//     </div>`;
//         $(".dynamic-inputs1").append(inputGroup);
//     });

//     // Delete input
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//     });
// });

// // =================== product varient ========================

// $(document).ready(function () {
//     // Add input
//     $(".add-input2").click(function () {
//         var inputField = $(".product_image_count2");
//         var currentValue = parseInt(inputField.val());
//         inputField.val(currentValue + 1);
//         var inputGroup = `
//         <div class="d-flex product_fields2">
//         <div class="row">
//             <div class="col-lg-8">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_image">Product Image*(750 *
//                         600)</label>
//                     <input type="file" class="form-control image_el dropzone needsclick"
//                         id="add_product_image" placeholder="Product Image" name="product_image1[]" required>
//                 </div>
//             </div>
//             <div class="col-lg-4 col-sm-12 mt-4">
//                 <div class="input-group-append">
//                     <button class="btn btn-danger delete-input2"
//                         type="button">Delete</button>
//                 </div>
//             </div>
//         </div>
//     </div>`;
//         $(".dynamic-inputs2").append(inputGroup);
//     });

//     // Delete input
//     $(document).on("click", ".delete-input2", function () {
//         $(this).closest(".product_fields2").remove();
//     });
// });

// $(document).ready(function () {
//     let imageIndex = 0; // Initial index for image fields

//     $(".add-input1").click(function () {
//         var inputField = $(".product_image_count");
//         var currentValue = parseInt(inputField.val());
//         inputField.val(currentValue + 1);

//         var inputGroup = `
//             <div class="d-flex product_fields1">
//                 <div class="row">
//                     <div class="col-lg-8">
//                         <div class="mb-3">
//                             <label class="form-label" for="add_product_image">Product Image*(750 * 600)</label>
//                             <input type="file" class="form-control image_el dropzone needsclick"
//                                 id="add_product_image_${imageIndex}"
//                                 placeholder="Product Image"
//                                 name="product_image1[${imageIndex}]" required>
//                         </div>
//                     </div>
//                     <div class="col-lg-4 col-sm-12 mt-4">
//                         <div class="input-group-append">
//                             <button class="btn btn-danger delete-input1" type="button">Delete</button>
//                         </div>
//                     </div>
//                 </div>
//             </div>`;

//         $(".dynamic-inputs1").append(inputGroup);
//         imageIndex++; // Increment index for the next image field
//     });

//     // Delete input
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//         imageIndex--; // Decrement index when deleting an image field
//     });
// });

// $(document).ready(function () {
//     let imageIndex = 0;
//     // Add input
//     $(document).on("click", ".add-input2", function () {
//         var inputId = $(this).data("input");
//         var inputField = $("#" + inputId);
//         var currentValue = parseInt(inputField.val());
//         inputField.val(currentValue + 1);
//         var targetId = $(this).data("target");
//         var inputGroup = `
//         <div class="d-flex product_fields1">
//         <div class="row">
//             <div class="col-lg-8">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_image">Product Image*(750 *
//                         600)</label>
//                      <input type="file" class="form-control image_el dropzone needsclick"
//                                 id="add_product_image_${imageIndex}"
//                                 placeholder="Product Image"
//                                 name="product_image1[${imageIndex}]" required>
//                 </div>
//             </div>
//             <div class="col-lg-4 col-sm-12 mt-4">
//                 <div class="input-group-append">
//                     <button class="btn btn-danger delete-input1"
//                         type="button">Delete</button>
//                 </div>
//             </div>
//         </div>
//     </div>`;
//         $("#" + targetId).append(inputGroup);
//         imageIndex++;
//     });

//     // Delete input
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//         imageIndex--;
//     });
// });
// $(document).ready(function () {
//     // Add input
//     $(document).on("click", ".add-input2", function () {
//         var inputId = $(this).data("input");
//         var inputField = $("#" + inputId);
//         var currentValue = parseInt(inputField.val());
//         inputField.val(currentValue + 1);
//         var targetId = $(this).data("target");
//         var inputGroup = `
//         <div class="d-flex product_fields1">
//         <div class="row">
//             <div class="col-lg-8">
//                 <div class="mb-3">
//                     <label class="form-label" for="add_product_image">Product Image*(750 *
//                         600)</label>
//                     <input type="file" class="form-control image_el dropzone needsclick"
//                         id="add_product_image" placeholder="Product Image" name="product_image1[]" required>
//                 </div>
//             </div>
//             <div class="col-lg-4 col-sm-12 mt-4">
//                 <div class="input-group-append">
//                     <button class="btn btn-danger delete-input1"
//                         type="button">Delete</button>
//                 </div>
//             </div>
//         </div>
//     </div>`;
//         $("#" + targetId).append(inputGroup);
//     });

//     // Delete input
//     $(document).on("click", ".delete-input1", function () {
//         $(this).closest(".product_fields1").remove();
//     });
// });

//

$(document).ready(function () {
    $("body").on("change", "input[id^='add_varient_image-']", function () {
        var inputId = $(this).attr("id");
        var targetId = $(this).data("container");
        console.log("Input ID:", inputId);
        console.log("Target ID:", targetId);

        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger product_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                // $("#" + targetId)
                //     .empty()
                //     .append(img)
                //     .append(removeBtn);
                $("#" + targetId)
                    .empty()
                    .append(img)
                    .append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $("#" + targetId).html("");
                    // Clear the input field
                    $("#" + inputId).val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

const addValidator2 = new JustValidate("#productfilterForm", {
    validateBeforeSubmitting: true,
});

addValidator2
    .addField("#select_category_select", [
        {
            rule: "required",
            errorMessage: "*Category  is required",
        },
    ])

    .onSuccess((event) => {
        $(".product_filter_btn").attr("disabled", "true");
        $(".product_filter_btn").html("Uploading.....");
        productfilterFormSubmit(event);
    });

function productfilterFormSubmit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        url: "getproductfilter",
        method: "POST",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".product_filter_btn").removeAttr("disabled");
            $(".product_filter_btn").html("Get Report");
            const updatedProduct = response.products;
            gridjsReRender(updatedProduct);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".product_filter_btn").removeAttr("disabled");
            $(".product_filter_btn").html("Get Report");
            Swal.fire(textStatus.toUpperCase(), textStatus, "warning");
        },
    });
}

$(document).on("change", "#add_category_select", function () {
    let id = $(this).val();

    $("#add_subcategory_select").empty();
    $("#add_subcategory_select").append(
        '<option value="" disabled selected>Processing...</option>'
    );

    $.ajax({
        type: "GET",
        url: "getsubcategory/" + id,
        success: function (response) {
            console.log(response);
            $("#add_subcategory_select").empty();
            $("#add_subcategory_select").append(
                '<option value="" disabled selected>Select Subcategory</option>'
            );
            response.forEach((element) => {
                $("#add_subcategory_select").append(
                    `<option value='${element["id"]}'>${element["subcategory_name"]}</option>`
                );
            });
        },
    });
});

$(document).on("change", "#edit_category_select", function () {
    let id = $(this).val();

    $("#edit_subcategory_select").empty();
    $("#edit_subcategory_select").append(
        '<option value="" disabled selected>Processing...</option>'
    );

    $.ajax({
        type: "GET",
        url: "getsubcategory/" + id,
        success: function (response) {
            console.log(response);
            $("#edit_subcategory_select").empty();
            $("#edit_subcategory_select").append(
                '<option value="" disabled selected>Select Subcategory</option>'
            );
            response.forEach((element) => {
                $("#edit_subcategory_select").append(
                    `<option value='${element["id"]}'>${element["subcategory_name"]}</option>`
                );
            });
        },
    });
});

$(document).on("change", "#add_subcategory_select", function () {
    let id = $(this).val();
    var inputGroup1 = `
    <div value="" class="subcate_append_wrapper">
        <div>
            <input type="hidden" name="size_check" class="size_check" value=1>
        </div>
    </div>
    `;

    var inputGroup2 = `
    <div value="" class="subcate_append_wrapper">
        <div>
            <input type="hidden" name="size_check" class="foot_size_check" value=2>
        </div>
    </div>
    `;

    var inputGroup3 = `
    <div value="" class="subcate_append_wrapper">
        <div>
            <input type="checkbox" name="size_check" class="watch_size_check" value=3>
        </div>
    </div>
    `;

    var inputGroup4 = `
    <div value="" class="subcate_append_wrapper">
        <div>
            <input type="checkbox" name="size_check" class="bag_size_check" value=4>
        </div>
    </div>
    `;

    if (id === "16") {
        $(".subcate_size_append").empty();
        $(".subcate_size_append").append(inputGroup1);
    } else if (id === "17") {
        $(".subcate_size_append").empty();
        $(".subcate_size_append").append(inputGroup2);
    } else if (id === "18") {
        $(".subcate_size_append").empty();
        $(".subcate_size_append").append(inputGroup3);
    } else if (id === "19") {
        $(".subcate_size_append").empty();
        $(".subcate_size_append").append(inputGroup4);
    } else {
        $(".subcate_size_append").empty();
    }
});

// $(document).on("input", "#product_low_stock", function () {
//     var totStock = $("#add_product_quantity").val();
//     var lowStock = $("#product_low_stock").val();

//     if (lowStock > totStock) {
//         alert("low stock must be below the total stock");
//         $("#product_low_stock").val("");
//     }
// });
