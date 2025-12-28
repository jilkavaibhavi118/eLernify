@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Instructor</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('backend.instructors.update', $instructor->id) }}" method="POST"
                        enctype="multipart/form-data" id="crudForm">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Linked User --}}
                            <div class="col-md-12">
                                <x-select2_ajax name="user_id" label="Link to User (Instructor Role)" :selected="old('user_id', $instructor->user_id)" :selectedText="$instructor->user->name . ' (' . $instructor->user->email . ')'"
                                    :required="true" placeholder="Search by name or email" :url="route('backend.users.search')" />
                            </div>

                            {{-- Name --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $instructor->name) }}" placeholder="Enter instructor name">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $instructor->email) }}" placeholder="Enter email">
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $instructor->phone) }}" placeholder="Enter phone">
                                </div>
                            </div>

                            {{-- Bio --}}
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>Bio</label>
                                    <textarea name="bio" class="form-control" rows="3" placeholder="Enter short bio">{{ old('bio', $instructor->bio) }}</textarea>
                                </div>
                            </div>

                            {{-- Designation & Specialty --}}
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Designation (e.g. CEO & Founder)</label>
                                    <input type="text" name="designation" class="form-control"
                                        value="{{ old('designation', $instructor->designation) }}"
                                        placeholder="e.g. Senior Instructor">
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Specialty (e.g. Expert in Java)</label>
                                    <input type="text" name="specialty" class="form-control"
                                        value="{{ old('specialty', $instructor->specialty) }}"
                                        placeholder="e.g. Web Development">
                                </div>
                            </div>

                            {{-- Social Links --}}
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>LinkedIn URL</label>
                                    <input type="url" name="linkedin_url" class="form-control"
                                        value="{{ old('linkedin_url', $instructor->linkedin_url) }}"
                                        placeholder="https://linkedin.com/in/...">
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Twitter URL</label>
                                    <input type="url" name="twitter_url" class="form-control"
                                        value="{{ old('twitter_url', $instructor->twitter_url) }}"
                                        placeholder="https://twitter.com/...">
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Github URL</label>
                                    <input type="url" name="github_url" class="form-control"
                                        value="{{ old('github_url', $instructor->github_url) }}"
                                        placeholder="https://github.com/...">
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Instagram URL</label>
                                    <input type="url" name="instagram_url" class="form-control"
                                        value="{{ old('instagram_url', $instructor->instagram_url) }}"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Website URL</label>
                                    <input type="url" name="website_url" class="form-control"
                                        value="{{ old('website_url', $instructor->website_url) }}"
                                        placeholder="https://example.com">
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="active"
                                            {{ old('status', $instructor->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $instructor->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Image --}}
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>Instructor Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">

                                    @if ($instructor->image)
                                        <div class="mt-2 text-center">
                                            <img src="{{ asset('storage/' . $instructor->image) }}"
                                                alt="Instructor Image"
                                                style="width:120px;height:120px;object-fit:cover;border-radius:10px; border: 2px solid var(--primary-color);">
                                            <p class="small text-muted mt-1">Current Image</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{ route('backend.instructors.index') }}" class="btn btn-secondary">
                                    Back
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#crudForm').on('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = $(this).find('button[type="submit"]');

                    // Disable submit button
                    submitBtn.prop('disabled', true);

                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.success,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = response.url;
                            });
                        },
                        error: function(xhr) {
                            submitBtn.prop('disabled', false);

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    const input = $('[name="' + key + '"]');
                                    input.addClass('is-invalid');
                                    input.after('<div class="invalid-feedback">' + value[
                                        0] + '</div>');
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.'
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
