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
                   
                    <h6 class="mb-3 text-primary">Sender Details</h6>
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
                            <textarea class="form-control" name="sender_address" rows="2">No. 123, Street Name, City, State, India - 600000</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Additional Company Details (Appears below company info)</label>
                            <textarea class="form-control" name="additional_company_details" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Contact Number</label>
                            <input type="text" class="form-control" name="sender_contact" value="+91 9876543210">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Tax ID No.</label>
                            <input type="text" class="form-control" name="sender_tax_id" value="">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">Importer of Record Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Name</label>
                            <input type="text" class="form-control" name="importer_name" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Email</label>
                            <input type="email" class="form-control" name="importer_email" value="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Importer Address</label>
                            <textarea class="form-control" name="importer_address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Contact Number</label>
                            <input type="text" class="form-control" name="importer_contact" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Importer Tax ID No.</label>
                            <input type="text" class="form-control" name="importer_tax_id" value="">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">Recipient / User Data Details</h6>
                    <div class="row" id="receiver_section">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Name</label>
                            <input type="text" class="form-control" name="receiver_name" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Email</label>
                            <input type="email" class="form-control" name="receiver_email" value="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Receiver Address</label>
                            <textarea class="form-control" name="receiver_address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Contact Number</label>
                            <input type="text" class="form-control" name="receiver_contact" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver Tax ID No.</label>
                            <input type="text" class="form-control" name="receiver_tax_id" value="">
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">General Information / Shipment Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipment Date</label>
                            <input type="date" class="form-control" name="shipment_date" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipment Reference No. / Ref No.</label>
                            <input type="text" class="form-control" name="shipment_ref_no" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reason for Export</label>
                            <input type="text" class="form-control" name="reason_for_export" value="Commercial">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type of Export</label>
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
                            <select class="form-select" name="currency_code">
                                <option value="USD" selected>USD - US Dollar</option>
                                <option value="INR">INR - Indian Rupee</option>
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

                    <h6 class="mb-3 mt-4 text-primary">Packing / Item Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mode of Transportation</label>
                            <input type="text" class="form-control" name="mode_of_transportation" value="Air">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transportation Terms</label>
                            <input type="text" class="form-control" name="transportation_terms" value="">
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
                            <textarea class="form-control" name="package_description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Gross Weight Unit</label>
                            <select class="form-select" name="gross_weight_unit">
                                <option value="GRAMS" selected>GRAMS</option>
                                <option value="KILOGRAMS">KILOGRAMS</option>
                                <option value="TONNES">TONNES</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-6 mb-3">
                            <label class="form-label">Gross Weight / Total Weight (Kg)</label>
                            <input type="number" step="0.01" class="form-control" name="total_weight" value="0.00">
                        </div> -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">HS Code</label>
                            <input type="text" class="form-control" name="hs_code" value="84433210">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country of Origin</label>
                            <input type="text" class="form-control" name="country_of_origin" value="India">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">OTHER INFORMATION AND COMPLIANCE DETAILS</label>
                            <textarea class="form-control" name="comments" rows="2">Good Condition</textarea>
                        </div>
                    </div>

                    <h6 class="mb-3 mt-4 text-primary">Individual Product Unit Net Weights</h6>
                    <div class="row" id="product_weights_container">
                        <div class="col-12 text-muted"><small>Clicking generate will automatically load products...</small></div>
                    </div>
                    
                    <h6 class="mb-3 mt-4 text-primary">Signatory Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Signatory Name</label>
                            <input type="text" class="form-control" name="signatory_name" value="Saaluvesa Enterprises Private Limited">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Signatory Designation</label>
                            <input type="text" class="form-control" name="signatory_designation" value="Manager">
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

<!-- Document Viewer Modal -->
<div class="modal fade" id="docViewerModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0"> 
                <iframe id="docViewerIframe" name="docViewerIframe" style="width:100%; height:85vh; border:none; "></iframe>
            </div>
        </div>
    </div>
</div>
