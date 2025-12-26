<div class="comments-section mt-5 py-4 border-top">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Comments & Discussion
            ({{ $lecture->comments->count() + $lecture->comments->sum(fn($c) => $c->replies->count()) }})</h4>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="bi bi-bell-fill me-1"></i> Get notified when participating
        </button>
    </div>

    <!-- Comments List -->
    @forelse($lecture->comments as $comment)
        <div class="comment-item mb-4">
            <div class="d-flex gap-3">
                <div class="comment-avatar">
                    <div class="avatar-circle"
                        style="background-color: {{ '#' . substr(md5($comment->user->name), 0, 6) }};">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($comment->user->name, ' '), 1, 1)) ?: '' }}
                    </div>
                </div>
                <div class="comment-content flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="fw-bold text-dark">{{ $comment->user->name }}</span>
                        @if ($comment->user_id == $lecture->course->instructor->user_id)
                            <span class="badge bg-primary rounded-pill small"
                                style="font-size: 0.65rem;">Instructor</span>
                        @elseif($comment->user->hasRole('Admin'))
                            <span class="badge bg-dark rounded-pill small" style="font-size: 0.65rem;">Admin</span>
                        @endif
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="comment-text text-muted mb-3 markdown-content">
                        {!! $comment->content !!}
                    </div>

                    <div class="comment-actions d-flex align-items-center gap-3 mb-3">
                        <button class="btn-action react-btn {{ $comment->isLikedBy(Auth::id()) ? 'active' : '' }}"
                            data-id="{{ $comment->id }}" title="React">
                            <i class="bi {{ $comment->isLikedBy(Auth::id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            <span class="reaction-count small px-1">{{ $comment->reactions->count() ?: '' }}</span>
                        </button>
                        <button class="btn-action small fw-bold"
                            onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('d-none')">
                            Reply
                        </button>
                        @if ($comment->user_id == Auth::id())
                            <button class="btn-action small fw-bold text-danger delete-comment-btn"
                                data-id="{{ $comment->id }}"
                                data-url="{{ route('user.comments.user.destroy', $comment->id) }}">
                                Delete
                            </button>
                        @endif
                    </div>

                    <!-- Reply Form (Hidden by default) -->
                    <div id="reply-form-{{ $comment->id }}"
                        class="reply-input-wrapper d-none shadow-sm rounded-pill border px-3 py-1 mb-3 d-flex align-items-center">
                        <div class="avatar-circle-sm me-2"
                            style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <form action="{{ route('user.comments.store') }}" method="POST"
                            class="flex-grow-1 d-flex align-items-center">
                            @csrf
                            <input type="hidden" name="lecture_id" value="{{ $lecture->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <input type="text" name="content"
                                class="form-control border-0 bg-transparent shadow-none small"
                                placeholder="Leave a reply" required>
                            <button type="submit" class="btn btn-link py-0 text-primary border-0"><i
                                    class="bi bi-send-fill"></i></button>
                        </form>
                    </div>

                    <!-- Nested Replies -->
                    @if ($comment->replies->count() > 0)
                        <div class="nested-replies ms-4 ps-3 border-start">
                            @foreach ($comment->replies as $reply)
                                @php
                                    $isInstructorReply = $reply->user_id == $lecture->course->instructor->user_id;
                                @endphp
                                <div
                                    class="comment-item mb-3 {{ $isInstructorReply ? 'instructor-reply p-2 rounded' : '' }}">
                                    <div class="d-flex gap-2">
                                        <div class="comment-avatar">
                                            <div class="avatar-circle-sm"
                                                style="background-color: {{ '#' . substr(md5($reply->user->name), 0, 6) }};">
                                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="comment-content flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark small">{{ $reply->user->name }}</span>
                                                @if ($reply->user_id == $lecture->course->instructor->user_id)
                                                    <span class="badge bg-primary rounded-pill small"
                                                        style="font-size: 0.55rem;">Instructor</span>
                                                @elseif($reply->user->hasRole('Admin'))
                                                    <span class="badge bg-dark rounded-pill small"
                                                        style="font-size: 0.55rem;">Admin</span>
                                                @endif
                                                <small class="text-muted"
                                                    style="font-size: 0.7rem;">{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="comment-text text-muted small mb-2 markdown-content">
                                                {!! $reply->content !!}
                                            </div>
                                            <div class="comment-actions d-flex align-items-center gap-3">
                                                <button
                                                    class="btn-action react-btn {{ $reply->isLikedBy(Auth::id()) ? 'active' : '' }}"
                                                    data-id="{{ $reply->id }}" style="font-size: 0.85rem;">
                                                    <i
                                                        class="bi {{ $reply->isLikedBy(Auth::id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                    <span
                                                        class="reaction-count small px-1">{{ $reply->reactions->count() ?: '' }}</span>
                                                </button>
                                                @if ($reply->user_id == Auth::id())
                                                    <button
                                                        class="btn-action small fw-bold text-danger delete-comment-btn"
                                                        data-id="{{ $reply->id }}"
                                                        data-url="{{ route('user.comments.user.destroy', $reply->id) }}"
                                                        style="font-size: 0.75rem;">
                                                        Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-light rounded-4 mb-4">
            <i class="bi bi-chat-dots fa-3x text-muted mb-3 d-block"></i>
            <p class="text-muted">No comments yet. Be the first to start the discussion!</p>
        </div>
    @endforelse

    <!-- Main Comment Editor -->
    <div class="comment-editor-card rounded-4 border p-0 mt-5 shadow-sm overflow-hidden">
        <form action="{{ route('user.comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="lecture_id" value="{{ $lecture->id }}">
            <div class="editor-toolbar bg-light px-3 py-2 border-bottom d-flex align-items-center gap-3">
                <button type="button" class="toolbar-btn"><i class="bi bi-type-bold"></i></button>
                <button type="button" class="toolbar-btn"><i class="bi bi-type-italic"></i></button>
                <button type="button" class="toolbar-btn"><i class="bi bi-quote"></i></button>
                <button type="button" class="toolbar-btn"><i class="bi bi-list-task"></i></button>
                <button type="button" class="toolbar-btn"><i class="bi bi-list-ol"></i></button>
                <button type="button" class="toolbar-btn"><i class="bi bi-link-45deg"></i></button>
            </div>
            <div class="editor-body p-3">
                <textarea name="content" class="form-control border-0 shadow-none bg-transparent" placeholder="Leave a comment"
                    rows="4" required></textarea>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">You can use <a href="#"
                            class="text-primary text-decoration-none">Markdown</a></small>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">Comment</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to handle form submission via AJAX
            function handleCommentSubmit(form) {
                const $form = $(form);
                const $submitBtn = $form.find('button[type="submit"]');
                const originalBtnHtml = $submitBtn.html();

                // Loading state
                $submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // For now, reload the page to show the new comment with all its complex Blade-driven styling
                            // In a full SPA this would append a component, but here reload is safest for consistency
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);
                        const errors = xhr.responseJSON.errors;
                        let errorMsg = 'Something went wrong';
                        if (errors) {
                            errorMsg = Object.values(errors).flat().join('<br>');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMsg,
                        });
                    }
                });
            }

            // Attach to forms
            $(document).on('submit', '.comments-section form', function(e) {
                e.preventDefault();
                handleCommentSubmit(this);
            });

            // Markdown Rendering
            function renderMarkdown() {
                $('.markdown-content').each(function() {
                    if (!$(this).data('rendered')) {
                        const rawContent = $(this).text().trim();
                        // Render markdown and then sanitize with DOMPurify
                        const htmlContent = DOMPurify.sanitize(marked.parse(rawContent));
                        $(this).html(htmlContent);
                        $(this).data('rendered', true);
                    }
                });
            }

            renderMarkdown();

            // Reaction handling
            $(document).on('click', '.react-btn', function() {
                const $btn = $(this);
                const id = $btn.data('id');
                const $icon = $btn.find('i');
                const $count = $btn.find('.reaction-count');

                $.ajax({
                    url: `/my/comment/${id}/react`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.status === 'added') {
                                $btn.addClass('active');
                                $icon.removeClass('bi-heart').addClass('bi-heart-fill');
                            } else {
                                $btn.removeClass('active');
                                $icon.removeClass('bi-heart-fill').addClass('bi-heart');
                            }
                            $count.text(response.count || '');
                        }
                    }
                });
            });

            // User deletion handling
            $(document).on('click', '.delete-comment-btn', function() {
                const $btn = $(this);
                const url = $btn.data('url');

                Swal.fire({
                    title: 'Delete Comment?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $btn.closest('.comment-item').fadeOut(400,
                                        function() {
                                            $(this).remove();
                                        });
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted',
                                        text: response.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

<style>
    .comments-section {
        color: #1f2937;
    }

    .comment-item {
        transition: all 0.2s;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .avatar-circle-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .comment-text {
        font-size: 0.935rem;
        line-height: 1.6;
    }

    .btn-action {
        background: none;
        border: none;
        color: #94a3b8;
        padding: 0;
        font-size: 1.1rem;
        transition: color 0.2s;
    }

    .btn-action:hover {
        color: var(--primary-color);
    }

    .reply-input-wrapper {
        background-color: #f8fafc;
        max-width: 100%;
        transition: border-color 0.2s;
    }

    .reply-input-wrapper:focus-within {
        border-color: var(--primary-color) !important;
    }

    .reaction-pill {
        background: #f1f5f9;
        padding: 2px 10px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .toolbar-btn {
        background: none;
        border: none;
        color: #64748b;
        font-size: 1.1rem;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .toolbar-btn:hover {
        background: #e2e8f0;
        color: var(--primary-color);
    }

    .editor-body textarea {
        resize: none;
        font-size: 0.95rem;
    }

    .comment-editor-card {
        background-color: #fff;
    }

    .nested-replies {
        border-left: 2px solid #f1f5f9 !important;
    }

    /* Primary color overrides for internal elements if needed */
    .text-primary {
        color: #0a2283 !important;
    }

    .btn-primary {
        background-color: #0a2283 !important;
        border-color: #0a2283 !important;
    }

    .react-btn.active {
        color: #e11d48 !important;
        /* Rose color for active heart */
    }

    .react-btn.active i {
        color: #e11d48 !important;
    }

    .instructor-reply {
        background-color: #f0f4ff;
        border-left: 3px solid #0a2283 !important;
    }

    .markdown-content p {
        margin-bottom: 0.5rem;
    }

    .markdown-content pre {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-bottom: 1rem;
    }

    .markdown-content code {
        background: #f1f5f9;
        padding: 2px 4px;
        border-radius: 4px;
        font-size: 0.9em;
    }
</style>
