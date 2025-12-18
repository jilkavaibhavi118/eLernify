@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Payment Details</h5>
                <a href="{{ route('backend.payments.index') }}" class="btn btn-sm btn-secondary">
                    ← Back to Payments
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Payment & User Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Payment Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Payment ID:</th>
                                <td>PAY-{{ $payment->id }}</td>
                            </tr>
                            <tr>
                                <th>Razorpay Order ID:</th>
                                <td>{{ $payment->razorpay_order_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Razorpay Payment ID:</th>
                                <td>{{ $payment->razorpay_payment_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($payment->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($payment->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Currency:</th>
                                <td>{{ $payment->currency ?? 'INR' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Date:</th>
                                <td>{{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : ($payment->created_at ? $payment->created_at->format('d M Y, h:i A') : 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">User Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $payment->user->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>User ID:</th>
                                <td>#{{ $payment->user->id ?? 'N/A' }}</td>
                            </tr>
                        </table>

                        <h6 class="text-uppercase text-muted mt-4">Course Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Course Title:</th>
                                <td>{{ $payment->course->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Course ID:</th>
                                <td>#{{ $payment->course->id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Course Price:</th>
                                <td>₹{{ $payment->course->price ?? number_format($payment->amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Razorpay Signature (if available) --}}
                @if($payment->razorpay_signature)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-uppercase text-muted">Payment Verification</h6>
                        <div class="alert alert-info">
                            <strong>Signature:</strong> {{ $payment->razorpay_signature }}
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

