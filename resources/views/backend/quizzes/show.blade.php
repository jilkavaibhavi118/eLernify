@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-warning">Quiz Details</h5>
                        <small class="text-muted">Attached to: <strong>{{ $quiz->lecture->title }}</strong></small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.quizzes.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        <a href="{{ route('backend.quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit Quiz</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3 border-warning">
                                <div class="card-header bg-warning text-dark">Settings</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Time Limit
                                        <strong>{{ $quiz->time_limit }} minutes</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Passing Score
                                        <strong>{{ $quiz->passing_score }}%</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Questions
                                        <span class="badge bg-primary rounded-pill">{{ $quiz->questions->count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Attempts Allowed
                                        <strong>{{ $quiz->attempts_allowed ?? 'Unlimited' }}</strong>
                                    </li>
                                </ul>
                            </div>

                            <div class="alert alert-info small">
                                <strong>Note:</strong> This quiz is part of the <em>{{ $quiz->lecture->course->title }}</em>
                                course.
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $quiz->title }}</h3>
                            <div class="mb-4 p-3 bg-light rounded text-muted">
                                {{ $quiz->description ?? 'No description available for this quiz.' }}
                            </div>

                            <hr>

                            <h5 class="mb-3">Preview Questions ({{ $quiz->questions->count() }})</h5>
                            @forelse($quiz->questions as $index => $question)
                                <div class="card mb-3">
                                    <div class="card-header bg-light py-2">
                                        <strong>Q{{ $index + 1 }}:</strong> {{ $question->question_text }}
                                        <span class="float-end badge bg-secondary">{{ $question->points }} pts</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <ul class="list-group list-group-flush small">
                                            @foreach ($question->options as $option)
                                                <li class="list-group-item py-1 border-0">
                                                    @if ($option->is_correct)
                                                        <i class="cil-check-circle text-success me-2"></i>
                                                        <strong>{{ $option->option_text }}</strong>
                                                    @else
                                                        <i class="cil-circle text-muted me-2"></i>
                                                        {{ $option->option_text }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-4 bg-light rounded">
                                    <p class="text-muted mb-0">No questions added to this quiz yet.</p>
                                    <a href="{{ route('backend.quizzes.edit', $quiz->id) }}"
                                        class="btn btn-sm btn-outline-warning mt-2">Add Questions</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
