@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>View Message from {{ $message->name }}</h6>
                        <a href="{{ route('backend.contact_messages.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $message->name }}</p>
                            <p><strong>Email:</strong> {{ $message->email }}</p>
                            <p><strong>Subject:</strong> {{ $message->subject }}</p>
                            <p><strong>Status:</strong> 
                                @if($message->status == 'replied')
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Received At:</strong> {{ $message->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-12 mt-3">
                            <p><strong>Message:</strong></p>
                            <div class="p-3 bg-light rounded shadow-sm">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <form action="{{ route('backend.contact_messages.update', $message->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="reply" class="form-label fw-bold">Reply Message</label>
                            <textarea name="reply" id="reply" rows="5" class="form-control @error('reply') is-invalid @enderror" placeholder="Write your reply here...">{{ old('reply', $message->reply) }}</textarea>
                            @error('reply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save & Mark as Replied</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
