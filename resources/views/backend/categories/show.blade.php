@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Category Details</h5>
                    <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="img-fluid rounded border shadow-sm" style="max-width: 100%; height: auto;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center border rounded"
                                    style="height: 200px;">
                                    <span class="text-muted">No Image Available</span>
                                </div>
                            @endif
                            <h4 class="mt-3">{{ $category->name }}</h4>
                            <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Category Name</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category Slug</th>
                                    <td><code>{{ $category->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($category->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Courses</th>
                                    <td>
                                        <span class="badge bg-info">{{ $category->courses_count }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $category->description ?? 'No description provided.' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('backend.categories.edit', $category->id) }}"
                                    class="btn btn-primary">Edit Category</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
