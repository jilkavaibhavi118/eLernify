<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:purchases.view', only: ['index']),
            new Middleware('permission:purchases.refund', only: ['refund']),
        ];
    }



    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $orders = Order::with(['user', 'items.course']);

                // Apply filters
                if ($request->filled('status')) {
                    $orders->where('status', $request->status);
                }

                if ($request->filled('start_date')) {
                    $orders->whereDate('created_at', '>=', $request->start_date);
                }

                if ($request->filled('end_date')) {
                    $orders->whereDate('created_at', '<=', $request->end_date);
                }

                // Filter by instructor if not admin
                if (!Auth::user()->hasRole('Admin')) {
                    $instructorId = Auth::user()->instructor ? Auth::user()->instructor->id : 0;
                    $orders->whereHas('items.course', function($q) use ($instructorId) {
                        $q->where('instructor_id', $instructorId);
                    });
                }

                if ($request->filled('user_id')) {
                    $orders->where('user_id', $request->user_id);
                }

                return DataTables::of($orders)
                    ->addColumn('order_id', function ($row) {
                        return $row->id;
                    })
                    ->addColumn('name', function ($row) {
                        return $row->user->name ?? '-';
                    })
                    ->addColumn('course_title', function ($row) {
                        try {
                            if ($row->items && $row->items->count() > 0) {
                                $titles = $row->items->map(function($item) {
                                    return $item->course ? $item->course->title : null;
                                })->filter()->toArray();
                                return !empty($titles) ? implode(', ', $titles) : '-';
                            }
                            return '-';
                        } catch (\Exception $e) {
                            return '-';
                        }
                    })
                    ->addColumn('amount', function ($row) {
                        return '₹' . number_format($row->total_amount, 2);
                    })
                    ->addColumn('status', function ($row) {
                        $badgeClass = $row->status === 'completed' ? 'success' : ($row->status === 'refunded' ? 'warning' : 'danger');
                        return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                    })
                    ->addColumn('date', function ($row) {
                        return $row->created_at ? $row->created_at->format('d M Y') : '-';
                    })
                    ->addColumn('action', function ($row) {
                        $extra = '';
                        if ($row->status === 'completed') {
                            $extra = '<button type="button" 
                                        class="btn btn-warning btn-sm d-flex align-items-center gap-1 refund-btn" 
                                        data-id="' . $row->id . '" title="Refund">
                                        <svg class="icon icon-sm" width="16" height="16" style="fill: currentColor; vertical-align: middle;">
                                            <use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-reload"></use>
                                        </svg>
                                        <span>Refund</span>
                                    </button>';
                        }

                        return view('layouts.includes.list-actions', [
                            'module' => 'purchases',
                            'routePrefix' => 'backend.orders',
                            'data' => $row,
                            'extra' => $extra
                        ])->render();
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('OrderController index error: ' . $e->getMessage());
                return response()->json(['error' => 'Error loading orders: ' . $e->getMessage()], 500);
            }
        }

        return view('backend.orders.index');
    }



    public function refund(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        DB::transaction(function () use ($order) {
            // 1. Mark Order as Refunded
            $order->update(['status' => 'refunded']);

            // 2. Mark all OrderItems as Refunded and disable Enrollments
            foreach ($order->items as $item) {
                $item->update(['status' => 'refunded']);

                Enrollment::where('user_id', $order->user_id)
                    ->where('course_id', $item->course_id)
                    ->update([
                        'status' => 'refunded',
                        'progress' => 0,
                    ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Entire order and all associated access marked as refunded successfully.'
        ]);
    }

    public function refundCourse($orderItemId)
    {
        return DB::transaction(function () use ($orderItemId) {
            $item = OrderItem::with('order')->findOrFail($orderItemId);

            //mark course refunded
            $item->update(['status' => 'refunded']);

            //Disable enrollment
            if ($item->order && $item->course_id) {
                Enrollment::where('user_id', $item->order->user_id)
                    ->where('course_id', $item->course_id)
                    ->update([
                        'status' => 'refunded',
                        'progress' => 0,
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Course access removed and item marked as refunded.'
            ]);
        });
    }



    public function show($id)
{
    $order = \App\Models\Order::with(['user', 'items.course'])->findOrFail($id);

    return view('backend.orders.show', compact('order'));
}

}
