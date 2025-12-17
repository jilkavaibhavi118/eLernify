@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Purchase History / Orders</h6>
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
                                    <option value="refunded">Refunded</option>
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
                                            Order ID</th>
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

    <!-- Refund Modal Confirmation -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Check for user_id in URL params to pre-filter
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('user_id');

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('backend.orders.index') }}",
                    data: function(d) {
                        d.status = $('#status').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.user_id = userId; // Auto-include if present
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user.name'
                    },
                    {
                        data: 'course_title',
                        name: 'items.course.title'
                    },
                    {
                        data: 'formatted_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'payment_status',
                        name: 'status'
                    },
                    {
                        data: 'created_date',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
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

            // Handle Refund
            $(document).on('click', '.refund-btn', function() {
                var id = $(this).data('id');
                if (confirm(
                        "Are you sure you want to refund this order? This action connects to manual refund logic currently."
                    )) {
                    $.ajax({
                        url: "/admin/orders/" + id + "/refund",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            alert(response.success);
                            table.draw();
                        },
                        error: function(xhr) {
                            alert('Something went wrong');
                        }
                    });
                }
            });
        });
    </script>
@endsection
