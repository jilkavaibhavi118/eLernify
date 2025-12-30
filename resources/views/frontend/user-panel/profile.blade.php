@extends('layouts.frontend')

@section('title', 'My Profile | eLEARNIFY')

@section('content')
    <div class="dashboard-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.user-panel.components.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="profile-card">

                            <!-- Header -->
                            <div class="profile-header-row">
                                <div class="profile-title">
                                    <i class="bi bi-person"></i> Profile
                                </div>
                            </div>

                            <div class="row">
                                <!-- Left Column: Image -->
                                <div class="col-md-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="profile-image-wrapper">
                                            @if ($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                                    class="profile-avatar-xl" id="previewImage">
                                            @else
                                                <div class="profile-avatar-xl" id="previewInitials">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <img src="" class="profile-avatar-xl d-none" id="previewImage"
                                                    style="background:none;">
                                            @endif

                                            <label for="profile_photo" class="camera-icon-btn">
                                                <i class="bi bi-camera-fill"></i>
                                            </label>
                                            <input type="file" name="profile_photo" id="profile_photo" class="d-none"
                                                accept="image/*">
                                        </div>
                                        <div class="mt-3 text-muted fw-medium">Change Profile Picture</div>
                                    </div>
                                </div>

                                <!-- Right Column: Form Fields -->
                                <div class="col-md-9 ps-md-4">

                                    <!-- Personal Information -->
                                    <h5 class="section-label">Personal Information</h5>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $user->name }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">User Name</label>
                                        <div class="col-md-9 input-icon-wrapper">
                                            <input type="text" class="form-control"
                                                value="{{ Str::slug($user->name) . '-' . $user->id }}" readonly>
                                            <i class="bi bi-lock-fill input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Certificate Name</label>
                                        <div class="col-md-9 input-icon-wrapper">
                                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                            <i class="bi bi-lock-fill input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Email</label>
                                        <div class="col-md-9 input-icon-wrapper">
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $user->email }}" readonly>
                                            <i class="bi bi-lock-fill input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label">Mobile Number</label>
                                        <div class="col-md-9 input-icon-wrapper">
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $user->phone }}">
                                            <i class="bi bi-pencil-square input-icon text-dark"></i>
                                        </div>
                                    </div>

                                    <!-- Education/Qualifications -->
                                    <h5 class="section-label mt-4">Education/ Qualifications</h5>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Occupation</label>
                                        <div class="col-md-9">
                                            <input type="text" name="occupation" class="form-control"
                                                value="{{ $user->occupation ?? 'Student' }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Education</label>
                                        <div class="col-md-9">
                                            <select class="form-select text-muted">
                                                <option selected>SELECT</option>
                                                <option>High School</option>
                                                <option>Bachelor's</option>
                                                <option>Master's</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <label class="col-md-3 form-label">College</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control"
                                                placeholder="Type few characters to find your college">
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <h5 class="section-label mt-4">Location</h5>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">Country</label>
                                        <div class="col-md-9">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <select class="form-select">
                                                        <option selected>India</option>
                                                        <option>USA</option>
                                                        <option>UK</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 text-end pt-2"><label
                                                        class="form-label">State</label></div>
                                                <div class="col-md-5">
                                                    <select class="form-select">
                                                        <option selected>Gujarat</option>
                                                        <option>Maharashtra</option>
                                                        <option>Delhi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-3 form-label">City</label>
                                        <div class="col-md-9">
                                            <div class="col-md-6"> <!-- Matching screenshot width roughly -->
                                                <select class="form-select">
                                                    <option selected>Rajkot</option>
                                                    <option>Ahmedabad</option>
                                                    <option>Surat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Form Footer: Centered Save Button -->
                            <div class="row mt-5">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('previewImage');
                    var initials = document.getElementById('previewInitials');

                    if (initials) initials.classList.add('d-none');
                    img.classList.remove('d-none');
                    img.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush
