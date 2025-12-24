@extends('layouts.frontend')

@section('title', 'Quiz Result: ' . $quiz->title . ' | Elearnify')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-right">Quiz Results</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item"><a href="{{ route('user.courses') }}">My Courses</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('user.course.view', $enrollment->id ?? 1) }}">{{ $enrollment->course->title ?? 'Course' }}</a>
                            </li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>{{ $quiz->title }}</span></li>
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
                            <h3 class="mb-3">Result: {{ $quiz->title }}</h3>
                            <div
                                class="display-3 font-weight-bold text-primary mb-2 shadow-sm d-inline-block px-4 py-2 bg-white rounded-pill border">
                                {{ $attempt->score }} <span class="text-muted h4">/ {{ $attempt->total_questions }}</span>
                            </div>
                            @php
                                $percentage =
                                    $attempt->total_questions > 0
                                        ? ($attempt->score / $attempt->total_questions) * 100
                                        : 0;
                            @endphp
                            <h4 class="mt-3 {{ $percentage >= 50 ? 'text-success' : 'text-danger' }}">
                                <i class="fa {{ $percentage >= 50 ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                                {{ number_format($percentage, 2) }}% - {{ $percentage >= 50 ? 'Passed' : 'Failed' }}
                            </h4>
                        </div>

                        <hr class="my-5">

                        <h5 class="mb-4 d-flex align-items-center">
                            <i class="fa fa-list-check text-primary me-2"></i>Review Detailed Answers
                        </h5>

                        @foreach ($quiz->questions as $index => $question)
                            @php
                                $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
                                $userOptionId = $userAnswer ? $userAnswer->question_option_id : null;
                                $correctOption = $question->options->where('is_correct', true)->first();
                                $isCorrect = $userAnswer && $userAnswer->is_correct;
                            @endphp

                            <div class="card mb-4 border-{{ $isCorrect ? 'success' : 'danger' }} shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="card-title mb-0">
                                            <span
                                                class="badge bg-{{ $isCorrect ? 'success' : 'danger' }} me-2">{{ $index + 1 }}</span>
                                            {{ $question->question_text }}
                                        </h6>
                                        <span
                                            class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                            <i class="fa {{ $isCorrect ? 'fa-check' : 'fa-times' }} me-1"></i>
                                            {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                        </span>
                                    </div>

                                    <div class="options-review mt-3">
                                        @foreach ($question->options as $option)
                                            <div
                                                class="p-3 mb-2 rounded border d-flex align-items-center
                                                @if ($option->id == $userOptionId && $option->is_correct) bg-success text-white border-success
                                                @elseif($option->id == $userOptionId && !$option->is_correct) 
                                                    bg-danger text-white border-danger
                                                @elseif($option->is_correct) 
                                                    bg-white border-success text-success fw-bold
                                                @else 
                                                    bg-white text-muted opacity-75 @endif
                                            ">
                                                <i
                                                    class="fa {{ $option->is_correct ? 'fa-check-circle' : ($option->id == $userOptionId ? 'fa-times-circle' : 'fa-circle-notch opacity-25') }} me-3"></i>
                                                <span>{{ $option->option_text }}</span>
                                                @if ($option->id == $userOptionId)
                                                    <small class="ms-auto opacity-75">(Your Answer)</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($question->explanation)
                                        <div class="alert alert-primary mt-3 border-0 shadow-sm small">
                                            <strong><i class="fa fa-lightbulb me-2"></i>Expert Explanation:</strong><br>
                                            <p class="mb-0 mt-1 opacity-75">{{ $question->explanation }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center mt-5">
                            @if ($enrollment)
                                <a href="{{ route('user.course.view', $enrollment->id) }}"
                                    class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                    <i class="fa fa-graduation-cap me-2"></i>Return to Course Curriculum
                                </a>
                            @else
                                <a href="{{ route('landing') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                    <i class="fa fa-home me-2"></i>Back to Home
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Course Lessons -->
            @if ($enrollment)
                <div class="col-lg-3">
                    <div class="course-lessons-sidebar sticky-top"
                        style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto; background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <!-- Header -->
                        <h5 class="fw-bold mb-4" style="color: #1f2937;">Course Curriculum</h5>

                        <!-- Active Course Section -->
                        <div class="lesson-section mb-3">
                            @foreach ($enrollment->course->lectures as $index => $l)
                                <a href="{{ route('user.lecture.view', $l->id) }}"
                                    class="lesson-item d-flex align-items-center py-2 px-3 mb-1"
                                    style="border-radius: 6px; text-decoration: none;">
                                    <i class="bi bi-play-fill text-muted me-3" style="font-size: 1.1rem;"></i>
                                    <span class="lesson-title flex-grow-1" style="font-size: 0.9rem; color: #374151;">
                                        {{ sprintf('%02d', $index + 1) }} - {{ $l->title }}
                                    </span>
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
            @else
                <div class="col-lg-3">
                    <div class="course-lessons-sidebar sticky-top"
                        style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto; background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <h5 class="fw-bold mb-4" style="color: #1f2937;">Quiz Info</h5>
                        <p class="text-muted small">You are viewing a single quiz result.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush
