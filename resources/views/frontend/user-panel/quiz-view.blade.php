@extends('layouts.frontend')

@section('title', $quiz->title . ' | Elearnify')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --player-bg: #f9fafb;
            --sidebar-width: 380px;
            --primary-color: #0a2283;
            --primary-light: rgba(10, 34, 131, 0.1);
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

        .quiz-card {
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

        /* Question Styles */
        .question-badge {
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            color: #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .form-check {
            border: 1px solid var(--border-color);
            padding: 1.25rem 1.25rem 1.25rem 3rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .form-check:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .form-check-input:checked+.form-check-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Navigation Cards */
        .nav-cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 3rem;
            margin-bottom: 2rem;
        }

        .nav-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all 0.2s;
            height: 100%;
        }

        .nav-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .nav-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .nav-card:hover .nav-card-icon {
            background: var(--primary-color);
            color: #fff;
        }

        .nav-card-content {
            flex: 1;
            min-width: 0;
        }

        .nav-card-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .nav-card-title {
            display: block;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-primary,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background-color: #081b6a !important;
            border-color: #081b6a !important;
            color: #fff !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .progress-bar {
            background-color: var(--primary-color) !important;
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
    </style>
@endpush

@section('content')
    <!-- Header -->
    <header class="player-header">
        <div class="header-container">
            <a href="{{ route('user.course.view', $enrollment->id) }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Course Dashboard
            </a>
            <div class="player-title-section">
                <h1>{{ $quiz->title }}</h1>
            </div>
        </div>
    </header>

    <div class="player-container">
        <!-- Main Content Area -->
        <main class="player-main">
            <div class="quiz-card">
                <div class="text-center mb-5">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <div class="bg-white px-4 py-2 rounded-pill shadow-sm border d-flex align-items-center">
                            <i class="fa fa-clock text-danger me-2"></i>
                            <span class="text-muted me-2">Time Remaining:</span>
                            <span id="timer" class="h4 mb-0 text-danger fw-bold">00:00</span>
                        </div>
                    </div>

                    @if ($quiz->instructions)
                        <div class="alert alert-info text-start border-0 shadow-sm"
                            style="background: var(--primary-light); color: var(--primary-color);">
                            <h6 class="alert-heading fw-bold"><i class="fa fa-info-circle me-2"></i>Instructions:</h6>
                            <p class="mb-0 small">{{ $quiz->instructions }}</p>
                        </div>
                    @endif
                </div>

                <form id="quizForm" action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST">
                    @csrf

                    @forelse($quiz->questions as $index => $question)
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-start">
                                <span class="question-badge">{{ $index + 1 }}</span>
                                <span class="flex-grow-1">{{ $question->question_text }}</span>
                            </h5>

                            <div class="options-group ps-4 ms-2">
                                @foreach ($question->options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                            id="option_{{ $option->id }}" value="{{ $option->id }}" required>
                                        <label class="form-check-label w-100" for="option_{{ $option->id }}">
                                            {{ $option->option_text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center">
                            <i class="fa fa-exclamation-triangle me-2"></i>No questions available in this quiz.
                        </div>
                    @endforelse

                    @if ($quiz->questions->count() > 0)
                        <div class="text-center mt-5">
                            <button type="submit"
                                class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm border-0">
                                Submit My Answers <i class="fa fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    @endif
                </form>

                <div class="nav-cards-container">
                    <div>
                        @if ($prev_url)
                            <a href="{{ $prev_url }}" class="nav-card">
                                <div class="nav-card-icon">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="nav-card-content">
                                    <span class="nav-card-label">Previous Lesson</span>
                                    <span class="nav-card-title">{{ $prev_title }}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                    <div>
                        @if ($next_url)
                            <a href="{{ $next_url }}" class="nav-card flex-row-reverse">
                                <div class="nav-card-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="nav-card-content text-end">
                                    <span class="nav-card-label">Next Lesson</span>
                                    <span class="nav-card-title">{{ $next_title }}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="player-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="fw-bold mb-1">Course Lessons</h5>
                    <div class="progress mt-3" style="height: 6px;">
                        @php
                            $progress = $enrollment->progress ?? 0;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
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
                                <div class="fw-bold" style="font-size: 0.95rem; line-height: 1.3; color: var(--text-dark);">
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
                                    </a>
                                @endif
                            @endforeach

                            @foreach ($l->quizzes as $q)
                                <a href="{{ route('user.quiz.view', $q->id) }}"
                                    class="lesson-list-item {{ $q->id == $quiz->id ? 'active' : '' }}">
                                    <div class="lesson-icon">
                                        <i
                                            class="fas {{ $q->id == $quiz->id ? 'fa-question-circle' : 'fa-question-circle' }}"></i>
                                    </div>
                                    <div class="material-title">
                                        Quiz: {{ $q->title }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        document.addEventListener('DOMContentLoaded', function() {
            var duration = {{ $quiz->duration ?? 10 }} * 60; // Duration in seconds
            var display = document.querySelector('#timer');
            var timer = duration,
                minutes, seconds;

            var interval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    alert("Time's up! Submitting your quiz.");
                    document.getElementById('quizForm').submit();
                }
            }, 1000);

            // Form persistence warning
            window.onbeforeunload = function() {
                return "Are you sure you want to leave? Your quiz progress will be lost.";
            };

            document.getElementById('quizForm').onsubmit = function() {
                window.onbeforeunload = null;
            };
        });
    </script>
@endpush
