@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Edit New User</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.users.update', $user->id) }}" method="POST" id="crudForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                        placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" name="confirm-password" class="form-control"
                                        placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="roles">Role</label>
                                    <select class="form-control" multiple name="roles[]">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}"
                                                {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-start">
                                <button type="submit" class="btn btn-primary" id="crudFormSave">Update</button>
                                <a href="{{ route('backend.users.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
