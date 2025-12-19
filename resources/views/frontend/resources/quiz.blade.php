@extends('layouts.frontend')

@section('title', $quiz->title . ' | eLEARNIFY')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
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

                            @if ($quiz->short_description)
                                <div class="alert alert-info text-start border-0 shadow-sm">
                                    <h6 class="alert-heading"><i class="fa fa-info-circle me-2"></i>Instructions:</h6>
                                    <p class="mb-0 small">{{ $quiz->short_description }}</p>
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
                                                        name="answers[{{ $question->id }}]" id="option_{{ $option->id }}"
                                                        value="{{ $option->id }}" required>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
