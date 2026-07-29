const gridNew = new gridjs.Grid({
    columns: [
        "S.NO",
        "Location",
        "Shipping Amount",
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
    data: shipping.map((shipping, index) => {
        return [
            index + 1,
            shipping.id,
            shipping.location,
            shipping.shipping_amt,
            gridjs.html(
                `<div> <button data-bs-toggle="modal"
                data-productid ="${shipping.id}"

                data-bs-target="#editProductModal"  class="btn btn-success edit_btn ">Add</button>   <button data-bs-toggle="modal"
               
                data-location ="${shipping.location}"
                data-shipping_amt ="${shipping.shipping_amt}"

                data-bs-target="#updateProductModal"  class="btn btn-secondary edit_btn1 ">Edit</button></div>`
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

function gridjsReRender(shipping) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: shipping.map((shipping, index) => {
                return [
                    index + 1,
                    shipping.id,
                    shipping.location,
                    shipping.shipping_amt,
                    gridjs.html(
                        `<div> <button data-bs-toggle="modal"
                data-productid ="${shipping.id}"

                data-bs-target="#editProductModal"  class="btn btn-success edit_btn ">Add</button>   <button data-bs-toggle="modal"
               
                data-location ="${shipping.location}"
                data-shipping_amt ="${shipping.shipping_amt}"

                data-bs-target="#updateProductModal"  class="btn btn-secondary edit_btn1 ">Edit</button></div>`
                    ),
                ];
            }),
        })
        .forceRender();
}
// $(document).on("click", ".edit_btn", function () {
//     $("#productid").val($(this).attr("data-productid"));
// });
$(document).on("click", ".edit_btn1", function () {
    $("#editlocation").val($(this).attr("data-location"));
    $("#editshipping_amt").val($(this).attr("data-shipping_amt"));
});

const addValidator = new JustValidate("#addshipping", {
    validateBeforeSubmitting: true,
});
const addValidator1 = new JustValidate("#editshipping", {
    validateBeforeSubmitting: true,
});
addValidator
    .addField("#location", [
        {
            rule: "required",
            errorMessage: "*Location Field is required",
        },
    ])
    .addField("#shipping_amt", [
        {
            rule: "required",
            errorMessage: "*Shipping Amount Field is required",
        },
    ])

    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", "true");
        $(".add_submit_btn").html("Uploading.....");
        addStockFormSubmit(event);
    });

addValidator1
    .addField("#editlocation", [
        {
            rule: "required",
            errorMessage: "*Location Field is required",
        },
    ])
    .addField("#editshipping_amt", [
        {
            rule: "required",
            errorMessage: "*Shipping Amount Field is required",
        },
    ])

    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", "true");
        $(".add_submit_btn").html("Uploading.....");
        addStockForm1Submit(event);
    });

$(document).on("click", ".edit_btn", function () {
    $("#editid").val($(this).attr("data-id"));
});
$(document).on("click", ".edit_btn1", function () {
    $("#location").val($(this).attr("data-productid1"));
    $("#availa_quantity1").val($(this).attr("data-availa"));
});

function addStockFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "updateshipping",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProduct = response.lowshipping;
            $("#addStockForm")[0].reset();
            $("#editProductModal").hide();
            $(".modal-backdrop").remove();

            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProduct);
            $(".add_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            Swal.fire("Updated", "Records Updated  Successfully.", "success");
            window.location.reload();
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

function addStockForm1Submit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "addshipping",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProduct = response.shipping;
            $("#addStockForm1")[0].reset();
            $("#updateProductModal").hide();
            $(".modal-backdrop").remove();

            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProduct);
            $(".add_submit_btn").removeAttr("disabled");
            $(".edit1_submit_btn").html("Update");
            Swal.fire("Updated", "Records Updated  Successfully.", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".edit1_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").removeAttr("disabled");
            $(".edit1_submit_btn").html("Update");
            $(".add_submit_btn").html("Submit");
            console.log(textStatus + ": " + errorThrown);

            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}
