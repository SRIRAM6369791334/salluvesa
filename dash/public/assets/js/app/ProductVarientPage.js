const gridNew = new gridjs.Grid({
    columns: [
        "S.NO",
        "category",
        "Subcategory",
        "Product Name",
        "Product Size",

        "Product MRP Price",
        "Product Offer Price",
        "Product Gst",
        "Product Qty",

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
    data: productvarient.map((productvarient, index) => {
        return [
            index + 1,
            productvarient.category_name,
            productvarient.subcatename,
            productvarient.size_value,

            gridjs.html(
                productvarient.varient == 1
                    ? `<span>${productvarient.product_name}</span></p>
            `
                    : productvarient.varient == 2
                        ? `<span>${productvarient.product_name}</span></p>`
                        : productvarient.varient == 3
                            ? `<span>${productvarient.product_name}</span></p>`
                            : productvarient.varient == 4
                                ? `<span>${productvarient.product_name}</span></p>`
                                : `<span>${productvarient.product_name}</span></p>`
            ),

            `$${productvarient.mrp_price}`,
            `$${productvarient.offer_price}`,
            gridjs.html(
                productvarient.product_gst == 5
                    ? `<p>5%</p>
        `
                    : productvarient.product_gst == 12
                        ? `<p>12%</p>`
                        : productvarient.product_gst == 18
                            ? `<p>18%</p>`
                            : productvarient.product_gst == 28
                                ? `<p>28%</p>`
                                : `<p>No GST</p>`
            ),

            productvarient.product_qty,
            gridjs.html(
                `<div> <button data-bs-toggle="modal"
                data-categoryid ="${productvarient.categoryid}"
                data-subcategoryid ="${productvarient.subcategoryid}"
                data-produid="${productvarient.product_id}"
                data-productverid ="${productvarient.id}"
                data-productname="${productvarient.product_name}"
                 data-productsize="${productvarient.size_value ?? ""}"
                 data-productcolor="${productvarient.color_value ?? ""}"
                data-productvarimrpprice="${productvarient.mrp_price}"
                data-productvarioffer="${productvarient.offer_price}"
                data-productvarqut="${productvarient.product_qty}"
                data-hotpro="${productvarient.hot_deals}"
                data-productget="${productvarient.product_gst}"
                data-produlowsto="${productvarient.low_stock}"
                data-bs-target="#editProductModal"  class="btn btn-secondary edit_btn ">Edit</button> <button class="btn btn-danger mt-1 delete_btn" data-productverid = ${productvarient.id
                }>Delete</button> </div>`
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

function gridjsReRender(productvarient) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productvarient.map((productvarient, index) => {
                return [
                    index + 1,
                    productvarient.category_name,
                    productvarient.subcatename,
                    productvarient.size_value,

                    gridjs.html(
                        productvarient.varient == 1
                            ? `<span>${productvarient.product_name}</span>
                    `
                            : productvarient.varient == 2
                                ? `<span>${productvarient.product_name}</span>`
                                : productvarient.varient == 3
                                    ? `<span>${productvarient.product_name}</span>`
                                    : productvarient.varient == 4
                                        ? `<span>${productvarient.product_name}</span>`
                                        : `<span>${productvarient.product_name}</span>`
                    ),

                    `$${productvarient.mrp_price}`,
                    `$${productvarient.offer_price}`,
                    gridjs.html(
                        productvarient.product_gst == 0
                            ? `<p> No GST </p>`
                            : `<p>${productvarient.product_gst}%</p>`
                    ),
                    //     gridjs.html(
                    //         productvarient.product_gst == 1
                    //             ? `<p>5%</p>
                    // `
                    //             : productvarient.product_gst == 2
                    //                 ? `<p>12%</p>`
                    //                 : productvarient.product_gst == 3
                    //                     ? `<p>18%</p>`

                    //                     :productvarient.product_gst == 4
                    //                     ?`<p>28%</p>`
                    //                     :`<p>No GST</p>`
                    //     ),

                    // data-produid ="${productvarient.categoryid}"
                    // data-subcategoryid ="${productvarient.subcategoryid}"
                    // data-categoryid ="${productvarient.product_id}"
                    productvarient.product_qty,
                    gridjs.html(
                        `<div> <button data-bs-toggle="modal"
                        data-categoryid ="${productvarient.categoryid}"
                        data-subcategoryid ="${productvarient.subcategoryid}"
                        data-produid="${productvarient.product_id}"
                        data-productverid ="${productvarient.id}"
                        data-productname="${productvarient.product_name}"
                        data-productsize="${productvarient.size_value ?? ""}"
                        data-productcolor="${productvarient.color_value ?? ""}"
                        data-productvarimrpprice="${productvarient.mrp_price}"
                        data-productvarioffer="${productvarient.offer_price}"
                        data-productvarqut="${productvarient.product_qty}"
                        data-hotpro="${productvarient.hot_deals}"
                        data-productget="${productvarient.product_gst}"
                        data-produlowsto="${productvarient.low_stock}"
                        data-bs-target="#editProductModal"  class="btn btn-secondary edit_btn ">Edit</button> <button class="btn btn-danger mt-1 delete_btn" data-productverid = ${productvarient.id
                        }>Delete</button> </div>`
                    ),
                ];
            }),
        })
        .forceRender();
}

const addValidator = new JustValidate("#editProductVarientForm", {
    validateBeforeSubmitting: true,
});
const addValidator1 = new JustValidate("#addProductvarientForm", {
    validateBeforeSubmitting: true,
});

addValidator

    .addField("#edit_category_select", [
        {
            rule: "required",
            errorMessage: "*Category Field is required",
        },
    ])

    .addField("#edit_subcategory_select", [
        {
            rule: "required",
            errorMessage: "*Sub Category Field is required",
        },
    ])

    .addField("#edit_product_name", [
        {
            rule: "required",
            errorMessage: "*Product Field is required",
        },
    ])
    .addField("#edit_prod_size_select", [
        {
            rule: "required",
            errorMessage: "*Product Size Field is required",
        },
    ])
    .addField("#edit_product_gst", [
        {
            rule: "required",
            errorMessage: "*Product Gst Field is required",
        },
    ])
    .addField("#edit_productthum_image", [
        {
            rule: "required",
            errorMessage: "*Product Thumb Image Field is required",
        },
    ])

    .addField("#edit_product_mrp_price", [
        {
            rule: "required",
            errorMessage: "*Product MRP Field is required",
        },
        {
            rule: "number",

            errorMessage: "*Product MRP should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage: "*Product MRP should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage: "*Product MRP should be at Maximum 5 character long",
        },
    ])
    .addField("#edit_product_offer_price", [
        {
            rule: "required",
            errorMessage: "*Product Offer Field is required",
        },
        {
            rule: "number",

            errorMessage: "*Product Offer Price should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage: "*Product MRP should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage: "*Product MRP should be at Maximum 5 character long",
        },
        {
            validator: (value) => {
                const ava = $("#edit_product_mrp_price").val();
                if (parseInt(value) <= parseInt(ava)) {
                    return true;
                } else {
                    return false;
                }
            },
            errorMessage: "Should not be above MRP Price",
        },
    ])
    .addField("#edit_product_quantity", [
        {
            rule: "required",
            errorMessage: "*Product Quantity Field is required",
        },
        {
            rule: "number",

            errorMessage: "*Product Quantity should be numbers",
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
    .addField("#edit_Low_Stock", [
        {
            rule: "required",
            errorMessage: "*Product low Stock Field is required",
        },
        {
            rule: "number",

            errorMessage: "*Product low Stock should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage:
                "*Product low Stock should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 5,
            errorMessage:
                "*Product low Stock should be at Maximum 5 character long",
        },
    ])
    .onSuccess((event) => {
        $(".editver_submit_btn").attr("disabled", "true");
        $(".editver_submit_btn").html("Uploading.....");
        editProductVarientFormSubmit(event);
    });
addValidator1
    .addField("#select_category_select", [
        {
            rule: "required",
            errorMessage: "*Category Field is required",
        },
    ])
    .addField("#select_subcategory_select", [
        {
            rule: "required",
            errorMessage: "*Sub Category Field is required",
        },
    ])
    .addField("#add_product_name", [
        {
            rule: "required",
            errorMessage: "*Product Field is required",
        },
    ])
    .addField("#add_prod_size_select", [
        {
            rule: "required",
            errorMessage: "*Product Size Field is required",
        },
    ])
    .addField("#add_product_color_value", [
        {
            rule: "required",
            errorMessage: "*Product Color Field is required",
        },
        {
            rule: "minLength",
            value: 3,
            errorMessage: "*Product Color should be at least 3 characters long",
        },
        {
            rule: "maxLength",
            value: 15,
            errorMessage:
                "*Product Color should be at maximum 15 characters long",
        },
    ])
    .addField("#add_product_mrp_price", [
        {
            rule: "required",
            errorMessage: "*Product MRP Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product MRP should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage: "*Product MRP should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 4,
            errorMessage: "*Product MRP should be at maximum 4 characters long",
        },
    ])
    .addField("#add_product_offer_price", [
        {
            rule: "required",
            errorMessage: "*Product Offer Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product Offer Price should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage: "*Product Offer should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 4,
            errorMessage:
                "*Product Offer should be at maximum 4 characters long",
        },
        {
            validator: (value) => {
                const mrp = $("#add_product_mrp_price").val();
                return parseInt(value) <= parseInt(mrp);
            },
            errorMessage: "Should not be above MRP Price",
        },
    ])
    .addField("#add_product_quantity", [
        {
            rule: "required",
            errorMessage: "*Product Quantity Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product Quantity should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage:
                "*Product Quantity should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 4,
            errorMessage:
                "*Product Quantity should be at maximum 4 characters long",
        },
    ])
    .addField("#add_product_image", [
        {
            rule: "required",
            errorMessage: "*Product Thumb Image Field is required",
        },
        {
            validator: (value, fields) => {
                const input = document.querySelector("#add_product_image");
                const file = input.files[0];
                if (!file) return false;

                return new Promise((resolve) => {
                    const img = new Image();
                    img.onload = function () {
                        if (img.width !== 526 || img.height !== 789) {
                            alert("Image must be exactly 526 × 789 px!");
                            resolve(false);
                        } else {
                            resolve(true);
                        }
                    };
                    img.src = URL.createObjectURL(file);
                });
            },
            errorMessage: "",
        },
    ])

    .addField("#product_gst", [
        {
            rule: "required",
            errorMessage: "*Product Gst  Field is required",
        },
    ])
    .addField("#add_Low_Stock", [
        {
            rule: "required",
            errorMessage: "*Product Low Stock Field is required",
        },
        {
            rule: "number",
            errorMessage: "*Product Low Stock should be numbers",
        },
        {
            rule: "minLength",
            value: 1,
            errorMessage:
                "*Product Low Stock should be at least 1 character long",
        },
        {
            rule: "maxLength",
            value: 4,
            errorMessage:
                "*Product Low Stock should be at maximum 4 characters long",
        },
    ])
    .addField(".image_el", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Product Image Field is required",
        },
        {
            rule: "files",
            value: {
                files: {
                    extensions: ["jpg", "jpeg", "png", "webp"],
                    maxSize: 5000000, // 5MB
                    types: ["image/jpeg", "image/png", "image/webp"],
                },
            },
            errorMessage: "*Invalid image format or size (Max: 5MB)",
        },
    ])

    .onSuccess((event) => {
        // $(".addvari_submit_btn").attr("disabled", "true");
        // $(".addvari_submit_btn").html("Uploading.....");
        addProductvarientFormSubmit(event);
    });

// $(document).on("click", ".edit_btn", function () {
//     const catId = $(this).attr("data-categoryid");
//     const ProId = $(this).attr("data-produid");
//     const subId = $(this).attr("data-subcategoryid");

//     console.log(ProId);
//     $("#edit_category_select")
//         .find(`option[value="${ProId}"]`)
//         .prop("selected", true);

//     $("#edit_subcategory_select")
//         .find(`option[value="${subId}"]`)
//         .prop("selected", true);

//     $("#edit_productvar_id").val($(this).attr("data-productverid"));
//     $("#edit_product_name")
//         .find(`option[value="${catId}"]`)
//         .prop("selected", true);
//     // $("#edit_product_value").val($(this).attr("data-productvarvalue"));
//     $("#edit_product_mrp_price").val($(this).attr("data-productvarimrpprice"));
//     $("#edit_product_offer_price").val($(this).attr("data-productvarioffer"));
//     $("#edit_product_quantity").val($(this).attr("data-productvarqut"));
//     // $("#edit_unit_select").val($(this).attr("data-productunit"));
//     $("#edit_product_gst").val($(this).attr("data-productget"));
//     $("#edit_Low_Stock").val($(this).attr("data-produlowsto"));
//     var hotProValue = $(this).attr("data-hotpro");

//     // Set the checkbox value
//     $("#edit_hot_product").val(hotProValue);

//     // Check the checkbox if the value is '1', uncheck if '0'
//     $("#edit_hot_product").prop("checked", hotProValue === "1");
// });
$(document).on("click", ".edit_btn", function () {
    const catId = $(this).attr("data-categoryid");
    const subId = $(this).attr("data-subcategoryid");
    const ProId = $(this).attr("data-produid");

    $("#edit_category_select")
        .find(`option[value="${catId}"]`)
        .prop("selected", true);

    $("#edit_subcategory_select")
        .find(`option[value="${subId}"]`)
        .prop("selected", true);

    $("#edit_product_name")
        .find(`option[value="${ProId}"]`)
        .prop("selected", true);

    // Other fields
    $("#edit_productvar_id").val($(this).attr("data-productverid"));
    $("#edit_product_mrp_price").val($(this).attr("data-productvarimrpprice"));
    $("#edit_product_offer_price").val($(this).attr("data-productvarioffer"));
    $("#edit_product_quantity").val($(this).attr("data-productvarqut"));
    $("#edit_product_gst").val($(this).attr("data-productget"));
    $("#edit_Low_Stock").val($(this).attr("data-produlowsto"));
    $("#edit_product_color_value").val($(this).attr("data-productcolor"));
    $("#color_picker").val($(this).attr("data-productcolor"));
    $("#edit_prod_size_select").val($(this).attr("data-productsize"));

    const hotProValue = $(this).attr("data-hotpro");
    $("#edit_hot_product").val(hotProValue);
    $("#edit_hot_product").prop("checked", hotProValue === "1");
});

// add function

function addProductvarientFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "addproductvarient",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".addvari_submit_btn").removeAttr("disabled");
            $(".addvari_submit_btn").html("Submit");

            const updatedProduct = response.productvarient;
            $("#addProductvarientForm")[0].reset();
            $("#addProductvariModal").hide();
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";

            console.log(updatedProduct);

            gridjsReRender(updatedProduct);
            Swal.fire("Added", "Records Added Successfully.", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".editver_submit_btn").removeAttr("disabled");
            $(".addvari_submit_btn").removeAttr("disabled");
            $(".editver_submit_btn").html("Update");
            $(".addvari_submit_btn").html("Submit");
            console.log(textStatus + ": " + errorThrown);

            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

function editProductVarientFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "updateProductsvarient/" + $("#edit_productvar_id").val(),
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProduct = response.productvarient;
            $("#editProductVarientForm")[0].reset();

            $("#editProductModal").hide();
            $(".modal-backdrop").remove();
            $(".edit_product_remove_btn ").trigger("click");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProduct);
            $(".editver_submit_btn").removeAttr("disabled");
            $(".editver_submit_btn").html("Update");
            Swal.fire("Updated", "Records Updated  Successfully.", "success");
            // window.location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".editver_submit_btn").removeAttr("disabled");
            $(".addvari_submit_btn").removeAttr("disabled");
            $(".editver_submit_btn").html("Update");
            $(".addvari_submit_btn").html("Submit");
            console.log(textStatus + ": " + errorThrown);
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

$(document).on("click", ".delete_btn", function () {
    const id = $(this).attr("data-productverid");
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
                url: "destroyvarient/" + id,
                method: "post",
                dataType: "json",
                success: function (response) {
                    const updatedBannerImages = response.productvarient;
                    gridjsReRender(updatedBannerImages);
                    Swal.fire(
                        "Deleted!",
                        "Records Deleted Successfully.",
                        "success"
                    );

                    // renderSort();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".editvar_submit_btn").removeAttr("disabled");
                    $(".addvar_submit_btn").removeAttr("disabled");
                    $(".editvar_submit_btn").html("Update");
                    $(".addvar_submit_btn").html("Submit");
                    console.log(textStatus + ": " + errorThrown);

                    Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
                },
            });
        }
    });
});

