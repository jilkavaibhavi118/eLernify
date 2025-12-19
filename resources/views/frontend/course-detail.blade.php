@extends('layouts.frontend')

@section('title', $course->title . ' | eLEARNIFY')

@section('content')
    <!-- Course Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        @if ($course->image)
                            <img class="img-fluid w-100 rounded shadow-sm" src="{{ asset('storage/' . $course->image) }}"
                                alt="{{ $course->title }}" style="max-height: 400px; object-fit: cover;">
                        @endif
                    </div>
                    <h1 class="mb-4">{{ $course->title }}</h1>
                    <div class="d-flex mb-3">
                        <small class="me-4"><i
                                class="fa fa-tag text-primary me-2"></i>{{ $course->category->name ?? 'Uncategorized' }}</small>
                        @if ($course->duration)
                            <small class="me-4"><i
                                    class="fa fa-clock text-primary me-2"></i>{{ $course->duration }}</small>
                        @endif
                        @if ($course->instructor)
                            <small><i class="fa fa-user text-primary me-2"></i>{{ $course->instructor->name }}</small>
                        @endif
                    </div>

                    <div class="mb-5">
                        <h5 class="mb-3">Course Description</h5>
                        <p class="text-muted">{{ $course->description ?? 'No description available.' }}</p>
                    </div>

                    <h5 class="mb-3 mt-4">Course Content</h5>
                    <div class="row g-3">
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="bg-light p-3 text-center rounded border">
                                <i class="fa fa-book-open fa-2x text-primary mb-2"></i>
                                <h6>{{ $course->lectures_count ?? 0 }} Lectures</h6>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="bg-light p-3 text-center rounded border">
                                <i class="fa fa-question-circle fa-2x text-primary mb-2"></i>
                                <h6>{{ $course->quizzes_count ?? 0 }} Quizzes</h6>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="bg-light p-3 text-center rounded border">
                                <i class="fa fa-certificate fa-2x text-primary mb-2"></i>
                                <h6>Certificate</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top shadow-sm border" style="top: 100px;">
                        <h3 class="text-primary mb-4">₹{{ number_format($course->price, 2) }}</h3>

                        @if ($isEnrolled)
                            <a href="{{ route('user.dashboard') }}" class="btn btn-success w-100 py-3 mb-3 rounded-pill">
                                <i class="fa fa-check me-2"></i>Already Enrolled - Go to Dashboard
                            </a>
                        @else
                            @auth
                                <form action="{{ route('course.pay', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 py-3 mb-3 rounded-pill shadow">
                                        <i class="fa fa-shopping-cart me-2"></i>Pay ₹{{ number_format($course->price, 2) }}
                                        & Enroll
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 mb-3 rounded-pill shadow">
                                    <i class="fa fa-sign-in-alt me-2"></i>Login to Enroll
                                </a>
                            @endauth
                        @endif

                        <h5 class="mb-3 pt-3 border-top">This course includes:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fa fa-play-circle text-primary me-3"></i>
                                <span>{{ $course->lectures_count ?? 0 }} Enrolled Lectures</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fa fa-tasks text-primary me-3"></i>
                                <span>{{ $course->quizzes_count ?? 0 }} Practice Quizzes</span>
                            </li>
                            @if ($course->duration)
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fa fa-clock text-primary me-3"></i>
                                    <span>Duration: {{ $course->duration }}</span>
                                </li>
                            @endif
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fa fa-infinity text-primary me-3"></i>
                                <span>Full lifetime access</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fa fa-trophy text-primary me-3"></i>
                                <span>Certificate of completion</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Course Detail End -->
@endsection
