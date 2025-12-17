<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $enrollment->course->title }} | eLEARNIFY</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
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
                <a href="{{ url('/') }}" class="nav-item nav-link">Home</a>
                <a href="{{ route('user.dashboard') }}" class="nav-item nav-link">My Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-item nav-link btn btn-link"
                        style="text-decoration: none;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Course Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top" style="top: 100px;">
                        <h5 class="mb-4">{{ $enrollment->course->title }}</h5>

                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $enrollment->progress }}%"
                                aria-valuenow="{{ $enrollment->progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $enrollment->progress }}%
                            </div>
                        </div>

                        <h6 class="mb-3">Course Content</h6>

                        <!-- Lectures -->
                        @if ($enrollment->course->lectures->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-primary mb-2"><i class="fa fa-book-open me-2"></i>Lectures</h6>
                                <div class="list-group">
                                    @foreach ($enrollment->course->lectures as $lecture)
                                        <a href="{{ route('user.lecture.view', $lecture->id) }}"
                                            class="list-group-item list-group-item-action">
                                            <i class="fa fa-play-circle me-2"></i>{{ $lecture->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quizzes -->
                        @if ($enrollment->course->quizzes->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-primary mb-2"><i class="fa fa-question-circle me-2"></i>Quizzes</h6>
                                <div class="list-group">
                                    @foreach ($enrollment->course->quizzes as $quiz)
                                        <a href="{{ route('user.quiz.view', $quiz->id) }}"
                                            class="list-group-item list-group-item-action">
                                            <i class="fa fa-clipboard-list me-2"></i>{{ $quiz->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary w-100">
                            <i class="fa fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    @if (session('quiz_result'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h5><i class="fa fa-check-circle me-2"></i>Quiz Completed!</h5>
                            <p class="mb-0">Score:
                                {{ session('quiz_result')['score'] }}/{{ session('quiz_result')['total'] }}
                                ({{ session('quiz_result')['percentage'] }}%)</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="bg-light rounded p-5">
                        <h3 class="mb-4">Welcome to {{ $enrollment->course->title }}</h3>

                        @if ($enrollment->course->instructor)
                            <div class="d-flex align-items-center mb-4">
                                @if ($enrollment->course->instructor->image)
                                    <img src="{{ asset('storage/' . $enrollment->course->instructor->image) }}"
                                        class="rounded-circle me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-0">Instructor</h6>
                                    <p class="mb-0 text-primary">{{ $enrollment->course->instructor->name }}</p>
                                </div>
                            </div>
                        @endif

                        <p>{{ $enrollment->course->description ?? 'No description available.' }}</p>

                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <div class="bg-white p-3 rounded text-center">
                                    <i class="fa fa-book-open fa-2x text-primary mb-2"></i>
                                    <h6>{{ $enrollment->course->lectures->count() }} Lectures</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white p-3 rounded text-center">
                                    <i class="fa fa-question-circle fa-2x text-primary mb-2"></i>
                                    <h6>{{ $enrollment->course->quizzes->count() }} Quizzes</h6>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="fa fa-info-circle me-2"></i>
                            Select a lecture or quiz from the sidebar to start learning!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Course Content End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-12 text-center">
                    <p class="mb-0">&copy; <a class="border-bottom" href="#">eLEARNIFY</a>, All Right
                        Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