$(".hot_value").on("change", function () {
    // Get the current checked status
    var isChecked = $(this).prop("checked");

    // Set the value to 1 if checked, 0 if unchecked
    if (isChecked == true) {
        $(this).prop("value", 1);
    } else {
        $(this).prop("value", 0);
    }
});

//ADD AND EDIT PRODUCT APPEND

$("#sel_category_select").on("change", function () {
    var custid = $(this).val();

    // $('.produ1').hide();
    // $('.product2').show();

    $(".proname").empty();

    $(".proname").append(
        `<option value="0" disabled selected>Processing...</option>`
    );

    $.ajax({
        type: "GET",
        url: "Getproduct/" + custid,
        dataType: "JSON",
        success: function (response) {
            $(".proname").empty();
            $(".proname").append(
                `<option value="0" disabled selected>Select Product</option>`
            );

            response.forEach((element) => {
                $(".proname").append(
                    `<option value="${element["id"]}">${element["product_name"]}</option>`
                );
            });
        },
    });
});

// $('.product2').hide();
$("#select_subcategory_select").on("change", function () {
    var custid = $(this).val();

    // $('.produ1').hide();
    // $('.product2').show();

    // $(".proname").empty();

    $(".proname").append(
        `<option value="0" disabled selected>Processing...</option>`
    );

    $.ajax({
        type: "GET",
        url: "Getsubcategory/" + custid,
        dataType: "JSON",
        success: function (response) {
            $(".proname").empty();
            $(".proname").append(
                `<option value="0" disabled selected>Select Product</option>`
            );

            response.forEach((element) => {
                $(".proname").append(
                    `<option value="${element["id"]}">${element["product_name"]}</option>`
                );
            });
        },
    });
});

$("#edit_subcategory_select").on("change", function () {
    var custid = $(this).val();

    // $('.produ1').hide();
    // $('.product2').show();

    // $(".proname").empty();

    $("#edit_product_name").append(
        `<option value="0" disabled selected>Processing...</option>`
    );

    $.ajax({
        type: "GET",
        url: "Getsubcategory/" + custid,
        dataType: "JSON",
        success: function (response) {
            $("#edit_product_name").empty();
            $("#edit_product_name").append(
                `<option value="0" disabled selected>Select Product</option>`
            );

            response.forEach((element) => {
                $("#edit_product_name").append(
                    `<option value="${element["id"]}">${element["product_name"]}</option>`
                );
            });
        },
    });
});

//ADD AND EDIT SUBCATEGORY APPEND

$(document).on("change", "#select_category_select", function () {
    let id = $(this).val();

    $("#select_subcategory_select").empty();
    $(".proname").empty();
    $("#select_subcategory_select").append(
        '<option value="" disabled selected>Processing...</option>'
    );

    $.ajax({
        type: "GET",
        url: "getsubcategory/" + id,
        success: function (response) {
            console.log(response);
            $("#select_subcategory_select").empty();
            $("#select_subcategory_select").append(
                '<option value="" disabled selected>Select Subcategory</option>'
            );
            $(".proname").empty();
            $(".proname").append(
                `<option value="0" disabled selected>Select Product</option>`
            );
            response.forEach((element) => {
                $("#select_subcategory_select").append(
                    `<option value='${element["id"]}'>${element["subcategory_name"]}</option>`
                );
            });
        },
    });
});

