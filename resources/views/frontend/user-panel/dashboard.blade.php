@extends('layouts.frontend')

@section('title', 'My Dashboard | eLEARNIFY')

@section('content')
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
                            <i class="fa fa-3x fa-list-alt text-primary mb-4"></i>
                            <h5 class="mb-3">Learning Assets</h5>
                            <h2 class="text-primary">{{ $stats['total_items'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Enrolled Courses -->
            <div class="text-center mb-4">
                <h3>My Enrolled Courses</h3>
            </div>
            <div class="row g-4">
                @forelse($enrollments as $enrollment)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img class="img-fluid w-100 h-100"
                                    src="{{ $enrollment->course->image ? asset('storage/' . $enrollment->course->image) : asset('frontend/img/course-1.jpg') }}"
                                    alt="" style="object-fit: cover;">
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    <a href="{{ route('user.course.view', $enrollment->id) }}"
                                        class="btn btn-primary px-4 py-2 rounded-pill">Continue Learning</a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <small
                                        class="text-primary fw-bold">{{ $enrollment->course->category->name ?? 'Category' }}</small>
                                    <small class="text-muted">{{ $enrollment->progress }}% Complete</small>
                                </div>
                                <h5 class="mb-3">{{ $enrollment->course->title }}</h5>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">You are not enrolled in any courses yet.</p>
                        <a href="{{ route('courses') }}" class="btn btn-primary px-5 py-3 rounded-pill">Explore Courses</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Dashboard End -->
@endsection
