@extends('layouts.frontend')

@section('title', 'My Learning Library | eLEARNIFY')

@push('styles')
    <style>
        :root {
            --primary-blue: #0a2283;
            --primary-gradient: linear-gradient(135deg, #0a2283 0%, #081b6a 100%);
            --bg-light: #f8f9fa;
            --text-dark: #1f2937;
        }

        .learning-header {
            background: #fff;
            padding: 4rem 0 3rem;
            border-bottom: 1px solid #eee;
            margin-bottom: 3rem;
        }

        .premium-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(10, 34, 131, 0.1), 0 10px 10px -5px rgba(10, 34, 131, 0.04);
            border-color: rgba(10, 34, 131, 0.1);
        }

        .card-image-box {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .premium-card:hover .card-image-box img {
            transform: scale(1.05);
        }

        .card-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-blue);
            backdrop-filter: blur(4px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .item-type {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .item-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .progress-box {
            margin-top: auto;
            padding-top: 1rem;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background-color: #f1f5f9;
            margin-bottom: 0.5rem;
        }

        .progress-bar {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        .progress-text {
            font-size: 0.875rem;
            color: var(--primary-blue);
            font-weight: 600;
        }

        .btn-continue {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .btn-continue:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(10, 34, 131, 0.3);
            color: #fff;
        }

        .empty-state {
            color: var(--primary-blue);
        }
    </style>
@endpush

@section('content')
    <div class="learning-header">
        <div class="container text-center">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-3">My Learning</h6>
            <h1 class="display-5 fw-bold mb-0">Your Library</h1>
            <p class="text-muted mt-3">All your purchased courses, lectures, and resources in one place.</p>
        </div>
    </div>

    <div class="container mb-5 pb-5">
        <div class="row g-4">
            @php $hasItems = false; @endphp
            @foreach ($orders as $order)
                @foreach ($order->items as $item)
                    @php
                        $hasItems = true;
                        $title = '';
                        $type = '';
                        $icon = 'fa-book';
                        $viewRoute = '#';
                        $image = null;
                        $progress = 0;

                        if ($item->course) {
                            $title = $item->course->title;
                            $type = 'Course';
                            $icon = 'fa-graduation-cap';
                            // Redirect to the first lecture if available
                            $firstLecture = $item->course->lectures->first();
                            $viewRoute = $firstLecture
                                ? route('user.lecture.view', $firstLecture->id)
                                : route('course.detail', $item->course_id);
                            if ($item->course->image) {
                                $image = asset('storage/' . $item->course->image);
                            }
                            // Find enrollment for progress
                            $enrollment = \App\Models\Enrollment::where('user_id', Auth::id())
                                ->where('course_id', $item->course_id)
                                ->first();
                            $progress = $enrollment ? $enrollment->progress : 0;
                        } elseif ($item->material) {
                            $title = $item->material->title;
                            $type = 'Resource';
                            $icon = !empty($item->material->video_path) ? 'fa-video' : 'fa-file-alt';
                            $viewRoute = route('material.view', $item->material_id);
                        } elseif ($item->lecture) {
                            $title = $item->lecture->title;
                            $type = 'Lecture';
                            $icon = 'fa-play-circle';
                            $viewRoute = route('lecture.view', $item->lecture_id);
                        } elseif ($item->quiz) {
                            $title = $item->quiz->title;
                            $type = 'Quiz';
                            $icon = 'fa-tasks';
                            $viewRoute = route('quiz.view', $item->quiz_id);
                        }
                    @endphp

                    <div class="col-lg-4 col-md-6">
                        <div class="premium-card">
                            <div class="card-image-box">
                                @if ($image)
                                    <img src="{{ $image }}" alt="{{ $title }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                        <i class="fa {{ $icon }} fa-3x text-primary opacity-25"></i>
                                    </div>
                                @endif
                                <div class="card-badge">{{ $type }}</div>
                            </div>
                            <div class="card-content">
                                <div class="item-type">{{ $type }}</div>
                                <h5 class="item-title">{{ $title }}</h5>

                                <div class="progress-box">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small
                                            class="text-muted">{{ $type == 'Course' ? 'Course Progress' : 'Purchased on' }}</small>
                                        <small
                                            class="fw-bold text-dark">{{ $type == 'Course' ? round($progress) . '%' : $order->created_at->format('M d') }}</small>
                                    </div>
                                    @if ($type == 'Course')
                                        <div class="progress">
                                            <div class="progress-bar" style="width:{{ $progress }}%"></div>
                                        </div>
                                    @else
                                        <div class="text-muted small">
                                            <i class="far fa-check-circle text-success me-1"></i> Access Secured
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer-action">
                                    <a href="{{ $viewRoute }}" class="btn-continue">
                                        {{ $type == 'Course' ? 'Continue Learning' : 'View Content' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @if (!$hasItems)
                <div class="col-12 empty-state">
                    <div class="empty-icon">
                        <i class="fa fa-layer-group fa-4x"></i>
                    </div>
                    <h2 class="fw-bold">Your library is empty</h2>
                    <p class="text-muted mb-4">Explore our premium courses and start learning today.</p>
                    <a href="{{ route('courses') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold">
                        Browse Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
