@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Course Details</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.courses.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-4">
                            <div class="position-relative">
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                        class="img-fluid rounded border shadow-sm w-100"
                                        style="object-fit: cover; max-height: 300px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center border rounded"
                                        style="height: 250px;">
                                        <span class="text-muted">No Image Available</span>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span
                                        class="badge {{ $course->status === 'active' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="card mt-4 border-info">
                                <div class="card-header bg-info text-white">Quick Info</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Price
                                        <span class="fw-bold">₹ {{ number_format($course->price, 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Category
                                        <span class="badge bg-primary">{{ $course->category->name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Level
                                        <span class="badge bg-secondary">{{ ucfirst($course->level ?? 'Beginner') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Duration
                                        <span>{{ $course->duration ?? 'N/A' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3>{{ $course->title }}</h3>
                            <p class="text-muted mb-4">{{ $course->sub_title }}</p>

                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active"
                                            data-coreui-toggle="tab" href="#details" role="tab" aria-controls="details"
                                            aria-selected="true">Course Info</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-coreui-toggle="tab"
                                            href="#stats" role="tab" aria-controls="stats"
                                            aria-selected="false">Instructor & Stats</a></li>
                                </ul>
                                <div class="tab-content border-start border-end border-bottom p-3">
                                    <div class="tab-pane active" id="details" role="tabpanel">
                                        <h6 class="fw-bold">Description</h6>
                                        <div class="course-description p-2 bg-light rounded shadow-inner"
                                            style="min-height: 100px;">
                                            {!! $course->description !!}
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Created:</strong> {{ $course->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Last Update:</strong>
                                                    {{ $course->updated_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="stats" role="tabpanel">
                                        <div class="d-flex align-items-center mb-3 p-2 border rounded bg-light">
                                            <img src="{{ $course->instructor->image ? asset('storage/' . $course->instructor->image) : asset('assets/img/avatars/8.jpg') }}"
                                                class="rounded-circle me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0">{{ $course->instructor->name }}</h5>
                                                <small
                                                    class="text-muted">{{ $course->instructor->designation ?? 'Instructor' }}</small>
                                            </div>
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Instructor Email
                                                <span>{{ $course->instructor->email }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Instructor Specialty
                                                <span>{{ $course->instructor->specialty ?? 'General' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('backend.courses.edit', $course->id) }}" class="btn btn-warning">
                                    <svg class="icon" width="16" height="16">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-pencil">
                                        </use>
                                    </svg> Edit Course
                                </a>
                                <a href="{{ route('backend.lectures.index', ['course_id' => $course->id]) }}"
                                    class="btn btn-primary ms-2">
                                    <svg class="icon" width="16" height="16">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-book"></use>
                                    </svg> Manage Lectures
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
