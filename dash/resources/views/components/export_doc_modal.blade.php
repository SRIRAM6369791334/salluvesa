<div class="modal fade" id="exportDocModal" tabindex="-1" aria-labelledby="exportDocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportDocModalLabel">Generate Export Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="exportDocForm" method="GET">
                    <input type="hidden" name="order_id" id="export_order_id">
                   
                    <h6 class="mb-3 text-primary">1. Sender Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" class="form-control" name="sender_name" value="Saaluvesa Enterprises Private Limited">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Email</label>
                            <input type="email" class="form-control" name="sender_email" value="info@saaluvesa.com">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Sender Address</label>
                            <textarea class="form-control" name="sender_address" rows="2">Dr.No.18/76, Thiru.Ve.Ka. St, Punjai Puliampatti, SATHYAMANGALAM, ERODE, TAMIL NADU. -638459</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Additional Company Details (Appears below company info)</label>
                            <textarea class="form-control" name="additional_company_details" rows="2">C.I.N : U46900TZ2025PTC36041 | ROC COIMBATORE - REG. NO : 036041&#10;GST - 33ABRCS3304A1ZR | Import Export code - ABRCS3304A | ICEGATE ID - ABRCS3304APIE000</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Contact Number</label>
                            <input type="text" class="form-control" name="sender_contact" value="+91 94884 10884">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Tax ID No.</label>
                            <input type="text" class="form-control" name="sender_tax_id" value="33ABRCS3304A1ZR">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">2. Importer of Record Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="importer_name" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Email (Optional)</label>
                            <input type="email" class="form-control" name="importer_email" value="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Importer Address (Optional)</label>
                            <textarea class="form-control" name="importer_address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Contact Number (Optional)</label>
                            <input type="text" class="form-control" name="importer_contact" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Tax ID No. (Optional)</label>
                            <input type="text" class="form-control" name="importer_tax_id" value="">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">3. Recipient / User Data Details</h6>
                    <div class="row" id="receiver_section">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Name (Optional)</label>
                            <input type="text" class="form-control" name="receiver_name" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Email (Optional)</label>
                            <input type="email" class="form-control" name="receiver_email" value="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Receiver Address (Optional)</label>
                            <textarea class="form-control" name="receiver_address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Contact Number (Optional)</label>
                            <input type="text" class="form-control" name="receiver_contact" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Tax ID No. (Optional)</label>
                            <input type="text" class="form-control" name="receiver_tax_id" value="">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">4. General Information / Shipment Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Invoice No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="doc_invoice_no" id="doc_invoice_no" placeholder="e.g. PI-2026-273">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipment Date (Optional)</label>
                            <input type="date" class="form-control" name="shipment_date" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipment Reference No. (Optional)</label>
                            <input type="text" class="form-control" name="shipment_ref_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reason for Export (Optional)</label>
                            <input type="text" class="form-control" name="reason_for_export" value="Commercial">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type of Export (Optional)</label>
                            <input type="text" class="form-control" name="type_of_export" value="Permanent">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Export License No.</label>
                            <input type="text" class="form-control" name="export_license_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Import License No.</label>
                            <input type="text" class="form-control" name="import_license_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">INCOTERMS / Incoterms Desc.</label>
                            <input type="text" class="form-control" name="incoterms" value="DAP">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency Code</label>
                            <select class="form-select" name="currency_code" id="currency_code_select" onchange="recalcExportTotals()">
                                <option value="INR" selected>INR – Indian Rupee</option>
                                <option value="USD">USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                                <option value="AED">AED - UAE Dirham</option>
                                <option value="SAR">SAR - Saudi Riyal</option>
                                <option value="CAD">CAD - Canadian Dollar</option>
                                <option value="AUD">AUD - Australian Dollar</option>
                                <option value="SGD">SGD - Singapore Dollar</option>
                                <option value="JPY">JPY - Japanese Yen</option>
                                <option value="CNY">CNY - Chinese Yuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Method / Payment Terms</label>
                            <input type="text" class="form-control" name="payment_method" value="Bank Transfer">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Letter of Credit No.</label>
                            <input type="text" class="form-control" name="letter_of_credit_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer PO No.</label>
                            <input type="text" class="form-control" name="customer_po_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">PO Date</label>
                            <input type="date" class="form-control" name="po_date" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">File Number</label>
                            <input type="text" class="form-control" name="file_number" value="">
                        </div>
                    </div>

                    <!-- Tax Configuration -->
                    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                        <div>
                            <h6 class="mb-0 text-primary">Tax Configuration (Optional - Max 5 Taxes)</h6>
                            <small class="text-muted">Configure up to 5 tax lines (e.g., GST, IGST, VAT, Cess, Duties)</small>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTaxRow()">
                            <i class="bx bx-plus"></i> Add Tax
                        </button>
                    </div>
                    <div id="tax_rows_container" class="mb-3">
                        <!-- Dynamic Tax Rows -->
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">Packing / Item Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mode of Transportation</label>
                            <input type="text" class="form-control" name="mode_of_transportation" value="Air">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transportation Terms</label>
                            <input type="text" class="form-control" name="transportation_terms" value="EXW">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">AWB / BL No.</label>
                            <input type="text" class="form-control" name="awb_bl_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number of Packages</label>
                            <input type="number" class="form-control" name="number_of_packages" value="1">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Package Description</label>
                            <textarea class="form-control" name="package_description" rows="2">Apparel and Textiles in corrugated boxes</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Gross Weight Unit</label>
                            <select class="form-select" name="gross_weight_unit" id="gross_weight_unit_select" onchange="recalcExportTotals()">
                                <option value="GRAMS" selected>GRAMS</option>
                                <option value="KILOGRAMS">KILOGRAMS</option>
                                <option value="TONNES">TONNES</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">HS Code</label>
                            <input type="text" class="form-control" name="hs_code" value="61091000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country of Origin</label>
                            <input type="text" class="form-control" name="country_of_origin" value="India">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">OTHER INFORMATION AND COMPLIANCE DETAILS</label>
                            <textarea class="form-control" name="comments" rows="2">CERTIFICATES ATTACHED</textarea>
                        </div>
                    </div>

                    <!-- 6. Product Details -->
                    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                        <div>
                            <h6 class="mb-0 text-primary">6. Product Details</h6>
                            <small class="text-muted">Add, edit product names, quantities, and prices</small>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="openBulkPasteModal()">
                                <i class="bx bx-paste"></i> Bulk Paste
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addProductRow('', 1, 0)">
                                <i class="bx bx-plus"></i> Add Product
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm align-middle" id="product_table">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 200px;">Product</th>
                                    <th style="width: 120px;">Quantity</th>
                                    <th style="width: 150px;">Price (<span class="currency_label">INR</span>)</th>
                                    <th style="width: 50px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="product_rows_tbody">
                                <!-- Dynamic Product Rows -->
                            </tbody>
                        </table>
                    </div>

                    <!-- 7. Individual Product Unit Net Weights -->
                    <h6 class="mb-3 mt-4 text-primary">7. Individual Product Unit Net Weights</h6>
                    <div class="row" id="product_weights_container">
                        <div class="col-12 text-muted"><small>Products will appear here for unit weight configuration...</small></div>
                    </div>
                    
                    <!-- 8. Signatory Details -->
                    <h6 class="mb-3 mt-4 text-primary">8. Signatory Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Signatory Name</label>
                            <input type="text" class="form-control" name="signatory_name" value="Saaluvesa Enterprises Private Limited">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Signatory Designation</label>
                            <input type="text" class="form-control" name="signatory_designation" value="Authorized Signatory">
                        </div>
                    </div>

                    <!-- Real-Time Calculation Totals Summary Box -->
                    <div class="card border border-primary bg-soft-primary p-3 mt-4 mb-2 rounded-3">
                        <div class="row text-center text-md-start g-2">
                            <div class="col-6 col-md-2 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Total Products</small>
                                <span class="fw-bold fs-6" id="summary_total_products">0</span>
                            </div>
                            <div class="col-6 col-md-2 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Total Quantity</small>
                                <span class="fw-bold fs-6" id="summary_total_qty">0</span>
                            </div>
                            <div class="col-6 col-md-2 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Total Cost</small>
                                <span class="fw-bold fs-6" id="summary_total_cost">INR 0.00</span>
                            </div>
                            <div class="col-6 col-md-2 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Taxes</small>
                                <div id="summary_tax_list" class="fw-bold fs-6 text-warning">0.00</div>
                            </div>
                            <div class="col-6 col-md-2 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Total Weight</small>
                                <span class="fw-bold fs-6" id="summary_total_weight">0 g</span>
                            </div>
                            <div class="col-12 col-md-2">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Total Goods Value</small>
                                <span class="fw-bold fs-6 text-primary" id="summary_final_total">INR 0.00</span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer bg-light flex-column">
                <div class="w-100 text-end mb-3 border-bottom pb-3">
                    <button type="button" class="btn btn-primary" onclick="saveExportData()">
                        <i class="bx bx-save"></i> Save Details
                    </button>
                    <span id="save_status_msg" class="text-success ms-2" style="display:none;">Saved successfully!</span>
                </div>
                <div class="row w-100 text-center">
                    <div class="col-md-4 border-end">
                        <p class="mb-1 fw-bold text-primary">Commercial Invoice</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="submitExportForm('invoice', 'view', 'commercial')"><i class="bx bx-show"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="submitExportForm('invoice', 'download', 'commercial')"><i class="bx bx-download"></i> PDF</button>
                        </div>
                    </div>
                    <div class="col-md-4 border-end">
                        <p class="mb-1 fw-bold text-warning">Proforma Invoice</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="submitExportForm('invoice', 'view', 'proforma')"><i class="bx bx-show"></i> View</button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="submitExportForm('invoice', 'download', 'proforma')"><i class="bx bx-download"></i> PDF</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 fw-bold text-success">Packing List</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="submitExportForm('packing', 'view')"><i class="bx bx-show"></i> View</button>
                            <button type="button" class="btn btn-success btn-sm" onclick="submitExportForm('packing', 'download')"><i class="bx bx-download"></i> PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Paste Modal -->
