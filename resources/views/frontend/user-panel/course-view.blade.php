@extends('layouts.frontend')

@section('title', $enrollment->course->title . ' | eLEARNIFY')

@section('content')
    <!-- Course Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top shadow-sm border" style="top: 100px;">
                        <h5 class="mb-4">{{ $enrollment->course->title }}</h5>

                        <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width:{{ $enrollment->progress }}%" aria-valuenow="{{ $enrollment->progress }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <small class="text-muted small">Course Progress</small>
                            <small class="text-primary fw-bold">{{ $enrollment->progress }}%</small>
                        </div>

                        <h6 class="mb-3">Course Content</h6>

                        <!-- Lectures -->
                        @if ($enrollment->course->lectures->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-primary mb-2 small fw-bold text-uppercase"><i
                                        class="fa fa-book-open me-2"></i>Lectures</h6>
                                <div class="list-group list-group-flush border rounded overflow-hidden">
                                    @foreach ($enrollment->course->lectures as $lecture)
                                        <a href="{{ route('user.lecture.view', $lecture->id) }}"
                                            class="list-group-item list-group-item-action py-3 border-bottom-0">
                                            <i class="fa fa-play-circle me-2 text-primary"></i>{{ $lecture->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quizzes -->
                        @if ($enrollment->course->quizzes->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-primary mb-2 small fw-bold text-uppercase"><i
                                        class="fa fa-question-circle me-2"></i>Quizzes</h6>
                                <div class="list-group list-group-flush border rounded overflow-hidden">
                                    @foreach ($enrollment->course->quizzes as $quiz)
                                        <a href="{{ route('user.quiz.view', $quiz->id) }}"
                                            class="list-group-item list-group-item-action py-3 border-bottom-0">
                                            <i class="fa fa-clipboard-list me-2 text-primary"></i>{{ $quiz->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill">
                            <i class="fa fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    @if (session('quiz_result'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check-circle fa-2x me-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Quiz Completed!</h5>
                                    <p class="mb-0">You scored
                                        <strong>{{ session('quiz_result')['score'] }}/{{ session('quiz_result')['total'] }}</strong>
                                        ({{ session('quiz_result')['percentage'] }}%)</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="bg-light rounded p-5 shadow-sm border">
                        <h2 class="mb-4">{{ $enrollment->course->title }}</h2>

                        @if ($enrollment->course->instructor)
                            <div class="d-flex align-items-center mb-4 p-3 bg-white rounded border shadow-sm">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px; font-weight: bold; font-size: 1.2rem;">
                                    {{ strtoupper(substr($enrollment->course->instructor->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">Course Instructor</h6>
                                    <p class="mb-0 text-primary fw-bold">{{ $enrollment->course->instructor->name }}</p>
                                </div>
                            </div>
                        @endif

                        <h5 class="mb-3">About this course</h5>
                        <p class="text-muted">{{ $enrollment->course->description ?? 'No description available.' }}</p>

                        <div class="row g-3 mt-4">
                            <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="bg-white p-4 rounded text-center border shadow-sm">
                                    <i class="fa fa-book-open fa-2x text-primary mb-3"></i>
                                    <h5>{{ $enrollment->course->lectures->count() }}</h5>
                                    <p class="mb-0 text-muted">Total Lectures</p>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="bg-white p-4 rounded text-center border shadow-sm">
                                    <i class="fa fa-question-circle fa-2x text-primary mb-3"></i>
                                    <h5>{{ $enrollment->course->quizzes->count() }}</h5>
                                    <p class="mb-0 text-muted">Practice Quizzes</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-primary mt-5 border-0 shadow-sm d-flex align-items-center">
                            <i class="fa fa-info-circle fa-2x me-3"></i>
                            <p class="mb-0 fw-bold">Ready to start? Select a lecture or quiz from the sidebar to begin your
                                learning journey!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Course Content End -->
@endsection
