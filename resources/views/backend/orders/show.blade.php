@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order Details</h5>
                <a href="{{ route('backend.orders.index') }}" class="btn btn-sm btn-secondary">
                    ← Back to Orders
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Order & User Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Order Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Order ID:</th>
                                <td>ORD-{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($order->status === 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Order Date:</th>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">User Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $order->user->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>User ID:</th>
                                <td>#{{ $order->user->id ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Course Details --}}
                <h6 class="text-uppercase text-muted">Purchased Courses</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->course->title ?? 'N/A' }}</td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No course items found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table">
                            <tr>
                                <th class="text-end">Total Amount:</th>
                                <th class="text-end">₹{{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    @can('purchases.refund')
                        @if($order->status === 'completed')
                            <button class="btn btn-outline-danger"
                                onclick="alert('Refund logic can be implemented here')">
                                Refund Order
                            </button>
                        @endif
                    @endcan
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
