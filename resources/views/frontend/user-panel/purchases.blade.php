@extends('layouts.frontend')

@section('title', 'My Purchases | eLEARNIFY')

@section('content')
    <div class="dashboard-container">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.user-panel.components.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="courses-card">
                        <div class="courses-header">
                            <div class="courses-title">
                                <i class="bi bi-cart me-2"></i> My Purchases
                            </div>
                        </div>

                        <div class="row g-4">
                            @php $hasItems = false; @endphp
                            @forelse ($orders as $order)
                                @foreach ($order->items as $item)
                                    @php
                                        $hasItems = true;
                                        $title = '';
                                        $type = '';
                                        $icon = 'bi-journal-bookmark';
                                        $viewRoute = '#';
                                        $image = null;
                                        $progress = 0;

                                        if ($item->course) {
                                            $title = $item->course->title;
                                            $type = 'Course';
                                            $icon = 'bi-mortarboard';
                                            $firstLecture = $item->course->lectures->first();
                                            $viewRoute = $firstLecture
                                                ? route('user.lecture.view', $firstLecture->id)
                                                : route('course.detail', $item->course_id);
                                            if ($item->course->image) {
                                                $image = asset('storage/' . $item->course->image);
                                            }
                                            $enrollment = \App\Models\Enrollment::where('user_id', Auth::id())
                                                ->where('course_id', $item->course_id)
                                                ->first();
                                            $progress = $enrollment ? $enrollment->progress : 0;
                                        } elseif ($item->material) {
                                            $title = $item->material->title;
                                            $type = 'Resource';
                                            $icon = !empty($item->material->video_path)
                                                ? 'bi-play-circle'
                                                : 'bi-file-earmark-text';
                                            $viewRoute = route('material.view', $item->material_id);
                                        } elseif ($item->lecture) {
                                            $title = $item->lecture->title;
                                            $type = 'Lecture';
                                            $icon = 'bi-play-btn';
                                            $viewRoute = route('lecture.view', $item->lecture_id);
                                        } elseif ($item->quiz) {
                                            $title = $item->quiz->title;
                                            $type = 'Quiz';
                                            $icon = 'bi-clipboard-check';
                                            $viewRoute = route('quiz.view', $item->quiz_id);
                                        }
                                    @endphp

                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 border-0 shadow-sm course-card-hover position-relative">
                                            <div class="card-badge">{{ $type }}</div>
                                            @if ($image)
                                                <img src="{{ $image }}" class="card-img-top"
                                                    alt="{{ $title }}" style="height: 160px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                                    style="height: 160px;">
                                                    <i class="bi {{ $icon }} text-primary"
                                                        style="font-size: 3rem; opacity: 0.3;"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title mb-2 text-truncate" title="{{ $title }}">
                                                    {{ $title }}
                                                </h6>

                                                <div class="mt-auto">
                                                    @if ($type == 'Course')
                                                        <div class="progress mb-2" style="height: 5px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $progress }}%; background-color: #0a2283;">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <small class="text-muted">{{ round($progress) }}%
                                                                Completed</small>
                                                        </div>
                                                        <a href="{{ $viewRoute }}"
                                                            class="btn btn-primary btn-sm w-100">Continue learning</a>
                                                    @else
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <small class="text-muted"><i
                                                                    class="bi bi-calendar-event me-1"></i>
                                                                {{ $order->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                        <a href="{{ $viewRoute }}"
                                                            class="btn btn-primary btn-sm w-100">View Content</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @empty
                                <div class="col-12">
                                    <div class="empty-state-alert">
                                        You have not purchased any courses or resources yet, <a
                                            href="{{ route('courses') }}">explore our library</a>
                                    </div>
                                    <div class="text-center py-5">
                                        <h3 class="mb-3" style="color: #00235B; font-weight: 700;">Start Your Learning
                                            Journey</h3>
                                        <p class="text-muted mb-4">Level up your skills and take the next step in your
                                            career with our online video courses.</p>
                                        <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2">Explore
                                            Courses</a>
                                    </div>
                                </div>
                            @endforelse

                            @if (!$hasItems && $orders->count() > 0)
                                <div class="col-12">
                                    <div class="empty-state-alert">
                                        You have not purchased any courses or resources yet, <a
                                            href="{{ route('courses') }}">explore our library</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
