@extends('layouts.frontend')

@section('title', 'My Purchases | eLEARNIFY')

@push('styles')
    <style>
        .course-card {
            transition: .5s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
        }

        .course-img {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .course-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-status {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1;
        }

        .course-meta {
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="section-title bg-light text-center text-primary px-3">My Assets</h6>
            <h1 class="mb-0">Purchase History</h1>
        </div>

        <div class="row g-4">
            @php $hasItems = false; @endphp
            @foreach ($orders as $order)
                @foreach ($order->items as $item)
                    @php
                        $hasItems = true;
                        $title = '';
                        $type = '';
                        $icon = '';
                        $viewRoute = '#';
                        $image = asset('frontend/img/course-1.jpg');

                        if ($item->course) {
                            $title = $item->course->title;
                            $type = 'Course';
                            $icon = 'fa-graduation-cap';
                            $viewRoute = route('course.detail', $item->course_id);
                            if ($item->course->image) {
                                $image = asset('storage/' . $item->course->image);
                            }
                        } elseif ($item->material) {
                            $title = $item->material->title;
                            $type = 'Material';
                            $icon = !empty($item->material->video_path)
                                ? 'fa-video'
                                : (!empty($item->material->file_path)
                                    ? 'fa-file-pdf'
                                    : 'fa-link');
                            $viewRoute = route('material.view', $item->material_id);
                        } elseif ($item->lecture) {
                            $title = $item->lecture->title;
                            $type = 'Lecture';
                            $icon = 'fa-book-open';
                            $viewRoute = route('lecture.view', $item->lecture_id);
                        } elseif ($item->quiz) {
                            $title = $item->quiz->title;
                            $type = 'Quiz';
                            $icon = 'fa-question-circle';
                            $viewRoute = route('quiz.view', $item->quiz_id);
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card bg-white h-100">
                            <div class="course-img" style="height: 150px;">
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="fa {{ $icon }} fa-4x text-primary opacity-25"></i>
                                </div>
                                <div class="course-status">
                                    <span class="badge bg-primary px-3 py-2 text-white">{{ $type }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-primary fw-bold text-uppercase">{{ $type }}</small>
                                    <small class="text-muted"><i
                                            class="fa fa-calendar-alt text-primary me-2"></i>{{ $order->created_at->format('M d, Y') }}</small>
                                </div>
                                <h5 class="mb-3 text-dark text-truncate">{{ $title }}</h5>
                                <p class="text-muted small mb-4">Paid: ₹{{ number_format($item->price, 2) }}</p>

                                <div class="mt-auto">
                                    <a href="{{ $viewRoute }}" class="btn btn-primary w-100 py-2 rounded-pill shadow-sm">
                                        <i class="fa fa-eye me-2"></i>View Content
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @if (!$hasItems)
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fa fa-shopping-cart fa-4x text-light"></i>
                    </div>
                    <h3>No Purchases Found</h3>
                    <p class="text-muted">You haven't purchased any items yet. Start your learning journey today!</p>
                    <a href="{{ route('landing') }}" class="btn btn-primary px-5 py-3 mt-3 rounded-pill">
                        Browse Catalogue
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
