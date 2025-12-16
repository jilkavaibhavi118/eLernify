@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Material</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.materials.update', $material->id) }}" method="POST" id="crudForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter material title" value="{{ old('title', $material->title) }}">
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Enter description">{{ old('description', $material->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-select2_ajax name="lecture_id" :selected="old('lecture_id', $material->lecture_id)" :selectedText="$material->lecture->title ?? ''" :required="true" />
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="file">File (leave blank to keep current file)</label>
                                    <input type="file" name="file"
                                        class="form-control @error('file') is-invalid @enderror">
                                    <small class="text-muted">Current file: {{ basename($material->file_path) }} | Max size:
                                        10MB</small>
                                    @error('file')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Update</button>
                                <a href="{{ route('backend.materials.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
