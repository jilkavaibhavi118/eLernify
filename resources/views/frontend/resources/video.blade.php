@extends('layouts.frontend')

@section('title', $material->title . ' | eLEARNIFY')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-dark rounded overflow-hidden shadow mb-4" style="aspect-ratio: 16/9;">
                        <video width="100%" height="100%" controls controlsList="nodownload" oncontextmenu="return false;">
                            <source src="{{ asset('storage/' . $material->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>

                    <div class="bg-light rounded p-5 shadow-sm border">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="text-primary mb-2">{{ $material->title }}</h2>
                                <p class="text-muted">{{ $material->short_description }}</p>
                            </div>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fa fa-arrow-left me-2"></i>Back
                            </a>
                        </div>

                        <div class="bg-white p-4 rounded border">
                            <h5 class="mb-3">About this video</h5>
                            <p class="mb-0 text-muted">This is a premium learning resource from eLEARNIFY. You have
                                successfully unlocked this content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
