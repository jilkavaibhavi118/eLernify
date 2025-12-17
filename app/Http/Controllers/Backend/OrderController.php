<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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
            $query = \App\Models\Order::with(['user', 'items.course'])->latest();

            // Filter by Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by Date Range
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }

            // Filter by User ID
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('course_title', function ($row) {
                    // Assuming single course per order for now, based on current flow
                    $item = $row->items->first();
                    return $item && $item->course ? $item->course->title : 'N/A';
                })
                ->addColumn('formatted_amount', function ($row) {
                    return '₹' . number_format($row->total_amount, 2);
                })
                ->addColumn('payment_status', function ($row) {
                    if ($row->status == 'completed') {
                        return '<span class="badge bg-success">Completed</span>';
                    } elseif ($row->status == 'refunded') {
                        return '<span class="badge bg-secondary">Refunded</span>';
                    } else {
                        return '<span class="badge bg-danger">Pending</span>';
                    }
                })
                ->addColumn('created_date', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($row) {
                     $btn = '';
                     if ($row->status == 'completed' && auth()->user()->can('purchases.refund')) {
                         $btn .= '<button type="button" class="btn btn-sm btn-outline-danger refund-btn" data-id="'.$row->id.'">Refund</button>';
                     }
                     return $btn ?: 'N/A';
                })
                ->rawColumns(['payment_status', 'action'])
                ->make(true);
        }

        return view('backend.orders.index');
    }

    public function refund(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->status = 'refunded';
        $order->save();

        return response()->json(['success' => 'Order marked as refunded successfully.']);
    }
}
