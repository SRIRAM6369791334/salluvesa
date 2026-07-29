const gridNew = new gridjs.Grid({
    columns: [
        "S.No",
        "Order ID",
        "Ordered Date",
        "Name",
        "Payment Method",
        "Payment Status",
        "Delivery Status",

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
    data: productcompletes.map((productComplete, index) => {
        // Extract user_id and lookup customer safely
        const userId = productComplete.user_id ?? productComplete.guest_user_id;
        // Resolve Customer Name: prioritize orderAddress.address_username
        let customerName = "N/A";
        let customerCountry = "";

        if (productComplete.order_address && productComplete.order_address.address_username) {
            customerName = productComplete.order_address.address_username;
            customerCountry = productComplete.order_address.country ?? "";
        } else if (productComplete.orderAddress && productComplete.orderAddress.address_username) {
            customerName = productComplete.orderAddress.address_username;
            customerCountry = productComplete.orderAddress.country ?? "";
        } else if (productComplete.customer) {
            customerName = productComplete.customer.name;
        } else if (userId && window.users && window.users[userId]) {
            customerName = window.users[userId].name;
        } else if (productComplete.order_name) {
            customerName = productComplete.order_name;
        }

        // Add country if available
        if (customerCountry) {
            customerName += ` (${customerCountry})`;
        }

        // Format payment method
        let paymentMethodDisplay = productComplete.payment_method || "N/A";
        if (productComplete.payment_method === 'mp') paymentMethodDisplay = 'Bank Transfer';
        else if (productComplete.payment_method === 'razorpay') paymentMethodDisplay = 'Razorpay';
        else if (productComplete.payment_method === 'cod') paymentMethodDisplay = 'COD';

        return [
            index + 1,
            productComplete.order_id,
            productComplete.date_ordered_on,
            customerName,
            paymentMethodDisplay,
            gridjs.html(
                productComplete.payment_status == 0
                    ? `<div class="text-danger" style="font-weight:bold">Not Paid</div>`
                    : `<div class="text-success" style="font-weight:bold">Paid</div>`
            ),

            gridjs.html(
                productComplete.delivery_status == 0
                    ? `<div class="text-info" style="font-weight:bold">Pending</div>
            `
                    : productComplete.delivery_status == 1
                        ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
                        : productComplete.delivery_status == 2
                            ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                            : productComplete.delivery_status == 3
                                ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
                                : `<div class="text-success" style="font-weight:bold">Delivered</div>`
            ),

            gridjs.html(`
                <div class="d-flex gap-1 justify-content-center">
                    <a href="viewProductdetail/${productComplete.order_id}" target="_blank">
                        <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                    </a>
                    <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productComplete.order_id}')">
                        <i class="bx bx-receipt"></i>
                    </button>
                </div>
            `),
            gridjs.html(
                productComplete.payment_proof
                    ? `<a href="/uploads/proof/${productComplete.payment_proof}" target="_blank">
                        <img src="/uploads/proof/${productComplete.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
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

function gridjsReRender(productcompletes) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productcompletes.map((productComplete, index) => {
                // Extract user_id and lookup customer safely
                const userId = productComplete.user_id ?? productComplete.guest_user_id;
                // Resolve Customer Name: prioritize orderAddress.address_username
                let customerName = "N/A";
                let customerCountry = "";

                if (productComplete.order_address && productComplete.order_address.address_username) {
                    customerName = productComplete.order_address.address_username;
                    customerCountry = productComplete.order_address.country ?? "";
                } else if (productComplete.orderAddress && productComplete.orderAddress.address_username) {
                    customerName = productComplete.orderAddress.address_username;
                    customerCountry = productComplete.orderAddress.country ?? "";
                } else if (productComplete.customer) {
                    customerName = productComplete.customer.name;
                } else if (userId && window.users && window.users[userId]) {
                    customerName = window.users[userId].name;
                } else if (productComplete.order_name) {
                    customerName = productComplete.order_name;
                }

                // Add country if available
                if (customerCountry) {
                    customerName += ` (${customerCountry})`;
                }

                // Format payment method
                let paymentMethodDisplay = productComplete.payment_method || "N/A";
                if (productComplete.payment_method === 'mp') paymentMethodDisplay = 'Bank Transfer';
                else if (productComplete.payment_method === 'razorpay') paymentMethodDisplay = 'Razorpay';
                else if (productComplete.payment_method === 'cod') paymentMethodDisplay = 'COD';

                return [
                    index + 1,
                    productComplete.order_id,
                    productComplete.date_ordered_on,
                    customerName,
                    paymentMethodDisplay,
                    gridjs.html(
                        productComplete.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Pending</div>
                    `
                            : productComplete.delivery_status == 1
                                ? `<div class="text-primary" style="font-weight:bold">Packing</div>`
                                : productComplete.delivery_status == 2
                                    ? `<div class="text-warning" style="font-weight:bold">Dispatched</div>`
                                    : productComplete.delivery_status == 3
                                        ? `<div class="text-success" style="font-weight:bold">Out Of Delivery</div>`
                                        : `<div class="text-success" style="font-weight:bold">Delivered</div>`
                    ),

                    gridjs.html(`
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="viewProductdetail/${productComplete.order_id}" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm text-truncate" title="View Details">
                                    <i class="bx bx-show"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-info btn-sm text-truncate" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${productComplete.order_id}')">
                                <i class="bx bx-receipt"></i>
                            </button>
                        </div>
                    `),
                    gridjs.html(
                        productComplete.payment_proof
                            ? `<a href="/uploads/proof/${productComplete.payment_proof}" target="_blank">
                                <img src="/uploads/proof/${productComplete.payment_proof}" style="height: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                               </a>`
                            : `<span class="text-muted">No Proof</span>`
                    ),
                ];
            }),
        })
        .forceRender();
}
