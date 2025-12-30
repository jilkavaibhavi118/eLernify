@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-primary">Lecture Detail</h5>
                        <small class="text-muted">Part of course: <strong>{{ $lecture->course->title }}</strong></small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.lectures.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        <a href="{{ route('backend.lectures.edit', $lecture->id) }}" class="btn btn-warning btn-sm">Edit
                            Lecture</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light"><strong>Lecture Information</strong></div>
                                <div class="card-body">
                                    <h3 class="mb-3">{{ $lecture->title }}</h3>
                                    <div class="mb-4 p-3 bg-light rounded text-dark fs-5">
                                        {{ $lecture->description ?? 'No description.' }}
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="p-2 border rounded">
                                                <p class="mb-1 text-muted">Status</p>
                                                <span
                                                    class="badge {{ $lecture->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($lecture->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-2 border rounded">
                                                <p class="mb-1 text-muted">Order</p>
                                                <strong>{{ $lecture->order }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="p-2 border rounded">
                                                <p class="mb-1 text-muted">Live Class</p>
                                                @if ($lecture->live_class_available)
                                                    <span class="badge bg-primary">Available</span>
                                                    <div class="mt-2 p-2 bg-dark text-white rounded small">
                                                        Meeting ID: {{ $lecture->zoom_meeting_id }}<br>
                                                        Start Time: {{ $lecture->zoom_start_time }}
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary">Pre-recorded Only</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 border-info">
                                <div class="card-header bg-info text-white">Lecture Video</div>
                                <div class="card-body p-0">
                                    @if ($lecture->video_url)
                                        @php
                                            $videoId = '';
                                            if (
                                                preg_match(
                                                    '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                                    $lecture->video_url,
                                                    $match,
                                                )
                                            ) {
                                                $videoId = $match[1];
                                            }
                                        @endphp
                                        @if ($videoId)
                                            <div class="ratio ratio-16x9">
                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                                    allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <div class="p-4 text-center">
                                                <a href="{{ $lecture->video_url }}" target="_blank"
                                                    class="btn btn-primary">Watch External Video</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="p-5 text-center bg-light text-muted">
                                            No Video Provided
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between">
                                    <strong>Materials</strong>
                                    <span class="badge bg-primary">{{ $lecture->materials->count() }}</span>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @forelse($lecture->materials as $material)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $material->title }}
                                            <a href="{{ route('backend.materials.show', $material->id) }}"
                                                class="btn btn-sm btn-ghost-info p-0"><svg class="icon">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-notes">
                                                    </use>
                                                </svg></a>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No materials attached.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <strong>Quizzes</strong>
                                    <span class="badge bg-warning">{{ $lecture->quizzes->count() }}</span>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @forelse($lecture->quizzes as $quiz)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $quiz->title }}
                                            <a href="{{ route('backend.quizzes.show', $quiz->id) }}"
                                                class="btn btn-sm btn-ghost-info p-0"><svg class="icon">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-notes">
                                                    </use>
                                                </svg></a>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No quizzes attached.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
