@extends('layouts.frontend')

@section('title', 'eLEARNIFY | Courses')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                <h1 class="mb-5">Courses Categories</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        @if (isset($categories[0]))
                            <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[0]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[0]->image ? asset('storage/' . $categories[0]->image) : asset('frontend/img/cat-1.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[0]->name }}</h5>
                                        <small class="text-primary">{{ $categories[0]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (isset($categories[1]))
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[1]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[1]->image ? asset('storage/' . $categories[1]->image) : asset('frontend/img/cat-2.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[1]->name }}</h5>
                                        <small class="text-primary">{{ $categories[1]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (isset($categories[2]))
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[2]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[2]->image ? asset('storage/' . $categories[2]->image) : asset('frontend/img/cat-3.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[2]->name }}</h5>
                                        <small class="text-primary">{{ $categories[2]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if (isset($categories[3]))
                    <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                        <a class="position-relative d-block h-100 overflow-hidden"
                            href="{{ route('courses', ['category' => $categories[3]->id]) }}">
                            <img class="img-fluid position-absolute w-100 h-100"
                                src="{{ $categories[3]->image ? asset('storage/' . $categories[3]->image) : asset('frontend/img/cat-4.jpg') }}"
                                alt="" style="object-fit: cover;">
                            <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                style="margin: 1px;">
                                <h5 class="m-0">{{ $categories[3]->name }}</h5>
                                <small class="text-primary">{{ $categories[3]->courses_count }} Courses</small>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Categories End -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Our Courses</h1>
            </div>

            @if (request('search') || request('category'))
                <div class="mb-4">
                    @if (request('search'))
                        <h4>Search results for: "{{ request('search') }}"</h4>
                    @endif
                    @if (request('category'))
                        @php $cat = $categories->firstWhere('id', request('category')) ?: \App\Models\Category::find(request('category')); @endphp
                        <h4>Category: "{{ $cat ? $cat->name : 'Unknown' }}"</h4>
                    @endif
                    <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @forelse($courses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100"
                                    src="{{ $course->image ? asset('storage/' . $course->image) : asset('frontend/img/course-1.jpg') }}"
                                    alt="{{ $course->title }}" style="object-fit: cover;">
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    <a href="{{ route('course.detail', $course->id) }}"
                                        class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                                        style="border-radius: 30px 1 0 30px;">Read More</a>
                                    <a href="{{ route('course.detail', $course->id) }}"
                                        class="flex-shrink-0 btn btn-sm btn-primary px-3"
                                        style="border-radius: 0 30px 30px 0;">Join Now</a>
                                </div>
                            </div>
                            <div class="text-center p-4 pb-0">
                                <h3 class="mb-0">₹{{ number_format($course->price, 2) }}</h3>
                                <div class="mb-3 text-primary">
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="text-muted">(123)</small>
                                </div>
                                <h5 class="mb-4">{{ $course->title }}</h5>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2">
                                    <i
                                        class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor->name ?? 'Instructor' }}
                                </small>
                                <small class="flex-fill text-center border-end py-2">
                                    <i class="fa fa-clock text-primary me-2"></i>1.49 Hrs
                                </small>
                                <small class="flex-fill text-center py-2">
                                    <i class="fa fa-user text-primary me-2"></i>30 Students
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No courses found matching your criteria.</h4>
                        <a href="{{ route('courses') }}" class="btn btn-primary mt-3">View All Courses</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Start -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $courses->links() }}
                </div>
            </div>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- Courses End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-1.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <!-- ... (keeping testimonial items for structure) ... -->
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-2.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-3.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-4.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection
