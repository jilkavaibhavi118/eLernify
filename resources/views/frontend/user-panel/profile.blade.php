@extends('layouts.frontend')

@section('title', 'My Profile | eLEARNIFY')

@push('styles')
    <style>
        .profile-sidebar {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        .profile-main {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        .avatar-upload {
            position: relative;
            max-width: 150px;
            margin: 0 auto 20px;
        }

        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border: 4px solid var(--primary);
        }

        .section-header {
            border-bottom: 2px solid #f8f9fa;
            margin-bottom: 20px;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h4 {
            margin-bottom: 0;
            color: var(--dark);
        }

        .stub-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px dashed #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-4 mb-4">
                <div class="profile-sidebar text-center">
                    <div class="avatar-upload">
                        <div class="avatar-preview" id="imagePreview"
                            style="background-image: url('{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=06BBCC&color=fff&size=150' }}');">
                        </div>
                    </div>
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <p class="text-primary fw-bold mb-3">{{ $user->occupation ?? 'Student' }}</p>
                    <p class="text-muted small mb-4">{{ $user->bio ?? 'No bio yet. Tell the world about yourself!' }}
                    </p>

                    <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="fa fa-edit me-2"></i>Edit Profile
                    </button>

                    <hr class="my-4">

                    <div class="text-start">
                        <h6 class="text-muted text-uppercase small fw-bold mb-3">Contact Information</h6>
                        <div class="mb-3">
                            <i class="fa fa-envelope text-primary me-2"></i>
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>
                        <div class="mb-3">
                            <i class="fa fa-phone text-primary me-2"></i>
                            <span class="text-muted">{{ $user->phone ?? 'Add phone' }}</span>
                        </div>
                        <div class="mb-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            <span class="text-muted">{{ $user->address ?? 'Add address' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="profile-main">
                    <!-- Professional Experience -->
                    <div class="experience-section mb-5">
                        <div class="section-header">
                            <h4>Professional Experience</h4>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addExperienceModal">
                                <i class="fa fa-plus me-1"></i> Add
                            </button>
                        </div>

                        @forelse($user->experiences as $exp)
                            <div class="stub-card position-relative">
                                <h5 class="mb-1">{{ $exp->position }}</h5>
                                <p class="text-primary fw-bold mb-2">{{ $exp->company }}</p>
                                <p class="text-muted small mb-2">
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} -
                                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}
                                </p>
                                <p class="mb-0 small">{{ $exp->description }}</p>

                                <form action="{{ route('user.experience.delete', $exp->id) }}" method="POST"
                                    class="position-absolute top-0 end-0 p-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No experience added yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Education -->
                    <div class="education-section">
                        <div class="section-header">
                            <h4>Education</h4>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addEducationModal">
                                <i class="fa fa-plus me-1"></i> Add
                            </button>
                        </div>

                        @forelse($user->educations as $edu)
                            <div class="stub-card position-relative">
                                <h5 class="mb-1">{{ $edu->degree }}</h5>
                                <p class="text-primary fw-bold mb-2">{{ $edu->institution }}</p>
                                <p class="text-muted small mb-0">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} -
                                    {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : 'Present' }}
                                </p>

                                <form action="{{ route('user.education.delete', $edu->id) }}" method="POST"
                                    class="position-absolute top-0 end-0 p-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No education added yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (Edit Profile, Add Experience, Add Education) -->
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 text-center mb-3">
                                <label class="form-label d-block">Profile Photo</label>
                                <div class="avatar-upload">
                                    <div class="avatar-preview shadow-sm" id="modalImagePreview"
                                        style="background-image: url('{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=06BBCC&color=fff&size=150' }}');">
                                    </div>
                                    <input type='file' name="profile_photo" class="form-control mt-2" id="imageUpload"
                                        accept=".png, .jpg, .jpeg" />
                                </div>
                            </div>
                            <div class="col-md-6 pt-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" name="occupation" class="form-control"
                                        value="{{ $user->occupation }}" placeholder="e.g. Software Engineer">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Bio (Short summary)</label>
                                <textarea name="bio" class="form-control" rows="3">{{ $user->bio }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Experience Modal -->
    <div class="modal fade" id="addExperienceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.experience.add') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Work Experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="position" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                                <small class="text-muted">Leave blank if currently working</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Experience</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Education Modal -->
    <div class="modal fade" id="addEducationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.education.add') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Education</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Degree / Certificate</label>
                            <input type="text" name="degree" class="form-control" required
                                placeholder="e.g. Master of Computer Science">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Institution / University</label>
                            <input type="text" name="institution" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Education</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image Preview for Profile Update
        document.getElementById('imageUpload')?.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('modalImagePreview').style.backgroundImage = 'url(' + e.target
                        .result + ')';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush
