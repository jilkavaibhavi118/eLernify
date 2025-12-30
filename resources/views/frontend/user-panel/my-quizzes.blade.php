@extends('layouts.frontend')

@section('title', 'My Quizzes | eLEARNIFY')

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