// $(document).on("change", "#edit_category_select", function () {
//     let id = $(this).val();

//     $("#edit_subcategory_select").empty();
//     $("#edit_product_name").empty();
//     $("#edit_subcategory_select").append(
//         '<option value="" disabled selected>Processing...</option>'
//     );

//     $.ajax({
//         type: "GET",
//         url: "getsubcategory/" + id,
//         success: function (response) {
//             console.log(response);
//             $("#edit_subcategory_select").empty();
//             $("#edit_subcategory_select").append(
//                 '<option value="" disabled selected>Select Subcategory</option>'
//             );
//             $("#edit_product_name").empty();
//             $("#edit_product_name").append(
//                 `<option value="0" disabled selected>Select Product</option>`
//             );
//             response.forEach((element) => {
//                 $("#edit_subcategory_select").append(
//                     `<option value='${element["id"]}'>${element["subcategory_name"]}</option>`
//                 );
//             });
//         },
//     });
// });
$(document).on("change", "#edit_subcategory_select", function () {
    let subId = $(this).val();
    $("#edit_product_name")
        .empty()
        .append('<option value="" disabled selected>Processing...</option>');

    $.ajax({
        type: "GET",
        url: "getproducts/" + subId,
        success: function (response) {
            $("#edit_product_name")
                .empty()
                .append(
                    `<option value="0" disabled selected>Select Product</option>`
                );
            response.forEach((element) => {
                $("#edit_product_name").append(
                    `<option value="${element.id}">${element.product_name}</option>`
                );
            });
        },
    });
});

