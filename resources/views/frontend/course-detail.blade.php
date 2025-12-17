<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $course->title }} | eLEARNIFY</title>
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
                @auth
                    <a href="{{ route('user.dashboard') }}" class="nav-item nav-link">My Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-item nav-link btn btn-link"
                            style="text-decoration: none;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Course Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        @if ($course->image)
                            <img class="img-fluid w-100 rounded" src="{{ asset('storage/' . $course->image) }}"
                                alt="{{ $course->title }}" style="max-height: 400px; object-fit: cover;">
                        @endif
                    </div>
                    <h1 class="mb-4">{{ $course->title }}</h1>
                    <div class="d-flex mb-3">
                        <small class="me-3"><i
                                class="fa fa-tag text-primary me-2"></i>{{ $course->category->name ?? 'Uncategorized' }}</small>
                        @if ($course->duration)
                            <small class="me-3"><i
                                    class="fa fa-clock text-primary me-2"></i>{{ $course->duration }}</small>
                        @endif
                        @if ($course->instructor)
                            <small><i class="fa fa-user text-primary me-2"></i>{{ $course->instructor->name }}</small>
                        @endif
                    </div>
                    <h5 class="mb-3">Course Description</h5>
                    <p>{{ $course->description ?? 'No description available.' }}</p>

                    <h5 class="mb-3 mt-4">Course Content</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="bg-light p-3 text-center rounded">
                                <i class="fa fa-book-open fa-2x text-primary mb-2"></i>
                                <h6>{{ $course->lectures_count ?? 0 }} Lectures</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 text-center rounded">
                                <i class="fa fa-question-circle fa-2x text-primary mb-2"></i>
                                <h6>{{ $course->quizzes_count ?? 0 }} Quizzes</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 text-center rounded">
                                <i class="fa fa-certificate fa-2x text-primary mb-2"></i>
                                <h6>Certificate</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top" style="top: 100px;">
                        <h3 class="text-primary mb-4">₹{{ number_format($course->price, 2) }}</h3>

                        @if ($isEnrolled)
                            <a href="{{ route('user.dashboard') }}" class="btn btn-success w-100 py-3 mb-3">
                                <i class="fa fa-check me-2"></i>Already Enrolled - Go to Dashboard
                            </a>
                        @else
                            @auth
                                <form action="{{ route('course.pay', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                                        <i class="fa fa-shopping-cart me-2"></i>Pay ₹{{ number_format($course->price, 2) }}
                                        & Enroll
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 mb-3">
                                    <i class="fa fa-sign-in-alt me-2"></i>Login to Enroll
                                </a>
                            @endauth
                        @endif

                        <h5 class="mb-3">This course includes:</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fa fa-check text-primary me-2"></i>{{ $course->lectures_count ?? 0 }}
                                Lectures</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fa fa-check text-primary me-2"></i>{{ $course->quizzes_count ?? 0 }}
                                Quizzes</span>
                        </div>
                        @if ($course->duration)
                            <div class="d-flex justify-content-between mb-3">
                                <span><i class="fa fa-check text-primary me-2"></i>Duration:
                                    {{ $course->duration }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fa fa-check text-primary me-2"></i>Full lifetime access</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fa fa-check text-primary me-2"></i>Certificate of completion</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Course Detail End -->

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
