@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Payment Details</h6>
                    <div>
                        {{-- Placeholder for CSV Export Button --}}
                        <button class="btn btn-sm btn-outline-success"
                            onclick="alert('Export logic meant to be implemented with Maatwebsite/Excel or pure JS')"><i
                                class="fa fa-file-excel"></i> Export CSV</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-3">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input type="date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>End Date</label>
                                <input type="date" id="end_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select id="status" class="form-control">
                                    <option value="">All</option>
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="filterBtn" class="btn btn-primary me-2">Filter</button>
                                <button id="resetBtn" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Payment ID</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Razorpay Payment ID</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            User</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Course</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Amount</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Payment Method</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Check for user_id in URL params to pre-filter
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('user_id');

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [7, 'desc']
                ], // Default sort by Date (index 7)
                ajax: {
                    url: "{{ route('backend.payments.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.status = $('#status').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.user_id = userId; // Auto-include if present
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTables Error:', error);
                        console.error('Response:', xhr.responseText);
                        alert('Error loading table data. Please check console for details.');
                    }
                },
                columns: [{
                        data: 'payment_id',
                        name: 'id'
                    },
                    {
                        data: 'razorpay_payment_id',
                        name: 'razorpay_payment_id',
                        orderable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        orderable: false
                    },
                    {
                        data: 'course_title',
                        name: 'course_title',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        orderable: false
                    },
                    {
                        data: 'date',
                        name: 'paid_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            $('#filterBtn').click(function() {
                table.draw();
            });

            $('#resetBtn').click(function() {
                $('#status').val('');
                $('#start_date').val('');
                $('#end_date').val('');
                table.draw();
            });
        });
    </script>
@endpush

