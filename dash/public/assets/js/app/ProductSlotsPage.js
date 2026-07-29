    columns: [
        "S.No",
        "Product",
        "Artwork Preview",
        "Price",
        "Product Qut",
        "Amount",
        "Area",
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

        return [
            index + 1,



            gridjs.html(() => {
                if (productSlot.product_varient) {
                    const unit = productSlot.product_varient.varient == 1 ? 'l' :
                        productSlot.product_varient.varient == 2 ? 'ml' :
                            productSlot.product_varient.varient == 3 ? 'g' :
                                productSlot.product_varient.varient == 4 ? 'kg' : "No's";
                    return `<p>${productSlot.product.product_name} ${productSlot.product_varient.value}${unit}</p>`;
                } else if (productSlot.sample_variant) {
                    const colors = productSlot.sample_variant.color_value || 'N/A';
                    return `<p>${productSlot.sample.sample_name} (${productSlot.sample_variant.size_value} / ${colors})</p>`;
                } else if (productSlot.design_variant) {
                    return `<p>${productSlot.design.design_name} (${productSlot.design_variant.size_value} / ${productSlot.design_variant.color_value})</p>`;
                }
                return `<p>${productSlot.product_name || 'N/A'}</p>`;
            }),

            gridjs.html(() => {
                let html = '';
                if (productSlot.preview_screenshot_url) {
                    html += `<a href="${productSlot.preview_screenshot_url}" target="_blank"><img src="${productSlot.preview_screenshot_url}" style="width:50px; height:50px; object-fit:contain; border:1px solid #ddd; border-radius:6px; background:#fff;" title="View Preview Screenshot"></a>`;
                }
                if (productSlot.custom_logo_url) {
                    html += `<div class="mt-1"><a href="${productSlot.custom_logo_url}" target="_blank" class="badge bg-primary text-white" download><i class="bx bx-download"></i> Download Logo</a></div>`;
                }
                if (productSlot.custom_text) {
                    html += `<div class="small text-muted mt-1">Text: <b>${productSlot.custom_text}</b></div>`;
                }
                if (productSlot.customization_position && productSlot.customization_position !== 'none') {
                    html += `<div class="badge bg-info text-white mt-1">${productSlot.customization_position}</div>`;
                }
                return html || '<span class="text-muted">Standard Item</span>';
            }),

            // productSlot.product.product_name,
            productSlot.product_varient ? productSlot.product_varient.offer_price :
                (productSlot.sample_variant ? productSlot.sample_variant.offer_price :
                    (productSlot.design_variant ? productSlot.design_variant.offer_price : 0)),
            productSlot.quantity,
            gridjs.html(() => {
                const price = productSlot.product_varient ? productSlot.product_varient.offer_price :
                    (productSlot.sample_variant ? productSlot.sample_variant.offer_price :
                        (productSlot.design_variant ? productSlot.design_variant.offer_price : 0));
                return `${price * productSlot.quantity}`;
            }),

            productSlot.order.customer.user_addresses[0].address_line_one,
            gridjs.html(
                productSlot.delivery_status == 0
                    ? `<div class="text-info" style="font-weight:bold">Billing</div>
`
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
                        ? `
                    <div class="btn btn-sm btn-danger">Cancelled</div>`
                        : `<button
                    data-productSlotid ="${productSlot.id}",
                    data-ogproductSlotid = "${productSlot.order_id}"
                    data-customername= "${productSlot.order.customer.name}"
                    data-productname= "${productSlot.product ? productSlot.product.product_name : (productSlot.sample ? productSlot.sample.sample_name : (productSlot.design ? productSlot.design.design_name : 'N/A'))}"

                    data-deliverypersonid ="${productSlot.delivery_person_id}"
               class="btn btn-warning  btn-sm text-truncate ms-2 cancel_slot_btn">
                Cancel</button>`


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

function gridjsReRender(productSlots) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: productSlots.map((productSlot, index) => {
                return [
                    index + 1,



                    gridjs.html(() => {
                        if (productSlot.product_varient) {
                            const unit = productSlot.product_varient.varient == 1 ? 'l' :
                                productSlot.product_varient.varient == 2 ? 'ml' :
                                    productSlot.product_varient.varient == 3 ? 'g' :
                                        productSlot.product_varient.varient == 4 ? 'kg' : "No's";
                            return `<p>${productSlot.product.product_name} ${productSlot.product_varient.value}${unit}</p>`;
                        } else if (productSlot.sample_variant) {
                            const colors = productSlot.sample_variant.color_value || 'N/A';
                            return `<p>${productSlot.sample.sample_name} (${productSlot.sample_variant.size_value} / ${colors})</p>`;
                        } else if (productSlot.design_variant) {
                            return `<p>${productSlot.design.design_name} (${productSlot.design_variant.size_value} / ${productSlot.design_variant.color_value})</p>`;
                        }
                        return "<p>N/A</p>";
                    }),

                    // productSlot.product.product_name,
                    productSlot.product_varient ? productSlot.product_varient.offer_price :
                        (productSlot.sample_variant ? productSlot.sample_variant.offer_price :
                            (productSlot.design_variant ? productSlot.design_variant.offer_price : 0)),
                    productSlot.quantity,
                    gridjs.html(() => {
                        const price = productSlot.product_varient ? productSlot.product_varient.offer_price :
                            (productSlot.sample_variant ? productSlot.sample_variant.offer_price :
                                (productSlot.design_variant ? productSlot.design_variant.offer_price : 0));
                        return `${price * productSlot.quantity}`;
                    }),

                    productSlot.order.customer.user_addresses[0].address_line_one,
                    gridjs.html(
                        productSlot.delivery_status == 0
                            ? `<div class="text-info" style="font-weight:bold">Billing</div>
        `
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
                                ? `
                            <div class="btn btn-sm btn-danger">Cancelled</div>`
                                : `<button
                            data-productSlotid ="${productSlot.id}",
                            data-ogproductSlotid = "${productSlot.order_id}"
                            data-productname= "${productSlot.product ? productSlot.product.product_name : (productSlot.sample ? productSlot.sample.sample_name : (productSlot.design ? productSlot.design.design_name : 'N/A'))}"
                            data-customername= "${productSlot.order.customer.name}"

                            data-deliverypersonid ="${productSlot.delivery_person_id}"
                       class="btn btn-warning  btn-sm text-truncate ms-2 cancel_slot_btn">
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
