@extends('layouts.frontend')

@section('title', 'My Courses | eLEARNIFY')

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
                                <i class="bi bi-journal-bookmark me-2"></i> My Courses
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="custom-tabs">
                            <a href="{{ route('user.courses') }}" class="custom-tab-item active">Courses</a>
                            <a href="{{ route('user.quizzes') }}" class="custom-tab-item">My Quizzes</a>
                            <a href="{{ route('user.certificates') }}" class="custom-tab-item">Certificates</a>
                        </div>

                        @if ($enrollments->count() > 0)
                            <!-- Actual Enrolled Courses List (If any) -->
                            <div class="row g-4">
                                @foreach ($enrollments as $enrollment)
                                    <div class="col-md-6 col-lg-4">
                                        <div
                                            class="card h-100 border-0 shadow-sm course-card-hover {{ $enrollment->status == 'refunded' ? 'opacity-75' : '' }}">
                                            @if ($enrollment->status == 'refunded')
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                    style="background: rgba(0,0,0,0.4); z-index: 2; border-radius: 8px;">
                                                    <span class="badge bg-danger px-3 py-2 shadow">REFUNDED</span>
                                                </div>
                                            @endif
                                            <img src="{{ asset('storage/' . $enrollment->course->image) }}"
                                                class="card-img-top" alt="{{ $enrollment->course->title }}"
                                                style="height: 160px; object-fit: cover;">
                                            <div class="card-body">
                                                <h6 class="card-title mb-2 text-truncate"
                                                    title="{{ $enrollment->course->title }}">
                                                    {{ $enrollment->course->title }}</h6>
                                                <div class="progress mb-2" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $enrollment->progress }}%; background-color: #0a2283;">
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ $enrollment->progress }}% Completed</small>
                                                @if ($enrollment->status == 'refunded')
                                                    <a href="{{ route('user.course.view', $enrollment->id) }}"
                                                        class="btn btn-outline-danger btn-sm w-100 mt-3">Access Denied</a>
                                                @else
                                                    <a href="{{ route('user.course.view', $enrollment->id) }}"
                                                        class="btn btn-primary btn-sm w-100 mt-3">Continue</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $enrollments->links() }}
                            </div>
                        @else
                            <!-- Empty State (Matching Screenshot) -->
                            <div class="empty-state-alert">
                                You have not enrolled for any courses, <a href="{{ route('courses') }}">start
                                    learning</a>
                            </div>

                            <div class="empty-state-content">
                                <h3 class="empty-state-title">Learn Any Course For Free In Your Own Language</h3>
                                <p class="empty-state-text">Level up your skills and take the next step in your career with
                                    our 80+ online video courses.</p>

                                <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2">Explore
                                    Courses</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
