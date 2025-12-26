@extends('layouts.frontend')

@section('title', 'My Quizzes | eLEARNIFY')

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

        .btn-outline-primary {
            color: #0a2283 !important;
            border-color: #0a2283 !important;
        }

        .btn-outline-primary:hover {
            background-color: #0a2283 !important;
            border-color: #0a2283 !important;
            color: #fff !important;
        }

        /* Stats Cards */
        .stats-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .stats-card .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stats-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .stats-card .label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Quiz Card */
        .quiz-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .quiz-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .score-badge {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .score-badge.pass {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .score-badge.fail {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
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
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="bi bi-clipboard-check me-2"></i>My Quizzes</h3>
                    </div>

                    <!-- Stats Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-6">
                            <div class="stats-card">
                                <div class="icon text-primary">
                                    <i class="bi bi-clipboard-data"></i>
                                </div>
                                <div class="value">{{ $stats['total'] }}</div>
                                <div class="label">Total Quizzes</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-card">
                                <div class="icon text-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="value">{{ $stats['passed'] }}</div>
                                <div class="label">Passed</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-card">
                                <div class="icon text-danger">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                                <div class="value">{{ $stats['failed'] }}</div>
                                <div class="label">Failed</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-card">
                                <div class="icon text-warning">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="value">{{ number_format($stats['avg_score'], 1) }}%</div>
                                <div class="label">Avg Score</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Attempts List -->
                    @if ($attempts->count() > 0)
                        @foreach ($attempts as $attempt)
                            @php
                                $percentage =
                                    $attempt->total_questions > 0
                                        ? ($attempt->score / $attempt->total_questions) * 100
                                        : 0;
                                $isPassed = $percentage >= 60;
                            @endphp
                            <div class="quiz-card">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="mb-2">
                                            <i class="bi bi-patch-question me-2 text-primary"></i>
                                            {{ $attempt->quiz->title }}
                                        </h5>
                                        <p class="text-muted mb-1 small">
                                            @if ($attempt->quiz->course)
                                                <i class="bi bi-book me-1"></i>
                                                {{ $attempt->quiz->course->title }}
                                            @elseif($attempt->quiz->lecture)
                                                <i class="bi bi-play-circle me-1"></i>
                                                {{ $attempt->quiz->lecture->title }}
                                            @endif
                                        </p>
                                        <p class="text-muted mb-0 small">
                                            <i class="bi bi-calendar me-1"></i>
                                            Completed: {{ $attempt->completed_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-center my-3 my-md-0">
                                        <div class="score-badge {{ $isPassed ? 'pass' : 'fail' }}">
                                            {{ $attempt->score }}/{{ $attempt->total_questions }}
                                            <div class="small" style="font-size: 0.8rem; font-weight: normal;">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('user.quiz.result', $attempt->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> View Results
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $attempts->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-clipboard-x"></i>
                            <h4>No Quizzes Taken Yet</h4>
                            <p class="text-muted">You haven't attempted any quizzes yet. Start learning and test your
                                knowledge!</p>
                            <a href="{{ route('courses') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-book me-2"></i>Explore Courses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
