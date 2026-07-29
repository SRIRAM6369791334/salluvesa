@extends('layouts.master')
@section('title')
    Bank Details
@endsection
@section('css')
    <!-- Summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border: 1px solid #ced4da;
        }
        .description-cell {
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Bank Details
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Bank Details List (Country-wise)</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBankModal">
                            <i class="bx bx-plus me-1"></i> Add New Bank Detail
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Country</th>
                                    <th>Bank Details</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bankDetails as $detail)
                                    <tr>
                                        <td><strong>{{ $detail->bank_country }}</strong></td>
                                        <td>
                                            <div class="description-cell">
                                                {!! Str::limit(strip_tags($detail->description), 100) !!}
                                            </div>
                                        </td>
                                        <td>{{ $detail->updated_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-primary edit-bank-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editBankModal"
                                                    data-detail="{{ json_encode($detail) }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>
                                                <form action="{{ route('bank-details.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bank detail?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No bank details found. Click "Add New Bank Detail" to create one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bank Modal -->
    <div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBankModalLabel">Add New Bank Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bank-details.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bank_country" class="form-label">Country*</label>
                            <input type="text" class="form-control" name="bank_country" placeholder="e.g. United States, India" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Bank Details / Description*</label>
                            <textarea id="summernote-add" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Bank Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Bank Modal -->
    <div class="modal fade" id="editBankModal" tabindex="-1" aria-labelledby="editBankModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBankModalLabel">Edit Bank Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBankForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_bank_country" class="form-label">Country*</label>
                            <input type="text" class="form-control" id="edit_bank_country" name="bank_country" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Bank Details / Description*</label>
                            <textarea id="summernote-edit" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Bank Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote for Add Modal
            $('#summernote-add').summernote({
                placeholder: 'Enter bank details here...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Initialize Summernote for Edit Modal
            $('#summernote-edit').summernote({
                placeholder: 'Enter bank details here...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        document.querySelectorAll('.edit-bank-btn').forEach(button => {
            button.addEventListener('click', function() {
                const detail = JSON.parse(this.getAttribute('data-detail'));
                const form = document.getElementById('editBankForm');
                
                // Set action URL
                form.action = `/bank-details/update/${detail.id}`;
                
                // Fill form fields
                document.getElementById('edit_bank_country').value = detail.bank_country || '';
                
                // Set Summernote content
                $('#summernote-edit').summernote('code', detail.description || '');
            });
        });
    </script>
@endsection
