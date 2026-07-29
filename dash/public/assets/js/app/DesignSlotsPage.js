const gridNew = new gridjs.Grid({
    columns: [
        "S.No",
        "Order ID",
        "Own Product Name",
        "Variant",
        "Price",
        "Qty",
        "Amount",
        "Delivery Status",
        {
            name: "Cancel Slot",
            sort: false,
        },
    ],
    pagination: {
        limit: 10,
    },
    sort: !0,
    search: !0,
    data: productSlots.map((productSlot, index) => {
        const variant = productSlot.design_variant || {};
        const design = productSlot.design || {};
        const customer = productSlot.order ? productSlot.order.customer : null;

        return [
            index + 1,
            productSlot.order_id,
            design.design_name || "N/A",
            `${variant.size_value || ""} / ${variant.color_value || ""}`,
            variant.offer_price || 0,
            productSlot.quantity,
            gridjs.html(
                `${(variant.offer_price || 0) * productSlot.quantity}`
            ),
            gridjs.html(
                productSlot.delivery_status == 0
                    ? `<div class="text-info" style="font-weight:bold">Billing</div>`
                    : productSlot.delivery_status == 1
                        ? `<div class="text-secondary" style="font-weight:bold">Packing</div>`
                        : productSlot.delivery_status == 2
                            ? `<div class="text-success" style="font-weight:bold">Dispatched</div>`
                            : productSlot.delivery_status == 3
                                ? `<div class="text-danger" style="font-weight:bold">Out Of Delivery</div>`
                                : productSlot.delivery_status == 4
                                    ? `<div class="text-warning" style="font-weight:bold">Delivered</div>`
                                    : productSlot.delivery_status == 5
                                        ? `<div class="text-info" style="font-weight:bold">Cancel</div>`
                                        : `<div class="text-dark" style="font-weight:bold">Product Return</div>`
            ),
            gridjs.html(
                productSlot.is_cancelled == 0
                    ? ` <div class="btn btn-sm btn-danger">Not Cancel</div>`
                    : productSlot.is_cancelled == 1
                        ? ` <div class="btn btn-sm btn-danger">Cancelled</div>`
                        : `<button
                            data-productSlotid ="${productSlot.id}"
                            data-ogproductSlotid = "${productSlot.order_id}"
                            data-productname = "${design.design_name || "N/A"}"
                            data-customername= "${customer ? customer.name : "N/A"}"
                       class="btn btn-warning btn-sm text-truncate ms-2 cancel_slot_btn">
                        Cancel</button>`
            ),
        ];
    }),
    style: {
        table: { border: "1px solid #ccc" },
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

function gridjsReRender(productSlots) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productSlots.map((productSlot, index) => {
                const variant = productSlot.design_variant || {};
                const design = productSlot.design || {};
                const customer = productSlot.order ? productSlot.order.customer : null;
                return [
                    index + 1,
                    productSlot.order_id,
                    design.design_name || "N/A",
                    `${variant.size_value || ""} / ${variant.color_value || ""}`,
                    variant.offer_price || 0,
                    productSlot.quantity,
                    gridjs.html(
                        `${(variant.offer_price || 0) * productSlot.quantity}`
                    ),
                    gridjs.html(
                        productSlot.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Billing</div>`
                            : productSlot.delivery_status == 1
                                ? `<div class="text-secondary" style="font-weight:bold">Packing</div>`
                                : productSlot.delivery_status == 2
                                    ? `<div class="text-success" style="font-weight:bold">Dispatched</div>`
                                    : productSlot.delivery_status == 3
                                        ? `<div class="text-danger" style="font-weight:bold">Out Of Delivery</div>`
                                        : productSlot.delivery_status == 4
                                            ? `<div class="text-warning" style="font-weight:bold">Delivered</div>`
                                            : productSlot.delivery_status == 5
                                                ? `<div class="text-info" style="font-weight:bold">Cancel</div>`
                                                : `<div class="text-dark" style="font-weight:bold">Product Return</div>`
                    ),
                    gridjs.html(
                        productSlot.is_cancelled == 0
                            ? ` <div class="btn btn-sm btn-danger">Not Cancel</div>`
                            : productSlot.is_cancelled == 1
                                ? ` <div class="btn btn-sm btn-danger">Cancelled</div>`
                                : `<button
                                    data-productSlotid ="${productSlot.id}"
                                    data-ogproductSlotid = "${productSlot.order_id}"
                                    data-productname = "${design.design_name || "N/A"}"
                                    data-customername= "${customer ? customer.name : "N/A"}"
                               class="btn btn-warning btn-sm text-truncate ms-2 cancel_slot_btn">
                                Cancel</button>`
                    ),
                ];
            }),
        })
        .forceRender();
}

$(function () {
    $(document).on("click", ".cancel_slot_btn", function () {
        const id = $(this).attr("data-productSlotid");
        Swal.fire({
            title: "Are you sure want to cancel order?",
            text: "This current slot will be cancelled!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Cancel it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: location.origin + "/cancelProductSlot",
                    method: "post",
                    data: {
                        product_slot_id: id,
                    },
                    dataType: "json",
                    success: function (response) {
                        const updatedProductSlots = response.productSlots;
                        gridjsReRender(updatedProductSlots);
                        Swal.fire(
                            "Cancelled!",
                            "Slot Cancelled Successfully",
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
