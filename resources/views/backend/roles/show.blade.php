@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Role Detail: <strong>{{ ucfirst($role->name) }}</strong></h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.roles.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        <a href="{{ route('backend.roles.permissions', $role->id) }}" class="btn btn-warning btn-sm">Manage
                            Permissions</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <h6 class="fw-bold border-bottom pb-2">Assigned Permissions
                                    ({{ $role->permissions->count() }})</h6>
                                <div class="row mt-3">
                                    @php
                                        $groupedPermissions = $role->permissions->groupBy(function ($permission) {
                                            return explode('.', $permission->name)[0];
                                        });
                                    @endphp

                                    @forelse($groupedPermissions as $group => $permissions)
                                        <div class="col-md-3 mb-4">
                                            <div class="card h-100 border-light shadow-sm">
                                                <div class="card-header bg-light py-1">
                                                    <strong>{{ ucfirst($group) }}</strong></div>
                                                <div class="card-body py-2">
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($permissions as $permission)
                                                            <li class="mb-1">
                                                                <i class="cil-check text-success me-1"></i>
                                                                <small>{{ str_replace($group . '.', '', $permission->name) }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-warning">This role has no permissions assigned.</div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-2 text-muted small">
                                <strong>Role Created:</strong> {{ $role->created_at->format('M d, Y H:i') }} |
                                <strong>Last Updated:</strong> {{ $role->updated_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
