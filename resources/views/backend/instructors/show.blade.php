@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Instructor Profile</h5>
                    <a href="{{ route('backend.instructors.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <img src="{{ $instructor->image ? asset('storage/' . $instructor->image) : asset('assets/img/avatars/8.jpg') }}"
                                alt="{{ $instructor->name }}" class="img-fluid rounded border shadow-sm"
                                style="width: 200px; height: 200px; object-fit: cover;">
                            <h4 class="mt-3">{{ $instructor->name }}</h4>
                            <p class="text-primary fw-bold">{{ $instructor->designation ?? 'Instructor' }}</p>
                            <p class="text-muted"><small>{{ $instructor->specialty ?? 'Generalist' }}</small></p>

                            <div class="d-flex justify-content-center gap-2 mt-2">
                                @if ($instructor->linkedin_url)
                                    <a href="{{ $instructor->linkedin_url }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">LinkedIn</a>
                                @endif
                                @if ($instructor->github_url)
                                    <a href="{{ $instructor->github_url }}" target="_blank"
                                        class="btn btn-outline-dark btn-sm">GitHub</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6>About Instructor</h6>
                                <div class="p-3 bg-light rounded border">
                                    {{ $instructor->bio ?? 'No bio available.' }}
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Email</th>
                                    <td>{{ $instructor->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $instructor->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Linked User Account</th>
                                    <td>
                                        @if ($instructor->user)
                                            <a href="{{ route('backend.users.show', $instructor->user->id) }}">{{ $instructor->user->name }}
                                                ({{ $instructor->user->email }})</a>
                                        @else
                                            <span class="text-danger">Not Linked</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span
                                            class="badge {{ $instructor->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($instructor->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Courses</th>
                                    <td><span class="badge bg-info">{{ $instructor->courses->count() }}</span></td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('backend.instructors.edit', $instructor->id) }}"
                                    class="btn btn-warning">Edit Instructor</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
