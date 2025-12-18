<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $quiz->title }} | eLEARNIFY</title>
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
                            <h3 class="mb-3">{{ $quiz->title }}</h3>
                            <p class="text-muted"><i class="fa fa-clock me-2"></i>Duration: {{ $quiz->duration }} mins
                            </p>
                            <div id="timer" class="display-6 text-danger fw-bold"></div>
                            @if ($quiz->instructions)
                                <div class="alert alert-info text-start">
                                    <strong>Instructions:</strong><br>
                                    {{ $quiz->instructions }}
                                </div>
                            @endif
                        </div>

                        <form id="quizForm" action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST">
                            @csrf

                            @forelse($quiz->questions as $index => $question)
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">{{ $index + 1 }}.
                                            {{ $question->question_text }}</h5>

                                        @foreach ($question->options as $option)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio"
                                                    name="answers[{{ $question->id }}]"
                                                    id="option_{{ $option->id }}" value="{{ $option->id }}"
                                                    required>
                                                <label class="form-check-label" for="option_{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning text-center">
                                    No questions available in this quiz.
                                </div>
                            @endforelse

                            @if ($quiz->questions->count() > 0)
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">Submit Quiz</button>
                                </div>
                            @endif
                        </form>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        @if (isset($prev_url) && $prev_url)
                            <a href="{{ $prev_url }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Previous
                            </a>
                        @else
                            <a href="{{ route('user.course.view', $enrollment->id) }}"
                                class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Back to Course
                            </a>
                        @endif

                        @if (isset($next_url) && $next_url)
                            <a href="{{ $next_url }}" class="btn btn-primary">
                                Next <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        @endif
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
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>

        <script>
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
            });
        </script>
</body>

</html>
