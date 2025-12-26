@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>Comments & Discussion Management</h6>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table class="table align-items-center mb-0" id="table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lecture
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Content
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                                    </th>
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

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Comment</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="replyForm">
                    @csrf
                    <input type="hidden" name="comment_id" id="parent_comment_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Parent Comment:</label>
                            <div id="parent_comment_text" class="p-2 bg-light rounded small"></div>
                        </div>
                        <div class="mb-3">
                            <label for="reply_content" class="form-label">Your Answer:</label>
                            <textarea class="form-control" name="content" id="reply_content" rows="4" required
                                placeholder="Write your response here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('backend.comments.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: 'course',
                            name: 'course'
                        },
                        {
                            data: 'lecture',
                            name: 'lecture'
                        },
                        {
                            data: 'content',
                            name: 'content'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                // Reply Button Click
                $(document).on('click', '.reply-btn', function() {
                    const id = $(this).data('id');
                    const content = $(this).data('content');
                    $('#parent_comment_id').val(id);
                    $('#parent_comment_text').text(content);
                    $('#reply_content').val('');
                    var myModal = new coreui.Modal(document.getElementById('replyModal'));
                    myModal.show();
                });

                // Reply Form Submit
                $('#replyForm').on('submit', function(e) {
                    e.preventDefault();
                    const id = $('#parent_comment_id').val();
                    const url = `{{ url('admin/comments') }}/${id}/reply`;
                    const $submitBtn = $(this).find('button[type="submit"]');

                    $submitBtn.prop('disabled', true).text('Sending...');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succeed',
                                    text: response.message,
                                    timer: 1500
                                });
                                var myModalEl = document.getElementById('replyModal');
                                var modal = coreui.Modal.getInstance(myModalEl);
                                modal.hide();
                                table.ajax.reload();
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to send reply. Please try again.'
                            });
                        },
                        complete: function() {
                            $submitBtn.prop('disabled', false).text('Send Reply');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
