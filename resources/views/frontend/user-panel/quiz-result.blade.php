@extends('layouts.frontend')

@section('title', 'Quiz Result: ' . $quiz->title . ' | Elearnify')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --player-bg: #f9fafb;
            --sidebar-width: 380px;
            --primary-color: #1266c2;
            --primary-light: rgba(18, 102, 194, 0.1);
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--player-bg);
            font-family: 'Inter', sans-serif;
        }

        /* Player Header (Sync with Lecture View) */
        .player-header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        /* Main Layout */
        .player-container {
            display: flex;
            min-height: calc(100vh - 120px);
            max-width: 1600px;
            margin: 2rem auto;
            gap: 2rem;
            padding: 0 2rem;
        }

        .player-main {
            flex: 1;
            min-width: 0;
        }

        .result-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar (Sync with Lecture View) */
        .player-sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 160px);
            position: sticky;
            top: 100px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--primary-color);
            background: #fff;
        }

        .sidebar-header h5 {
            color: var(--text-dark);
            margin: 0;
            position: relative;
        }

        .sidebar-content {
            overflow-y: auto;
            padding: 0;
        }

        .section-group {
            border-bottom: 1px solid var(--border-color);
        }

        .section-group:last-child {
            border-bottom: none;
        }

        .section-header {
            background-color: #f8fafc;
            padding: 1.25rem 1.25rem 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .lesson-list-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.2s;
            border-bottom: 1px solid var(--border-color);
            gap: 1rem;
        }

        .lesson-list-item:last-child {
            border-bottom: none;
        }

        .lesson-list-item:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }

        .lesson-list-item.active {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        .lesson-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: 0.85rem;
            flex-shrink: 0;
            color: var(--text-muted);
        }

        .active .lesson-icon {
            background: var(--primary-color);
            color: #fff;
        }

        .material-title {
            flex-grow: 1;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        @media (max-width: 1200px) {
            .player-container {
                flex-direction: column;
            }

            .player-sidebar {
                width: 100%;
            }

            .sidebar-card {
                position: static;
                max-height: none;
            }
        }

        /* Aggressive Branding Overrides */
        .btn-primary {
            background-color: #1266c2 !important;
            border-color: #1266c2 !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: #0d4a8e !important;
            border-color: #0d4a8e !important;
        }

        .text-primary {
            color: #1266c2 !important;
        }

        .bg-primary {
            background-color: #1266c2 !important;
        }

        .progress-bar {
            background-color: #1266c2 !important;
        }

        /* WhatsApp-style Double Checkmarks */
        .completion-check {
            font-size: 0.75rem;
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .check-icon {
            position: relative;
            display: inline-block;
            width: 14px;
            height: 10px;
            color: #bdc3c7;
            /* Muted gray (default) */
        }

        .check-icon.completed {
            color: #34b7f1;
            /* WhatsApp blue */
        }

        .check-icon i {
            position: absolute;
        }

        .check-icon i:last-child {
            left: 4px;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <header class="player-header">
        <div class="header-container">
            <a href="{{ $enrollment ? route('user.course.view', $enrollment->id) : route('user.dashboard') }}"
                class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Course Dashboard
            </a>
            <div class="player-title-section">
                <h1>Quiz Results: {{ $quiz->title }}</h1>
            </div>
        </div>
    </header>

    <div class="player-container">
        <!-- Main Content Area -->
        <main class="player-main">
            <div class="result-card">
                <div class="text-center mb-5">
                    <div
                        class="display-3 fw-bold text-primary mb-2 shadow-sm d-inline-block px-4 py-2 bg-white rounded-pill border">
                        {{ $attempt->score }} <span class="text-muted h4">/ {{ $attempt->total_questions }}</span>
                    </div>
                    @php
                        $percentage =
                            $attempt->total_questions > 0 ? ($attempt->score / $attempt->total_questions) * 100 : 0;
                    @endphp
                    <h4 class="mt-3 {{ $percentage >= 50 ? 'text-success' : 'text-danger' }}">
                        <i class="fa {{ $percentage >= 50 ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                        {{ number_format($percentage, 2) }}% - {{ $percentage >= 50 ? 'Passed' : 'Failed' }}
                    </h4>
                </div>

                <hr class="my-5 opacity-10">

                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="fa fa-list-check text-primary me-3"></i>Review Detailed Answers
                </h5>

                @foreach ($quiz->questions as $index => $question)
                    @php
                        $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
                        $userOptionId = $userAnswer ? $userAnswer->question_option_id : null;
                        $correctOption = $question->options->where('is_correct', true)->first();
                        $isCorrect = $userAnswer && $userAnswer->is_correct;
                    @endphp

                    <div class="mb-5 border rounded-4 overflow-hidden">
                        <div
                            class="p-4 {{ $isCorrect ? 'bg-success-subtle' : 'bg-danger-subtle' }} border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">
                                <span
                                    class="badge bg-{{ $isCorrect ? 'success' : 'danger' }} me-2">{{ $index + 1 }}</span>
                                {{ $question->question_text }}
                            </h6>
                            <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                            </span>
                        </div>
                        <div class="p-4 bg-white">
                            @foreach ($question->options as $option)
                                <div
                                    class="p-3 mb-2 rounded-3 border d-flex align-items-center
                                    @if ($option->id == $userOptionId && $option->is_correct) border-success bg-success-subtle
                                    @elseif($option->id == $userOptionId && !$option->is_correct) border-danger bg-danger-subtle
                                    @elseif($option->is_correct) border-success
                                    @else opacity-50 @endif
                                ">
                                    <i
                                        class="fa {{ $option->is_correct ? 'fa-check-circle text-success' : ($option->id == $userOptionId ? 'fa-times-circle text-danger' : 'fa-circle-notch opacity-10') }} me-3"></i>
                                    <span>{{ $option->option_text }}</span>
                                    @if ($option->id == $userOptionId)
                                        <small class="ms-auto text-muted">(Your Answer)</small>
                                    @endif
                                </div>
                            @endforeach

                            @if ($question->explanation)
                                <div class="mt-3 p-3 rounded-3 border-start border-primary border-4 small"
                                    style="background-color: var(--primary-light);">
                                    <strong><i class="fa fa-lightbulb text-primary me-2"></i>Explanation:</strong>
                                    <p class="mb-0 mt-1 text-muted">{{ $question->explanation }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="text-center mt-5 d-flex justify-content-center gap-3">
                    <a href="{{ route('user.quiz.view', $quiz->id) }}"
                        class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm border-0">
                        <i class="fa fa-redo me-2"></i>Re-attempt Quiz
                    </a>
                    @if ($enrollment)
                        <a href="{{ route('user.course.view', $enrollment->id) }}"
                            class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fa fa-graduation-cap me-2"></i>Return to Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                            class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fa fa-home me-2"></i>Back to My Courses
                        </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="player-sidebar">
            @if ($enrollment)
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="fw-bold mb-1">Course Curriculum</h5>
                        <div class="progress mt-3" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress ?? 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-content">
                        @php $materialCounter = 1; @endphp
                        @foreach ($enrollment->course->lectures as $l)
                            <div class="section-group">
                                <div class="section-header">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="text-primary fw-bold small text-uppercase">Lecture
                                            {{ $loop->iteration }}</span>
                                        <span class="badge bg-light text-primary fw-normal border"
                                            style="font-size: 0.65rem; border-color: var(--primary-light) !important;">
                                            {{ $l->materials->filter(fn($m) => !empty($m->video_path) || !empty($m->content_url))->count() }}
                                            Videos
                                        </span>
                                    </div>
                                    <div class="fw-bold"
                                        style="font-size: 0.95rem; line-height: 1.3; color: var(--text-dark);">
                                        {{ $l->title }}
                                    </div>
                                </div>

                                @foreach ($l->materials as $m)
                                    @if (!empty($m->video_path) || !empty($m->content_url))
                                        <a href="{{ route('user.lecture.view', ['lectureId' => $l->id, 'materialId' => $m->id]) }}"
                                            class="lesson-list-item">
                                            <div class="lesson-icon">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                            <div class="material-title">
                                                {{ sprintf('%02d', $materialCounter++) }} - {{ $m->title }}
                                            </div>
                                            <div class="completion-check">
                                                <span
                                                    class="check-icon {{ in_array($m->id, $completedMaterialIds ?? []) ? 'completed' : '' }}">
                                                    <i class="fas fa-check"></i>
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach

                                @foreach ($l->quizzes as $q)
                                    <a href="{{ route('user.quiz.view', $q->id) }}"
                                        class="lesson-list-item {{ $q->id == $quiz->id ? 'active' : '' }}">
                                        <div class="lesson-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div class="material-title">
                                            Quiz: {{ $q->title }}
                                        </div>
                                        <div class="completion-check">
                                            <span
                                                class="check-icon {{ in_array($q->id, $completedQuizIds ?? []) ? 'completed' : '' }}">
                                                <i class="fas fa-check"></i>
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="fw-bold mb-1">Quiz Info</h5>
                    </div>
                    <div class="p-4">
                        <p class="text-muted small">Viewing results for: <br><strong>{{ $quiz->title }}</strong></p>
                    </div>
                </div>
            @endif
        </aside>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush
