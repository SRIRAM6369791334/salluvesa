const addValidator = new JustValidate("#addDesignForm", {
    validateBeforeSubmitting: true,
});
const editValidator = new JustValidate("#editDesignForm", {
    validateBeforeSubmitting: true,
});







// Custom Validator for Image Dimensions (1024x1024)
const imageDimensionValidator = (file) => {
    return new Promise((resolve) => {
        if (!file || !file.type.startsWith("image/")) {
            resolve(true); // Let other validators handle type/presence
            return;
        }
        const img = new Image();
        img.onload = () => {
            resolve(img.width === 1024 && img.height === 1024);
        };
        img.onerror = () => {
            resolve(false);
        };
        img.src = URL.createObjectURL(file);
    });
};

addValidator
    .addField("#add_designTitle", [
        { rule: "required", errorMessage: "*Title is required" },
        { rule: "maxLength", value: 15, errorMessage: "*Max 15 characters" },
    ])
    .addField("#add_designTag", [
        { rule: "required", errorMessage: "*Tag is required" },
        { rule: "maxLength", value: 15, errorMessage: "*Max 15 characters" },
    ])
    .addField("#add_designType", [
        { rule: "required", errorMessage: "*Type is required" },
        { rule: "maxLength", value: 20, errorMessage: "*Max 20 characters" },
    ])
    .addField("#add_designPrice", [
        { rule: "required", errorMessage: "*Price is required" },
    ])
    .addField("#add_designDescription", [
        { rule: "required", errorMessage: "*Description is required" },
        { rule: "maxLength", value: 100, errorMessage: "*Max 100 characters" },
    ])
    .addField("#add_designImage", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Upload Image",
        },
        {
            rule: "files",
            value: {
                files: {
                    extensions: ["jpeg", "jpg", "png", "webp"],
                    maxSize: 5000000,
                },
            },
            errorMessage: "*Unsupported File Format or File size too large",
        },
        {
            validator: (value, fields) => {
                const element = document.getElementById("add_designImage");
                const file = element.files[0];
                return imageDimensionValidator(file);
            },
            errorMessage: "*Image must be exactly 1024x1024 pixels",
        },
    ])
    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", "true");
        $(".add_submit_btn").html("Uploading.....");
        addDesignFormSubmit(event);
    });

editValidator
    .addField("#edit_designTitle", [
        { rule: "required", errorMessage: "*Title is required" },
        { rule: "maxLength", value: 15, errorMessage: "*Max 15 characters" },
    ])
    .addField("#edit_designTag", [
        { rule: "required", errorMessage: "*Tag is required" },
        { rule: "maxLength", value: 15, errorMessage: "*Max 15 characters" },
    ])
    .addField("#edit_designType", [
        { rule: "required", errorMessage: "*Type is required" },
        { rule: "maxLength", value: 20, errorMessage: "*Max 20 characters" },
    ])
    .addField("#edit_designPrice", [
        { rule: "required", errorMessage: "*Price is required" },
    ])
    .addField("#edit_designDescription", [
        { rule: "required", errorMessage: "*Description is required" },
        { rule: "maxLength", value: 100, errorMessage: "*Max 100 characters" },
    ])
    .addField("#edit_designImage", [
        {
            rule: "files",
            value: {
                files: {
                    extensions: ["jpeg", "jpg", "png", "webp"],
                    maxSize: 5000000,
                },
            },
            errorMessage: "*Unsupported File Format or File size too large",
        },
        {
            validator: (value, fields) => {
                const element = document.getElementById("edit_designImage");
                const file = element.files[0];
                if (!file) return true; // Optional on edit
                return imageDimensionValidator(file);
            },
            errorMessage: "*Image must be exactly 1024x1024 pixels",
        },
    ])
    .onSuccess((event) => {
        $(".edit_submit_btn").attr("disabled", "true");
        $(".edit_submit_btn").html("Uploading.....");
        editDesignFormSubmit(event);
    });

