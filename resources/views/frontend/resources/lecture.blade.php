@extends('layouts.frontend')

@section('title', $lecture->title . ' | eLEARNIFY')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-4 mb-4 shadow-sm border">
                        <h2 class="mb-3 text-primary">{{ $lecture->title }}</h2>
                        <div class="d-flex align-items-center mb-4 text-muted small">
                            <span class="me-3"><i class="fa fa-book-open me-2 text-primary"></i>Lecture</span>
                            <span class="me-3"><i
                                    class="fa fa-clock me-2 text-primary"></i>{{ $lecture->duration ?? 'N/A' }} Mins</span>
                            @if ($lecture->course)
                                <span><i
                                        class="fa fa-layer-group me-2 text-primary"></i>{{ $lecture->course->title }}</span>
                            @endif
                        </div>

                        <div class="lecture-content bg-white p-4 rounded shadow-sm">
                            {!! $lecture->description !!}
                        </div>
                    </div>

                    @if ($lecture->materials->count() > 0)
                        <div class="bg-white rounded p-4 mb-4 shadow-sm border">
                            <h4 class="mb-4">Learning Materials</h4>
                            <div class="list-group list-group-flush">
                                @foreach ($lecture->materials as $material)
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="fa {{ !empty($material->video_path) ? 'fa-video' : (!empty($material->file_path) ? 'fa-file-pdf' : 'fa-link') }} text-primary me-3 fa-lg"></i>
                                            <div>
                                                <h6 class="mb-0">{{ $material->title }}</h6>
                                                <small class="text-muted">{{ $material->short_description }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('material.view', $material->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">View</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded p-4 shadow-sm border sticky-top" style="top: 100px;">
                        <h4 class="mb-4 text-dark">Course Details</h4>
                        @if ($lecture->course)
                            <div class="mb-4">
                                <img src="{{ $lecture->course->course_image ? asset('storage/' . $lecture->course->course_image) : asset('frontend/img/course-1.jpg') }}"
                                    class="img-fluid rounded mb-3" alt="">
                                <h5>{{ $lecture->course->title }}</h5>
                                <p class="text-muted small">{{ Str::limit($lecture->course->description, 100) }}</p>
                                <a href="{{ route('course.detail', $lecture->course_id) }}"
                                    class="btn btn-primary w-100 rounded-pill">View Full Course</a>
                            </div>
                        @endif

                        @if ($lecture->quizzes->count() > 0)
                            <h5 class="mt-4 mb-3">Associated Quizzes</h5>
                            <div class="list-group list-group-flush border rounded">
                                @foreach ($lecture->quizzes as $quiz)
                                    <a href="{{ route('quiz.view', $quiz->id) }}"
                                        class="list-group-item list-group-item-action py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i
                                                    class="fa fa-question-circle me-2 text-primary"></i>{{ $quiz->title }}</span>
                                            <i class="fa fa-chevron-right small text-muted"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
