<!DOCTYPE html>
<html lang="en">

<head>
    <title>Our Instructors | Elearnify</title>
    <meta charset="UTF-8">
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

<body class="bg-light">
    @include('partials.navbar')

    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 data-aos="fade-right">Our Instructors</h2>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>Instructors</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- INSTRUCTORS GRID -->
    <section class="py-5">
        <div class="container pb-5">
            <div class="row g-4">

                @forelse($instructors as $instructor)
                    <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div
                            class="mentor-card text-center p-4 border rounded-3 bg-white h-100 shadow-sm hover-shadow transition-all">
                            <div class="img-wrapper mb-3 mx-auto position-relative">
                                @if ($instructor->image)
                                    <img src="{{ asset('storage/' . $instructor->image) }}"
                                        class="rounded-circle img-fluid shadow-sm"
                                        style="width: 120px; height: 120px; object-fit: cover;"
                                        alt="{{ $instructor->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($instructor->name) }}&background=0D8ABC&color=fff&size=120"
                                        class="rounded-circle img-fluid shadow-sm" alt="{{ $instructor->name }}">
                                @endif

                                @if ($instructor->designation)
                                    <span
                                        class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                        {{ $instructor->designation }}
                                    </span>
                                @endif
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $instructor->name }}</h5>
                            <p class="text-muted small mb-3">{{ $instructor->specialty ?? 'Expert Instructor' }}</p>

                            <div class="d-flex justify-content-center gap-3">
                                @if ($instructor->linkedin_url)
                                    <a href="{{ $instructor->linkedin_url }}" target="_blank" class="social-link"><i
                                            class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if ($instructor->twitter_url)
                                    <a href="{{ $instructor->twitter_url }}" target="_blank" class="social-link"><i
                                            class="fab fa-twitter"></i></a>
                                @endif
                                @if ($instructor->github_url)
                                    <a href="{{ $instructor->github_url }}" target="_blank" class="social-link"><i
                                            class="fab fa-github"></i></a>
                                @endif
                                @if ($instructor->instagram_url)
                                    <a href="{{ $instructor->instagram_url }}" target="_blank" class="social-link"><i
                                            class="fab fa-instagram"></i></a>
                                @endif
                                @if ($instructor->website_url)
                                    <a href="{{ $instructor->website_url }}" target="_blank" class="social-link"><i
                                            class="fas fa-globe"></i></a>
                                @endif

                                @if (
                                    !$instructor->linkedin_url &&
                                        !$instructor->twitter_url &&
                                        !$instructor->github_url &&
                                        !$instructor->instagram_url &&
                                        !$instructor->website_url)
                                    <span class="text-muted small">Professional Profile</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-muted opacity-25"></i>
                        </div>
                        <h4 class="text-muted">No instructors found at the moment.</h4>
                        <p class="text-muted">Please check back later as we onboard our world-class experts.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
                    </div>
                @endforelse

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
