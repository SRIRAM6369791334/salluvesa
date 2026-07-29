const gridNew = new gridjs.Grid({
    columns: [
        "S.No",
        "Order ID",
        "Ordered Date",
        "Name",
        "Payment Method",
        // "Payment Status",
        // "Delivery Status",
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
    data: productDeliverys.map((productDelivery, index) => {
        // Extract user_id and lookup customer safely
        // Resolve Customer Name: prioritize orderAddress.address_username
        let customerName = "N/A";
        let customerPhone = "";
        let customerCountry = "";

        if (productDelivery.order_address && productDelivery.order_address.address_username) {
            customerName = productDelivery.order_address.address_username;
            customerPhone = productDelivery.order_address.address_phone_number ?? "";
            customerCountry = productDelivery.order_address.country ?? "";
        } else if (productDelivery.orderAddress && productDelivery.orderAddress.address_username) {
            customerName = productDelivery.orderAddress.address_username;
            customerPhone = productDelivery.orderAddress.address_phone_number ?? "";
            customerCountry = productDelivery.orderAddress.country ?? "";
        } else if (productDelivery.customer) {
            customerName = productDelivery.customer.name;
            customerPhone = productDelivery.customer.phone_number ?? "";
        } else if (productDelivery.user_id && window.users && window.users[productDelivery.user_id]) {
            customerName = window.users[productDelivery.user_id].name;
            customerPhone = window.users[productDelivery.user_id].phone_number ?? "";
        } else if (productDelivery.order_name) {
            customerName = productDelivery.order_name;
        }

        // Add country if available
        if (customerCountry) {
            customerName += ` (${customerCountry})`;
        }

        const customerId = productDelivery.user_id ?? "";

        // Format payment method
        let paymentMethodDisplay = productDelivery.payment_method || "N/A";
        if (productDelivery.payment_method === 'mp') paymentMethodDisplay = 'Bank Transfer';
        else if (productDelivery.payment_method === 'razorpay') paymentMethodDisplay = 'Razorpay';
        else if (productDelivery.payment_method === 'cod') paymentMethodDisplay = 'COD';

        return [
            index + 1,
            productDelivery.order_id,
            productDelivery.date_ordered_on,
            customerName,
            paymentMethodDisplay,
            // productDelivery.payment_status,
            // gridjs.html(
            //     productDelivery.delivery_status == 0
            //         ? `<div class="text-info" style="font-weight:bold">Pending</div>
            // `
            //         : productDelivery.delivery_status == 1
            //         ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
            //         : productDelivery.delivery_status == 2
            //         ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
            //         : productDelivery.delivery_status == 3
            //         ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
            //         : `<div class="text-success" style="font-weight:bold">Delivered</div>`
            // ),

            gridjs.html(
                productDelivery.payment_status == 1
                    ? `<div> <button data-bs-toggle="modal"
                    data-milkOrderid1 ="${productDelivery.id}",
                    data-ogmilkOrderid1 = "${productDelivery.order_id}"
                    data-orderedDate1="${productDelivery.date_ordered_on}"
                    data-custnum= "${customerPhone}"
                    data-tr_id= "${productDelivery.tracking_id}"



                    data-customername1= "${customerName}"
                    data-customerid1= "${customerId}"


                    data-deliverypersonid1 ="${productDelivery.delivery_person_id}"
                data-bs-target="#DeliveryModal"  class="btn btn-secondary edit_btns2 ">Status</button>`
                    : `<div> <button data-bs-toggle="modal"
                    data-milkOrderid1 ="${productDelivery.id}",
                    data-ogmilkOrderid1 = "${productDelivery.order_id}"
                    data-orderedDate1="${productDelivery.date_ordered_on}"
                    data-custnum= "${customerPhone}"


                    data-customername1= "${customerName}"
                    data-customerid1= "${customerId}"
                    data-codamt ="${productDelivery.total_amount}"


                    data-deliverypersonid1 ="${productDelivery.delivery_person_id}"
                data-bs-target="#CollectModal"  class="btn btn-secondary edit_btns3 ">Collect</button>`
            ),
            gridjs.html(`
                <div class="d-flex gap-1 justify-content-center">
                    <a href="viewProductdetail/${productDelivery.order_id}" target="_blank">
                        <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                    </a>
                    <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productDelivery.order_id}')">
                        <i class="bx bx-receipt"></i>
                    </button>
                </div>
            `),
            gridjs.html(
                productDelivery.payment_proof
                    ? `<a href="/uploads/proof/${productDelivery.payment_proof}" target="_blank">
                        <img src="/uploads/proof/${productDelivery.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
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

function gridjsReRender(productDeliverys) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productDeliverys.map((productDelivery, index) => {
                // Extract user_id and lookup customer safely
                // Resolve Customer Name: prioritize orderAddress.address_username
                let customerName = "N/A";
                let customerPhone = "";
                let customerCountry = "";

                if (productDelivery.order_address && productDelivery.order_address.address_username) {
                    customerName = productDelivery.order_address.address_username;
                    customerPhone = productDelivery.order_address.address_phone_number ?? "";
                    customerCountry = productDelivery.order_address.country ?? "";
                } else if (productDelivery.orderAddress && productDelivery.orderAddress.address_username) {
                    customerName = productDelivery.orderAddress.address_username;
                    customerPhone = productDelivery.orderAddress.address_phone_number ?? "";
                    customerCountry = productDelivery.orderAddress.country ?? "";
                } else if (productDelivery.customer) {
                    customerName = productDelivery.customer.name;
                    customerPhone = productDelivery.customer.phone_number ?? "";
                } else if (productDelivery.user_id && window.users && window.users[productDelivery.user_id]) {
                    customerName = window.users[productDelivery.user_id].name;
                    customerPhone = window.users[productDelivery.user_id].phone_number ?? "";
                } else if (productDelivery.order_name) {
                    customerName = productDelivery.order_name;
                }

                // Add country if available
                if (customerCountry) {
                    customerName += ` (${customerCountry})`;
                }

                const customerId = productDelivery.user_id ?? "";

                // Format payment method
                let paymentMethodDisplay = productDelivery.payment_method || "N/A";
                if (productDelivery.payment_method === 'mp') paymentMethodDisplay = 'Bank Transfer';
                else if (productDelivery.payment_method === 'razorpay') paymentMethodDisplay = 'Razorpay';
                else if (productDelivery.payment_method === 'cod') paymentMethodDisplay = 'COD';

                return [
                    index + 1,
                    productDelivery.order_id,
                    productDelivery.date_ordered_on,
                    customerName,
                    paymentMethodDisplay,
                    gridjs.html(
                        productDelivery.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Pending</div>`
                            : productDelivery.delivery_status == 1
                                ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
                                : productDelivery.delivery_status == 2
                                    ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                                    : productDelivery.delivery_status == 3
                                        ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
                                        : `<div class="text-success" style="font-weight:bold">Delivered</div>`
                    ),

                    gridjs.html(
                        productDelivery.payment_status == 1
                            ? `<div> <button data-bs-toggle="modal"
                            data-milkOrderid1 ="${productDelivery.id}",
                            data-ogmilkOrderid1 = "${productDelivery.order_id}"
                            data-orderedDate1="${productDelivery.date_ordered_on}"
                            data-custnum= "${customerPhone}"
 data-tr_id= "${productDelivery.tracking_id}"

                            data-customername1= "${customerName}"
                            data-customerid1= "${customerId}"



                            data-deliverypersonid1 ="${productDelivery.delivery_person_id}"
                        data-bs-target="#DeliveryModal"  class="btn btn-secondary edit_btns2 ">Status</button>`
                            : `<div> <button data-bs-toggle="modal"
                            data-milkOrderid1 ="${productDelivery.id}",
                            data-ogmilkOrderid1 = "${productDelivery.order_id}"
                            data-orderedDate1="${productDelivery.date_ordered_on}"
                            data-custnum= "${customerPhone}"


                            data-customername1= "${customerName}"
                            data-customerid1= "${customerId}"
                            data-codamt ="${productDelivery.total_amount}"


                            data-deliverypersonid1 ="${productDelivery.delivery_person_id}"
                        data-bs-target="#CollectModal"  class="btn btn-secondary edit_btns3 ">Collect</button>`
                    ),
                    gridjs.html(`
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="viewProductdetail/${productDelivery.order_id}" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                    <i class="bx bx-show"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productDelivery.order_id}')">
                                <i class="bx bx-receipt"></i>
                            </button>
                        </div>
                    `),
                    gridjs.html(
                        productDelivery.payment_proof
                            ? `<a href="/uploads/proof/${productDelivery.payment_proof}" target="_blank">
                                <img src="/uploads/proof/${productDelivery.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                               </a>`
                            : `<span class="text-muted">No Proof</span>`
                    ),
                ];
            }),
        })
        .forceRender();
}

