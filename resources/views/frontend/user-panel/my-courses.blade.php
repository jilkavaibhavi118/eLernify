@extends('layouts.frontend')

@section('title', 'My Courses | eLEARNIFY')

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

        .app-download-card {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        /* My Courses Content */
        .courses-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 30px;
            min-height: 500px;
        }

        .courses-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .courses-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .custom-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 30px;
            display: flex;
            gap: 30px;
        }

        .custom-tab-item {
            padding-bottom: 15px;
            color: #555;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            cursor: pointer;
        }

        .custom-tab-item.active {
            color: #004aad;
            /* Dark Blue */
            border-bottom-color: #004aad;
        }

        .custom-tab-item:hover {
            color: #004aad;
        }

        .empty-state-alert {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .empty-state-alert a {
            color: #0d6efd;
            text-decoration: underline;
        }

        .empty-state-content {
            padding-top: 10px;
        }

        .empty-state-title {
            color: #00235B;
            /* Dark Blue */
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .empty-state-text {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        /* Course Card Hover Effect */
        .course-card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.user-panel.components.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="courses-card">

                        <div class="courses-header">
                            <div class="courses-title">
                                <i class="bi bi-journal-bookmark me-2"></i> My Courses
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="custom-tabs">
                            <a href="#" class="custom-tab-item active">Courses</a>
                            <a href="#" class="custom-tab-item">Live Lecures</a>
                            <a href="#" class="custom-tab-item">Certificates</a>
                        </div>

                        @if ($enrollments->count() > 0)
                            <!-- Actual Enrolled Courses List (If any) -->
                            <div class="row g-4">
                                @foreach ($enrollments as $enrollment)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 border-0 shadow-sm course-card-hover">
                                            <img src="{{ asset('storage/' . $enrollment->course->image) }}"
                                                class="card-img-top" alt="{{ $enrollment->course->title }}"
                                                style="height: 160px; object-fit: cover;">
                                            <div class="card-body">
                                                <h6 class="card-title mb-2 text-truncate"
                                                    title="{{ $enrollment->course->title }}">
                                                    {{ $enrollment->course->title }}</h6>
                                                <div class="progress mb-2" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $enrollment->progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $enrollment->progress }}% Completed</small>
                                                <a href="{{ route('user.course.view', $enrollment->id) }}"
                                                    class="btn btn-primary btn-sm w-100 mt-3">Continue</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $enrollments->links() }}
                            </div>
                        @else
                            <!-- Empty State (Matching Screenshot) -->
                            <div class="empty-state-alert">
                                You have not enrolled for any courses, <a href="{{ route('courses') }}">start
                                    learning</a>
                            </div>

                            <div class="empty-state-content">
                                <h3 class="empty-state-title">Learn Any Course For Free In Your Own Language</h3>
                                <p class="empty-state-text">Level up your skills and take the next step in your career with
                                    our 80+ online video courses.</p>

                                <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2">Explore
                                    Courses</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
