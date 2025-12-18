<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $lecture->title }} | eLEARNIFY</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>eLEARNIFY</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('user.dashboard') }}" class="nav-item nav-link">My Dashboard</a>
                <a href="{{ route('user.course.view', $enrollment->id) }}" class="nav-item nav-link">Back to Course</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-4 mb-4">
                        <h4 class="mb-3">{{ $lecture->title }}</h4>
                        <div class="d-flex mb-3">
                            <small class="me-3"><i class="fa fa-book-open text-primary me-2"></i>Lecture</small>
                            <small class="me-3"><i
                                    class="fa fa-clock text-primary me-2"></i>{{ $lecture->duration ?? '10 mins' }}</small>
                        </div>

                        <!-- Video / Media Player -->
                        <div
                            class="ratio ratio-16x9 mb-4 bg-dark rounded d-flex align-items-center justify-content-center">
                            @php
                                $primaryVideo = null;
                                if ($lecture->materials && $lecture->materials->count()) {
                                    $primaryVideo = $lecture->materials->firstWhere('video_path', '!=', null);
                                }
                            @endphp

                            @if ($primaryVideo)
                                <video controls class="w-100 h-100">
                                    <source src="{{ asset('storage/' . $primaryVideo->video_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($lecture->video_url)
                                <iframe src="{{ $lecture->video_url }}" allowfullscreen></iframe>
                            @else
                                <div class="text-white text-center">
                                    <i class="fa fa-play-circle fa-4x mb-3"></i>
                                    <h5>Video Content Placeholder</h5>
                                    <p class="mb-0">Video player integration required</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <h5>Description</h5>
                            <p>{{ $lecture->description ?? 'No description available.' }}</p>
                        </div>

                        @if ($lecture->materials && $lecture->materials->count())
                            <div class="mt-4">
                                <h5>Resources for this lecture</h5>
                                <ul class="list-group">
                                    @foreach ($lecture->materials as $material)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $material->title }}</strong>
                                                    @if ($material->description)
                                                        <div class="text-muted small">{{ $material->description }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2">
                                                    @if ($material->file_path)
                                                        <a href="{{ asset('storage/' . $material->file_path) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-file-pdf me-1"></i>Download
                                                        </a>
                                                    @endif
                                                    @if ($material->video_path)
                                                        <a href="{{ asset('storage/' . $material->video_path) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-success">
                                                            <i class="fa fa-video me-1"></i>Open Video
                                                        </a>
                                                    @endif
                                                    @if ($material->content_url)
                                                        <a href="{{ $material->content_url }}" target="_blank"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            <i class="fa fa-link me-1"></i>Open Link
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        @if (isset($prev_url) && $prev_url)
                            <a href="{{ $prev_url }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Previous
                            </a>
                        @else
                            <a href="{{ route('user.course.view', $enrollment->id) }}"
                                class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Back to Course
                            </a>
                        @endif

                        @if (isset($next_url) && $next_url)
                            @php
                                $isNextQuiz = str_contains($next_url, '/quiz/');
                            @endphp
                            <a href="{{ $next_url }}"
                                class="btn btn-primary {{ $isNextQuiz ? 'btn-next-quiz' : '' }}"
                                {{ $isNextQuiz ? 'data-bs-toggle=modal data-bs-target=#quizStartModal' : '' }}>
                                Next <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top" style="top: 100px;">
                        <h5 class="mb-3">{{ $enrollment->course->title }}</h5>
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $enrollment->progress }}%"></div>
                        </div>

                        <h6 class="mb-3">Course Content</h6>
                        <div class="list-group course-sidebar">
                            @foreach ($enrollment->course->lectures as $l)
                                {{-- Lecture Item --}}
                                <a href="{{ route('user.lecture.view', $l->id) }}"
                                    class="list-group-item list-group-item-action {{ $l->id == $lecture->id ? 'active' : '' }} d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fa fa-play-circle me-2"></i>{{ $l->title }}
                                    </div>
                                    <small>{{ $l->duration ?? '10m' }}</small>
                                </a>

                                {{-- Nested Quizzes for this Lecture --}}
                                @if ($l->quizzes && $l->quizzes->count() > 0)
                                    @foreach ($l->quizzes as $q)
                                        <a href="{{ route('user.quiz.view', $q->id) }}"
                                            class="list-group-item list-group-item-action ps-5 border-0 bg-white text-secondary">
                                            <i class="fa fa-question-circle me-2"></i>{{ $q->title }}
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Quiz Start Modal -->
    <div class="modal fade" id="quizStartModal" tabindex="-1" aria-labelledby="quizStartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizStartModalLabel">Ready for the Quiz?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fa fa-question-circle fa-4x text-primary mb-3"></i>
                    <p>The next item is a quiz.</p>
                    <p class="text-muted">You will be navigating to the quiz page where you can see instructions before
                        starting. The time will start once you click 'Take Quiz' on the next page.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    @if (isset($next_url))
                        <a href="{{ $next_url }}" class="btn btn-primary px-4">Take Quiz</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
