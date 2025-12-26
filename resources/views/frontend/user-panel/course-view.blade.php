@extends('layouts.frontend')

@section('title', $enrollment->course->title . ' | eLEARNIFY')

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

        /* Course View Content */
        .courses-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 30px;
            min-height: 500px;
        }

        .course-page-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
        }

        .course-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .instructor-badge {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 20px;
        }

        .instructor-badge i {
            color: #0a2283;
            margin-right: 8px;
        }

        .content-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .list-group-item {
            border: 1px solid #eee;
            margin-bottom: 10px;
            border-radius: 8px !important;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            border-color: #0a2283;
        }

        .progress-compact {
            height: 8px;
            border-radius: 10px;
            background-color: #f0f0f0;
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

        .instructor-badge i,
        .content-section-title i {
            color: #0a2283 !important;
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
                        @if (session('quiz_result'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4"
                                role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Quiz Completed!</h6>
                                        <p class="mb-0 small">You scored
                                            <strong>{{ session('quiz_result')['score'] }}/{{ session('quiz_result')['total'] }}</strong>
                                            ({{ session('quiz_result')['percentage'] }}%)
                                        </p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="course-page-header">
                            <a href="{{ route('user.courses') }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            <h2 class="course-page-title mb-0">{{ $enrollment->course->title }}</h2>
                        </div>

                        @if ($enrollment->course->instructor)
                            <div class="instructor-badge">
                                <i class="bi bi-person-workspace"></i>
                                Instructor: <strong>{{ $enrollment->course->instructor->name }}</strong>
                            </div>
                        @endif

                        <div class="row mb-5">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Course Progress</span>
                                    <span class="fw-bold text-primary">{{ round($enrollment->progress) }}%</span>
                                </div>
                                <div class="progress progress-compact">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $enrollment->progress }}%; background-color: #0a2283;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Lectures List -->
                            <div class="col-md-7">
                                <h5 class="content-section-title">
                                    <i class="bi bi-play-btn text-primary"></i> Lectures
                                </h5>
                                <div class="list-group list-group-flush">
                                    @forelse ($enrollment->course->lectures as $lecture)
                                        <a href="{{ route('user.lecture.view', $lecture->id) }}"
                                            class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                            <span><i
                                                    class="bi bi-play-circle me-3 text-primary"></i>{{ $lecture->title }}</span>
                                            <i class="bi bi-chevron-right small text-muted"></i>
                                        </a>
                                    @empty
                                        <div class="text-center py-4 text-muted">No lectures available yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Quizzes & Info -->
                            <div class="col-md-5">
                                <h5 class="content-section-title">
                                    <i class="bi bi-clipboard-check text-primary"></i> Practice Quizzes
                                </h5>
                                <div class="list-group list-group-flush mb-4">
                                    @forelse ($enrollment->course->quizzes as $quiz)
                                        <a href="{{ route('user.quiz.view', $quiz->id) }}"
                                            class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                            <span><i
                                                    class="bi bi-question-circle me-3 text-primary"></i>{{ $quiz->title }}</span>
                                            <i class="bi bi-chevron-right small text-muted"></i>
                                        </a>
                                    @empty
                                        <div class="text-center py-4 text-muted">No quizzes available for this course.</div>
                                    @endforelse
                                </div>

                                <div class="card border-0 bg-light p-4 rounded-3">
                                    <h6 class="fw-bold mb-3">Course Info</h6>
                                    <ul class="list-unstyled mb-0 small text-muted">
                                        <li class="mb-2"><i class="bi bi-book me-2"></i>
                                            {{ $enrollment->course->lectures->count() }} Lectures</li>
                                        <li class="mb-2"><i class="bi bi-patch-question me-2"></i>
                                            {{ $enrollment->course->quizzes->count() }} Quizzes</li>
                                        <li><i class="bi bi-clock me-2"></i>
                                            {{ $enrollment->course->duration ?? 'Self-paced' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-top">
                            <h6 class="fw-bold mb-3">About this course</h6>
                            <p class="text-muted small leading-relaxed">
                                {{ $enrollment->course->description ?? 'No detailed description available.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