<div class="modal fade" id="bulkPasteModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Paste Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-2">Paste tab-separated, comma-separated, or multi-line product rows. Format: <code>Product Name [Tab/Comma] Quantity [Tab/Comma] Price</code></p>
                <textarea id="bulkPasteInput" class="form-control" rows="8" placeholder="How are you&#9;1.000&#9;1000&#10;Product 2&#9;2&#9;500"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="applyBulkPaste()">Apply & Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div class="modal fade" id="docViewerModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background: #f8fafc;">
            <!-- Modal Header -->
            <div class="modal-header border-0 pb-1 px-4 pt-4 bg-transparent d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="modal-title fw-bold text-dark mb-1" id="docViewerTitle" style="font-size: 22px; color: #0f172a !important;">Commercial Invoice</h3>
                    <p class="text-muted mb-0" id="docViewerSubtitle" style="font-size: 13px;">Previewing document for PI-2026-273</p>
                </div>
                <button type="button" class="btn-close border rounded-circle p-2 bg-white shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Toolbar (Language & Actions) -->
            <div class="px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <!-- Left: Language Selector Pill -->
                <div class="dropdown">
                    <button class="btn btn-sm rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-2 border" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #10b981 !important; color: #047857; background: #ecfdf5;">
                        <i class="bx bx-globe fs-5"></i>
                        <span id="currentDocLang">English</span>
                        <i class="bx bx-chevron-down ms-1"></i>
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-3 py-2">
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('en', 'English')">English</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('ta', 'Tamil (தமிழ்)')">Tamil (தமிழ்)</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('de', 'German (Deutsch)')">German (Deutsch)</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('fr', 'French (Français)')">French (Français)</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('es', 'Spanish (Español)')">Spanish (Español)</a></li>
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="changeDocLanguage('ar', 'Arabic (العربية)')">Arabic (العربية)</a></li>
                    </ul>
                </div>

                <!-- Right: Action Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm px-3 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3 transition-all" onclick="openDocPdfInNewTab()" style="background-color: #ccfbf1; color: #0f766e; border: none;">
                        <i class="bx bx-link-external fs-6"></i> <span>Open PDF</span>
                    </button>
                    <button type="button" class="btn btn-sm px-3 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3 transition-all" onclick="downloadDocPdfDirect()" style="background-color: #0f172a; color: #ffffff; border: none;">
                        <i class="bx bx-download fs-6"></i> <span>Download PDF</span>
                    </button>
                </div>
            </div>

            <!-- Document Card Container -->
            <div class="modal-body px-4 pb-4 pt-0"> 
                <div class="card border rounded-3 p-2 p-md-3 shadow-sm bg-white" style="border-color: #e2e8f0 !important; max-height: 75vh; overflow-y: auto;">
                    <iframe id="docViewerIframe" name="docViewerIframe" style="width:100%; height:72vh; border:none; background: #fff;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
