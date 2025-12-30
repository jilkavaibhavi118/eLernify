@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-info">Material Detail</h5>
                        <small class="text-muted">Attached to: <strong>{{ $material->lecture->title }}</strong>
                            ({{ $material->lecture->course->title }})</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.materials.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        <a href="{{ route('backend.materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Edit
                            Material</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="mb-4">{{ $material->title }}</h3>

                            <div class="mb-4">
                                <h6 class="fw-bold">File Information</h6>
                                <table class="table table-sm table-bordered bg-light">
                                    <tr>
                                        <th style="width: 30%">File Type</th>
                                        <td><span
                                                class="badge bg-secondary text-uppercase">{{ $material->type ?? 'Unknown' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>File Size</th>
                                        <td>{{ $material->file_size ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Storage Path</th>
                                        <td><code>{{ $material->file_path }}</code></td>
                                    </tr>
                                </table>
                            </div>

                            @if ($material->description)
                                <div class="mb-4">
                                    <h6 class="fw-bold">Description</h6>
                                    <div class="p-3 border rounded">
                                        {{ $material->description }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-5">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">Preview / Download</div>
                                <div class="card-body text-center py-5">
                                    <div class="mb-4">
                                        <i class="cil-file fs-1 text-primary" style="font-size: 5rem !important;"></i>
                                    </div>
                                    <p class="text-muted">You can download this material to view its content.</p>
                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                        class="btn btn-primary lg">
                                        <svg class="icon me-2">
                                            <use
                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-cloud-download">
                                            </use>
                                        </svg> Download File
                                    </a>
                                </div>
                            </div>

                            <div class="mt-3 card">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">Metadata</h6>
                                    <p class="mb-1 small"><strong>Created:</strong>
                                        {{ $material->created_at->format('M d, Y H:i') }}</p>
                                    <p class="mb-0 small"><strong>Updated:</strong>
                                        {{ $material->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
