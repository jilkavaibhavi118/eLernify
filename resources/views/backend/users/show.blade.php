@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Details</h5>
                    <a href="{{ route('backend.users.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('assets/img/avatars/8.jpg') }}"
                                alt="{{ $user->name }}" class="img-fluid rounded-circle border"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 class="mt-3">{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            <div>
                                @foreach ($user->getRoleNames() as $role)
                                    <span class="badge bg-info">{{ $role }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Account Status</th>
                                    <td>
                                        @if ($user->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Verified At</th>
                                    <td>{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y H:i') : 'Not Verified' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                                <a href="{{ route('backend.orders.index', ['user_id' => $user->id]) }}"
                                    class="btn btn-info text-white">View Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
