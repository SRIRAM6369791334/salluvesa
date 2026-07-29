const addValidator = new JustValidate("#addCategoriesForm", {
    validateBeforeSubmitting: true,
});
const editValidator = new JustValidate("#editCategoriesForm", {
    validateBeforeSubmitting: true,
});

$("#add_categoryImage").on("change", function () {
    const file = this.files[0];
    if (file && file.type.startsWith("image/")) {
        let img = new Image();
        img.src = window.URL.createObjectURL(file);

        img.decode().then(() => {
            if (!(img.width === 191 && img.height === 296)) {
                console.log("hi");
                $(".product_remove_btn").trigger("click");
                addValidator.showErrors({
                    "#add_categoryImage":
                        "*Image resolution should be below 191 × 296px",
                });
            }
        });
    }
});
// $("#add_categorybanner").on("change", function () {
//     const file = this.files[0];
//     if (file && file.type.startsWith("image/")) {
//         let img = new Image();
//         img.src = window.URL.createObjectURL(file);

//         img.decode().then(() => {
//             if (!(img.width === 1320 && img.height === 250)) {
//                 console.log("hi");
//                 $(".bproduct_remove_btn").trigger("click");
//                 addValidator.showErrors({
//                     "#add_categorybanner":
//                         "*Image resolution should be below 1320 * 250",
//                 });
//             }
//         });
//     }
// });
// $("#add_collectionImage").on("change", function () {
//     const file = this.files[0];
//     if (file && file.type.startsWith("image/")) {
//         let img = new Image();
//         img.src = window.URL.createObjectURL(file);

//         img.decode().then(() => {
//             if (!(img.width === 512 && img.height === 512)) {
//                 console.log("hi");
//                 $(".cproduct_remove_btn").trigger("click");
//                 addValidator.showErrors({
//                     "#add_collectionImage":
//                         "*Image resolution should be below 512 * 512",
//                 });
//             }
//         });
//     }
// });

$("#edit_categoryImage").on("change", function () {
    const file = this.files[0];
    if (file && file.type.startsWith("image/")) {
        let img = new Image();
        img.src = window.URL.createObjectURL(file);

        img.decode().then(() => {
            if (!(img.width === 191 && img.height === 296)) {
                console.log("hi");
                $(".edit_product_remove_btn").trigger("click");
                editValidator.showErrors({
                    "#edit_categoryImage":
                        "*Image resolution should be below 191 × 296px",
                });
            }
        });
    }
});
// $("#edit_categorybanner").on("change", function () {
//     const file = this.files[0];
//     if (file && file.type.startsWith("image/")) {
//         let img = new Image();
//         img.src = window.URL.createObjectURL(file);

//         img.decode().then(() => {
//             if (!(img.width === 1320 && img.height === 250)) {
//                 console.log("hi");
//                 $(".bedit_product_remove_btn").trigger("click");
//                 editValidator.showErrors({
//                     "#add_categorybanner":
//                         "*Image resolution should be below 1320 * 250",
//                 });
//             }
//         });
//     }
// });
// $("#edit_collectionImage").on("change", function () {
//     const file = this.files[0];
//     if (file && file.type.startsWith("image/")) {
//         let img = new Image();
//         img.src = window.URL.createObjectURL(file);

//         img.decode().then(() => {
//             if (!(img.width === 191 && img.height === 296)) {
//                 console.log("hi");
//                 $(".cedit_product_remove_btn").trigger("click");
//                 editValidator.showErrors({
//                     "#edit_collectionImage":
//                         "*Image resolution should be below 191 × 296px",
//                 });
//             }
//         });
//     }
// });

