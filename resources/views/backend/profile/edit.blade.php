@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Profile</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.profile.update') }}" method="POST" id="crudForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo -->
                        <div class="form-group">
                            <label for="profile_photo">Profile Photo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <img id="profilePhotoPreview"
                                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('assets/img/avatars/8.jpg') }}"
                                        alt="Profile Photo" class="rounded-circle"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="profile_photo" name="profile_photo"
                                        accept="image/*">
                                    <small class="text-muted">Allowed formats: JPG, PNG, GIF. Max size: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" placeholder="Enter your name">
                        </div>
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" placeholder="Enter your email">
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter new password">
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" id="crudFormSave">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image preview functionality
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePhotoPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
