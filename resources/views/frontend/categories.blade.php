<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Categories - Elearnify</title>
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

    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 data-aos="fade-right">All Categories</h2>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>All Categories</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
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
                        <a href="{{ route('courses', ['category' => $category->id]) }}" class="text-decoration-none">
                            <div class="card h-100 border rounded-3 p-3 shadow-sm hover-effect" data-aos="fade-up"
                                data-aos-delay="{{ ($index % 8) * 100 }}" data-aos-duration="1000">
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
                        </a>
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

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/components.js') }}"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