const addValidator2 = new JustValidate("#productverfilterForm", {
    validateBeforeSubmitting: true,
});
addValidator2
    .addField("#sel_category_select", [
        {
            rule: "required",
            errorMessage: "*Category is required",
        },
    ])
    .addField("#select_product", [
        {
            rule: "required",
            errorMessage: "*Product is required",
        },
    ])

    .onSuccess((event) => {
        $(".productver_filter_btn").attr("disabled", "true");
        $(".productver_filter_btn").html("Uploading.....");
        productverfilterFormSubmit(event);
    });

function productverfilterFormSubmit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        url: "getproductverfilter",
        method: "POST",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".productver_filter_btn").removeAttr("disabled");
            $(".productver_filter_btn").html("Submit");
            const updatedProductvar = response.productvarient;
            gridjsReRender(updatedProductvar);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".productver_filter_btn").removeAttr("disabled");
            $(".productver_filter_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), textStatus, "warning");
        },
    });
}

// =================== product varient ========================

// $(document).ready(function () {
//     // Counter for unique input IDs (optional but helps with better identification)
//     let dynamicImageCount = 0;

//     // Add input
//     $(document).ready(function () {
//         let dynamicImageCount = 0;

//         // Add new image input field
//         $(".add-input2").click(function () {
//             const inputField = $(".product_image_count2");
//             const currentValue = parseInt(inputField.val());
//             inputField.val(currentValue + 1);
//             dynamicImageCount++;

