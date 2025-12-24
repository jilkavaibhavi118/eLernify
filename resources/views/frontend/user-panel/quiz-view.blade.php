@extends('layouts.frontend')

@section('title', $quiz->title . ' | Elearnify')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-right">{{ $quiz->title }}</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item"><a href="{{ route('user.courses') }}">My Courses</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('user.course.view', $enrollment->id) }}">{{ $enrollment->course->title }}</a>
                            </li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>Quiz</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5 px-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-9">
                <div class="container">
                    <div class="bg-light rounded p-5 mb-4 shadow-sm border">
                        <div class="text-center mb-5">
                            <h3 class="mb-3">{{ $quiz->title }}</h3>
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <div class="bg-white px-4 py-2 rounded-pill shadow-sm border d-flex align-items-center">
                                    <i class="fa fa-clock text-danger me-2"></i>
                                    <span class="text-muted me-2">Time Remaining:</span>
                                    <span id="timer" class="h4 mb-0 text-danger fw-bold">00:00</span>
                                </div>
                            </div>

                            @if ($quiz->instructions)
                                <div class="alert alert-info text-start border-0 shadow-sm">
                                    <h6 class="alert-heading"><i class="fa fa-info-circle me-2"></i>Instructions:</h6>
                                    <p class="mb-0 small">{{ $quiz->instructions }}</p>
                                </div>
                            @endif
                        </div>

                        <form id="quizForm" action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST">
                            @csrf

                            @forelse($quiz->questions as $index => $question)
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-4">
                                            <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                            {{ $question->question_text }}
                                        </h5>

                                        <div class="options-group">
                                            @foreach ($question->options as $option)
                                                <div
                                                    class="form-check mb-3 p-3 border rounded transition-all hover-bg-light">
                                                    <input class="form-check-input ms-0" type="radio"
                                                        name="answers[{{ $question->id }}]"
                                                        id="option_{{ $option->id }}" value="{{ $option->id }}"
                                                        required>
                                                    <label class="form-check-label ms-2 d-block w-100"
                                                        for="option_{{ $option->id }}">
                                                        {{ $option->option_text }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning text-center">
                                    <i class="fa fa-exclamation-triangle me-2"></i>No questions available in this quiz.
                                </div>
                            @endforelse

                            @if ($quiz->questions->count() > 0)
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                        Submit My Answers <i class="fa fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        @if (isset($prev_url) && $prev_url)
                            <a href="{{ $prev_url }}" class="btn btn-primary">
                                <i class="bi bi-chevron-left me-1"></i>Previous
                            </a>
                        @else
                            <button class="btn btn-outline-primary" disabled>
                                <i class="bi bi-chevron-left me-1"></i>Previous
                            </button>
                        @endif

                        @if (isset($next_url) && $next_url)
                            <a href="{{ $next_url }}" class="btn btn-primary">
                                Next <i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar - Course Lessons -->
            <div class="col-lg-3">
                <div class="course-lessons-sidebar sticky-top"
                    style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto; background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <h5 class="fw-bold mb-4" style="color: #1f2937;">Course Lessons</h5>

                    <!-- Active Course Section -->
                    <div class="lesson-section mb-3">
                        <p class="section-header small fw-semibold mb-2" style="color: #6b7280;">Curriculum</p>

                        @foreach ($enrollment->course->lectures as $index => $l)
                            <a href="{{ route('user.lecture.view', $l->id) }}"
                                class="lesson-item d-flex align-items-center py-2 px-3 mb-1"
                                style="border-radius: 6px; text-decoration: none;">
                                <i class="bi bi-play-fill text-muted me-3" style="font-size: 1.1rem;"></i>
                                <span class="lesson-title flex-grow-1" style="font-size: 0.9rem; color: #374151;">
                                    {{ sprintf('%02d', $index + 1) }} - {{ $l->title }}
                                </span>
                                <span class="lesson-duration small" style="color: #6b7280;">{{ $l->duration ?? '' }}</span>
                            </a>

                            @if ($l->quizzes && $l->quizzes->count() > 0)
                                @foreach ($l->quizzes as $q)
                                    <a href="{{ route('user.quiz.view', $q->id) }}"
                                        class="lesson-item {{ $q->id == $quiz->id ? 'active' : '' }} d-flex align-items-center py-2 px-3 mb-1 ms-4"
                                        style="{{ $q->id == $quiz->id ? 'background: rgba(99, 102, 241, 0.1); border-left: 3px solid #6366f1;' : '' }} border-radius: 6px; text-decoration: none;">
                                        <i class="bi bi-question-circle {{ $q->id == $quiz->id ? 'text-primary' : 'text-muted' }} me-2"
                                            style="font-size: 1rem;"></i>
                                        <span class="lesson-title flex-grow-1"
                                            style="font-size: 0.9rem; color: {{ $q->id == $quiz->id ? '#1f2937' : '#374151' }};">
                                            {{ $q->title }}
                                        </span>
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
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
