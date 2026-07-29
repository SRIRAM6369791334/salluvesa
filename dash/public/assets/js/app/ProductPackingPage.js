const gridNew = new gridjs.Grid({
    columns: [
        "S.No",
        "Order ID",
        "Ordered Date",
        "Name",
        "Payment Method",
        {
            name: "Status",
            sort: false,
        },
        {
            name: "Action",
            sort: false,
        },
        {
            name: "Payment Proof",
            sort: false,
        },
    ],
    pagination: {
        limit: 10,
    },
    sort: !0,
    search: !0,
    data: productPackings.map((productPacking, index) => {
        // Extract user_id (prefer customer relationship, fallback to direct fields)
        const userId = productPacking.user_id ?? productPacking.guest_user_id;

        // Resolve Customer Name: prioritize orderAddress.address_username
        let customerName = "N/A";
        let customerPhone = "";
        let customerCountry = "";

        if (productPacking.order_address && productPacking.order_address.address_username) {
            customerName = productPacking.order_address.address_username;
            customerPhone = productPacking.order_address.address_phone_number ?? "";
            customerCountry = productPacking.order_address.country ?? "";
        } else if (productPacking.orderAddress && productPacking.orderAddress.address_username) {
            customerName = productPacking.orderAddress.address_username;
            customerPhone = productPacking.orderAddress.address_phone_number ?? "";
            customerCountry = productPacking.orderAddress.country ?? "";
        } else if (productPacking.customer) {
            customerName = productPacking.customer.name;
            customerPhone = productPacking.customer.phone_number ?? "";
        } else if (userId && window.users && window.users[userId]) {
            customerName = window.users[userId].name;
            customerPhone = window.users[userId].phone_number ?? "";
        } else if (productPacking.order_name) {
            customerName = productPacking.order_name;
        }

        // Add country if available
        if (customerCountry) {
            customerName += ` (${customerCountry})`;
        }

        const customerId = userId ?? "";

        // Format payment method for display
        let paymentMethodDisplay = productPacking.payment_method || "N/A";
        if (productPacking.payment_method === 'mp') {
            paymentMethodDisplay = 'Bank Transfer';
        } else if (productPacking.payment_method === 'razorpay') {
            paymentMethodDisplay = 'Razorpay';
        } else if (productPacking.payment_method === 'cod') {
            paymentMethodDisplay = 'COD';
        }

        return [
            index + 1,
            productPacking.order_id,
            productPacking.date_ordered_on,
            customerName,  // ✅ FIXED: Use calculated customerName
            paymentMethodDisplay,

            gridjs.html(
                productPacking.delivery_status == 2
                    ? `<div> <button data-bs-toggle="modal"
                    data-milkOrderid1 ="${productPacking.id}",
                    data-ogmilkOrderid1 = "${productPacking.order_id}"
                    data-orderedDate1="${productPacking.date_ordered_on}"

                    data-customername1= "${customerName}"
                    data-customerid1= "${customerId}"


                data-bs-target="#PackingModal"  class="btn btn-secondary edit_btns ">Changed</button>`
                    : `<div> <button data-bs-toggle="modal"
                    data-milkOrderid1 ="${productPacking.id}",
                    data-ogmilkOrderid1 = "${productPacking.order_id}"
                    data-orderedDate1="${productPacking.date_ordered_on}"

                    data-customername1= "${customerName}"
                    data-customerid1= "${customerId}"
                    data-cusnum= "${customerPhone}"

                    data-deliverypersonid1 ="${productPacking.delivery_person_id}"
                data-bs-target="#PackingModal"  class="btn btn-warning edit_btns ">Status</button>`
            ),
            gridjs.html(`
                <div class="d-flex gap-1 justify-content-center">
                    <a href="viewProductdetail/${productPacking.order_id}" target="_blank">
                        <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                    </a>
                    <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productPacking.order_id}')">
                        <i class="bx bx-receipt"></i>
                    </button>
                </div>
            `),
            gridjs.html(
                productPacking.payment_proof
                    ? `<a href="/uploads/proof/${productPacking.payment_proof}" target="_blank">
                        <img src="/uploads/proof/${productPacking.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                       </a>`
                    : `<span class="text-muted">No Proof</span>`
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

function gridjsReRender(productPackings) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productPackings.map((productPacking, index) => {
                // Extract user_id (prefer customer relationship, fallback to direct fields)
                const userId = productPacking.user_id ?? productPacking.guest_user_id;

                // Resolve Customer Name: prioritize orderAddress.address_username
                let customerName = "N/A";
                let customerPhone = "";
                let customerCountry = "";

                if (productPacking.order_address && productPacking.order_address.address_username) {
                    customerName = productPacking.order_address.address_username;
                    customerPhone = productPacking.order_address.address_phone_number ?? "";
                    customerCountry = productPacking.order_address.country ?? "";
                } else if (productPacking.orderAddress && productPacking.orderAddress.address_username) {
                    customerName = productPacking.orderAddress.address_username;
                    customerPhone = productPacking.orderAddress.address_phone_number ?? "";
                    customerCountry = productPacking.orderAddress.country ?? "";
                } else if (productPacking.customer) {
                    customerName = productPacking.customer.name;
                    customerPhone = productPacking.customer.phone_number ?? "";
                } else if (userId && window.users && window.users[userId]) {
                    customerName = window.users[userId].name;
                    customerPhone = window.users[userId].phone_number ?? "";
                } else if (productPacking.order_name) {
                    customerName = productPacking.order_name;
                }

                // Add country if available
                if (customerCountry) {
                    customerName += ` (${customerCountry})`;
                }

                const customerId = userId ?? "";

                // Format payment method for display
                let paymentMethodDisplay = productPacking.payment_method || "N/A";
                if (productPacking.payment_method === 'mp') {
                    paymentMethodDisplay = 'Bank Transfer';
                } else if (productPacking.payment_method === 'razorpay') {
                    paymentMethodDisplay = 'Razorpay';
                } else if (productPacking.payment_method === 'cod') {
                    paymentMethodDisplay = 'COD';
                }

                return [
                    index + 1,
                    productPacking.order_id,
                    productPacking.date_ordered_on,
                    customerName,  // ✅ FIXED: Use calculated customerName
                    paymentMethodDisplay,
                    gridjs.html(
                        productPacking.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Pending</div>
                    `
                            : productPacking.delivery_status == 1
                                ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
                                : productPacking.delivery_status == 2
                                    ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                                    : `<div class="text-success" style="font-weight:bold">Delivery</div>`
                    ),

                    gridjs.html(
                        productPacking.delivery_status == 2
                            ? `<div> <button data-bs-toggle="modal"
                            data-milkOrderid1 ="${productPacking.id}",
                            data-ogmilkOrderid1 = "${productPacking.order_id}"
                            data-orderedDate1="${productPacking.date_ordered_on}"


                            data-customername1= "${customerName}"
                            data-customerid1= "${customerId}"

                            data-deliverypersonid1 ="${productPacking.delivery_person_id}"
                        data-bs-target="#PackingModal"  class="btn btn-secondary edit_btns ">Change</button>`
                            : `<div> <button data-bs-toggle="modal"
                            data-milkOrderid1 ="${productPacking.id}",
                            data-ogmilkOrderid1 = "${productPacking.order_id}"
                            data-orderedDate1="${productPacking.date_ordered_on}"

                            data-customername1= "${customerName}"
                            data-customerid1= "${customerId}"
                            data-cusnum= "${customerPhone}"

                            data-deliverypersonid1 ="${productPacking.delivery_person_id}"
                        data-bs-target="#PackingModal"  class="btn btn-warning edit_btns ">Assign</button>`
                    ),
                    gridjs.html(`
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="viewProductdetail/${productPacking.order_id}" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                    <i class="bx bx-show"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productPacking.order_id}')">
                                <i class="bx bx-receipt"></i>
                            </button>
                        </div>
                    `),
                    gridjs.html(
                        productPacking.payment_proof
                            ? `<a href="/uploads/proof/${productPacking.payment_proof}" target="_blank">
                                <img src="/uploads/proof/${productPacking.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                               </a>`
                            : `<span class="text-muted">No Proof</span>`
                    ),
                ];
            }),
        })
        .forceRender();
}

$(function () {
    $(document).on("click", ".edit_btns", function () {
        console.log("hai");
        $("#customer_name_input1").val($(this).attr("data-customername1"));
        $("#order_id_input1").val($(this).attr("data-ogmilkOrderid1"));
        $("#cusid").val($(this).attr("data-customerid1"));
        $("#cusnum").val($(this).attr("data-cusnum"));
    });
});

$(function () {
    $(document).on("click", ".edit_btn2", function () {
        $("#customer_name_input2").val($(this).attr("data-customername"));
        $("#order_id_input2").val($(this).attr("data-ogmilkOrderid"));
        $("#cusid2").val($(this).attr("data-customerid"));
        $("#cusnum").val($(this).attr("data-cusnum"));
        $("#customer_resons_input2").val($(this).attr("data-refund"));
    });
});

const assignDeliveryValidator = new JustValidate("#changestatus1", {
    validateBeforeSubmitting: true,
});

const assignDeliveryValidator1 = new JustValidate("#changestatus2", {
    validateBeforeSubmitting: true,
});

assignDeliveryValidator
    .addField("#add_status_select1", [
        {
            rule: "required",
            errorMessage: "*Status field is required",
        },
    ])
    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", "true");
        changestatus1submit(event);
    });

assignDeliveryValidator1.onSuccess((event) => {
    $(".reson2_submit_btn").attr("disabled", "true");
    changestatus2submit(event);
});
function changestatus1submit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "updatestatupacking",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedproductPackings = response.productPackings;
            $("#changestatus1")[0].reset();
            $("#PackingModal").hide();
            $(".modal-backdrop").remove();
            $(".add_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedproductPackings);
            Swal.fire("Success", "Status Change Successfully", "success");
            window.location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".add_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

function changestatus2submit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "updaterefund1",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProductOrders = response.productPackings;
            $("#changestatus2")[0].reset();
            $("#Refund1ModalLabel").hide();
            $(".modal-backdrop").remove();
            $(".reson1_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProductOrders);
            Swal.fire("Success", "Status Change Successfully", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".reson1_submit_btn").removeAttr("disabled");
            $(".reson1_submit_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}
