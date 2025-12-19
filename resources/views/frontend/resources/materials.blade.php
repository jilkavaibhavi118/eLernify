@extends('layouts.frontend')

@section('title', 'eLEARNIFY | Materials')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Materials</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Materials</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Materials Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Materials</h6>
                <h1 class="mb-5">Learning Materials</h1>
            </div>

            @if (request('search'))
                <div class="mb-4">
                    <h4>Search results for: "{{ request('search') }}"</h4>
                    <a href="{{ route('materials.index') }}" class="btn btn-sm btn-outline-secondary">Clear Search</a>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @forelse($materials as $material)
                    @php
                        $hasAccess =
                            $material->is_free ||
                            (auth()->check() &&
                                (auth()->user()->hasRole('admin') ||
                                    auth()->user()->hasPurchased('material', $material->id) ||
                                    ($material->lecture &&
                                        (auth()->user()->hasPurchased('lecture', $material->lecture_id) ||
                                            auth()
                                                ->user()
                                                ->enrolledCourses->contains($material->lecture->course_id)))));

                        $type = 'Link';
                        $icon = 'fa-link';
                        if (!empty($material->video_path)) {
                            $type = 'Video';
                            $icon = 'fa-video';
                        } elseif (!empty($material->file_path)) {
                            $type = 'PDF / Document';
                            $icon = 'fa-file-pdf';
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden d-flex align-items-center justify-content-center bg-dark"
                                style="height: 200px;">
                                <i class="fa {{ $icon }} fa-4x text-white opacity-25"></i>
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    @if ($hasAccess)
                                        <a href="{{ route('material.view', $material->id) }}"
                                            class="btn btn-sm btn-primary px-4 rounded-pill">Download / View</a>
                                    @else
                                        @guest
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-4 rounded-pill">Buy
                                                Now</a>
                                        @else
                                            <form action="{{ route('purchase.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="material">
                                                <input type="hidden" name="id" value="{{ $material->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill">Buy
                                                    Now</button>
                                            </form>
                                        @endguest
                                    @endif
                                </div>
                                <div class="course-status position-absolute top-0 end-0 p-3">
                                    <span
                                        class="badge bg-primary text-white">{{ $material->is_free ? 'Free' : 'Premium' }}</span>
                                </div>
                            </div>
                            <div class="p-4 text-center">
                                <small class="text-primary fw-bold text-uppercase">{{ $type }}</small>
                                <h5 class="mb-3 mt-2">{{ $material->title }}</h5>
                                <p class="text-muted small">{{ $material->short_description }}</p>
                                @if (!$material->is_free)
                                    <h5 class="text-primary mb-0">₹{{ number_format($material->price, 2) }}</h5>
                                @endif
                            </div>
                            <div class="d-flex border-top text-center">
                                <small class="flex-fill py-2">
                                    <i
                                        class="fa fa-book-open text-primary me-2"></i>{{ $material->lecture->title ?? 'General Resource' }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No materials found.</h4>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Start -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $materials->links() }}
                </div>
            </div>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- Materials End -->
@endsection
