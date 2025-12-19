@extends('layouts.frontend')

@section('title', 'eLEARNIFY | Lectures')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Lectures</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Lectures</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Lectures Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Lectures</h6>
                <h1 class="mb-5">Our Featured Lectures</h1>
            </div>

            @if (request('search'))
                <div class="mb-4">
                    <h4>Search results for: "{{ request('search') }}"</h4>
                    <a href="{{ route('lectures.index') }}" class="btn btn-sm btn-outline-secondary">Clear Search</a>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @forelse($lectures as $lecture)
                    @php
                        $hasAccess =
                            $lecture->is_free ||
                            (auth()->check() &&
                                (auth()->user()->hasRole('admin') ||
                                    auth()->user()->hasPurchased('lecture', $lecture->id) ||
                                    auth()->user()->enrolledCourses->contains($lecture->course_id)));
                    @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100"
                                    src="{{ $lecture->course->image ? asset('storage/' . $lecture->course->image) : asset('frontend/img/course-1.jpg') }}"
                                    alt="{{ $lecture->title }}" style="object-fit: cover;">
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    @if ($hasAccess)
                                        <a href="{{ route('lecture.view', $lecture->id) }}"
                                            class="btn btn-sm btn-primary px-4 rounded-pill">View Lecture</a>
                                    @else
                                        @guest
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-4 rounded-pill">Buy
                                                Now</a>
                                        @else
                                            <form action="{{ route('purchase.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="lecture">
                                                <input type="hidden" name="id" value="{{ $lecture->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill">Buy
                                                    Now</button>
                                            </form>
                                        @endguest
                                    @endif
                                </div>
                            </div>
                            <div class="text-center p-4">
                                <h3 class="mb-0">
                                    @if ($lecture->is_free)
                                        Free
                                    @else
                                        ₹{{ number_format($lecture->price, 2) }}
                                    @endif
                                </h3>
                                <div class="mb-3 text-primary">
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                    <small class="fa fa-star"></small>
                                </div>
                                <h5 class="mb-3">{{ $lecture->title }}</h5>
                                <p class="text-muted small">{{ $lecture->short_description }}</p>
                            </div>
                            <div class="d-flex border-top text-center">
                                <small class="flex-fill py-2 border-end">
                                    <i
                                        class="fa fa-book-open text-primary me-2"></i>{{ $lecture->course->title ?? 'General' }}
                                </small>
                                <small class="flex-fill py-2">
                                    <i class="fa fa-clock text-primary me-2"></i>{{ $lecture->duration ?? 'N/A' }} Mins
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No lectures found.</h4>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Start -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $lectures->links() }}
                </div>
            </div>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- Lectures End -->
@endsection
