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

                            {{-- Status --}}
                            <div class="col-md-6 mt-3">
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
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $instructor->image) }}" alt="Instructor Image"
                                                style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
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
