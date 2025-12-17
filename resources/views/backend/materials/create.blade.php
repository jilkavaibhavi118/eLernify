@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Create New Material</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.materials.store') }}" method="POST" id="crudForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter material title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Enter description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-select2_ajax name="lecture_id" :selected="old('lecture_id')" :required="true" />
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="file">Document File</label>
                                    <input type="file" name="file"
                                        class="form-control @error('file') is-invalid @enderror">
                                    <small class="text-muted">PDF, Doc, Docx | Max: 10MB</small>
                                    @error('file')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="video">Video File</label>
                                    <input type="file" name="video"
                                        class="form-control @error('video') is-invalid @enderror">
                                    <small class="text-muted">MP4, WebM | Max: 100MB</small>
                                    @error('video')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="content_url">External URL</label>
                                    <input type="url" name="content_url"
                                        class="form-control @error('content_url') is-invalid @enderror"
                                        placeholder="https://example.com/video" value="{{ old('content_url') }}">
                                    @error('content_url')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Save</button>
                                <a href="{{ route('backend.materials.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