//             const newInputId = `add_product_image_${dynamicImageCount}`;

//             const inputGroup = `
//             <div class="d-flex product_fields2">
//                 <div class="row">
//                     <div class="col-lg-8">
//                         <div class="mb-3">
//                             <label class="form-label" for="${newInputId}">Product Image*(600 * 600)</label>
//                             <input type="file" class="form-control image_el needsclick"
//                                 id="${newInputId}" placeholder="Product Image" name="product_image2[]" required>
//                         </div>
//                     </div>
//                     <div class="col-lg-4 col-sm-12 mt-4">
//                         <div class="input-group-append">
//                             <button class="btn btn-danger delete-input2" type="button">Delete</button>
//                         </div>
//                     </div>
//                 </div>
//             </div>`;

//             $(".dynamic-inputs2").append(inputGroup);

//             // Add validation rule to newly added image field
//             addValidator1.addField(`#${newInputId}`, [
//                 {
//                     rule: "required",
//                     errorMessage: "*Product Image Field is required",
//                 },
//             ]);
//         });
//         // Replace with your actual form ID

//         // Delete input
//         $(document).on("click", ".delete-input2", function () {
//             const imageInput = $(this)
//                 .closest(".product_fields2")
//                 .find("input[type='file']");
//             const inputId = imageInput.attr("id");

//             // Remove validation if it was added
//             if (inputId) {
//                 addValidator1.removeField(`#${inputId}`);
//             }

//             // Remove the input from DOM
//             $(this).closest(".product_fields2").remove();
//         });
//     });
//     // Delete input
//     $(document).on("click", ".delete-input2", function () {
//         const imageInput = $(this)
//             .closest(".product_fields2")
//             .find("input[type='file']");
//         const inputId = imageInput.attr("id");

//         // Remove from validator before removing from DOM
//         if (inputId) {
//             addValidator1.removeField(`#${inputId}`);
//         }

//         // Remove the field group from DOM
//         $(this).closest(".product_fields2").remove();
//     });
// });
// required size
const REQUIRED_WIDTH = 526;
const REQUIRED_HEIGHT = 789;

// Helper to show error (uses Swal if available, fallback to alert)
function showImageError(msg) {
    if (window.Swal) {
        Swal.fire("Invalid image", msg, "warning");
    } else {
        alert(msg);
    }
}

