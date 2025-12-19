@extends('layouts.frontend')

@section('title', $lecture->title . ' | eLEARNIFY')

@push('styles')
    <style>
        .course-sidebar .list-group-item {
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .course-sidebar .list-group-item.active {
            background-color: #f8f9fa;
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
        }

        .video-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-4 mb-4 shadow-sm border">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">{{ $lecture->title }}</h3>
                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                <i class="fa fa-clock me-2"></i>{{ $lecture->duration ?? '10 mins' }}
                            </span>
                        </div>

                        <!-- Video / Media Player -->
                        <div class="video-container ratio ratio-16x9 mb-4 bg-dark">
                            @php
                                $primaryVideo = null;
                                if ($lecture->materials && $lecture->materials->count()) {
                                    $primaryVideo = $lecture->materials->firstWhere('video_path', '!=', null);
                                }
                            @endphp

                            @if ($primaryVideo)
                                <video controls class="w-100 h-100" poster="{{ asset('frontend/img/course-1.jpg') }}">
                                    <source src="{{ asset('storage/' . $primaryVideo->video_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($lecture->video_url)
                                <iframe src="{{ $lecture->video_url }}" allowfullscreen></iframe>
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center text-white p-5">
                                    <i class="fa fa-play-circle fa-4x mb-3 text-primary"></i>
                                    <h5>No Video Stream Available</h5>
                                    <p class="mb-0 text-muted">Please check the resources section below for materials.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 p-3 bg-white rounded border shadow-sm">
                            <h5 class="border-bottom pb-2 mb-3">About this Lecture</h5>
                            <p class="text-muted mb-0">
                                {{ $lecture->description ?? 'No description available for this lecture.' }}</p>
                        </div>

                        @if ($lecture->materials && $lecture->materials->count())
                            <div class="mt-4">
                                <h5 class="mb-3"><i class="fa fa-paperclip me-2 text-primary"></i>Learning Resources</h5>
                                <div class="row g-3">
                                    @foreach ($lecture->materials as $material)
                                        <div class="col-12">
                                            <div
                                                class="p-3 bg-white rounded border d-flex justify-content-between align-items-center shadow-sm">
                                                <div>
                                                    <h6 class="mb-1">{{ $material->title }}</h6>
                                                    @if ($material->description)
                                                        <small
                                                            class="text-muted d-block">{{ $material->description }}</small>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2">
                                                    @if ($material->file_path)
                                                        <a href="{{ asset('storage/' . $material->file_path) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary rounded-pill">
                                                            <i class="fa fa-download me-1"></i>PDF
                                                        </a>
                                                    @endif
                                                    @if ($material->content_url)
                                                        <a href="{{ $material->content_url }}" target="_blank"
                                                            class="btn btn-sm btn-outline-secondary rounded-pill">
                                                            <i class="fa fa-external-link-alt me-1"></i>Link
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mt-4">
                        @if (isset($prev_url) && $prev_url)
                            <a href="{{ $prev_url }}" class="btn btn-outline-primary px-4 py-2 rounded-pill">
                                <i class="fa fa-arrow-left me-2"></i>Previous Lecture
                            </a>
                        @else
                            <a href="{{ route('user.course.view', $enrollment->id) }}"
                                class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                                <i class="fa fa-list me-2"></i>Course Overview
                            </a>
                        @endif

                        @if (isset($next_url) && $next_url)
                            @php
                                $isNextQuiz = str_contains($next_url, '/quiz/');
                            @endphp
                            <a href="{{ $next_url }}" class="btn btn-primary px-4 py-2 rounded-pill shadow"
                                {{ $isNextQuiz ? 'data-bs-toggle=modal data-bs-target=#quizStartModal' : '' }}>
                                Next Section <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 sticky-top shadow-sm border" style="top: 100px;">
                        <h5 class="mb-1 text-truncate">{{ $enrollment->course->title }}</h5>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">Current Progress</small>
                            <small class="text-primary fw-bold">{{ $enrollment->progress }}%</small>
                        </div>
                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $enrollment->progress }}%"></div>
                        </div>

                        <h6 class="mb-3 fw-bold text-uppercase small text-muted">Course Curriculum</h6>
                        <div class="list-group list-group-flush border rounded overflow-hidden course-sidebar">
                            @foreach ($enrollment->course->lectures as $l)
                                <a href="{{ route('user.lecture.view', $l->id) }}"
                                    class="list-group-item list-group-item-action py-3 {{ $l->id == $lecture->id ? 'active' : '' }} border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-truncate">
                                            <i
                                                class="fa {{ $l->id == $lecture->id ? 'fa-play-circle' : 'fa-check-circle text-muted opacity-50' }} me-2"></i>
                                            {{ $l->title }}
                                        </div>
                                        <small class="ms-2 opacity-75">{{ $l->duration ?? '10m' }}</small>
                                    </div>
                                </a>

                                @if ($l->quizzes && $l->quizzes->count() > 0)
                                    @foreach ($l->quizzes as $q)
                                        <a href="{{ route('user.quiz.view', $q->id) }}"
                                            class="list-group-item list-group-item-action py-2 ps-5 border-bottom bg-white text-secondary small">
                                            <i class="fa fa-question-circle me-2"></i>{{ $q->title }}
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>

                        <a href="{{ route('user.course.view', $enrollment->id) }}"
                            class="btn btn-link w-100 mt-3 text-muted">
                            <i class="fa fa-times me-2"></i>Exit Player
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Start Modal -->
    <div class="modal fade" id="quizStartModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-4"
                        style="width: 100px; height: 100px;">
                        <i class="fa fa-clipboard-check fa-3x text-primary"></i>
                    </div>
                    <h4 class="mb-3">Quiz Readiness Check</h4>
                    <p class="text-muted">The next section is a knowledge check. Are you ready to test what you've learned?
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-5">
                    <button type="button" class="btn btn-light px-4 py-2 rounded-pill me-2"
                        data-bs-dismiss="modal">Later</button>
                    @if (isset($next_url))
                        <a href="{{ $next_url }}" class="btn btn-primary px-5 py-2 rounded-pill shadow">Start Quiz</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
