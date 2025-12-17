@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Course</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.courses.update', $course->id) }}" method="POST" id="crudForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter course title" value="{{ old('title', $course->title) }}">
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <x-select2_ajax name="category_id" :selected="old('category_id', $course->category_id)" :selectedText="$course->category->name ?? ''" :required="true"
                                    placeholder="Select Category" :url="route('backend.categories.search')" />
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                        placeholder="Enter course description">{{ old('description', $course->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="price">Price (INR) <span class="text-danger">*</span></label>
                                    <input type="number" name="price"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"
                                        step="0.01" min="0" value="{{ old('price', $course->price) }}">
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
                                            {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $course->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <x-select2_ajax name="instructor_id" :selected="old('instructor_id', $course->instructor_id)" :selectedText="$course->instructor->name ?? ''" :required="false"
                                    placeholder="Select Instructor" :url="route('backend.instructors.search')" />
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="duration">Duration</label>
                                    <input type="text" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        placeholder="e.g., 4 weeks, 20 hours, 3 months"
                                        value="{{ old('duration', $course->duration) }}">
                                    <small class="text-muted">Enter the course duration (e.g., 4 weeks, 20 hours)</small>
                                    @error('duration')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="image">Course Image (leave blank to keep current image)</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @if ($course->image)
                                        <div class="mt-2">
                                            <small class="text-muted">Current image:</small><br>
                                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                                style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 4px; margin-top: 8px;">
                                        </div>
                                    @else
                                        <small class="text-muted">No image uploaded</small>
                                    @endif
                                    <br><small class="text-muted">Max size: 2MB. Allowed types: jpeg, png, jpg, gif</small>
                                    @error('image')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Update</button>
                                <a href="{{ route('backend.courses.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
