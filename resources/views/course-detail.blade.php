<!DOCTYPE html>
<html lang="en">

<head>
    <title>Course Details | Elearnify</title>
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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="bg-light">
    @include('partials.navbar')

    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-right">{{ $course->title }}</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item"><a href="{{ route('courses') }}">Courses</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>{{ $course->title }}</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5 pb-4 mt-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Course Content -->
                <div class="section-card">
                    <h4 class="section-title">Course Description</h4>
                    <div class="text-muted mb-4">
                        {!! $course->description !!}
                    </div>

                    <h4 class="section-title mt-5">Course content</h4>
                    <p class="small text-muted mb-4">
                        {{ $course->lectures_count }} lectures • {{ $course->duration }} total length
                    </p>

                    <div class="accordion" id="courseAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#curriculum">
                                    Full Curriculum
                                </button>
                            </h2>
                            <div id="curriculum" class="accordion-collapse collapse show">
                                <div class="accordion-body px-4">
                                    @forelse($course->lectures as $index => $lecture)
                                        <div
                                            class="lesson-item {{ $isEnrolled || $lecture->is_free ? 'text-dark' : 'text-muted' }}">
                                            <div class="lesson-title">
                                                @if ($isEnrolled || $lecture->is_free)
                                                    <i class="bi bi-play-circle-fill text-primary"></i>
                                                @else
                                                    <i class="bi bi-lock-fill"></i>
                                                @endif
                                                <span>{{ $lecture->title }}</span>
                                            </div>
                                            <span class="small">{{ $lecture->short_description ?? '' }}</span>
                                        </div>
                                    @empty
                                        <p class="text-muted small">No lectures available for this course yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructor -->
                <div class="section-card">
                    <h4 class="section-title">Instructor</h4>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $course->instructor && $course->instructor->profile_image ? asset('storage/' . $course->instructor->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($course->instructor->name ?? 'Instructor') . '&background=6366f1&color=fff' }}"
                            class="instructor-img" alt="Instructor">
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $course->instructor->name ?? 'N/A' }}</h5>
                            <p class="text-muted small mb-0">
                                {{ $course->instructor->designation ?? 'Expert Instructor' }}</p>
                        </div>
                    </div>
                    <p class="text-muted small">
                        {{ $course->instructor->bio ?? 'No biography available.' }}
                    </p>
                </div>

            </div>
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="section-card border-0 shadow-lg">
                        <!-- Thumbnail Section -->
                        <div class="preview-img-container mb-3">
                            @if ($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}"
                                    class="course-thumbnail img-fluid rounded" alt="{{ $course->title }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=800"
                                    class="course-thumbnail img-fluid rounded" alt="{{ $course->title }}">
                            @endif
                        </div>

                        <!-- Price Section -->
                        <div class="price-container mb-3 text-center">
                            @if ($course->price > 0)
                                <h2 class="fw-bold text-dark">₹{{ number_format($course->price, 2) }}</h2>
                            @else
                                <h2 class="fw-bold text-success">FREE</h2>
                            @endif
                        </div>

                        <!-- Series Info Section -->
                        <div class="info-list">
                            <h6 class="fw-bold mb-4 small uppercase text-muted" style="letter-spacing: 0.1em;">Course
                                Info</h6>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-list-ul"></i>
                                    <span>Lessons</span>
                                </div>
                                <span class="info-value">{{ $course->lectures_count }}</span>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-clock"></i>
                                    <span>Duration</span>
                                </div>
                                <span class="info-value">{{ $course->duration ?? 'N/A' }}</span>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-calendar3"></i>
                                    <span>Last Updated</span>
                                </div>
                                <span class="info-value">{{ $course->updated_at->format('M Y') }}</span>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-folder2"></i>
                                    <span>Category</span>
                                </div>
                                <span class="info-value">{{ $course->category->name ?? 'General' }}</span>
                            </div>
                        </div>

                        <!-- Action Footer -->
                        <div class="card-actions mt-4">
                            @php
                                $firstLecture = $course->lectures->first();
                            @endphp
                            @if ($isEnrolled && $firstLecture)
                                <a href="{{ route('user.lecture.view', $firstLecture->id) }}"
                                    class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                                    <i class="bi bi-play-fill me-2"></i> Continue Learning
                                </a>
                            @elseif($isEnrolled)
                                <button class="btn btn-secondary w-100 py-3 rounded-3 fw-bold" disabled>
                                    No Lectures Yet
                                </button>
                            @else
                                <form action="{{ route('course.pay', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                                        <i class="bi bi-cart-fill me-2"></i>
                                        {{ $course->price > 0 ? 'Buy Now' : 'Enroll Now' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Continue Learning Section -->
    <section class="continue-learning-section">
        <div class="container text-start">
            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-collection-play-fill text-primary"></i> More Courses
            </h4>

            <div class="swiper moreCoursesSwiper">
                <div class="swiper-wrapper">
                    @foreach ($relatedCourses as $related)
                        <div class="swiper-slide">
                            <a href="{{ route('course.detail', $related->id) }}" class="learning-mini-card">
                                @if ($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="mini-card-img"
                                        alt="{{ $related->title }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?auto=format&fit=crop&q=80&w=400"
                                        class="mini-card-img" alt="{{ $related->title }}">
                                @endif
                                <div class="mini-card-title">{{ $related->title }}</div>
                                <div class="mini-card-instructor">With {{ $related->instructor->name ?? 'Expert' }}</div>
                                <div class="mini-card-meta">
                                    <div class="meta-row"><i class="bi bi-list-ul"></i>
                                        {{ $related->lectures_count ?? $related->lectures->count() }} Episodes</div>
                                    <div class="meta-row"><i class="bi bi-bar-chart-steps"></i>
                                        {{ $related->duration ?? 'N/A' }}</div>
                                    <div class="meta-row"><i class="bi bi-folder2"></i>
                                        {{ $related->category->name ?? 'General' }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/components.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".moreCoursesSwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                },
            });
        });
    </script>
</body>

</html>
