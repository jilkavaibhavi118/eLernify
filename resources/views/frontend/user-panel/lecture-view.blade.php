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

                        <!-- Video Placeholder -->
                        <div
                            class="ratio ratio-16x9 mb-4 bg-dark rounded d-flex align-items-center justify-content-center">
                            @if ($lecture->video_url)
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
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.course.view', $enrollment->id) }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Back to Course
                        </a>
                        <!-- Next lecture logic could go here -->
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
                        <div class="list-group">
                            @foreach ($enrollment->course->lectures as $l)
                                <a href="{{ route('user.lecture.view', $l->id) }}"
                                    class="list-group-item list-group-item-action {{ $l->id == $lecture->id ? 'active' : '' }}">
                                    <i class="fa fa-play-circle me-2"></i>{{ $l->title }}
                                </a>
                            @endforeach
                            @foreach ($enrollment->course->quizzes as $q)
                                <a href="{{ route('user.quiz.view', $q->id) }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fa fa-question-circle me-2"></i>{{ $q->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