// Delegated handler — works for dynamically added inputs too
$(document).on("change", "input[type='file'].image_el", function (e) {
    const input = this;
    const file = input.files && input.files[0];
    if (!file) return;

    // quick client-side type/size check (optional)
    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (allowedTypes.indexOf(file.type) === -1) {
        showImageError("Only JPG, PNG or WEBP images are allowed.");
        input.value = ""; // clear
        // if using JustValidate, revalidate/remove field so error clears
        try {
            addValidator1.revalidate(`#${input.id}`);
        } catch (err) { }
        return;
    }
    if (file.size > maxSize) {
        showImageError("Image must be 5MB or smaller.");
        input.value = "";
        try {
            addValidator1.revalidate(`#${input.id}`);
        } catch (err) { }
        return;
    }

    // Read image to check dimensions
    const reader = new FileReader();
    reader.onload = function (evt) {
        const img = new Image();
        img.onload = function () {
            const w = img.naturalWidth || img.width;
            const h = img.naturalHeight || img.height;
            if (w !== REQUIRED_WIDTH || h !== REQUIRED_HEIGHT) {
                showImageError(
                    `Image must be exactly ${REQUIRED_WIDTH}×${REQUIRED_HEIGHT}px. ` +
                    `Uploaded image is ${w}×${h}px.`
                );
                // clear input
                input.value = "";
                // if you're using preview elements, clear them as well:
                // $(input).closest('.product_fields2').find('img.preview').attr('src','');

                // If you're using JustValidate, remove field error by revalidating
                try {
                    // remove the file from the validator then add back if needed
                    addValidator1.removeField(`#${input.id}`);
                    // re-add with same rules if you want immediate further validation:
                    addValidator1.addField(`#${input.id}`, [
                        {
                            rule: "required",
                            errorMessage: "*Product Image is required",
                        },
                        {
                            rule: "files",
                            value: {
                                files: {
                                    extensions: ["jpg", "jpeg", "png", "webp"],
                                    maxSize: 5000000,
                                    types: [
                                        "image/jpeg",
                                        "image/png",
                                        "image/webp",
                                    ],
                                },
                            },
                            errorMessage: "*Invalid image or > 5MB",
                        },
                    ]);
                } catch (err) {
                    // addValidator1 may not be defined for that scope — ignore
                }

                return;
            }

            // image is accepted — optional: show preview
            const previewImg = $(input)
                .closest(".product_fields2, .product_fieldsedit")
                .find("img.edit_preview_image, img.preview_image");
            if (previewImg.length) {
                previewImg.attr("src", evt.target.result);
            }

            // revalidate field so JustValidate knows it's OK
            try {
                addValidator1.revalidate(`#${input.id}`);
            } catch (err) { }
        };

        img.onerror = function () {
            showImageError(
                "Could not read image, please select a valid image file."
            );
            input.value = "";
            try {
                addValidator1.revalidate(`#${input.id}`);
            } catch (err) { }
        };

        img.src = evt.target.result;
    };

    reader.onerror = function () {
        showImageError("Failed to read file.");
        input.value = "";
        try {
            addValidator1.revalidate(`#${input.id}`);
        } catch (err) { }
    };

    reader.readAsDataURL(file);
});

$(document).ready(function () {
    let dynamicImageCount = 0;

    $(".add-input2").click(function () {
        const inputField = $(".product_image_count2");
        const currentValue = parseInt(inputField.val());
        inputField.val(currentValue + 1);
        dynamicImageCount++;

        const newInputId = `add_product_image_${dynamicImageCount}`;

        const inputGroup = `
            <div class="d-flex product_fields2">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label" for="${newInputId}">Product Image*(526 * 789)</label>
                            <input type="file" class="form-control image_el needsclick"
                                id="${newInputId}" name="product_image2[]" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 mt-4">
                        <div class="input-group-append">
                            <button class="btn btn-danger delete-input2" type="button">Delete</button>
                        </div>
                    </div>
                </div>
            </div>`;

        $(".dynamic-inputs2").append(inputGroup);

        // Add validation for new image field
        addValidator1.addField(`#${newInputId}`, [
            {
                rule: "required",
                errorMessage: "*Product Image is required",
            },
            {
                rule: "files",
                value: {
                    files: {
                        extensions: ["jpg", "jpeg", "png", "webp"],
                        maxSize: 5000000,
                        types: ["image/jpeg", "image/png", "image/webp"],
                    },
                },
                errorMessage: "*Invalid image or > 5MB",
            },
        ]);

        // Optional: immediately validate if needed
        addValidator1.revalidate(`#${newInputId}`);
    });

    // Remove dynamic image input
    $(document).on("click", ".delete-input2", function () {
        const input = $(this)
            .closest(".product_fields2")
            .find("input[type='file']");
        const inputId = input.attr("id");
        if (inputId) {
            addValidator1.removeField(`#${inputId}`);
        }
        $(this).closest(".product_fields2").remove();
    });
});

