@extends('layouts.master')

@section('title')
    Saaluvesa
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
    @slot('li_1') Home @endslot
    @slot('title') Shippings @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <p style="position: relative; top: 33px; left: 25px; font-weight: bold;">Search:</p>
                <div class="card-body">

                    <!-- ✅ Add Button -->
                    <div class="mb-3 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">
                            + Add Shipping
                        </button>
                    </div>

                    <div id="table-gridjs"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Add Shipping Modal --}}
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shipping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" action="/insertshipping" id="addshipping" novalidate method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Location Name <span class="text-danger">*</span></label>
                            <select name="location" id="location" class="form-control" required>
                                <option value="" disabled selected>Select Location</option>
                                <option value="others">Others</option>
                                @php $st = App\Models\State::all(); @endphp
                                @foreach ($st as $state)
                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shipping Amount*</label>
                            <input type="number" class="form-control" id="shipping_amt" name="shipping_amt"
                                placeholder="Shipping Amount" step="1" min="0" required>

                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary mt-3" type="submit">Add Shipping</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Edit Shipping Modal --}}
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Shipping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" id="editshipping" action="/updateship" novalidate method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="editid">
                        <div class="mb-3">
                            <label class="form-label">Location Name <span class="text-danger">*</span></label>
                            <select name="location" id="editlocation" class="form-control" required>
                                <option value="" disabled selected>Select Location</option>
                                <option value="others">Others</option>
                                @php $st = App\Models\State::all(); @endphp
                                @foreach ($st as $state)
                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shipping Amount*</label>
                            {{-- <input type="text" class="form-control" id="editshipping_amt" name="shipping_amt"
                                placeholder="Shipping Amount" required> --}}
                            <input type="number" class="form-control" id="editshipping_amt" name="shipping_amt"
                                placeholder="Shipping Amount" step="1" min="0" required>

                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary mt-3" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                text: '{{ session('success') }}'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

    <script>
        const shipping = @json($shipping);

        const gridNew = new gridjs.Grid({
            columns: [
                "S.NO",
                "Location ID",
                "Shipping Amount",
                {
                    name: "Action",
                    sort: false,
                },
            ],
            pagination: { limit: 10 },
            sort: true,
            search: true,
            data: shipping.map((item, index) => [
                index + 1,
                item.location,
                item.shipping_amt,
                gridjs.html(`
                                                                            <div class="d-flex gap-2 justify-content-center">
                                                                                <button 
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateProductModal"
                                                                                    data-id="${item.id}"
                                                                                    data-location="${item.location}"
                                                                                    data-shipping_amt="${item.shipping_amt}"
                                                                                    class="btn btn-warning btn-sm edit_btn1">
                                                                                    Edit
                                                                                </button>
                                                                                <button 
                                                                                    class="btn btn-danger btn-sm delete_btn" 
                                                                                    data-id="${item.id}">
                                                                                    Delete
                                                                                </button>
                                                                            </div>
                                                                        `)
            ]),
            style: {
                table: { border: "1px solid #ccc" },
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
        }).render(document.getElementById("table-gridjs"));

        // Populate Edit Modal
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('edit_btn1')) {
                const id = e.target.getAttribute('data-id');
                const location = e.target.getAttribute('data-location');
                const amt = e.target.getAttribute('data-shipping_amt');

                document.getElementById('editid').value = id;
                document.getElementById('editlocation').value = location;
                document.getElementById('editshipping_amt').value = amt;
            }
        });

        // Handle Delete
        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this Blogs?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/destroyshipping/" + id,
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "Delete failed!", "error");
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            $('#shipping_amt').on('input', function () {
                // Allow only digits and one decimal point
                let val = $(this).val();
                val = val.replace(/[^0-9.]/g, '')   // Remove non-numeric except dot
                    .replace(/(\..*?)\..*/g, '$1'); // Allow only one dot
                $(this).val(val);
            });
            $('#editshipping_amt').on('input', function () {
                // Allow only digits and one decimal point
                let val = $(this).val();
                val = val.replace(/[^0-9.]/g, '')   // Remove non-numeric except dot
                    .replace(/(\..*?)\..*/g, '$1'); // Allow only one dot
                $(this).val(val);
            });
        });
    </script>

@endsection