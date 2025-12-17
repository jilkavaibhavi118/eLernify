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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-5">
                        <div class="text-center mb-5">
                            <h3 class="mb-3">{{ $quiz->title }}</h3>
                            <p class="text-muted"><i class="fa fa-clock me-2"></i>Duration: {{ $quiz->duration }} mins
                            </p>
                            @if ($quiz->instructions)
                                <div class="alert alert-info text-start">
                                    <strong>Instructions:</strong><br>
                                    {{ $quiz->instructions }}
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST">
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
