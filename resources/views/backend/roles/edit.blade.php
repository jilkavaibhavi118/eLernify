@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Role</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.roles.update', $role->id) }}" method="POST" id="crudForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $role->name }}" placeholder="Enter role name">
                        </div>
                        <div class="form-group mt-3">
                            <label for="permissions">Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" id="crudFormSave">Update</button>
                            <a href="{{ route('backend.roles.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
