$(function () {
    $(document).on("click", ".edit_btn", function () {
        $("#customer_name_input").val($(this).attr("data-customername"));
        $("#order_id_input").val($(this).attr("data-ogmilkOrderid"));
        $("#cusid").val($(this).attr("data-customerid"));
        $("#cusnum").val($(this).attr("data-cusnum"));
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
        $(".add_submit_btn").attr("disabled", "true");
        changestatussubmit(event);
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

$(document).ready(function () {
    loadOrderTable();

    $(
        "#employee_permission_filter_select, #employee_permission_from_date, #employee_permission_to_date"
    ).on("change", function () {
        $("#orderTable").DataTable().ajax.reload();
    });
});

function loadOrderTable() {
    $("#orderTable").DataTable({
        processing: true,
        serverSide: true,
        destroy: true, // Important if reinitializing
        ajax: {
            url: "/orders/fetchtotalorders",
            type: "POST",
            data: function (d) {
                d.user = $("#employee_permission_filter_select").val();
                d.from = $("#employee_permission_from_date").val();
                d.to = $("#employee_permission_to_date").val();
                d._token = $('meta[name="csrf-token"]').attr("content");
            },
        },
        columns: [
            { data: "sno" },
            { data: "orderdate" },
            { data: "orderid" },
            { data: "username" },
            { data: "total" },
        ],
        responsive: true,
        pageLength: 10,
        dom: "Bfrtip",
        buttons: ["excelHtml5", "csvHtml5", "pdfHtml5", "print", "colvis"],
    });
}
