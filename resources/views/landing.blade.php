<!DOCTYPE html>
<html lang="en">

<head>
    <title>Elearnify - Find The Best Online Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')

    <section class="hero-gradient py-5">
        <div class="container py-lg-5">
            <div class="row align-items-center gy-5">

                <div class="col-lg-6 col-12">
                    <h1 class="display-4 fw-bold text-dark mb-4 lh-sm">
                        Find The Best Course <br>
                        <span class="text-primary" id="typing-text"></span><span class="typing-cursor"></span>
                    </h1>

                    <p class="lead text-secondary mb-5 pe-lg-5">
                        Join millions of learners on the world's leading e-learning platform.
                        Access expert-led courses in AI, development, design, and business strategies.
                    </p>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#" class="btn btn-primary-custom btn-lg rounded-pill px-5 fw-semibold shadow-sm">
                            Get Started
                        </a>
                        <a href="{{ route('courses') }}"
                            class="btn btn-outline-dark btn-lg rounded-pill px-5 fw-semibold">
                            View Courses
                        </a>
                    </div>

                </div>

                <div class="col-lg-6 col-12 ps-lg-5">
                    <div class="image-wrapper">
                        <img src="{{ asset('frontend/img/Software integration-bro.png') }}" class="img-fluid rounded-5"
                            alt="Student learning online">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row g-4">

                <div
                    class="col-lg-3 col-md-6 col-12 d-flex align-items-center justify-content-center border-end-custom">
                    <div class="icon-box rounded-circle p-3 me-3">
                        <i class="bi bi-laptop fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0"><span class="counter" data-target="8000">0</span>+</h3>
                        <p class="mb-0 small opacity-75">Online Courses</p>
                    </div>
                </div>

                <div
                    class="col-lg-3 col-md-6 col-12 d-flex align-items-center justify-content-center border-end-custom">
                    <div class="icon-box rounded-circle p-3 me-3">
                        <i class="bi bi-patch-check fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0"><span class="counter" data-target="450">0</span>+</h3>
                        <p class="mb-0 small opacity-75">Expert Mentors</p>
                    </div>
                </div>

                <div
                    class="col-lg-3 col-md-6 col-12 d-flex align-items-center justify-content-center border-end-custom">
                    <div class="icon-box rounded-circle p-3 me-3">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0"><span class="counter" data-target="7000">0</span>+</h3>
                        <p class="mb-0 small opacity-75">Certificates Issued</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 d-flex align-items-center justify-content-center">
                    <div class="icon-box rounded-circle p-3 me-3">
                        <i class="bi bi-globe fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0"><span class="counter" data-target="120">0</span>+</h3>
                        <p class="mb-0 small opacity-75">Countries</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white mt-5">
        <div class="container">

            <div class="row align-items-end mb-5" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-md-8">
                    <h6 class="text-primary fw-bold text-uppercase small ls-1 mb-2">
                        <i class="fas fa-file-alt me-2"></i> Our Course Categories
                    </h6>
                    <h2 class="display-6 fw-bold text-dark">
                        Top Most Unique Category
                    </h2>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2 rounded-2 fw-medium">
                        ALL CATEGORY
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-5">
                @php
                    $catIcons = [
                        'fa-laptop-code',
                        'fa-bullhorn',
                        'fa-pen-nib',
                        'fa-palette',
                        'fa-atom',
                        'fa-music',
                        'fa-chart-line',
                        'fa-briefcase',
                    ];
                @endphp

                @forelse($categories as $index => $category)
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card h-100 border rounded-3 p-3 shadow-sm hover-effect" data-aos="fade-up"
                            data-aos-delay="{{ $index * 100 }}" data-aos-duration="1000">
                            <div class="d-flex align-items-center">
                                <div
                                    class="icon-box-blue flex-shrink-0 d-flex align-items-center justify-content-center rounded-3 me-3">
                                    <i class="fas {{ $catIcons[$index % count($catIcons)] }} fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1 card-title">{{ $category->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $category->courses_count }} Courses</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                        <p>No categories available yet.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <section class="py-5 bg-light position-relative">
        <div class="container">

            <div class="d-flex justify-content-between align-items-end mb-4" data-aos="fade-down"
                data-aos-duration="800">
                <div>
                    <h6 class="text-primary fw-bold text-uppercase small ls-1 mb-2">
                        <i class="fas fa-book-reader me-2"></i> Explore
                    </h6>
                    <h2 class="display-6 fw-bold text-dark">Popular Courses</h2>
                </div>

                <div class="d-flex gap-2">
                    <button
                        class="btn btn-white border rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                        id="scrollLeftBtn" style="width: 45px; height: 45px; transition: all 0.3s;">
                        <i class="fas fa-chevron-left text-primary"></i>
                    </button>
                    <button
                        class="btn btn-primary rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                        id="scrollRightBtn" style="width: 45px; height: 45px; transition: all 0.3s;">
                        <i class="fas fa-chevron-right text-white"></i>
                    </button>
                </div>
            </div>

            <div class="course-scroll-container d-flex gap-4 py-2" id="courseContainer">

                @forelse($popularCourses as $index => $course)
                    <a href="{{ route('course.detail', $course->id) }}"
                        class="course-card border-0 rounded-3 shadow-sm bg-white flex-shrink-0 text-decoration-none d-block text-reset"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" data-aos-duration="1000">
                        <div class="position-relative">
                            @if ($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}"
                                    class="card-img-top rounded-top-3" alt="{{ $course->title }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&w=600&q=80"
                                    class="card-img-top rounded-top-3" alt="{{ $course->title }}">
                            @endif
                            <span
                                class="badge bg-primary position-absolute top-0 start-0 m-3">{{ $course->category->name ?? 'General' }}</span>
                        </div>
                        <div class="card-body p-3">
                            <h5 class="fw-bold text-dark mb-3 text-truncate-2">{{ $course->title }}</h5>

                            <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                <span><i class="far fa-clock me-1 text-primary"></i>
                                    {{ $course->duration ?? 'N/A' }}</span>
                                <span><i class="fas fa-book-open me-1 text-primary"></i>
                                    {{ $course->lectures->count() }} Lessons</span>
                                <span><i class="far fa-calendar-alt me-1 text-primary"></i>
                                    {{ $course->created_at->format('M d') }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5 w-100">
                        <i class="fas fa-book-open fa-3x mb-3 opacity-50"></i>
                        <p>No courses available yet.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">

            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase small ls-1 mb-2">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Meet Our Team
                </h6>
                <h2 class="display-6 fw-bold text-dark">Expert Mentors</h2>
                <p class="text-muted col-md-8 mx-auto">
                    Learn from the very best. Our mentors are industry leaders with years of real-world experience.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Mentor 1">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                CEO & Founder
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">James Anderson</h5>
                        <p class="text-muted small mb-3">Business Strategy Expert</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Mentor 2">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                Senior Dev
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Sarah Jenkins</h5>
                        <p class="text-muted small mb-3">Full Stack Developer</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Mentor 3">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                Marketing Pro
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Michael Chen</h5>
                        <p class="text-muted small mb-3">Digital Marketing Lead</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Mentor 4">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                UI/UX Lead
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Emily Roberts</h5>
                        <p class="text-muted small mb-3">Product Designer</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-dribbble"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/components.js') }}"></script>
</body>

</html>
