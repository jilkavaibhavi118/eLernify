@extends('layouts.frontend')

@section('title', 'Quiz Result: ' . $quiz->title . ' | eLEARNIFY')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-5 mb-4 shadow-sm border">
                        <div class="text-center mb-5">
                            <h3 class="mb-3">Quiz Result: {{ $quiz->title }}</h3>
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

                @if ($enrollment)
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-4 sticky-top shadow-sm border" style="top: 100px;">
                            <h5 class="mb-1">{{ $enrollment->course->title }}</h5>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">Current Progress</small>
                                <small class="text-primary fw-bold">{{ $enrollment->progress }}%</small>
                            </div>
                            <div class="progress mb-4" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $enrollment->progress }}%"></div>
                            </div>

                            <h6 class="mb-3 fw-bold text-uppercase small text-muted">Course History</h6>
                            <div class="list-group list-group-flush border rounded overflow-hidden course-sidebar">
                                @foreach ($enrollment->course->lectures as $l)
                                    <a href="{{ route('user.lecture.view', $l->id) }}"
                                        class="list-group-item list-group-item-action py-3 border-bottom">
                                        <i class="fa fa-play-circle me-2 text-muted opacity-50"></i>{{ $l->title }}
                                    </a>

                                    @if ($l->quizzes && $l->quizzes->count() > 0)
                                        @foreach ($l->quizzes as $q)
                                            <a href="{{ route('user.quiz.view', $q->id) }}"
                                                class="list-group-item list-group-item-action py-2 ps-5 border-bottom {{ $q->id == $quiz->id ? 'bg-primary text-white active' : 'bg-white text-secondary' }} small">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span><i
                                                            class="fa fa-question-circle me-2"></i>{{ $q->title }}</span>
                                                    @if ($q->id == $quiz->id)
                                                        <i class="fa fa-award"></i>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-4 sticky-top shadow-sm border" style="top: 100px;">
                            <h5 class="mb-4">Quiz Information</h5>
                            <div class="mb-3">
                                <small class="text-muted d-block">Items Attempted</small>
                                <span class="fw-bold">{{ $attempt->total_questions }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Correct Answers</small>
                                <span class="fw-bold text-success">{{ $attempt->score }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Completion Time</small>
                                <span class="fw-bold">{{ $attempt->completed_at->format('M d, Y H:i') }}</span>
                            </div>
                            <hr>
                            <p class="small text-muted mb-0">You purchased this quiz individually. Great job on completing
                                it!</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
