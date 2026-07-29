const gridNew = new gridjs.Grid({
    columns: [
        "S.No",
        "Order ID",
        "Ordered Date",
        "Name",
        "Payment Method",
        // "Payment Status",
        "Delivery Status",
        "Printing Method",
        {
            name: "Status",
            sort: false,
        },
        {
            name: "Payment Proof",
            sort: false,
        },
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
    data: productOrders.map((productOrder, index) => {
        // Extract user_id (prefer customer relationship, fallback to direct fields)
        const userId = productOrder.user_id ?? productOrder.guest_user_id;

        // Resolve Customer Name: prioritize orderAddress.address_username
        let customerName = "N/A";
        let customerPhone = "";
        let customerCountry = "";

        if (productOrder.order_address && productOrder.order_address.address_username) {
            customerName = productOrder.order_address.address_username;
            customerPhone = productOrder.order_address.address_phone_number ?? "";
            customerCountry = productOrder.order_address.country ?? "";
        } else if (productOrder.orderAddress && productOrder.orderAddress.address_username) {
            customerName = productOrder.orderAddress.address_username;
            customerPhone = productOrder.orderAddress.address_phone_number ?? "";
            customerCountry = productOrder.orderAddress.country ?? "";
        } else if (productOrder.customer) {
            customerName = productOrder.customer.name;
            customerPhone = productOrder.customer.phone_number ?? "";
        } else if (userId && window.users && window.users[userId]) {
            customerName = window.users[userId].name;
            customerPhone = window.users[userId].phone_number ?? "";
        } else if (productOrder.order_name) {
            customerName = productOrder.order_name;
        }

        // Add country to name if available
        if (customerCountry) {
            customerName += ` (${customerCountry})`;
        }

        const customerId = userId ?? "";

        // Format payment method for display
        let paymentMethodDisplay = productOrder.payment_method || "N/A";
        if (productOrder.payment_method === 'mp') {
            paymentMethodDisplay = 'Bank Transfer';
        } else if (productOrder.payment_method === 'razorpay') {
            paymentMethodDisplay = 'Razorpay';
        } else if (productOrder.payment_method === 'cod') {
            paymentMethodDisplay = 'COD';
        }

        return [
            index + 1,
            productOrder.order_id,
            productOrder.date_ordered_on,
            customerName,  // ✅ FIXED: Use calculated customerName instead of productOrder.order_name
            paymentMethodDisplay,
            // productOrder.payment_status,
            gridjs.html(
                productOrder.delivery_status == 0
                    ? `<div class="text-info" style="font-weight:bold">Billing</div>`
                    : productOrder.delivery_status == 1
                        ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
                        : productOrder.delivery_status == 2
                            ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                            : productOrder.delivery_status == 3
                                ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
                                : `<div class="text-success" style="font-weight:bold">Delivered</div>`
            ),
            productOrder.printing_method || "N/A",
            gridjs.html(
                productOrder.delivery_status == 1
                    ? `<div> 
                        <button 
                            data-bs-toggle="modal"
                            data-milkOrderid="${productOrder.id}"
                            data-ogmilkOrderid="${productOrder.order_id}"
                            data-orderedDate="${productOrder.date_ordered_on}"
                            data-customername="${customerName}"
                            data-customerid="${customerId}"
                            data-paymentmethod="${productOrder.payment_method}"
                            data-bs-target="#assignToModal"  
                            class="btn btn-secondary edit_btn">
                            Changed
                        </button>
                       </div>`
                    : `<div> 
                        <button 
                            data-bs-toggle="modal"
                            data-milkOrderid="${productOrder.id}"
                            data-ogmilkOrderid="${productOrder.order_id}"
                            data-orderedDate="${productOrder.date_ordered_on}"
                            data-customername="${customerName}"
                            data-customerid="${customerId}"
                            data-cusnum="${customerPhone}"
                            data-deliverypersonid="${productOrder.delivery_person_id}"
                            data-paymentmethod="${productOrder.payment_method}"
                            data-bs-target="#assignToModal"  
                            class="btn btn-warning edit_btn">
                            Status
                        </button>
                       </div>`
            ),
            gridjs.html(
                productOrder.payment_proof
                    ? `<a href="/uploads/proof/${productOrder.payment_proof}" target="_blank">
                        <img src="/uploads/proof/${productOrder.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                       </a>`
                    : `<span class="text-muted">No Proof</span>`
            ),
            gridjs.html(`
                <div class="d-flex gap-1 justify-content-center">
                    <a href="viewProductdetail/${productOrder.order_id}" target="_blank">
                        <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                    </a>
                    <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productOrder.order_id}')">
                        <i class="bx bx-receipt"></i>
                    </button>
                </div>
            `),
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

function gridjsReRender(productOrders) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productOrders.map((productOrder, index) => {
                // Extract user_id (prefer customer relationship, fallback to direct fields)
                const userId = productOrder.user_id ?? productOrder.guest_user_id;

                // Resolve Customer Name: prioritize orderAddress.address_username
                let customerName = "N/A";
                let customerPhone = "";
                let customerCountry = "";

                if (productOrder.order_address && productOrder.order_address.address_username) {
                    customerName = productOrder.order_address.address_username;
                    customerPhone = productOrder.order_address.address_phone_number ?? "";
                    customerCountry = productOrder.order_address.country ?? "";
                } else if (productOrder.orderAddress && productOrder.orderAddress.address_username) {
                    customerName = productOrder.orderAddress.address_username;
                    customerPhone = productOrder.orderAddress.address_phone_number ?? "";
                    customerCountry = productOrder.orderAddress.country ?? "";
                } else if (productOrder.customer) {
                    customerName = productOrder.customer.name;
                    customerPhone = productOrder.customer.phone_number ?? "";
                } else if (userId && window.users && window.users[userId]) {
                    customerName = window.users[userId].name;
                    customerPhone = window.users[userId].phone_number ?? "";
                } else if (productOrder.order_name) {
                    customerName = productOrder.order_name;
                }

                // Add country to name if available
                if (customerCountry) {
                    customerName += ` (${customerCountry})`;
                }

                const customerId = userId ?? "";

                // Format payment method for display
                let paymentMethodDisplay = productOrder.payment_method || "N/A";
                if (productOrder.payment_method === 'mp') {
                    paymentMethodDisplay = 'Bank Transfer';
                } else if (productOrder.payment_method === 'razorpay') {
                    paymentMethodDisplay = 'Razorpay';
                } else if (productOrder.payment_method === 'cod') {
                    paymentMethodDisplay = 'COD';
                }

                // Format payment status for display
                let paymentStatusHtml = `<div class="text-muted" style="font-weight:bold">Unknown</div>`;
                if (productOrder.payment_status == 0) {
                    paymentStatusHtml = `<div class="text-danger" style="font-weight:bold">Unpaid</div>`;
                } else if (productOrder.payment_status == 1) {
                    paymentStatusHtml = `<div class="text-success" style="font-weight:bold">Paid</div>`;
                } else if (productOrder.payment_status == 2) {
                    paymentStatusHtml = `<div class="text-warning" style="font-weight:bold">COD</div>`;
                } else if (productOrder.payment_status == 3) {
                    paymentStatusHtml = `<div class="text-info" style="font-weight:bold">Bank Transfer</div>`;
                }

                return [
                    index + 1,
                    productOrder.order_id,
                    productOrder.date_ordered_on,
                    customerName,  // ✅ FIXED: Use calculated customerName instead of productOrder.order_name
                    paymentMethodDisplay,
                    gridjs.html(
                        productOrder.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Billing</div>`
                            : productOrder.delivery_status == 1
                                ? `<div class="text-primary" style="font-weight:bold">Packed</div>`
                                : productOrder.delivery_status == 2
                                    ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                                    : productOrder.delivery_status == 3
                                        ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
                                        : `<div class="text-success" style="font-weight:bold">Delivered</div>`
                    ),
                    productOrder.printing_method || "N/A",
                    gridjs.html(
                        productOrder.delivery_status == 1
                            ? `<div> <button data-bs-toggle="modal"
                                data-milkOrderid="${productOrder.id}"
                                data-ogmilkOrderid="${productOrder.order_id}"
                                data-orderedDate="${productOrder.date_ordered_on}"
                                data-customername="${customerName}"
                                data-customerid="${customerId}"
                                data-deliverypersonid="${productOrder.delivery_person_id}"
                                data-paymentmethod="${productOrder.payment_method}"
                                data-bs-target="#assignToModal" class="btn btn-secondary edit_btn">Change</button></div>`
                            : `<div> <button data-bs-toggle="modal"
                                data-milkOrderid="${productOrder.id}"
                                data-ogmilkOrderid="${productOrder.order_id}"
                                data-orderedDate="${productOrder.date_ordered_on}"
                                data-customername="${customerName}"
                                data-customerid="${customerId}"
                                data-cusnum="${customerPhone}"
                                data-deliverypersonid="${productOrder.delivery_person_id}"
                                data-paymentmethod="${productOrder.payment_method}"
                                data-bs-target="#assignToModal" class="btn btn-warning edit_btn">Assign</button></div>`
                    ),
                    gridjs.html(
                        productOrder.payment_proof
                            ? `<a href="/uploads/proof/${productOrder.payment_proof}" target="_blank">
                                <img src="/uploads/proof/${productOrder.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                               </a>`
                            : `<span class="text-muted">No Proof</span>`
                    ),
                    gridjs.html(`
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="viewProductdetail/${productOrder.order_id}" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                    <i class="bx bx-show"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productOrder.order_id}')">
                                <i class="bx bx-receipt"></i>
                            </button>
                        </div>
                    `),
                ];
            }),
        })
        .forceRender();
}

$(function () {
    $(document).on("click", ".edit_btn", function () {
        $("#customer_name_input").val($(this).attr("data-customername"));
        $("#order_id_input").val($(this).attr("data-ogmilkOrderid"));
        $("#cusid").val($(this).attr("data-customerid"));
        $("#cusnum").val($(this).attr("data-cusnum"));
        $("#changestatus").attr("data-paymentmethod", $(this).attr("data-paymentmethod"));
    });

    $(document).on("click", ".edit_btn6", function () {
        $("#customer_name_input1").val($(this).attr("data-customername"));
        $("#order_id_input1").val($(this).attr("data-ogmilkOrderid"));
        $("#cusid6").val($(this).attr("data-customerid"));
        $("#cusnum").val($(this).attr("data-cusnum"));
    });
});

$(function () {
    $(document).on("click", ".edit_btn1", function () {
        $("#customer_name_input1").val($(this).attr("data-customername"));
        $("#order_id_input1").val($(this).attr("data-ogmilkOrderid"));
        $("#cusid1").val($(this).attr("data-customerid"));
        $("#customer_resons_input1").val($(this).attr("data-refund"));
    });
});

const assignDeliveryValidator = new JustValidate("#changestatus", {
    validateBeforeSubmitting: true,
});
const assignDeliveryValidator1 = new JustValidate("#changestatus1", {
    validateBeforeSubmitting: true,
});

assignDeliveryValidator
    .addField("#add_status_select", [
        {
            rule: "required",
            errorMessage: "*Status field is required",
        },
    ])
    .onSuccess((event) => {
        let paymentMethod = $("#changestatus").attr("data-paymentmethod");
        if (paymentMethod === 'mp') {
            Swal.fire({
                title: 'Bank Transfer Approval',
                html: '<p>You are about to change the status of a Bank Transfer order. Please confirm payment is verified.</p>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Submit Status',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".add_submit_btn").attr("disabled", "true");
                    changestatussubmit(event);
                }
            });
        } else {
            $(".add_submit_btn").attr("disabled", "true");
            changestatussubmit(event);
        }
    });
assignDeliveryValidator1.onSuccess((event) => {
    $(".reson_submit_btn").attr("disabled", "true");
    changestatus1submit(event);
});

function changestatussubmit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "updatestatus",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProductOrders = response.productOrders;
            $("#changestatus")[0].reset();
            $("#assignToModal").hide();
            $(".modal-backdrop").remove();
            $(".add_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProductOrders);
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

// product cancel

function changestatus1submit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "updaterefund",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedProductOrders = response.productOrders;
            $("#changestatus1")[0].reset();
            $("#RefundModal").hide();
            $(".modal-backdrop").remove();
            $(".reson_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedProductOrders);
            Swal.fire("Success", "Status Change Successfully", "success");
            willClose: () => {
                location.reload(); // Reload after alert closes
            };
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".reson_submit_btn").removeAttr("disabled");
            $(".reson_submit_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

$(document).ready(function () {
    $(document).on("click", ".reson_submit_btn", function () {
        $(".reson_submit_btn").removeAttr("disabled");
        $(".reson_submit_btn").html("Submit");
        Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");

        const updatedProductOrders = response.productOrders;
        $("#changestatus1")[0].reset();
        $("#RefundModal").hide();
        $(".modal-backdrop").remove();
        $(".reson_submit_btn").removeAttr("disabled");
        document.body.style.overflowY = "scroll";
        gridjsReRender(updatedProductOrders);
        Swal.fire("Success", "Status Change Successfully", "success");
    });
});