addValidator
    .addField("#add_categoriesname", [
        {
            rule: "required",
            errorMessage: "*Categories Name Field is required",
        },
        {

            rule: 'minLength',
            value: 3,
            errorMessage: '*Categories Name should be at least 3 character long',

        },
        {
                rule: 'maxLength',
                value: 50,
                errorMessage: '*Categories Name should be at Maximum 50 character long',

        },
        // {
        //     rule: "customRegexp",
        //     value: /^[a-zA-Z]+$/,
        //     errorMessage:
        //         "*Categories Name should contain only alphabetic characters",
        // },
    ])
    .addField("#add_categoryImage", [
        {
            rule: "minFilesCount",
            value: 1,
            errorMessage: "*Upload Category Image",
        },
        {
            rule: "files",
            value: {
                files: {
                    extensions: ["jpeg", "jpg", "png"],
                    maxSize: 10000000,
                    minSize: 0,
                },
            },
            errorMessage: "*Unsupported file format or file too large",
        },
        {
            validator: (value, fields) => {
                return new Promise((resolve) => {
                    const file = fields["#add_categoryImage"].elem.files[0];
                    if (!file || !file.type.startsWith("image/")) return resolve(false);

                    const img = new Image();
                    img.onload = () => {
                        const isExact = img.width === 191 && img.height === 296;
                        if (!isExact) $(".product_remove_btn").trigger("click"); // optional
                        resolve(isExact);
                    };
                    img.onerror = () => resolve(false);
                    img.src = URL.createObjectURL(file);
                });
            },
            errorMessage: "*Image resolution must be exactly 191 × 296px",
        },
    ])
    // .addField("#add_collectionImage", [
    //     {
    //         rule: "minFilesCount",
    //         value: 1,
    //         errorMessage: "*Upload Collection Image",
    //     },
    //     {
    //         rule: "files",
    //         value: {
    //             files: {
    //                 extensions: ["jpeg", "jpg", "png"],
    //                 maxSize: 10000000,
    //                 minSize: 0,
    //             },
    //         },
    //         errorMessage: "*Unsupported file format or file too large",
    //     },
    //     {
    //         validator: (value, fields) => {
    //             return new Promise((resolve) => {
    //                 const file = fields["#add_collectionImage"].elem.files[0];
    //                 if (!file || !file.type.startsWith("image/")) return resolve(false);

    //                 const img = new Image();
    //                 img.onload = () => {
    //                     const isExact = img.width === 512 && img.height === 512;
    //                     if (!isExact) $(".cproduct_remove_btn").trigger("click"); // optional
    //                     resolve(isExact);
    //                 };
    //                 img.onerror = () => resolve(false);
    //                 img.src = URL.createObjectURL(file);
    //             });
    //         },
    //         errorMessage: "*Image resolution must be exactly 512 × 512",
    //     },
    // ])
    // .addField("#add_categorybanner", [
    //     {
    //         rule: "minFilesCount",
    //         value: 1,
    //         errorMessage: "*Upload Category Banner",
    //     },
    //     {
    //         rule: "files",
    //         value: {
    //             files: {
    //                 extensions: ["jpeg", "jpg", "png"],
    //                 maxSize: 10000000,
    //                 minSize: 0,
    //             },
    //         },
    //         errorMessage: "*Unsupported file format or file too large",
    //     },
    //     {
    //         validator: (value, fields) => {
    //             return new Promise((resolve) => {
    //                 const file = fields["#add_categorybanner"].elem.files[0];
    //                 if (!file || !file.type.startsWith("image/")) return resolve(false);

    //                 const img = new Image();
    //                 img.onload = () => {
    //                     const isExact = img.width === 1320 && img.height === 250;
    //                     if (!isExact) $(".bproduct_remove_btn").trigger("click"); // optional
    //                     resolve(isExact);
    //                 };
    //                 img.onerror = () => resolve(false);
    //                 img.src = URL.createObjectURL(file);
    //             });
    //         },
    //         errorMessage: "*Image resolution must be exactly 1320 × 250",
    //     },
    // ])
    .onSuccess((event) => {
        $(".add_submit_btn").attr("disabled", true).html("Uploading...");
        addCategoriesFormSubmit(event);
    });

