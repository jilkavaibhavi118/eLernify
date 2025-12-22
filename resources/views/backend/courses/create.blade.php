@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Create New Course</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.courses.store') }}" method="POST" id="crudForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter course title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <x-select2_ajax name="category_id" :selected="old('category_id')" :required="true"
                                    placeholder="Select Category" :url="route('backend.categories.search')" />
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                        placeholder="Enter course description">{{ old('description') }}</textarea>
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
                                        step="0.01" min="0" value="{{ old('price') }}">
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
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @hasrole('Admin')
                                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                    <x-select2_ajax name="instructor_id" :selected="old('instructor_id')" :required="false"
                                        placeholder="Select Instructor" :url="route('backend.instructors.search')" />
                                </div>
                            @endhasrole
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="duration">Duration</label>
                                    <input type="text" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        placeholder="e.g., 4 weeks, 20 hours, 3 months" value="{{ old('duration') }}">
                                    <small class="text-muted">Enter the course duration (e.g., 4 weeks, 20 hours)</small>
                                    @error('duration')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="image">Course Image</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Max size: 2MB. Allowed types: jpeg, png, jpg, gif</small>
                                    @error('image')
                                        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Save</button>
                                <a href="{{ route('backend.courses.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
