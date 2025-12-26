@extends('layouts.frontend')

@section('title', 'My Certificates | eLEARNIFY')

@push('styles')
    <style>
        .dashboard-container {
            background-color: #f5f7f9;
            min-height: 100vh;
            padding-top: 140px;
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

        /* Certificate Card */
        .certificate-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .certificate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .certificate-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .certificate-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .certificate-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .certificate-meta {
            opacity: 0.9;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .certificate-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .certificate-actions .btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .certificate-actions .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .header-section {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 30px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .empty-state i {
            font-size: 5rem;
            color: #ffc107;
            margin-bottom: 20px;
        }

        /* Gradient variations for different certificates */
        .certificate-card:nth-child(3n+1) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .certificate-card:nth-child(3n+2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .certificate-card:nth-child(3n+3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Aggressive Branding Overrides */
        .btn-primary,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: #0a2283 !important;
            border-color: #0a2283 !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background-color: #081b6a !important;
            border-color: #081b6a !important;
            color: #fff !important;
        }

        .text-primary {
            color: #0a2283 !important;
        }

        .bg-primary {
            background-color: #0a2283 !important;
        }

        .progress-bar {
            background-color: #0a2283 !important;
        }

        .dashboard-menu .nav-link:hover,
        .dashboard-menu .nav-link.active {
            color: #0a2283 !important;
            border-left-color: #0a2283 !important;
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
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-2">
                                    <i class="bi bi-award me-2 text-warning"></i>My Certificates
                                </h3>
                                <p class="text-muted mb-0">
                                    You have earned <strong>{{ $stats['total'] }}</strong>
                                    certificate{{ $stats['total'] != 1 ? 's' : '' }}
                                </p>
                            </div>
                            @if ($stats['total'] > 0)
                                <div>
                                    <span class="badge bg-warning text-dark" style="font-size: 1.5rem; padding: 10px 20px;">
                                        <i class="bi bi-trophy-fill me-2"></i>{{ $stats['total'] }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Certificates Grid -->
                    @if ($completedEnrollments->count() > 0)
                        <div class="row g-4">
                            @foreach ($completedEnrollments as $enrollment)
                                <div class="col-md-6">
                                    <div class="certificate-card">
                                        <div class="certificate-icon">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </div>
                                        <div class="certificate-title">
                                            {{ $enrollment->course->title }}
                                        </div>
                                        <div class="certificate-meta">
                                            <div class="mb-1">
                                                <i class="bi bi-person-circle me-2"></i>
                                                @if ($enrollment->course->instructor)
                                                    {{ $enrollment->course->instructor->name }}
                                                @else
                                                    eLEARNIFY
                                                @endif
                                            </div>
                                            <div class="mb-1">
                                                <i class="bi bi-calendar-check me-2"></i>
                                                Completed: {{ $enrollment->completed_at->format('M d, Y') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-bookmark-fill me-2"></i>
                                                @if ($enrollment->course->category)
                                                    {{ $enrollment->course->category->name }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="certificate-actions">
                                            <a href="{{ route('user.certificate.download', $enrollment->id) }}"
                                                class="btn btn-sm">
                                                <i class="bi bi-download me-2"></i>Download PDF
                                            </a>
                                            <a href="{{ route('user.course.view', $enrollment->id) }}" class="btn btn-sm">
                                                <i class="bi bi-eye me-2"></i>View Course
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-trophy"></i>
                            <h4>No Certificates Yet</h4>
                            <p class="text-muted mb-4">
                                Complete a course to earn your first certificate!<br>
                                Certificates are awarded when you finish all lectures and quizzes in a course.
                            </p>
                            <a href="{{ route('courses') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-book me-2"></i>Browse Courses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
