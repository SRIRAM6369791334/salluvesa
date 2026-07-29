let grid;
let currentData = [];

function renderGrid(data) {
    const gridContainer = document.getElementById("bulk-orders-grid");
    if (!gridContainer) return;

    gridContainer.innerHTML = '';

    if (grid) {
        // We destroy the previous grid if it exists before re-rendering
        gridContainer.innerHTML = '';
    }

    grid = new gridjs.Grid({
        columns: [
            "ID",
            "Customer Info",
            "Order Details",
            "Requested On",
            "Notes / Feedback",
            "Status",
            {
                name: "Actions",
                sort: false,
            }
        ],
        pagination: { limit: 10 },
        sort: true,
        search: true,
        data: data.map((order) => {
            const displayOrderId = order.order_id || `B-${order.id}`;

            const customerInfo = gridjs.html(`
                <div class="text-start">
                    <strong>${order.name}</strong><br>
                    <small class="text-muted"><i class="bx bx-envelope"></i> ${order.email}</small><br>
                    <span class="badge ${order.user_type === 'B2B' ? 'bg-primary' : 'bg-info'} font-size-10 mt-1">${order.user_type}</span>
                </div>
            `);

            const orderDetails = gridjs.html(`
                <div class="text-start d-flex align-items-center gap-2">
                    ${order.custom_image_url ? `
                        <div class="cursor-pointer" onclick="viewImage('${order.custom_image_url}')" title="Click to view">
                            <img src="${order.custom_image_url}" alt="Design" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    ` : `
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; border-radius: 6px; border: 1px dashed #ccc;">
                            <i class="bx bx-image text-muted font-size-20"></i>
                        </div>
                    `}
                    <div>
                        <strong>Qty:</strong> ${order.quantity}<br>
                        <small class="text-muted">Type: ${order.product_type.replace('_', ' ')}</small>
                    </div>
                </div>
            `);

            const notesHtml = gridjs.html(`
                <div class="text-start">
                    <div><strong>User:</strong> ${order.notes ? order.notes.substring(0, 30) + (order.notes.length > 30 ? '...' : '') : '<span class="text-muted">None</span>'}</div>
                    ${order.admin_notes ? `<div class="mt-1"><strong class="text-danger">Admin:</strong> <span title="${order.admin_notes}">${order.admin_notes.substring(0, 25)}...</span></div>` : ''}
                </div>
            `);

            const statusLabel = gridjs.html(`
                ${order.status == 0 ? '<span class="badge bg-warning font-size-12 px-2 py-1"><i class="bx bx-time-five me-1"></i> Pending</span>' :
                    order.status == 1 ? '<span class="badge bg-success font-size-12 px-2 py-1"><i class="bx bx-check-circle me-1"></i> Approved</span>' :
                        '<span class="badge bg-danger font-size-12 px-2 py-1"><i class="bx bx-x-circle me-1"></i> Rejected</span>'}
            `);

            const actions = gridjs.html(`
                <div class="d-flex gap-2 justify-content-center">
                    <a href="viewProductdetail/${displayOrderId}" target="_blank">
                        <button type="button" class="btn btn-info btn-sm waves-effect waves-light" title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                    </a>
                    <button class="btn btn-primary btn-sm waves-effect waves-light" title="Generate Documents" data-bs-toggle="modal" data-bs-target="#exportDocModal" onclick="setExportOrderId('${displayOrderId}')">
                        <i class="bx bx-receipt"></i>
                    </button>
                    ${order.status == 0 ? `
                        <button class="btn btn-success btn-sm waves-effect waves-light" onclick="approveOrder(${order.id})" title="Approve">
                            <i class="bx bx-check"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm waves-effect waves-light" onclick="showRejectModal(${order.id})" title="Reject">
                            <i class="bx bx-x"></i>
                        </button>
                    ` : `
                        <span class="text-muted font-size-12 mt-1">Processed</span>
                    `}
                </div>
            `);

            return [
                displayOrderId,
                customerInfo,
                orderDetails,
                gridjs.html(`<small class="text-muted">${order.requested_on}</small>`),
                notesHtml,
                statusLabel,
                actions
            ];
        }),
        style: {
            table: { border: "1px solid #e2e5e8" },
            th: { "background-color": "#f8f9fa", color: "#495057", "text-align": "center", "font-weight": "600" },
            td: { "text-align": "center", "vertical-align": "middle" }
        }
    }).render(gridContainer);
}

function viewImage(url) {
    document.getElementById('preview_image').src = url;
    document.getElementById('download_link').href = url;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function approveOrder(id) {
    Swal.fire({
        title: 'Approve Bulk Order?',
        text: "The user will be notified via email about the approval.",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#34c38f',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Yes, Approve!'
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(id, 1);
        }
    });
}

function showRejectModal(id) {
    document.getElementById('reject_order_id').value = id;
    document.getElementById('reject_reason').value = '';
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

document.getElementById('rejectForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('reject_order_id').value;
    const reason = document.getElementById('reject_reason').value;

    updateStatus(id, 2, reason);
    bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
});

function updateStatus(id, status, notes = '') {
    Swal.fire({
        title: 'Processing...',
        text: 'Updating status and sending email notification.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '/bulk-orders/update-status',
        method: 'POST',
        data: {
            id: id,
            status: status,
            admin_notes: notes,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            Swal.fire('Updated!', response.message, 'success');
            currentData = response.bulkOrders;
            // Re-apply current filter
            const activeFilter = document.querySelector('.filter-btn.active')?.dataset?.status || 'all';
            applyFilter(activeFilter);
        },
        error: function (xhr) {
            const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
            Swal.fire('Error!', msg, 'error');
        }
    });
}

function applyFilter(status) {
    // Update button styles
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.status === status) {
            btn.classList.add('active', 'fw-bold', 'text-white');
            if (status === 'all') btn.className = 'btn btn-primary btn-sm filter-btn me-2 active fw-bold text-white';
            if (status === '0') btn.className = 'btn btn-warning btn-sm filter-btn me-2 active fw-bold text-white';
            if (status === '1') btn.className = 'btn btn-success btn-sm filter-btn me-2 active fw-bold text-white';
            if (status === '2') btn.className = 'btn btn-danger btn-sm filter-btn me-2 active fw-bold text-white';
        } else {
            if (btn.dataset.status === 'all') btn.className = 'btn btn-outline-primary btn-sm filter-btn me-2';
            if (btn.dataset.status === '0') btn.className = 'btn btn-outline-warning btn-sm filter-btn me-2';
            if (btn.dataset.status === '1') btn.className = 'btn btn-outline-success btn-sm filter-btn me-2';
            if (btn.dataset.status === '2') btn.className = 'btn btn-outline-danger btn-sm filter-btn me-2';
        }
    });

    // Filter data
    let filteredData = currentData;
    if (status !== 'all') {
        filteredData = currentData.filter(order => order.status == status);
    }
    renderGrid(filteredData);
}

// Event listeners for filters
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        applyFilter(e.target.dataset.status);
    });
});

// Initial render
document.addEventListener("DOMContentLoaded", function () {
    currentData = window.bulkOrders || [];
    applyFilter('all');
});
