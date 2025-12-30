@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Manage Permissions : {{ $role->name }}</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('backend.roles.permissions.update', $role->id) }}" id="crudForm">
                @csrf

                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="form-check-input"
                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success mt-3" id="crudFormSave">Update Permissions</button>
            </form>
        </div>
    </div>
@endsection