editValidator
    .addField("#edit_categoriesname", [
        // {
        //     rule: "required",
        //     errorMessage: "*Categories Name Field is required",
        // },
        {

            rule: 'minLength',
            value: 3,
            errorMessage: '*Categories Name should be at least 3 character long',

        },
        {
                rule: 'maxLength',
                value: 50,
                errorMessage: '*Categories Name should be at Maximum 50 character long',

        },


    ])
    .addField("#edit_categoryImage", [
        // {
        //     rule: "minFilesCount",
        //     value: 1,
        //     errorMessage: "*Upload Category Image",
        // },
        {
            rule: "files",
            value: {
                files: {
                    extensions: ["jpeg", "jpg", "png"],
                    maxSize: 10000000,
                    minSize: 0,
                },
            },
            errorMessage: "*Unsupported file format or file too large",
        },
        {
            validator: (value, fields) => {
                return new Promise((resolve) => {
                    const file = fields["#edit_categoryImage"].elem.files[0];
                    if (!file || !file.type.startsWith("image/")) return resolve(false);

                    const img = new Image();
                    img.onload = () => {
                        const isExact = img.width === 191 && img.height === 296;
                        if (!isExact) $(".edit_product_remove_btn").trigger("click"); // optional
                        resolve(isExact);
                    };
                    img.onerror = () => resolve(false);
                    img.src = URL.createObjectURL(file);
                });
            },
            errorMessage: "*Image resolution must be exactly 191 × 296px",
        },
    ])
    // .addField("#edit_collectionImage", [
    //     // {
    //     //     rule: "minFilesCount",
    //     //     value: 1,
    //     //     errorMessage: "*Upload Collection Image",
    //     // },
    //     {
    //         rule: "files",
    //         value: {
    //             files: {
    //                 extensions: ["jpeg", "jpg", "png"],
    //                 maxSize: 10000000,
    //                 minSize: 0,
    //             },
    //         },
    //         errorMessage: "*Unsupported file format or file too large",
    //     },
    //     {
    //         validator: (value, fields) => {
    //             return new Promise((resolve) => {
    //                 const file = fields["#edit_collectionImage"].elem.files[0];
    //                 if (!file || !file.type.startsWith("image/")) return resolve(false);

    //                 const img = new Image();
    //                 img.onload = () => {
    //                     const isExact = img.width === 512 && img.height === 512;
    //                     if (!isExact) $(".cedit_product_remove_btn").trigger("click"); // optional
    //                     resolve(isExact);
    //                 };
    //                 img.onerror = () => resolve(false);
    //                 img.src = URL.createObjectURL(file);
    //             });
    //         },
    //         errorMessage: "*Image resolution must be exactly 512 × 512",
    //     },
    // ])
    // .addField("#edit_categorybanner", [
    //     // {
    //     //     rule: "minFilesCount",
    //     //     value: 1,
    //     //     errorMessage: "*Upload Category Banner",
    //     // },
    //     {
    //         rule: "files",
    //         value: {
    //             files: {
    //                 extensions: ["jpeg", "jpg", "png"],
    //                 maxSize: 10000000,
    //                 minSize: 0,
    //             },
    //         },
    //         errorMessage: "*Unsupported file format or file too large",
    //     },
    //     {
    //         validator: (value, fields) => {
    //             return new Promise((resolve) => {
    //                 const file = fields["#edit_categorybanner"].elem.files[0];
    //                 if (!file || !file.type.startsWith("image/")) return resolve(false);

    //                 const img = new Image();
    //                 img.onload = () => {
    //                     const isExact = img.width === 1320 && img.height === 250;
    //                     if (!isExact) $(".bedit_product_remove_btn").trigger("click"); // optional
    //                     resolve(isExact);
    //                 };
    //                 img.onerror = () => resolve(false);
    //                 img.src = URL.createObjectURL(file);
    //             });
    //         },
    //         errorMessage: "*Image resolution must be exactly 1320 × 250",
    //     },
    // ])
    .onSuccess((event) => {
        $(".edit_submit_btn").attr("disabled", true).html("Uploading...");
        editCategoriesFormSubmit(event);
    });

    // .onSuccess((event) => {
    //     $(".edit_submit_btn").attr("disabled", "true");
    //     $(".edit_submit_btn").html("Uploading.....");
    //     editCategoriesFormSubmit(event);
    // });

