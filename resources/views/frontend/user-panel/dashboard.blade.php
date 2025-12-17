<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My Dashboard | eLEARNIFY</title>
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
                <a href="{{ route('user.dashboard') }}" class="nav-item nav-link active">My Dashboard</a>
                <a href="{{ route('user.courses') }}" class="nav-item nav-link">My Courses</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-item nav-link btn btn-link"
                        style="text-decoration: none;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Dashboard Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">My Dashboard</h6>
                <h1 class="mb-5">Welcome back, {{ Auth::user()->name }}!</h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Stats -->
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3 bg-light rounded">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book text-primary mb-4"></i>
                            <h5 class="mb-3">Total Courses</h5>
                            <h2 class="text-primary">{{ $stats['total'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3 bg-light rounded">
                        <div class="p-4">
                            <i class="fa fa-3x fa-play-circle text-primary mb-4"></i>
                            <h5 class="mb-3">Active Courses</h5>
                            <h2 class="text-primary">{{ $stats['active'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3 bg-light rounded">
                        <div class="p-4">
                            <i class="fa fa-3x fa-check-circle text-primary mb-4"></i>
                            <h5 class="mb-3">Completed</h5>
                            <h2 class="text-primary">{{ $stats['completed'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3 bg-light rounded">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chart-line text-primary mb-4"></i>
                            <h5 class="mb-3">Avg Progress</h5>
                            <h2 class="text-primary">{{ round($stats['avg_progress']) }}%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Courses -->
            <div class="text-center mb-4">
                <h3>My Enrolled Courses</h3>
            </div>

            @if ($enrollments->count() > 0)
                <div class="row g-4">
                    @foreach ($enrollments as $enrollment)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                            <div class="course-item bg-light">
                                <div class="position-relative overflow-hidden">
                                    <img class="img-fluid"
                                        src="{{ $enrollment->course->image ? asset('storage/' . $enrollment->course->image) : asset('frontend/img/course-1.jpg') }}"
                                        alt="{{ $enrollment->course->title }}"
                                        style="width: 100%; height: 250px; object-fit: cover;">
                                    <div
                                        class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                        <a href="{{ route('user.course.view', $enrollment->id) }}"
                                            class="btn btn-sm btn-primary px-3">
                                            Continue Learning
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center p-4 pb-0">
                                    <h5 class="mb-3">{{ $enrollment->course->title }}</h5>
                                    <div class="mb-3">
                                        <small
                                            class="text-muted">{{ $enrollment->course->category->name ?? 'Uncategorized' }}</small>
                                    </div>
                                    <div class="progress mb-3" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $enrollment->progress }}%"
                                            aria-valuenow="{{ $enrollment->progress }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">Progress: {{ $enrollment->progress }}%</small>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i
                                            class="fa fa-calendar text-primary me-2"></i>{{ $enrollment->enrolled_at->format('M d, Y') }}
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <span
                                            class="badge {{ $enrollment->status === 'completed' ? 'bg-success' : 'bg-primary' }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-book fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No courses enrolled yet</h4>
                    <p class="text-muted">Start learning by enrolling in a course!</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Browse Courses</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Dashboard End -->

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
