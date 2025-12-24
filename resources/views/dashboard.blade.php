    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $totalUsers }}</div>
                            <div>{{ isset($isInstructor) && $isInstructor ? 'My Students' : 'Total Users' }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <!-- Optional: Mini Chart -->
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-info">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $totalCourses }}</div>
                            <div>{{ isset($isInstructor) && $isInstructor ? 'My Courses' : 'Active Courses' }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    </div>
                </div>
            </div>

            @if (!isset($isInstructor) || !$isInstructor)
                <div class="col-sm-6 col-lg-3">
                    <div class="card mb-4 text-white bg-warning">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $totalInstructors }}</div>
                                <div>Instructors</div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-danger">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $totalOrders }}</div>
                            <div>{{ isset($isInstructor) && $isInstructor ? 'Total Enrollments' : 'Total Orders' }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Enrollments / Orders -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Recent Orders</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover border mb-0">
                                <thead class="table-light fw-semibold">
                                    <tr>
                                        <th>User</th>
                                        <th>Course</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <div>{{ $order->user->name ?? 'Unknown User' }}</div>
                                                <div class="small text-medium-emphasis">{{ $order->user->email ?? '' }}
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($order->items as $item)
                                                    <div>{{ $item->course->title ?? 'Deleted Course' }}</div>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <strong>₹{{ number_format($order->total_amount, 2) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->status == 'completed' || $order->status == 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($order->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('M d, Y h:i A') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">No recent orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
