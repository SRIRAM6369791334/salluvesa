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
    let currentProductIndex = 0;
    let currentTaxIndex = 0;
    let savedWeightsCache = {};

    function setExportOrderId(orderId) {
        let form = document.getElementById('exportDocForm');
        if (form) {
            form.reset();
        }
        document.getElementById('export_order_id').value = orderId;
        document.getElementById('product_rows_tbody').innerHTML = '';
        document.getElementById('tax_rows_container').innerHTML = '';
        document.getElementById('product_weights_container').innerHTML = '';
        currentProductIndex = 0;
        currentTaxIndex = 0;
        savedWeightsCache = {};

        // Fetch products and saved form data
        Promise.all([
            fetch('/export/order-products/' + orderId).then(r => r.json()).catch(() => []),
            fetch('/export/get-form-data/' + orderId).then(r => r.json()).catch(() => ({ success: false }))
        ]).then(([orderProducts, savedResult]) => {
            const savedData = (savedResult.success && savedResult.data) ? savedResult.data : {};

            // 1. Populate standard form fields
            for (const key in savedData) {
                if (savedData.hasOwnProperty(key)) {
                    let el = form.elements[key];
                    if (el && el.type !== 'file' && typeof savedData[key] !== 'object') {
                        el.value = savedData[key];
                    }
                    if (key.startsWith('product_weight_') || key.startsWith('product_weight_unit_')) {
                        savedWeightsCache[key] = savedData[key];
                    }
                }
            }

            // 2. Load Taxes
            if (savedData.taxes && Array.isArray(savedData.taxes) && savedData.taxes.length > 0) {
                savedData.taxes.forEach(tax => {
                    addTaxRow(tax.name || '', tax.percent || '0.00');
                });
            } else if (savedData.tax_names && Array.isArray(savedData.tax_names)) {
                savedData.tax_names.forEach((name, i) => {
                    addTaxRow(name || '', (savedData.tax_percents && savedData.tax_percents[i]) || '0.00');
                });
            }

            // 3. Load Products (from saved custom_products or original order products)
            if (savedData.custom_products && Array.isArray(savedData.custom_products) && savedData.custom_products.length > 0) {
                savedData.custom_products.forEach(p => {
                    addProductRow(p.name || '', p.quantity || 1, p.price || 0, p.id || null);
                });
            } else if (orderProducts && orderProducts.length > 0) {
                orderProducts.forEach(p => {
                    addProductRow(p.name || 'Product Item', p.quantity || 1, p.price || 0, p.id || null);
                });
            } else {
                addProductRow('Sample Product', 1, 1000);
            }

            if (!savedData.currency_code) {
                const currencySelect = form.elements['currency_code'];
                if (currencySelect) currencySelect.value = 'INR';
            }

            updateCurrencyLabels('INR');
            recalcExportTotals();
        }).catch(err => {
            console.error('Error loading export data:', err);
        });
    }

    function addTaxRow(taxName = '', taxPercent = '0.00') {
        const container = document.getElementById('tax_rows_container');
        const count = container.querySelectorAll('.tax-row').length;
        if (count >= 5) {
            alert('Maximum 5 taxes allowed.');
            return;
        }

        const idx = currentTaxIndex++;
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center mb-2 tax-row';
        row.dataset.taxIndex = idx;
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control form-control-sm tax-name-input" name="taxes[${idx}][name]" value="${taxName}" placeholder="e.g. VAT, GST, Cess" oninput="recalcExportTotals()">
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="number" step="0.01" min="0" max="100" class="form-control tax-percent-input" name="taxes[${idx}][percent]" value="${taxPercent}" placeholder="0.00" oninput="recalcExportTotals()">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeTaxRow(this)">
                    <i class="bx bx-trash"></i> Remove
                </button>
            </div>
        `;
        container.appendChild(row);
        recalcExportTotals();
    }

    function removeTaxRow(btn) {
        btn.closest('.tax-row').remove();
        recalcExportTotals();
    }

    function addProductRow(name = '', quantity = 1, price = 0, id = null) {
        const tbody = document.getElementById('product_rows_tbody');
        const idx = currentProductIndex++;
        const pId = id || ('custom_' + idx);

        const tr = document.createElement('tr');
        tr.className = 'product-row';
        tr.dataset.productIndex = idx;
        tr.dataset.productId = pId;

        tr.innerHTML = `
            <td>
                <input type="hidden" name="custom_products[${idx}][id]" value="${pId}">
                <input type="text" class="form-control form-control-sm product-name-input" name="custom_products[${idx}][name]" value="${name}" placeholder="Product Name" oninput="onProductNameChange(${idx}, this.value)" required>
            </td>
            <td>
                <input type="number" step="0.001" min="0.001" class="form-control form-control-sm product-qty-input" name="custom_products[${idx}][quantity]" value="${quantity}" oninput="recalcExportTotals()" required>
            </td>
            <td>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm product-price-input" name="custom_products[${idx}][price]" value="${price}" oninput="recalcExportTotals()" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm p-1" title="Remove Product" onclick="removeProductRow(this)">
                    <i class="bx bx-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);

        renderWeightRow(idx, pId, name);
        recalcExportTotals();
    }

    function removeProductRow(btn) {
        const tr = btn.closest('.product-row');
        const idx = tr.dataset.productIndex;
        tr.remove();

        const weightItem = document.getElementById(`weight_item_${idx}`);
        if (weightItem) weightItem.remove();

        recalcExportTotals();
    }

    function onProductNameChange(idx, newName) {
        const label = document.getElementById(`weight_label_${idx}`);
        if (label) {
            label.innerText = (newName ? newName : 'Product') + ' Unit Net Weight';
        }
        recalcExportTotals();
    }

    function renderWeightRow(idx, pId, name) {
        const container = document.getElementById('product_weights_container');
        if (container.querySelector('.text-muted')) {
            container.innerHTML = '';
        }

        const savedWeightVal = savedWeightsCache[`product_weight_${pId}`] || '100';
        const savedWeightUnit = savedWeightsCache[`product_weight_unit_${pId}`] || 'g';

        const col = document.createElement('div');
        col.className = 'col-md-6 mb-3 product-weight-item';
        col.id = `weight_item_${idx}`;
        col.innerHTML = `
            <label class="form-label fw-bold small text-truncate d-block" id="weight_label_${idx}">
                ${name ? name : 'Product ' + (idx + 1)} Unit Net Weight
            </label>
            <div class="input-group input-group-sm">
                <input type="number" step="0.001" min="0" class="form-control product-weight-input" name="product_weight_${pId}" value="${savedWeightVal}" placeholder="e.g. 100 or 1.5" oninput="recalcExportTotals()">
                <select class="form-select product-weight-unit" name="product_weight_unit_${pId}" style="max-width: 130px;" onchange="recalcExportTotals()">
                    <option value="g" ${savedWeightUnit === 'g' ? 'selected' : ''}>Grams (g)</option>
                    <option value="kg" ${savedWeightUnit === 'kg' ? 'selected' : ''}>Kilograms (kg)</option>
                    <option value="t" ${savedWeightUnit === 't' ? 'selected' : ''}>Tons (t)</option>
                </select>
            </div>
        `;
        container.appendChild(col);
    }

    function recalcExportTotals() {
        const currencySelect = document.querySelector('select[name="currency_code"]');
        const currency = currencySelect ? currencySelect.value : 'INR';
        updateCurrencyLabels(currency);

        let totalProducts = 0;
        let totalQuantity = 0;
        let totalCost = 0;
        let totalWeightGrams = 0;

        const productRows = document.querySelectorAll('#product_rows_tbody .product-row');
        totalProducts = productRows.length;

        productRows.forEach(tr => {
            const idx = tr.dataset.productIndex;
            const pId = tr.dataset.productId;
            const qty = parseFloat(tr.querySelector('.product-qty-input')?.value || 0);
            const price = parseFloat(tr.querySelector('.product-price-input')?.value || 0);

            totalQuantity += qty;
            totalCost += (qty * price);

            // Read individual weight
            const weightInput = document.querySelector(`input[name="product_weight_${pId}"]`);
            const unitSelect = document.querySelector(`select[name="product_weight_unit_${pId}"]`);
            const rawWeight = parseFloat(weightInput?.value || 0);
            const unit = unitSelect?.value || 'g';

            let weightInG = rawWeight;
            if (unit === 'kg') weightInG = rawWeight * 1000;
            else if (unit === 't') weightInG = rawWeight * 1000000;

            totalWeightGrams += (weightInG * qty);
        });

        // Calculate Taxes
        let taxBreakdownHtml = '';
        let totalTaxAmount = 0;
        const taxRows = document.querySelectorAll('#tax_rows_container .tax-row');

        taxRows.forEach(tr => {
            const nameInput = tr.querySelector('.tax-name-input');
            const percentInput = tr.querySelector('.tax-percent-input');
            const tName = nameInput ? nameInput.value.trim() : 'Tax';
            const tPercent = parseFloat(percentInput?.value || 0);

            if (tName && tPercent > 0) {
                const taxVal = (totalCost * tPercent) / 100;
                totalTaxAmount += taxVal;
                taxBreakdownHtml += `<div>${tName} (${tPercent.toFixed(2)}%): ${currency} ${taxVal.toFixed(2)}</div>`;
            }
        });

        if (!taxBreakdownHtml) {
            taxBreakdownHtml = `${currency} 0.00`;
        }

        const finalTotal = totalCost + totalTaxAmount;

        // Convert Gross weight to chosen unit
        const grossUnit = document.getElementById('gross_weight_unit_select')?.value || 'GRAMS';
        let formattedWeight = totalWeightGrams + ' g';
        if (grossUnit === 'KILOGRAMS') {
            formattedWeight = (totalWeightGrams / 1000).toFixed(2) + ' kg';
        } else if (grossUnit === 'TONNES') {
            formattedWeight = (totalWeightGrams / 1000000).toFixed(4) + ' t';
        } else {
            formattedWeight = totalWeightGrams.toFixed(1) + ' g';
        }

        // Update Summary UI
        document.getElementById('summary_total_products').innerText = totalProducts;
        document.getElementById('summary_total_qty').innerText = totalQuantity;
        document.getElementById('summary_total_cost').innerText = `${currency} ${totalCost.toFixed(2)}`;
        document.getElementById('summary_tax_list').innerHTML = taxBreakdownHtml;
        document.getElementById('summary_total_weight').innerText = formattedWeight;
        document.getElementById('summary_final_total').innerText = `${currency} ${finalTotal.toFixed(2)}`;
    }

    function updateCurrencyLabels(curr = null) {
        if (!curr) {
            const currencySelect = document.querySelector('select[name="currency_code"]');
            curr = currencySelect ? currencySelect.value : 'INR';
        }
        document.querySelectorAll('.currency_label').forEach(el => {
            el.innerText = curr;
        });
    }

    // Bulk Paste Implementation
    function openBulkPasteModal() {
        document.getElementById('bulkPasteInput').value = '';
        var modal = new bootstrap.Modal(document.getElementById('bulkPasteModal'));
        modal.show();
    }

    function applyBulkPaste() {
        const text = document.getElementById('bulkPasteInput').value.trim();
        if (!text) return;

        const lines = text.split(/\r?\n/);
        let addedCount = 0;

        lines.forEach(line => {
            const trimmed = line.trim();
            if (!trimmed) return;

            // Split by tab, comma, or multiple spaces
            let parts = trimmed.split(/\t/);
            if (parts.length < 2) {
                parts = trimmed.split(/,/);
            }
            if (parts.length < 2) {
                parts = trimmed.split(/\s{2,}/);
            }

            const name = parts[0] ? parts[0].trim() : 'Product Item';
            const qty = parts[1] ? parseFloat(parts[1].trim()) || 1 : 1;
            const price = parts[2] ? parseFloat(parts[2].trim().replace(/[^0-9.]/g, '')) || 0 : 0;

            addProductRow(name, qty, price);
            addedCount++;
        });

        const modalEl = document.getElementById('bulkPasteModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        recalcExportTotals();
    }

    function saveExportData() {
        let form = document.getElementById('exportDocForm');
        let formData = new FormData(form);
        let msg = document.getElementById('save_status_msg');
        
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

    let currentDocConfig = {
        docType: 'invoice',
        invoiceType: 'commercial',
        lang: 'en'
    };

    function submitExportForm(docType, action, invoiceType = 'commercial') {
        currentDocConfig.docType = docType;
        currentDocConfig.invoiceType = invoiceType;

        let form = document.getElementById('exportDocForm');
        let path = (docType === 'invoice') ? '/export/commercial-invoice' : '/export/packing-list';
        
        // Update Document Viewer Modal Titles
        let title = 'Commercial Invoice';
        if (docType === 'packing') {
            title = 'Packing List';
        } else if (invoiceType === 'proforma') {
            title = 'Proforma Invoice';
        }

        const invNo = form.querySelector('input[name="doc_invoice_no"]')?.value || form.querySelector('input[name="invoice_no"]')?.value || document.getElementById('export_order_id').value || 'PI-2026-273';
        
        const titleEl = document.getElementById('docViewerTitle');
        const subtitleEl = document.getElementById('docViewerSubtitle');
        if (titleEl) titleEl.innerText = title;
        if (subtitleEl) subtitleEl.innerText = `Previewing document for ${invNo}`;

        form.querySelectorAll('input[name="download"], input[name="view"], input[name="type"], input[name="lang"]').forEach(el => el.remove());

        let typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = invoiceType;
        form.appendChild(typeInput);

        if (currentDocConfig.lang && currentDocConfig.lang !== 'en') {
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'lang';
            langInput.value = currentDocConfig.lang;
            form.appendChild(langInput);
        }

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

    function openDocPdfInNewTab() {
        let form = document.getElementById('exportDocForm');
        let path = (currentDocConfig.docType === 'invoice') ? '/export/commercial-invoice' : '/export/packing-list';
        
        form.querySelectorAll('input[name="download"], input[name="view"], input[name="type"], input[name="lang"]').forEach(el => el.remove());

        let typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = currentDocConfig.invoiceType;
        form.appendChild(typeInput);

        let viewInput = document.createElement('input');
        viewInput.type = 'hidden';
        viewInput.name = 'view';
        viewInput.value = '1';
        form.appendChild(viewInput);

        if (currentDocConfig.lang && currentDocConfig.lang !== 'en') {
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'lang';
            langInput.value = currentDocConfig.lang;
            form.appendChild(langInput);
        }

        let prevTarget = form.target;
        form.target = '_blank';
        form.action = path;
        form.submit();
        form.target = prevTarget;
    }

    function downloadDocPdfDirect() {
        submitExportForm(currentDocConfig.docType, 'download', currentDocConfig.invoiceType);
    }

    function changeDocLanguage(langCode, langLabel) {
        currentDocConfig.lang = langCode;
        const langEl = document.getElementById('currentDocLang');
        if (langEl) langEl.innerText = langLabel;
        submitExportForm(currentDocConfig.docType, 'view', currentDocConfig.invoiceType);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const currencySelect = document.querySelector('select[name="currency_code"]');
        if (currencySelect) {
            currencySelect.addEventListener('change', function() {
                recalcExportTotals();
            });
        }
    });
    </script>
</body>

</html>