const gridNew = new gridjs.Grid({
    columns: [
        { name: "Image", sort: false },
        { name: "Title", sort: false },
        { name: "Tag", sort: false },
        { name: "Type", sort: false },
        { name: "Price", sort: false },
        { name: "Description", sort: false },
        {
            name: "Action",
            sort: false,
        },
    ],
    sort: !0,
    search: !0,
    pagination: {
        limit: 10,
    },
    data: designs.map((design, index) => {
        return [
            gridjs.html(
                `
                <div class="text-center sortable-row" data-id="${design.id}">
                <img class="bannerImage_image_el gridImage" src="images/${design.image}"  alt ="design_image${index}" style="max-width: 100px; max-height: 100px;"/>
            </div>

            `
            ),
            design.title || '',
            design.tag || '',
            design.type || '',
            design.price || '',
            design.description || '',
            gridjs.html(
                `<div> <button data-bs-toggle="modal"
                data-designid ="${design.id}"
                data-designimage ="${design.image}"
                data-designtitle ="${design.title || ''}"
                data-designtag ="${design.tag || ''}"
                data-designtype ="${design.type || ''}"
                data-designprice ="${design.price || ''}"
                data-designsize ="${design.size || ''}"
                data-designclothtypes ="${design.cloth_types || ''}"
                data-designdescription ="${design.description || ''}"
                data-bs-target="#editDesignModal"  class="btn btn-secondary edit_btn ">Edit</button> 
           
                <button class="btn btn-danger delete_btn" data-designid = ${design.id}>Delete</button> </div>`
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

gridNew.render(document.getElementById("table-designs-gridjs"));

function gridjsReRender(designs) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: designs.map((design, index) => {
                return [
                    gridjs.html(
                        `
                        <div class="text-center sortable-row" data-id="${design.id}">
                        <img class="bannerImage_image_el gridImage" src="images/${design.image}"  alt ="design_image${index}" style="max-width: 100px; max-height: 100px;"/>
                    </div>

                    `
                    ),
                    design.title || '',
                    design.tag || '',
                    design.type || '',
                    design.price || '',
                    design.description || '',
                    gridjs.html(
                        `<div> <button data-bs-toggle="modal"
                        data-designid ="${design.id}"
                        data-designimage ="${design.image}"
                        data-designtitle ="${design.title || ''}"
                        data-designtag ="${design.tag || ''}"
                        data-designtype ="${design.type || ''}"
                        data-designprice ="${design.price || ''}"
                        data-designsize ="${design.size || ''}"
                        data-designclothtypes ="${design.cloth_types || ''}"
                        data-designdescription ="${design.description || ''}"
                        data-bs-target="#editDesignModal"  class="btn btn-secondary edit_btn ">Edit</button> 
                        <button class="btn btn-danger delete_btn" data-designid = ${design.id}>Delete</button> </div>`
                    ),
                ];
            }),
        })
        .forceRender();
}

function addDesignFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "designs",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".add_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").html("Submit");
            const updatedDesigns = response.designs;
            $("#addDesignForm")[0].reset();
            $("#addDesignModal").hide();
            $(".product_remove_btn").trigger("click");
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";

            gridjsReRender(updatedDesigns);
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

function editDesignFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "updateDesigns/" + $("#edit_design_id").val(),
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedDesigns = response.designs;
            $("#editDesignForm")[0].reset();
            $("#editDesignModal").hide();
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedDesigns);
            $(".edit_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            $(".edit_product_remove_btn").trigger("click");
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
    $(document).on("click", ".edit_btn", function () {
        const imagePath = $(this).attr("data-designimage");
        $("#edit_design_id").val($(this).attr("data-designid"));
        $("#edit_designTitle").val($(this).attr("data-designtitle"));
        $("#edit_designTag").val($(this).attr("data-designtag"));
        $("#edit_designType").val($(this).attr("data-designtype"));
        $("#edit_designPrice").val($(this).attr("data-designprice"));
        $("#edit_designSize").val($(this).attr("data-designsize"));
        $("#edit_designClothTypes").val($(this).attr("data-designclothtypes"));
        $("#edit_designDescription").val($(this).attr("data-designdescription"));
        $(".edit_preview_image").attr("src", `images/${imagePath}`);
    });

    $(document).on("click", ".delete_btn", function () {
        const id = $(this).attr("data-designid");
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
                    url: "destroyDesigns/" + id,
                    method: "post",
                    dataType: "json",
                    success: function (response) {
                        const updatedDesigns = response.designs;
                        gridjsReRender(updatedDesigns);
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

    // Image preview logic for add form
    const backupHtml = $(".preview-container").html();

    $("#add_designImage").on("change", function () {
        var file = $(this)[0].files[0];
        if (file && file.type.match("image.*")) {
            var img = new Image();
            img.src = window.URL.createObjectURL(file);
            img.onload = function () {
                if (this.width !== 1024 || this.height !== 1024) {
                    Swal.fire("Error", "Image must be exactly 1024x1024 pixels.", "error");
                    $("#add_designImage").val("");
                    $(".preview-container").html(backupHtml);
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = $("<img>").attr("src", e.target.result).css({ maxWidth: "100%", maxHeight: "200px" });
                    var removeBtn = $("<button>")
                        .addClass("btn btn-danger product_remove_btn mt-2")
                        .text("Remove");

                    removeBtn.on("click", function () {
                        $(".preview-container").html(backupHtml);
                        $("#add_designImage").val("");
                    });

                    $(".preview-container").empty().append(img).append("<br>").append(removeBtn);
                };
                reader.readAsDataURL(file);
            };
        }
    });

    const editBackupHtml = $(".edit_preview-container").html();
    $("#edit_designImage").on("change", function () {
        var file = $(this)[0].files[0];
        if (file && file.type.match("image.*")) {
            var img = new Image();
            img.src = window.URL.createObjectURL(file);
            img.onload = function () {
                if (this.width !== 1024 || this.height !== 1024) {
                    Swal.fire("Error", "Image must be exactly 1024x1024 pixels.", "error");
                    $("#edit_designImage").val("");
                    $(".edit_preview-container").html(editBackupHtml);
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = $("<img>").attr("src", e.target.result).css({ maxWidth: "100%", maxHeight: "200px" });
                    var removeBtn = $("<button>")
                        .addClass("btn btn-danger edit_product_remove_btn mt-2")
                        .text("Remove");

                    removeBtn.on("click", function () {
                        $(".edit_preview-container").html(editBackupHtml);
                        $("#edit_designImage").val("");
                    });

                    $(".edit_preview-container").empty().append(img).append("<br>").append(removeBtn);
                };
                reader.readAsDataURL(file);
            };
        }
    });

    // Validations initialized at top

    // Update Edit Button Click Handler
    $(document).on("click", ".edit_btn", function () {
        const designId = $(this).attr("data-designid");
        const item = designs.find(d => d.id == designId);
        if (item) {
            $("#edit_design_id").val(item.id);
            $("#edit_designTitle").val(item.title || '');
            $("#edit_designTag").val(item.tag || '');
            $("#edit_designType").val(item.type || '');
            $("#edit_designPrice").val(item.price || '');
            $("#edit_designSize").val(item.size || '');
            $("#edit_designClothTypes").val(item.cloth_types || '');
            $("#edit_designDescription").val(item.description || '');
            $("#edit_designBadge").val(item.badge || '');
            $("#edit_designBadgeType").val(item.badge_type || '');
            $("#edit_designSortOrder").val(item.sort_order !== undefined ? item.sort_order : 0);
            $("#edit_designIsActive").val(item.is_active !== undefined ? item.is_active : 1);

            let gsm = item.gsm;
            if (typeof gsm === 'string') { try { gsm = JSON.parse(gsm); } catch (e) {} }
            $("#edit_designGsm").val(Array.isArray(gsm) ? gsm.join(',') : (gsm || ''));

            let features = item.features;
            if (typeof features === 'string') { try { features = JSON.parse(features); } catch (e) {} }
            $("#edit_designFeatures").val(Array.isArray(features) ? features.join(',') : (features || ''));

            let colors = item.colors;
            if (typeof colors === 'string') { try { colors = JSON.parse(colors); } catch (e) {} }
            const designColorContainer = $("#edit-colors-container-designs");
            designColorContainer.empty();
            if (Array.isArray(colors) && colors.length > 0) {
                colors.forEach(col => appendColorRow(designColorContainer, col));
            } else {
                appendColorRow(designColorContainer, "#000000");
            }

            $(".edit_preview_image").attr("src", `images/${item.image}`);
        }
    });
});

// --- Dynamic Color Row Management ---
function appendColorRow(container, value = "#000000") {
    const isHex = /^#([0-9A-F]{3}){1,2}$/i.test(value);
    const pickerValue = isHex ? value : "#000000";
    
    const row = `
        <div class="d-flex align-items-center gap-2 mb-2 color-row">
            <input type="color" class="form-control form-control-color color-picker-tool" value="${pickerValue}" title="Choose color" style="width: 60px; height: 38px; padding: 0;">
            <input type="text" class="form-control color-input-value" name="colors[]" value="${value}" placeholder="Color Hex/Name">
            <button type="button" class="btn btn-danger remove-color">Delete</button>
        </div>
    `;
    if ($(container).length) {
        $(container).append(row);
    }
}

$(document).on("click", ".add-color-btn", function () {
    const target = $(this).data("target");
    appendColorRow($("#" + target));
});

$(document).on("click", ".remove-color", function () {
    const container = $(this).closest('.color-row').parent();
    if (container.find('.color-row').length > 1) {
        $(this).closest(".color-row").remove();
    }
});

$(document).on("input", ".color-picker-tool", function () {
    $(this).next(".color-input-value").val($(this).val());
});

$(document).on("input", ".color-input-value", function () {
    const val = $(this).val();
    if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
        $(this).prev(".color-picker-tool").val(val);
    }
});
