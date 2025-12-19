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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="short_description">Short Description </label>
                                    <input type="text" name="short_description"
                                        class="form-control @error('short_description') is-invalid @enderror"
                                        placeholder="Enter short description"
                                        value="{{ old('short_description', $material->short_description) }}">
                                    @error('short_description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check form-switch pt-4">
                                    <input class="form-check-input" type="checkbox" name="is_free" id="is_free"
                                        value="1" {{ old('is_free', $material->is_free) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_free">Is Free Material?</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3" id="price_container"
                                style="{{ old('is_free', $material->is_free) ? 'display:none;' : '' }}">
                                <div class="form-group">
                                    <label for="price">Price (₹)</label>
                                    <input type="number" name="price" step="0.01"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"
                                        value="{{ old('price', $material->price) }}">
                                    @error('price')
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
                                    <label for="file">Document File (leave blank to keep current)</label>
                                    <input type="file" name="file"
                                        class="form-control @error('file') is-invalid @enderror">
                                    @if ($material->file_path)
                                        <small class="text-muted d-block mt-1">
                                            Current: <a href="{{ asset('storage/' . $material->file_path) }}"
                                                target="_blank"><i class="fa fa-file-pdf"></i>
                                                {{ basename($material->file_path) }}</a>
                                        </small>
                                    @endif
                                    <small class="text-muted">PDF, Doc, Docx | Max: 10MB</small>
                                    @error('file')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="video">Video File (leave blank to keep current)</label>
                                    <input type="file" name="video"
                                        class="form-control @error('video') is-invalid @enderror">
                                    @if ($material->video_path)
                                        <small class="text-muted d-block mt-1">
                                            Current: <a href="{{ asset('storage/' . $material->video_path) }}"
                                                target="_blank"><i class="fa fa-video"></i>
                                                {{ basename($material->video_path) }}</a>
                                        </small>
                                    @endif
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
                                        placeholder="https://example.com/video"
                                        value="{{ old('content_url', $material->content_url) }}">
                                    @error('content_url')
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
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#is_free').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#price_container').slideUp();
                    } else {
                        $('#price_container').slideDown();
                    }
                });
            });
        </script>
    @endpush
@endsection
