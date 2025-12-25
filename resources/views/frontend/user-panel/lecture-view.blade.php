@extends('layouts.frontend')

@section('title', $lecture->title . ' | eLEARNIFY Player')

@push('styles')
    <style>
        :root {
            --player-bg: #f9fafb;
            --sidebar-width: 380px;
            --primary-color: #0a2283;
            --primary-light: rgba(10, 34, 131, 0.1);
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--player-bg);
            font-family: 'Inter', sans-serif;
        }

        /* Player Header */
        .player-header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .player-title-section h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .lesson-stats {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Main Layout */
        .player-container {
            display: flex;
            min-height: calc(100vh - 120px);
            max-width: 1600px;
            margin: 2rem auto;
            gap: 2rem;
            padding: 0 2rem;
        }

        .player-main {
            flex: 1;
            min-width: 0;
        }

        .video-wrapper {
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            aspect-ratio: 16 / 9;
            margin-bottom: 2rem;
        }

        .video-wrapper iframe,
        .video-wrapper video {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Tabs & Content */
        .content-tabs {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .nav-pills .nav-link {
            color: var(--text-muted);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        /* Sidebar */
        .player-sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 160px);
            position: sticky;
            top: 100px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--primary-color);
            background: #fff;
        }

        .sidebar-header h5 {
            color: var(--text-dark);
            margin: 0;
            position: relative;
        }

        .sidebar-content {
            overflow-y: auto;
            padding: 0;
        }

        .section-group {
            border-bottom: 1px solid var(--border-color);
        }

        .section-group:last-child {
            border-bottom: none;
        }

        .section-header {
            background-color: #f9fafb;
            padding: 1.25rem 1.25rem 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .lesson-list-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.2s;
            border-bottom: 1px solid var(--border-color);
            gap: 1rem;
        }

        .lesson-list-item:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }

        .lesson-list-item.active {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        .lesson-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: 0.85rem;
            flex-shrink: 0;
            color: var(--text-muted);
        }

        .active .lesson-icon {
            background: var(--primary-color);
            color: #fff;
        }

        .material-title {
            flex-grow: 1;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .player-container {
                flex-direction: column;
            }

            .player-sidebar {
                width: 100%;
            }

            .sidebar-card {
                position: static;
                max-height: none;
            }
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #081b6a;
            border-color: #081b6a;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        /* Sidebar Section Styling Override */
        .section-header .text-primary {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .section-header .fw-bold {
            font-size: 1.1rem !important;
            margin-top: 0.25rem;
        }

        /* Navigation Cards */
        .nav-cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 3rem;
            margin-bottom: 2rem;
        }

        .nav-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .nav-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            color: inherit;
        }

        .nav-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .nav-card:hover .nav-card-icon {
            background: var(--primary-color);
            color: #fff;
        }

        .nav-card-content {
            flex: 1;
            min-width: 0;
        }

        .nav-card-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .nav-card-title {
            display: block;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .nav-cards-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <header class="player-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="player-title-section">
                <a href="{{ route('user.course.view', $enrollment->id) }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
                <h1>{{ $activeMaterial->title ?? $lecture->title }}</h1>
                <div class="lesson-stats">
                    <span><i class="fas fa-book-reader me-1"></i> Part of: {{ $lecture->title }}</span>
                    <span><i class="fas fa-clock me-1"></i> {{ $enrollment->course->duration ?? 'Self-paced' }}</span>
                </div>
            </div>
            <div class="header-actions">
                <div class="progress-info text-end">
                    <div class="d-flex align-items-center gap-3 mb-1">
                        @if ($prev_url)
                            <a href="{{ $prev_url }}" class="btn btn-link btn-sm text-muted p-0" title="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        <div class="progress" style="height: 6px; width: 120px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress }}%"></div>
                        </div>
                        @if ($next_url)
                            <a href="{{ $next_url }}" class="btn btn-link btn-sm text-muted p-0" title="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">{{ round($enrollment->progress) }}%
                        Complete</small>
                </div>
            </div>
        </div>
    </header>

    @php
        $videoSource = null;
        $videoType = null;

        if ($activeMaterial) {
            if (!empty($activeMaterial->video_path)) {
                $videoSource = asset('storage/' . $activeMaterial->video_path);
                $videoType = 'file';
            } elseif (!empty($activeMaterial->content_url)) {
                if (
                    preg_match(
                        '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^\"&?/ ]{11})%i',
                        $activeMaterial->content_url,
                        $match,
                    )
                ) {
                    $videoSource = 'https://www.youtube.com/embed/' . $match[1];
                    $videoType = 'youtube';
                }
            }
        }

        // Final fail-safe if no active material or video found
        if (!$videoType) {
            $fallback = $lecture->materials
                ->filter(fn($m) => !empty($m->video_path) || !empty($m->content_url))
                ->first();
            if ($fallback) {
                if (!empty($fallback->video_path)) {
                    $videoSource = asset('storage/' . $fallback->video_path);
                    $videoType = 'file';
                } elseif (!empty($fallback->content_url)) {
                    if (
                        preg_match(
                            '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^\"&?/ ]{11})%i',
                            $fallback->content_url,
                            $match,
                        )
                    ) {
                        $videoSource = 'https://www.youtube.com/embed/' . $match[1];
                        $videoType = 'youtube';
                    }
                }
            }
        }
    @endphp

    <div class="player-container">
        <!-- Main Player Area -->
        <main class="player-main">
            <div class="video-wrapper">
                @if ($videoType === 'youtube')
                    <iframe src="{{ $videoSource }}" title="{{ $activeMaterial->title ?? $lecture->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                @elseif ($videoType === 'file')
                    <video width="100%" height="100%" controls controlsList="nodownload" oncontextmenu="return false;">
                        <source src="{{ $videoSource }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-white bg-dark">
                        <div class="text-center">
                            <i class="fas fa-video-slash fa-3x mb-3 text-muted"></i>
                            <p>No video content available for this lesson yet.</p>
                        </div>
                    </div>
                @endif
            </div>


            <div class="content-tabs">
                @php
                    $resourceCount = $lecture->materials
                        ->filter(function ($m) use ($activeMaterial) {
                            // Hide the active material if it's purely a video (to avoid duplication in the player vs list)
                            // But if it has a file (PDF), we keep it so they can download it.
                            $isActive = $activeMaterial && $m->id == $activeMaterial->id;
                            if ($isActive && empty($m->file_path)) {
                                return false;
                            }
                            return true;
                        })
                        ->count();
                @endphp
                <ul class="nav nav-pills mb-4" id="playerTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview"
                            type="button" role="tab">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="resources-tab" data-bs-toggle="pill" data-bs-target="#resources"
                            type="button" role="tab">Resources ({{ $resourceCount }})</button>
                    </li>
                </ul>
                <div class="tab-content" id="playerTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        @if ($activeMaterial && $activeMaterial->description)
                            <div class="mb-4">
                                <h5 class="fw-bold text-dark mb-2">Video Overview</h5>
                                <p class="text-muted">{{ $activeMaterial->description }}</p>
                                <hr class="my-4 opacity-25">
                            </div>
                        @endif

                        <h5 class="fw-bold text-dark mb-3">Module Context</h5>
                        <div class="text-muted leading-relaxed">
                            @php
                                $desc = $lecture->description;
                                if (str_contains($desc, '-')) {
                                    $lines = preg_split('/\r\n|\r|\n/', $desc);
                                    echo '<ul class="list-unstyled mb-0">';
                                    foreach ($lines as $line) {
                                        $trimmed = trim($line);
                                        if (empty($trimmed)) {
                                            continue;
                                        }

                                        // Check if line starts with - or *
                                        if (preg_match('/^[-*]/', $trimmed)) {
                                            $content = ltrim($trimmed, '-* ');
                                            echo '<li class="mb-2 d-flex align-items-start">
                                                    <i class="fas fa-check-circle text-primary me-2 mt-1" style="font-size: 0.85rem; opacity: 0.8;"></i>
                                                    <span>' .
                                                e($content) .
                                                '</span>
                                                  </li>';
                                        } else {
                                            echo '<li class="fw-bold mb-2 mt-3 text-dark" style="font-size: 1.1rem; letter-spacing: -0.01em;">' .
                                                e($trimmed) .
                                                '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                } else {
                                    echo nl2br(e($desc));
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="tab-pane fade" id="resources" role="tabpanel">
                        <h4 class="fw-bold mb-4">Learning Materials</h4>
                        @php
                            $resources = $lecture->materials->filter(function ($m) use ($activeMaterial) {
                                // Hide the active material if it's purely a video (to avoid duplication in the player vs list)
                                // But if it has a file (PDF), we keep it so they can download it.
                                $isActive = $activeMaterial && $m->id == $activeMaterial->id;
                                if ($isActive && empty($m->file_path)) {
                                    return false;
                                }
                                return true;
                            });
                        @endphp

                        @if ($resources->count() > 0)
                            <div class="row g-3">
                                @foreach ($resources as $material)
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 border rounded-3 d-flex align-items-center bg-light transition-hover">
                                            <div class="me-3 text-primary">
                                                <i
                                                    class="fas {{ !empty($material->video_path) ? 'fa-video' : 'fa-file-pdf' }} fa-lg"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-bold small">{{ $material->title }}</h6>
                                                <small class="text-muted">{{ $material->short_description }}</small>
                                            </div>
                                            @if ($material->file_path)
                                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary ms-2 px-3 rounded-pill">Download</a>
                                            @elseif($material->content_url || $material->video_path)
                                                <span class="badge bg-primary rounded-pill px-3">Video Asset</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded-3">
                                <p class="text-muted mb-0">No additional resources available for this lesson.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="nav-cards-container">
                    <div>
                        @if ($prev_url)
                            <a href="{{ $prev_url }}" class="nav-card">
                                <div class="nav-card-icon">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="nav-card-content">
                                    <span class="nav-card-label">Previous Lesson</span>
                                    <span class="nav-card-title">{{ $prev_title }}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                    <div>
                        @if ($next_url)
                            <a href="{{ $next_url }}" class="nav-card flex-row-reverse">
                                <div class="nav-card-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="nav-card-content text-end">
                                    <span class="nav-card-label">Next Lesson</span>
                                    <span class="nav-card-title">{{ $next_title }}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="player-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="fw-bold mb-1">Course Lessons</h5>
                    <div class="progress mt-3" style="height: 6px;">
                        @php
                            $progress = $enrollment->progress ?? 0;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <div class="sidebar-content">
                    @php $materialCounter = 1; @endphp
                    @foreach ($enrollment->course->lectures as $l)
                        <div class="section-group">
                            <div class="section-header">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="text-primary fw-bold small text-uppercase">Lecture
                                        {{ $loop->iteration }}</span>
                                    <span class="badge bg-light text-primary fw-normal border"
                                        style="font-size: 0.65rem; border-color: var(--primary-light) !important;">
                                        {{ $l->materials->filter(fn($m) => !empty($m->video_path) || !empty($m->content_url))->count() }}
                                        Videos
                                    </span>
                                </div>
                                <div class="fw-bold"
                                    style="font-size: 0.95rem; line-height: 1.3; color: var(--text-dark);">
                                    {{ $l->title }}
                                </div>
                            </div>

                            @foreach ($l->materials as $m)
                                @if (!empty($m->video_path) || !empty($m->content_url))
                                    @php
                                        $isActive = $activeMaterial && $m->id == $activeMaterial->id;
                                    @endphp
                                    <a href="{{ route('user.lecture.view', ['lectureId' => $l->id, 'materialId' => $m->id]) }}"
                                        class="lesson-list-item {{ $isActive ? 'active' : '' }}">
                                        <div class="lesson-icon">
                                            <i class="fas {{ $isActive ? 'fa-play' : 'fa-play-circle' }}"></i>
                                        </div>
                                        <div class="material-title">
                                            {{ sprintf('%02d', $materialCounter++) }} - {{ $m->title }}
                                        </div>
                                    </a>
                                @endif
                            @endforeach

                            @if ($l->quizzes && $l->quizzes->count() > 0)
                                @foreach ($l->quizzes as $q)
                                    <a href="{{ route('user.quiz.view', $q->id) }}" class="lesson-list-item opacity-75"
                                        style="border-left: 4px solid #f3f4f6;">
                                        <div class="lesson-icon" style="background: transparent;">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div class="material-title" style="font-size: 0.85rem;">
                                            Quiz: {{ $q->title }}
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        // Tab switching logic (Bootstrap 5)
        var triggerTabList = [].slice.call(document.querySelectorAll('#playerTab button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    </script>
@endpush