const gridNew = new gridjs.Grid({
    columns: [
        "S.NO",
        "Category Name",
        "Category Image",
       

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
    data: categories.map((categories, index) => {
        return [
            index + 1,
            categories.category_name,
            gridjs.html(
                `
                <div class="text-center">
                <img class="category_image_el" src="images/${categories.category_image}"  alt ="categgory_image${index}" style="width:50px"/>
            </div>

            `
            ),
            // gridjs.html(
            //     `
            //     <div class="text-center">
            //     <img class="category_image_el" src="images/${categories.category_banner}"  alt ="categgory_banner${index}" style="width:50px"/>
            // </div>

            // `
            // ),
            // gridjs.html(
            //     `
            //     <div class="text-center">
            //     <img class="category_image_el" src="images/${categories.category_icon}"  alt ="category_icon${index}" style="width:50px"/>
            // </div>

            // `
            // ),


            gridjs.html(

                categories.status == 1

                ? `<div> <button data-bs-toggle="modal"
                data-categoriesid ="${categories.id}"
                data-categoriesname="${categories.category_name}"
                data-categoriesimage ="${categories.category_image}" data-categoriesicon ="${categories.category_icon}" data-categoriesbanner ="${categories.category_banner}" data-phonenumber="${categories.phone_number}" data-bs-target="#editCategoriesModal"  class="btn btn-secondary edit_btn ">Edit</button>

                </div>`
                : `<div> <button data-bs-toggle="modal"
                data-categoriesid ="${categories.id}"
                data-categoriesname="${categories.category_name}"
                data-categoriesimage ="${categories.category_image}" data-categoriesicon ="${categories.category_icon}" data-categoriesbanner ="${categories.category_banner}" data-phonenumber="${categories.phone_number}" data-bs-target="#editCategoriesModal"  class="btn btn-secondary edit_btn ">Edit</button>

                <button class="btn btn-danger delete_btn" data-categoriesid = ${categories.id}>Delete</button> </div>`

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

function gridjsReRender(categories) {
    if (gridNew) gridNew.config.plugin.remove("pagination");
    if (gridNew) gridNew.config.plugin.remove("search");
    gridNew
        .updateConfig({
            data: categories.map((categories, index) => {
                return [
                    index + 1,
                    categories.category_name,
                    gridjs.html(
                        `
                        <div class="text-center">
                        <img class="category_image_el" src="images/${categories.category_image}"  alt ="categgory_image${index}" style="width:50px"/>
                    </div>

                    `
                    ),
                    // gridjs.html(
                    //     `
                    //     <div class="text-center">
                    //     <img class="category_image_el" src="images/${categories.category_banner}"  alt ="categgory_banner${index}" style="width:50px"/>
                    // </div>

                    // `
                    // ),
            // gridjs.html(
            //     `
            //     <div class="text-center">
            //     <img class="category_image_el" src="images/${categories.category_icon}"  alt ="category_icon${index}" style="width:50px"/>
            // </div>

            // `
            // ),


                    gridjs.html(
                        categories.status == 1

                        ? `<div> <button data-bs-toggle="modal"
                        data-categoriesid ="${categories.id}"
                        data-categoriesname="${categories.category_name}"
                        data-categoriesimage ="${categories.category_image}" data-categoriesicon ="${categories.category_icon}" data-categoriesbanner ="${categories.category_banner}" data-phonenumber="${categories.phone_number}" data-bs-target="#editCategoriesModal"  class="btn btn-secondary edit_btn ">Edit</button>

                        </div>`
                        : `<div> <button data-bs-toggle="modal"
                        data-categoriesid ="${categories.id}"
                        data-categoriesname="${categories.category_name}"
                        data-categoriesimage ="${categories.category_image}" data-categoriesicon ="${categories.category_icon}" data-categoriesbanner ="${categories.category_banner}" data-phonenumber="${categories.phone_number}" data-bs-target="#editCategoriesModal"  class="btn btn-secondary edit_btn ">Edit</button>

                        <button class="btn btn-danger delete_btn" data-categoriesid = ${categories.id}>Delete</button> </div>`

                        ),

                ];
            }),
        })
        .forceRender();
}

function addCategoriesFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "categories",
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            $(".add_submit_btn").removeAttr("disabled");
            $(".add_submit_btn").html("Submit");
            const updatedCategories = response.categories;
            $("#addCategoriesForm")[0].reset();
            $("#addCategoriesModal").hide();
            $(".product_remove_btn").trigger("click");
            $(".bproduct_remove_btn").trigger("click");
            $(".cproduct_remove_btn").trigger("click");
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";

            gridjsReRender(updatedCategories);
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

function editCategoriesFormSubmit(e) {
    const formdata = new FormData(e.target);
    $.ajax({
        url: "updateCategories/" + $("#edit_categories_id").val(),
        method: "POST",
        dataType: "json",
        data: formdata,
        processData: false,
        contentType: false,
        success: function (response) {
            const updatedCategories = response.categories;
            $("#editCategoriesForm")[0].reset();
            $("#editCategoriesModal").hide();
            $(".modal-backdrop").remove();
            document.body.style.overflowY = "scroll";
            gridjsReRender(updatedCategories);
            $(".edit_submit_btn").removeAttr("disabled");
            $(".edit_submit_btn").html("Update");
            $(".edit_product_remove_btn").trigger("click");
            $(".bedit_product_remove_btn").trigger("click");
            $(".cedit_product_remove_btn").trigger("click");
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
    $(".bx-show").hide();
    $(".icon").on("click", function () {
        const parentEl = $(this).closest(".input-group");
        var input = $(this).closest(".input-group").find("input");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $(parentEl).find(".bx-hide").hide();
            $(parentEl).find(".bx-show").show();
        } else {
            input.attr("type", "password");
            $(parentEl).find(".bx-show").hide();
            $(parentEl).find(".bx-hide").show();
        }
    });

    $(document).on("click", ".edit_btn", function () {
        const imagePath = $(this).attr("data-categoriesimage");
         const imagbanPath = $(this).attr("data-categoriesbanner");
         const imagiconPath = $(this).attr("data-categoriesicon");
        console.log(imagePath);
        console.log(imagbanPath);
        console.log(imagiconPath);
        $("#edit_categories_id").val($(this).attr("data-categoriesid"));
        $("#edit_categoriesname").val($(this).attr("data-categoriesname"));
        $(".edit_preview_image").attr("src", `images/${imagePath}`);
        // $(".edit_preview_banner").attr("src", `images/${imagbanPath}`);
        // $(".edit_preview_icon").attr("src", `images/${imagiconPath}`);
    });

    $(document).on("click", ".delete_btn", function () {
        const id = $(this).attr("data-categoriesid");
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
                    url: "destroyCategories/" + id,
                    method: "post",
                    dataType: "json",
                    success: function (response) {
                        const updatedCategories = response.categories;
                        gridjsReRender(updatedCategories);
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
});

$(function () {
    const backupHtml = $(".preview-container").html();

    // Listen for changes to the input field
    $("#add_categoryImage").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger product_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".preview-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".preview-container").html(backupHtml);
                    // Clear the input field
                    $("#add_categoryImage").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

$(function () {
    const backupHtml = $(".banner_preview-container").html();

    // Listen for changes to the input field
    $("#add_categorybanner").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger bproduct_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".banner_preview-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".banner_preview-container").html(backupHtml);
                    // Clear the input field
                    $("#add_categorybanner").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});
$(function () {
    const backupHtml = $(".icon_preview-container").html();

    // Listen for changes to the input field
    $("#add_collectionImage").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger cproduct_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".icon_preview-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".icon_preview-container").html(backupHtml);
                    // Clear the input field
                    $("#add_collectionImage").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

$(function () {
    const backupHtml = $(".edit_preview-container").html();

    // Listen for changes to the input field
    $("#edit_categoryImage").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger edit_product_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".edit_preview-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".edit_preview-container").html(backupHtml);
                    // Clear the input field
                    $("#edit_categoryImage").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

$(function () {
    const backupHtml = $(".edit_banner-container").html();

    // Listen for changes to the input field
    $("#edit_categorybanner").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger bedit_product_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".edit_banner-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".edit_banner-container").html(backupHtml);
                    // Clear the input field
                    $("#edit_categorybanner").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

$(function () {
    const backupHtml = $(".edit_icon-container").html();

    // Listen for changes to the input field
    $("#edit_collectionImage").on("change", function () {
        // Get the selected file
        var file = $(this)[0].files[0];

        // Check if the file is an image
        if (file.type.match("image.*")) {
            // Create a new FileReader object
            var reader = new FileReader();

            // Set up the FileReader to load the image
            reader.onload = function (e) {
                // Create a new image element
                var img = $("<img>").attr("src", e.target.result);

                // Create a remove button
                var removeBtn = $("<button>")
                    .addClass("btn btn-danger cedit_product_remove_btn mt-2")
                    .text("Remove");

                // Add the image and remove button to the preview container
                $(".edit_icon-container").empty().append(img).append(removeBtn);

                // Listen for clicks on the remove button
                removeBtn.on("click", function (e) {
                    e.preventDefault();

                    // Remove the image from the preview container
                    $(".edit_icon-container").html(backupHtml);
                    // Clear the input field
                    $("#edit_collectionImage").val("");
                });
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    });
});

// $(function () {
//     const backupHtml = $(".edit_preview-container").html();

//     $("#edit_categoryImage").on("change", function () {
//         var file = $(this)[0].files[0];

//         if (file.type.match("image.*")) {
//             var reader = new FileReader();

//             reader.onload = function (e) {
//                 var img = $("<img>").attr("src", e.target.result);

//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger edit_product_remove_btn mt-2")
//                     .text("Remove");

//                 $(".edit_preview-container")
//                     .empty()
//                     .append(img)
//                     .append(removeBtn);

//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();

//                     $(".edit_preview-container").html(backupHtml);
//                     $("#edit_categoryImage").val("");
//                 });
//             };

//             reader.readAsDataURL(file);

//             var image = new Image();
//             image.src = URL.createObjectURL(file);
//             image.onload = function() {
//                 if (image.width === 512 || image.height === 512) {
//                     alert("Image dimensions must be 512x512 pixels or less.");
//                     $("#edit_categoryImage").val("");
//                     $(".edit_preview-container").html("");
//                 }
//             };
//     }
// });
// });
// $(function () {
//     const backupHtml = $(".edit_banner-container").html();

//     $("#edit_categorybanner").on("change", function () {
//         var file = $(this)[0].files[0];

//         if (file.type.match("image.*")) {
//             var reader = new FileReader();

//             reader.onload = function (e) {
//                 var img = $("<img>").attr("src", e.target.result);

//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger bedit_product_remove_btn mt-2")
//                     .text("Remove");

//                 $(".edit_banner-container")
//                     .empty()
//                     .append(img)
//                     .append(removeBtn);

//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();

//                     $(".edit_banner-container").html(backupHtml);
//                     $("#edit_categorybanner").val("");
//                 });
//             };

//             reader.readAsDataURL(file);

//             var image = new Image();
//             image.src = URL.createObjectURL(file);
//             image.onload = function() {
//                 if (image.width === 1320 || image.height === 250) {
//                     alert("Image dimensions must be 1320 x 250 pixels or less.");
//                     $("#edit_categorybanner").val("");
//                     $(".edit_banner-container").html("");
//                 }
//             };
//     }
// });
// });

// $(function () {
//     const backupHtml = $(".edit_preview-container").html();

//     // Listen for changes to the input field
//     $("#edit_categoryImage").on("change", function () {
//         // Get the selected file
//         var file = $(this)[0].files[0];

//         // Check if the file is an image
//         if (file.type.match("image.*")) {
//             // Create a new FileReader object
//             var reader = new FileReader();

//             // Set up the FileReader to load the image
//             reader.onload = function (e) {
//                 // Create a new image element
//                 var img = $("<img>").attr("src", e.target.result);

//                 // Create a remove button
//                 var removeBtn = $("<button>")
//                     .addClass("btn btn-danger edit_product_remove_btn mt-2")
//                     .text("Remove");

//                 // Add the image and remove button to the preview container
//                 $(".edit_preview-container")
//                     .empty()
//                     .append(img)
//                     .append(removeBtn);

//                 // Listen for clicks on the remove button
//                 removeBtn.on("click", function (e) {
//                     e.preventDefault();

//                     // Remove the image from the preview container
//                     $(".edit_preview-container").html(backupHtml);
//                     // Clear the input field
//                     $("#edit_categoryImage").val("");
//                 });
//             };

//             // Read the selected file as a data URL
//             reader.readAsDataURL(file);
//         }
//     });
// });
