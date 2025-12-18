<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quiz Result: {{ $quiz->title }} | eLEARNIFY</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>eLEARNIFY</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('user.dashboard') }}" class="nav-item nav-link">My Dashboard</a>
                <a href="{{ route('user.course.view', $enrollment->id) }}" class="nav-item nav-link">Back to Course</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-5 mb-4">
                        <div class="text-center mb-5">
                            <h3 class="mb-3">Quiz Result: {{ $quiz->title }}</h3>
                            <div class="display-4 font-weight-bold text-primary mb-3">
                                {{ $attempt->score }} / {{ $attempt->total_questions }}
                            </div>
                            @php
                                $percentage =
                                    $attempt->total_questions > 0
                                        ? ($attempt->score / $attempt->total_questions) * 100
                                        : 0;
                            @endphp
                            <h4 class="{{ $percentage >= 50 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($percentage, 2) }}% - {{ $percentage >= 50 ? 'Passed' : 'Failed' }}
                            </h4>
                        </div>

                        <hr>

                        <h5 class="mb-4">Review Answers</h5>

                        @foreach ($quiz->questions as $index => $question)
                            @php
                                $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
                                $userOptionId = $userAnswer ? $userAnswer->question_option_id : null;
                                $correctOption = $question->options->where('is_correct', true)->first();
                                $isCorrect = $userAnswer && $userAnswer->is_correct;
                            @endphp

                            <div class="card mb-4 border-{{ $isCorrect ? 'success' : 'danger' }} shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        {{ $index + 1 }}. {{ $question->question_text }}
                                        @if ($isCorrect)
                                            <span class="badge bg-success float-end"><i class="fa fa-check"></i>
                                                Correct</span>
                                        @else
                                            <span class="badge bg-danger float-end"><i class="fa fa-times"></i>
                                                Incorrect</span>
                                        @endif
                                    </h5>

                                    @foreach ($question->options as $option)
                                        <div
                                            class="p-2 mb-2 rounded border
                                            @if ($option->id == $userOptionId && $option->is_correct) bg-success text-white
                                            @elseif($option->id == $userOptionId && !$option->is_correct) bg-danger text-white
                                            @elseif($option->is_correct) border-success text-success fw-bold
                                            @else bg-light @endif
                                        ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    @if ($option->id == $userOptionId) checked @endif>
                                                <label class="form-check-label opacity-100">
                                                    {{ $option->option_text }}
                                                    @if ($option->is_correct)
                                                        <i class="fa fa-check-circle ms-2"></i>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($question->explanation)
                                        <div class="alert alert-info mt-3">
                                            <strong><i class="fa fa-info-circle me-2"></i>Explanation:</strong><br>
                                            {{ $question->explanation }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center mt-4">
                            <a href="{{ route('user.course.view', $enrollment->id) }}" class="btn btn-primary btn-lg">
                                Return to Course
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top" style="top: 100px;">
                        <h5 class="mb-3">{{ $enrollment->course->title }}</h5>
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $enrollment->progress }}%"></div>
                        </div>

                        <h6 class="mb-3">Course Content</h6>
                        <div class="list-group course-sidebar">
                            @foreach ($enrollment->course->lectures as $l)
                                {{-- Lecture Item --}}
                                <a href="{{ route('user.lecture.view', $l->id) }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fa fa-play-circle me-2"></i>{{ $l->title }}
                                    </div>
                                    <small>{{ $l->duration ?? '10m' }}</small>
                                </a>

                                {{-- Nested Quizzes --}}
                                @if ($l->quizzes && $l->quizzes->count() > 0)
                                    @foreach ($l->quizzes as $q)
                                        <a href="{{ route('user.quiz.view', $q->id) }}"
                                            class="list-group-item list-group-item-action ps-5 border-0 {{ $q->id == $quiz->id ? 'bg-primary text-white' : 'bg-white text-secondary' }}">
                                            <i class="fa fa-question-circle me-2"></i>{{ $q->title }}
                                            @if ($q->id == $quiz->id)
                                                <i class="fa fa-check-circle ms-auto"></i>
                                            @endif
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
