@extends('layouts.frontend')

@section('title', 'My Dashboard | eLEARNIFY')

@push('styles')
    <style>
        .dashboard-container {
            background-color: #f5f7f9;
            min-height: 100vh;
            padding-top: 140px;
            /* Increased spacing as per user request */
            padding-bottom: 50px;
        }

        /* Sidebar Styling */
        .dashboard-sidebar {
            background: #fff;
            border-radius: 10px;
            padding: 20px 0;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .dashboard-menu .nav-link {
            padding: 12px 20px;
            color: #555;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .dashboard-menu .nav-link:hover,
        .dashboard-menu .nav-link.active {
            color: var(--primary);
            background-color: #f8f9fa;
            border-left-color: var(--primary);
        }

        .dashboard-menu .nav-link i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        .app-download-card {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        /* Main Content Styling */
        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            height: 100%;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar-initials {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #0d6efd;
            /* Primary color fallback */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            border: 3px solid #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .stat-item {
            text-align: center;
            position: relative;
        }

        .stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background-color: #dee2e6;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }

        /* Referral Banner */
        .referral-banner {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 10px;
            color: white;
            padding: 0;
            overflow: hidden;
            position: relative;
        }

        .referral-content {
            padding: 30px;
            position: relative;
            z-index: 1;
        }

        .referral-image-container {
            position: absolute;
            right: 20px;
            bottom: 0;
            height: 100%;
            display: flex;
            align-items: flex-end;
        }

        .referral-img {
            max-height: 100%;
            object-fit: contain;
        }

        .copy-link-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            display: flex;
            padding: 5px;
            max-width: 400px;
            align-items: center;
        }

        .copy-link-input {
            border: none;
            background: transparent;
            flex-grow: 1;
            padding: 5px 10px;
            outline: none;
            color: #333;
            font-size: 0.9rem;
        }

        /* Circular Progress */
        .progress-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 8px solid #f0f0f0;
            border-top-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin: 0 auto;
        }

        /* Button Shadow Customization */
        .dashboard-card .btn {
            box-shadow: none !important;
        }

        .dashboard-card .btn-primary {
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3) !important;
            /* Website related color shadow */
            transition: all 0.3s ease;
        }

        .dashboard-card .btn-primary:hover {
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.4) !important;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.user-panel.components.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Row 1: Profile & Stats -->
                    <div class="row g-4 mb-4">
                        <!-- Profile Card -->
                        <div class="col-lg-7">
                            <div class="dashboard-card">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Profile</h5>
                                </div>
                                <div class="profile-header">
                                    @if (Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile"
                                            class="profile-avatar-lg">
                                    @else
                                        <div class="profile-avatar-initials">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                                        <p class="text-muted mb-1 small">{{ Auth::user()->email }}</p>
                                        <p class="text-muted mb-3 small">{{ Auth::user()->phone ?? '+91' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('user.profile') }}" class="btn btn-primary w-100 mt-3">Edit Profile</a>
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div class="col-lg-5">
                            <div class="dashboard-card">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h5 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>My Courses</h5>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-4 stat-item">
                                        <div class="stat-value">{{ $stats['total'] }}</div>
                                        <div class="stat-label">Enrolled</div>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-value">{{ $stats['completed'] }}</div>
                                        <div class="stat-label">Completed</div>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-value">0</div>
                                        <div class="stat-label">Total Certificates</div>
                                    </div>
                                </div>
                                <a href="{{ route('user.courses') }}" class="btn btn-primary w-100">View My Courses</a>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Continue Learning Banner -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="referral-banner">
                                <div class="referral-content position-relative">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            @php
                                                // Get the most recent active enrollment
                                                $lastCourse = $enrollments->first();
                                            @endphp

                                            @if ($lastCourse)
                                                <span class="badge bg-warning text-dark mb-2">Continue Learning</span>
                                                <h4 class="mb-2 text-white">{{ $lastCourse->course->title }}</h4>
                                                <p class="mb-3 opacity-75 small">You are doing great! Pick up right
                                                    where
                                                    you left off and keep moving forward.</p>

                                                <div class="d-flex align-items-center gap-3 mb-3" style="max-width: 400px;">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between text-white small mb-1">
                                                            <span>Progress</span>
                                                            <span>{{ $lastCourse->progress }}%</span>
                                                        </div>
                                                        <div class="progress"
                                                            style="height: 6px; background-color: rgba(255,255,255,0.2);">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: {{ $lastCourse->progress }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('user.course.view', $lastCourse->id) }}"
                                                    class="btn btn-primary border-white fw-bold shadow-sm">
                                                    <i class="bi bi-play-circle-fill me-2"></i> Resume Course
                                                </a>
                                            @else
                                                <h4 class="mb-2 text-white">Start Your Learning Journey</h4>
                                                <p class="mb-3 opacity-75 small">You haven't enrolled in any courses
                                                    yet.
                                                    Browse our library to get started!</p>
                                                <a href="{{ route('courses') }}"
                                                    class="btn btn-primary border-white fw-bold shadow-sm">
                                                    Explore Courses
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Background decoration -->
                                <div class="d-none d-md-block"
                                    style="position: absolute; right: 20px; bottom: 0; width: 250px; height: 100%; display: flex; align-items: flex-end; justify-content: flex-end; opacity: 0.3;">
                                    <i class="bi bi-laptop" style="font-size: 150px; color: white; line-height: 1;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Certificates & Recommended -->
                    <div class="row g-4">
                        <!-- My Certificates -->
                        <div class="col-lg-7">
                            <div class="dashboard-card">
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0"><i class="bi bi-award me-2"></i>My Certificates</h5>
                                    <a href="#"
                                        style="color: var(--primary); text-decoration: none; font-size: 0.875rem;">View
                                        All</a>
                                </div>

                                @php
                                    $completedCourses = $enrollments->where('status', 'completed')->take(3);
                                @endphp

                                @if ($completedCourses->count() > 0)
                                    @foreach ($completedCourses as $enrollment)
                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                            <div class="me-3">
                                                <i class="bi bi-patch-check-fill text-success" style="font-size: 2rem;"></i>
                                            </div>
                                            <div class="flex-grow-1" style="min-width: 0;">
                                                <h6 class="mb-1 text-truncate fw-bold" style="font-size: 0.9rem;">
                                                    {{ $enrollment->course->title }}</h6>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                    <i class="bi bi-calendar-check me-1"></i> Completed on
                                                    {{ $enrollment->updated_at->format('M d, Y') }}
                                                </small>
                                            </div>
                                            <a href="{{ route('user.certificate.download', $enrollment->id) }}"
                                                class="btn btn-sm btn-outline-primary ms-2" style="flex-shrink: 0;">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                    @endforeach

                                    @if ($stats['completed'] > 3)
                                        <div class="text-center mt-3">
                                            <small class="text-muted">+{{ $stats['completed'] - 3 }} more
                                                certificates</small>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3 p-3 rounded-circle bg-light d-inline-block">
                                            <i class="bi bi-trophy text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                        <h6>No Certificates Yet</h6>
                                        <p class="text-muted small mb-0">Complete a course to earn your first certificate!
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Recommended For You -->
                        <div class="col-lg-5">
                            <div class="dashboard-card">
                                <h5 class="mb-3"><i class="bi bi-stars me-2"></i>Recommended for You</h5>

                                @forelse($recommendedCourses as $rCourse)
                                    <div class="d-flex align-items-center mb-3 p-2 border rounded hover-shadow transition"
                                        style="cursor: pointer;">
                                        <img src="{{ asset('storage/' . $rCourse->image) }}" alt="{{ $rCourse->title }}"
                                            class="rounded me-3"
                                            style="width: 70px; height: 50px; object-fit: cover; flex-shrink: 0;">
                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <h6 class="mb-1 text-truncate fw-bold" style="font-size: 0.9rem;">
                                                {{ $rCourse->title }}</h6>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                @if ($rCourse->instructor)
                                                    <i class="bi bi-person me-1"></i> {{ $rCourse->instructor->name }}
                                                @endif
                                            </small>
                                        </div>
                                        <a href="{{ route('course.detail', $rCourse->id) }}"
                                            class="btn btn-sm btn-outline-primary ms-2" style="flex-shrink: 0;"><i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="bi bi-book text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted small mb-0">No recommendations available at the moment.</p>
                                    </div>
                                @endforelse

                                <a href="{{ route('courses') }}" class="btn btn-primary w-100 mt-3">Explore All
                                    Courses</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
@endsection
