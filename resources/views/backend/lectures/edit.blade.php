@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Lecture</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.lectures.update', $lecture->id) }}" method="POST" id="crudForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="course_id">Course <span class="text-danger">*</span></label>
                                    <select name="course_id" id="course_id"
                                        class="form-control @error('course_id') is-invalid @enderror">
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ old('course_id', $lecture->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter lecture title" value="{{ old('title', $lecture->title) }}">
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="short_description">Short Description </label>
                                    <input type="text" name="short_description"
                                        class="form-control @error('short_description') is-invalid @enderror"
                                        placeholder="Brief summary"
                                        value="{{ old('short_description', $lecture->short_description) }}">
                                    @error('short_description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                        placeholder="Enter lecture description">{{ old('description', $lecture->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check form-switch pt-4">
                                    <input class="form-check-input" type="checkbox" name="is_free" id="is_free"
                                        value="1" {{ old('is_free', $lecture->is_free) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_free">Is Free Lecture?</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3" id="price_container"
                                style="{{ old('is_free', $lecture->is_free) ? 'display:none;' : '' }}">
                                <div class="form-group">
                                    <label for="price">Price (INR) <span class="text-danger">*</span></label>
                                    <input type="number" name="price"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"
                                        step="0.01" min="0" value="{{ old('price', $lecture->price) }}">
                                    @error('price')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option value="active"
                                            {{ old('status', $lecture->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $lecture->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="live_class_available">Live Class Available <span
                                            class="text-danger">*</span></label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input @error('live_class_available') is-invalid @enderror"
                                                type="radio" name="live_class_available" id="live_yes" value="1"
                                                {{ old('live_class_available', $lecture->live_class_available) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="live_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input @error('live_class_available') is-invalid @enderror"
                                                type="radio" name="live_class_available" id="live_no" value="0"
                                                {{ old('live_class_available', $lecture->live_class_available) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="live_no">No</label>
                                        </div>
                                    </div>
                                    @error('live_class_available')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Update</button>
                                <a href="{{ route('backend.lectures.index') }}" class="btn btn-secondary">Back</a>
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
