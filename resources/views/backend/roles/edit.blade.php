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