$(document).ready(function () {
    // Add input
    $("#add-inputedit").click(function () {
        var inputGroup = `
        <div class="d-flex product_fieldsedit">
        <div class="row">
        <div class="col-lg-5">
        <div class="mb-3">
            <label class="form-label" for="add_product_image">Product
                Image*(600 *
                600)</label>
            <input type="file"
                class="form-control image_el  needsclick"
                id="edit_productthum_image" placeholder="Product Image"
                name="product_image1[]" required>
        </div>
    </div>
    <div class="col-md-5 d-flex mb-4">
        <div class="col-6">
            <div class="mb-2">Previous Image</div>
            <label class="edit_show_preview-containernew">
                <img src="" alt="image" class="edit_preview_image"></label>
        </div>



    </div>
    <div class="col-lg-2 col-sm-12 mt-4">
        <div class="input-group-append">
            <button class="btn btn-danger delete-inputdeit"
                type="button">Delete</button>
        </div>
    </div>
        </div>
    </div>`;
        $("#dynamic-inputsedit").append(inputGroup);
    });

    // Delete input
    $(document).on("click", ".delete-inputdeit", function () {
        const id = $(this).attr("data-varient-id");
        const elementId = $(this).attr("id");

        console.log({ id });

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
                    url: "destroyVarientThumpImages/" + id,
                    method: "post",
                    dataType: "json",
                    success: function (response) {
                        $("#" + elementId)
                            .closest(".product_fieldsedit")
                            .remove();

                        Swal.fire(
                            "Deleted!",
                            "Records Deleted Successfully.",
                            "success"
                        );
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            textStatus.toUpperCase(),
                            errorThrown,
                            "warning"
                        );
                    },
                });
            }
        });
    });
});

// thump image append
$(document).on("click", ".edit_btn", function () {
    var pro_ver_id = $(this).data("productverid");
    console.log({ pro_ver_id });
    $.ajax({
        url: "/getthump/" + pro_ver_id,
        method: "get",
        dataType: "json",
        success: function (response) {
            // Assuming response is an array of objects

            // Initialize an empty string to store the HTML content
            var htmlContent = "";

            // Iterate over each response object
            $.each(response, function (index, item) {
                // Append the HTML structure with the response values
                htmlContent += '<div class="d-flex product_fieldsedit">';
                htmlContent += '<div class="row">';
                htmlContent += '<div class="col-lg-5">';
                htmlContent += ' <div class="mb-3">';
                htmlContent +=
                    ' <label class="form-label" for="add_product_image">Product Image*(526*789)</label>';
                htmlContent += `<input type="file" class="form-control image_el pr_images_varient  needsclick" id="edit_productthum_image" placeholder="Product Image"name="product_image1[]" accept="image/*" required>`;
                htmlContent += "</div>";
                htmlContent += "</div>";
                htmlContent += '<div class="col-md-5 d-flex mb-4">';
                htmlContent += '<div class="col-6">';
                htmlContent += '<div class="mb-2">Previous Image  </div>';
                htmlContent +=
                    ' <label class="edit_show_preview-containernew">';
                htmlContent +=
                    '<img src="images/' +
                    item.product_child_image +
                    '" alt="image" class="edit_preview_image">';
                htmlContent += " </label>";
                htmlContent += "</div>";
                // htmlContent += '<div class="col-6 ">';
                // htmlContent += '<div class="mb-2">New Image</div>';
                // htmlContent += '<label for="edit_product_image" class="edit_preview-containernew123">';
                // htmlContent += '<div class="flex justify-content-center">';
                // htmlContent += '<div class="text-center">';
                // htmlContent += '<i class="display-4 col-12 text-muted mdi mdi-cloud-upload" style="font-size: 20px"></i>';
                // htmlContent += '</div>';
                // htmlContent += '<div>';
                // htmlContent += '</div>';
                // htmlContent += '</div>';
                // htmlContent += '</label>';
                htmlContent += "</div>";
                htmlContent += "</div>";

                htmlContent += '<div class="col-lg-2 col-sm-12 mt-4">';
                htmlContent += '<div class="input-group-append">';
                htmlContent += `<button data-varient-id="${item.id}"
                id="delete-inputdeit${item.id}"
                 class="btn btn-danger delete-inputdeit " type="button">Delete</button>`;
                htmlContent += "</div>";
                htmlContent += "</div>";
                htmlContent += "</div>";
                htmlContent += "</div>";
            });

            // Set the HTML content of the container to the new content
            $("#dynamic-inputsedit").html(htmlContent);

            // $(".pr_images_varient").each(function(index,elem){
            //    editValidator.addField(elem, imageValiation);
            // })
        },
    });
});
