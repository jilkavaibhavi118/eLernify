@extends('layouts.frontend')

@section('title', 'My Certificates | eLEARNIFY')

@section('content')
    <div class="dashboard-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.user-panel.components.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-2">
                                    <i class="bi bi-award me-2 text-warning"></i>My Certificates
                                </h3>
                                <p class="text-muted mb-0">
                                    You have earned <strong>{{ $stats['total'] }}</strong>
                                    certificate{{ $stats['total'] != 1 ? 's' : '' }}
                                </p>
                            </div>
                            @if ($stats['total'] > 0)
                                <div>
                                    <span class="badge bg-warning text-dark" style="font-size: 1.5rem; padding: 10px 20px;">
                                        <i class="bi bi-trophy-fill me-2"></i>{{ $stats['total'] }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Certificates Grid -->
                    @if ($completedEnrollments->count() > 0)
                        <div class="row g-4">
                            @foreach ($completedEnrollments as $enrollment)
                                <div class="col-md-6">
                                    <div class="certificate-card">
                                        <div class="certificate-icon">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </div>
                                        <div class="certificate-title">
                                            {{ $enrollment->course->title }}
                                        </div>
                                        <div class="certificate-meta">
                                            <div class="mb-1">
                                                <i class="bi bi-person-circle me-2"></i>
                                                @if ($enrollment->course->instructor)
                                                    {{ $enrollment->course->instructor->name }}
                                                @else
                                                    eLEARNIFY
                                                @endif
                                            </div>
                                            <div class="mb-1">
                                                <i class="bi bi-calendar-check me-2"></i>
                                                Completed: {{ $enrollment->completed_at->format('M d, Y') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-bookmark-fill me-2"></i>
                                                @if ($enrollment->course->category)
                                                    {{ $enrollment->course->category->name }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="certificate-actions">
                                            <a href="{{ route('user.certificate.download', $enrollment->id) }}"
                                                class="btn btn-sm">
                                                <i class="bi bi-download me-2"></i>Download PDF
                                            </a>
                                            <a href="{{ route('user.course.view', $enrollment->id) }}" class="btn btn-sm">
                                                <i class="bi bi-eye me-2"></i>View Course
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-trophy"></i>
                            <h4>No Certificates Yet</h4>
                            <p class="text-muted mb-4">
                                Complete a course to earn your first certificate!<br>
                                Certificates are awarded when you finish all lectures and quizzes in a course.
                            </p>
                            <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-book me-2"></i>Browse Courses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
