@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="cil-puzzle me-2"></i>User Quiz Results</h6>
                        <div class="header-actions">
                            <button class="btn btn-outline-primary btn-sm" onclick="table.ajax.reload()">
                                <i class="cil-reload me-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0" id="results-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quiz
                                        Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Score /
                                        Marks</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Attempted At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            var table;
            $(function() {
                table = $('#results-table').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('backend.quizzes.results') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: '50px'
                        },
                        {
                            data: 'user_name',
                            name: 'user.name',
                            className: 'fw-bold'
                        },
                        {
                            data: 'user_email',
                            name: 'user.email'
                        },
                        {
                            data: 'course_title',
                            name: 'quiz.lecture.course.title'
                        },
                        {
                            data: 'quiz_title',
                            name: 'quiz.title'
                        },
                        {
                            data: 'score_display',
                            name: 'score',
                            className: 'text-center'
                        },
                        {
                            data: 'date',
                            name: 'completed_at'
                        },
                    ],
                    language: {
                        searchPlaceholder: "Search by student name or email...",
                        search: ""
                    },
                    dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                });

                // Style the search input
                $('.dataTables_filter input').addClass('form-control form-control-sm border-secondary-subtle');
                $('.dataTables_length select').addClass('form-select form-select-sm border-secondary-subtle');
            });
        </script>
        <style>
            .dataTables_filter {
                margin-bottom: 0px;
            }

            .dataTables_filter input {
                width: 300px !important;
                margin-left: 0.5rem !important;
            }

            .table thead th {
                font-size: 0.7rem;
                padding: 0.75rem 1.5rem;
                border-bottom: 1px solid #ebedef;
            }

            .table tbody td {
                font-size: 0.85rem;
                padding: 1rem 1.5rem;
            }
        </style>
    @endpush
@endsection
