<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Courses | Elearnify</title>
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
                    <h2 data-aos="fade-right">All Courses</h2>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>All Courses</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="filter-card-section py-4">
        <div class="container">
            <div class="filter-card shadow-sm border p-4 bg-white rounded-4">
                <form action="{{ route('courses') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-search text-primary"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-start-0" placeholder="Search courses...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->courses_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ALL COURSES GRID -->
    <section class="popular-courses-section pt-4">
        <div class="container">
            <div class="section-header mb-5 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Courses</h2>
                <span class="text-muted">{{ $courses->total() }} results found</span>
            </div>

            <div class="row g-4">
                @forelse($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('course.detail', $course->id) }}"
                            class="course-card border-0 rounded-3 shadow-sm bg-white flex-shrink-0 text-decoration-none d-block text-reset">
                            <div class="position-relative">
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}"
                                        class="card-img-top rounded-top-3" alt="{{ $course->title }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=800"
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
                                        {{ $course->lectures_count ?? $course->lectures->count() }} Lessons</span>
                                    <span><i class="far fa-calendar-alt me-1 text-primary"></i>
                                        {{ $course->created_at->format('M d') }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="bi bi-search display-1 text-muted opacity-25"></i>
                            <h4 class="mt-4 text-muted">No courses found matching your criteria.</h4>
                            <a href="{{ route('courses') }}" class="btn btn-link">Clear all filters</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $courses->appends(request()->query())->links() }}
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
