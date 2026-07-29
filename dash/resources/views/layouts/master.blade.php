<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Saaluvesa Admin Dashboard" name="description" />
    <meta content="Saaluvesa" name="author" />
    {{-- <link rel="shortcut icon" href="{{ URL::asset('assets/images/yesbe-white.svg') }}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.head-css')
</head>

<body data-layout="vertical" data-sidebar="light">
    {{-- <div class="preloader">
        <div class="prelader_image_container">
            <img src="{{ asset('assets/images/yesbe.svg') }}" alt="preloader_image">
        </div>
    </div> --}}
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        @include('layouts.horizontal')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.right-sidebar')
    @include('components.export_doc_modal')
    @include('layouts.vendor-scripts')
    <script>
    // These functions must be available globally AFTER Bootstrap loads
    function setExportOrderId(orderId) {
        let form = document.getElementById('exportDocForm');
        if (form) {
            form.reset(); // Clear any previously entered data
        }
        document.getElementById('export_order_id').value = orderId;

        // Fetch products to allow individual weight input
        let container = document.getElementById('product_weights_container');
        let productsPromise = Promise.resolve();
        
        if (container) {
            container.innerHTML = '<div class="col-12"><small>Loading product weight inputs...</small></div>';
            productsPromise = fetch('/export/order-products/' + orderId)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            container.innerHTML += `
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">${item.name} Unit Net Weight (Grams)</label>
                                    <input type="number" step="0.01" class="form-control" name="product_weight_${item.id}" value="0.00">
                                </div>
                            `;
                        });
                    } else {
                        container.innerHTML = '<div class="col-12 text-muted"><small>No products found or error loading.</small></div>';
                    }
                })
                .catch(e => {
                    container.innerHTML = '<div class="col-12 text-danger"><small>Failed to load product weights.</small></div>';
                });
        }

        // Fetch Saved Data if exists and populate form
        productsPromise.then(() => {
            fetch('/export/get-form-data/' + orderId)
                .then(response => response.json())
                .then(result => {
                    if (result.success && result.data) {
                        const formData = result.data;
                        for (const key in formData) {
                            if (formData.hasOwnProperty(key)) {
                                let el = form.elements[key];
                                if (el) {
                                    el.value = formData[key];
                                }
                            }
                        }
                    }
                }).catch(e => console.error(e));
        });
    }

    function saveExportData() {
        let form = document.getElementById('exportDocForm');
        let formData = new FormData(form);
        let msg = document.getElementById('save_status_msg');
        
        // Remove tracking keys if any
        formData.delete('view');
        formData.delete('download');
        formData.delete('type');

        fetch('/export/save-form-data', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                msg.style.display = 'inline-block';
                setTimeout(() => { msg.style.display = 'none'; }, 3000);
            } else {
                alert('Error saving data: ' + data.message);
            }
        })
        .catch(e => {
            alert('Request failed');
            console.error(e);
        });
    }

    function submitExportForm(docType, action, invoiceType = 'commercial') {
        let form = document.getElementById('exportDocForm');
        let path = '';
        
        if (docType === 'invoice') {
            path = '/export/commercial-invoice';
        } else if (docType === 'packing') {
            path = '/export/packing-list';
        }
        
        // Remove any existing flags
        form.querySelectorAll('input[name="download"], input[name="view"], input[name="type"]').forEach(el => el.remove());

        // Add invoice type
        let typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = invoiceType;
        form.appendChild(typeInput);

        if (action === 'download') {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'download';
            input.value = '1';
            form.appendChild(input);
            form.removeAttribute('target');
        } else {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'view';
            input.value = '1';
            form.appendChild(input);
            form.target = 'docViewerIframe';
            var viewerModal = new bootstrap.Modal(document.getElementById('docViewerModal'));
            viewerModal.show();
        }
        
        form.action = path;
        form.submit();
    }
    </script>
</body>

</html>
