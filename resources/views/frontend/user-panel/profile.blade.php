@extends('layouts.frontend')

@section('title', 'My Profile | eLEARNIFY')

@push('styles')
    <style>
        .dashboard-container {
            background-color: #f5f7f9;
            min-height: 100vh;
            padding-top: 140px;
            padding-bottom: 50px;
        }

        /* Sidebar Styling (Consistent with Dashboard) */
        .dashboard-sidebar {
            background: #fff;
            border-radius: 10px;
            padding: 20px 0;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .dashboard-menu .nav-link {
            padding: 12px 20px;
            color: #555;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .dashboard-menu .nav-link:hover,
        .dashboard-menu .nav-link.active {
            color: var(--primary);
            background-color: #f8f9fa;
            border-left-color: var(--primary);
        }

        .dashboard-menu .nav-link i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        .app-download-card {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        /* Profile Main Content */
        .profile-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 30px;
            position: relative;
        }

        .profile-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .profile-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .profile-title i {
            margin-right: 10px;
        }

        /* Profile Image Section */
        .profile-image-container {
            text-align: center;
            width: 200px;
            margin-bottom: 30px;
        }

        .profile-avatar-xl {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background-color: #00235B;
            /* Dark Blue from screenshot */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            font-weight: bold;
            position: relative;
        }

        .profile-image-wrapper {
            position: relative;
            display: inline-block;
        }

        .camera-icon-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #fff;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            color: #333;
            border: 1px solid #ddd;
        }

        /* Form Styling */
        .section-label {
            color: #004aad;
            /* Blue heading from screenshot */
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            background-color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            /* Fallback blue/primary shadow */
            /* If --primary is defined as a hex, we might need a specific rgba here,
                       but usually standard bootstrap uses a specific variable.
                       Let's try to match the "website related color" which likely links to --primary. */
            outline: none;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }

        .input-group-text {
            background: transparent;
            border-left: none;
        }

        /* Lock icon inside input */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }
    </style>
@endpush

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
                                <button type="submit" class="btn btn-light border text-muted px-4">Save Changes</button>
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