$(function () {
    $(document).on("click", ".edit_btns2", function () {
        $("#customer_name_input2").val($(this).attr("data-customername1"));
        $("#order_id_input2").val($(this).attr("data-ogmilkOrderid1"));
        $("#cusiddelive").val($(this).attr("data-customerid1"));
        $("#cusnumer").val($(this).attr("data-custnum"));
        $("#tracking_id_input").val($(this).attr("data-tr_id"));
    });
});

$(function () {
    $(document).on("click", ".edit_btns3", function () {
        console.log("lkajsdkl");

        $("#customer_name_input21").val($(this).attr("data-customername1"));
        $("#order_id_input21").val($(this).attr("data-ogmilkOrderid1"));
        $("#cusiddelive1").val($(this).attr("data-customerid1"));
        // $("#cod_input21").val($(this).attr("data-codamt"));
        $("#cusnumer1").val($(this).attr("data-custnum"));
    });
});

const assignDeliveryValidator12 = new JustValidate("#collectstatus3", {
    validateBeforeSubmitting: true,
});

assignDeliveryValidator12
    .addField("#add_status_select21", [
        {
            rule: "required",
            errorMessage: "*Status field is required",
        },
    ])
    .onSuccess((event) => {
        $(".collectdelivery_submit_btn").attr("disabled", "true");
        collectstatus3submit(event);
    });

const assignDeliveryValidator = new JustValidate("#changestatus3", {
    validateBeforeSubmitting: true,
});

assignDeliveryValidator
    .addField("#add_status_select2", [
        {
            rule: "required",
            errorMessage: "*Status field is required",
        },
    ])
    .onSuccess((event) => {
        $(".adddelivery_submit_btn").attr("disabled", "true");
        changestatus3submit(event);
    });
function changestatus3submit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "updatestatusdelivery",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedproductDeliverys = response.productDeliverys;
            $("#changestatus3")[0].reset();
            $("#DeliveryModal").hide();
            $(".modal-backdrop").remove();
            $(".adddelivery_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedproductDeliverys);
            Swal.fire("Success", "Status Change Successfully", "success");
            window.location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".adddelivery_submit_btn").removeAttr("disabled");
            $(".adddelivery_submit_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}

function collectstatus3submit(event) {
    const formData = new FormData(event.target);
    $.ajax({
        type: "post",
        url: "collectstatusdelivery",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedproductDeliverys = response.productDeliverys;
            $("#collectstatus3")[0].reset();
            $("#CollectModal").hide();
            $(".modal-backdrop").remove();
            $(".collectdelivery_submit_btn").removeAttr("disabled");
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedproductDeliverys);
            Swal.fire("Success", "Status Change Successfully", "success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".collectdelivery_submit_btn").removeAttr("disabled");
            $(".collectdelivery_submit_btn").html("Submit");
            Swal.fire(textStatus.toUpperCase(), errorThrown, "warning");
        },
    });
}
