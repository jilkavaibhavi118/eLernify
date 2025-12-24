@extends('layouts.frontend')

@section('title', $lecture->title . ' | Elearnify')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-right">{{ $lecture->title }}</h1>
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Player</span></li>
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
                    <!-- Video Player -->
                    <div class="section-card mb-4" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                        <div class="ratio ratio-16x9">
                            @if ($lecture->video_url)
                                <iframe src="{{ $lecture->video_url }}" title="{{ $lecture->title }}"
                                    allowfullscreen></iframe>
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-dark text-white">
                                    <p>No video available for this lesson</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Lesson Info -->
                    <div class="section-card mb-4"
                        style="max-width: 800px; margin-left: auto; margin-right: auto; max-height: 400px; overflow-y: auto;">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                            <div class="mb-3 mb-md-0">
                                <h4 class="fw-bold mb-2">{{ $lecture->title }}</h4>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-clock me-2"></i>{{ $lecture->duration ?? 'N/A' }}
                                </p>
                            </div>
                            <!-- Future Feature: Mark as Complete Form -->
                            <button class="btn btn-success" disabled>
                                <i class="bi bi-check-circle me-1"></i>Mark as Complete
                            </button>
                        </div>

                        <h5 class="fw-bold mb-3">About this lesson</h5>
                        <div class="text-muted mb-0">
                            {!! $lecture->description !!}
                        </div>
                    </div>

                    <!-- Lesson Navigation -->
                    <div class="section-card mb-4" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            @if ($prev_url)
                                <a href="{{ $prev_url }}" class="btn btn-primary">
                                    <i class="bi bi-chevron-left me-1"></i>Previous Lesson
                                </a>
                            @else
                                <button class="btn btn-outline-primary" disabled>
                                    <i class="bi bi-chevron-left me-1"></i>Previous Lesson
                                </button>
                            @endif

                            <span class="text-muted small">
                                Lesson
                                {{ $enrollment->course->lectures->search(function ($l) use ($lecture) {return $l->id == $lecture->id;}) + 1 }}
                                of {{ $enrollment->course->lectures->count() }}
                            </span>

                            @if ($next_url)
                                <a href="{{ $next_url }}" class="btn btn-primary">
                                    Next Lesson<i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn btn-outline-primary" disabled>
                                    Next Lesson<i class="bi bi-chevron-right ms-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Lesson Resources -->
                    @if ($lecture->materials && $lecture->materials->count() > 0)
                        <div class="section-card mb-4" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                            <h5 class="fw-bold mb-3">Lesson Resources</h5>
                            <div class="list-group list-group-flush">
                                @foreach ($lecture->materials as $material)
                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <span><i
                                                class="bi bi-file-earmark-text text-primary me-2"></i>{{ $material->title }}</span>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
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
                                class="lesson-item {{ $l->id == $lecture->id ? 'active' : '' }} d-flex align-items-center py-2 px-3 mb-1"
                                style="{{ $l->id == $lecture->id ? 'background: rgba(99, 102, 241, 0.1); border-left: 3px solid #6366f1;' : '' }} border-radius: 6px; text-decoration: none;">
                                <i class="bi bi-play-fill {{ $l->id == $lecture->id ? 'text-primary' : 'text-muted' }} me-3"
                                    style="font-size: 1.1rem;"></i>
                                <span class="lesson-title flex-grow-1"
                                    style="font-size: 0.9rem; color: {{ $l->id == $lecture->id ? '#1f2937' : '#374151' }};">
                                    {{ sprintf('%02d', $index + 1) }} - {{ $l->title }}
                                </span>
                                <span class="lesson-duration small" style="color: #6b7280;">{{ $l->duration ?? '' }}</span>
                            </a>

                            @if ($l->quizzes && $l->quizzes->count() > 0)
                                @foreach ($l->quizzes as $q)
                                    <a href="{{ route('user.quiz.view', $q->id) }}"
                                        class="lesson-item d-flex align-items-center py-2 px-3 mb-1 ms-4"
                                        style="border-radius: 6px; text-decoration: none;">
                                        <i class="bi bi-question-circle text-muted me-2" style="font-size: 1rem;"></i>
                                        <span class="lesson-title flex-grow-1" style="font-size: 0.9rem; color: #374151;">
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
    </script>
@endpush
