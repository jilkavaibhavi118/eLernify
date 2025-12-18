<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:purchases.view', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $payments = Payment::with(['user', 'course']);

                // Apply filters
                if ($request->filled('status')) {
                    $payments->where('status', $request->status);
                }

                if ($request->filled('start_date')) {
                    $payments->whereDate('created_at', '>=', $request->start_date);
                }

                if ($request->filled('end_date')) {
                    $payments->whereDate('created_at', '<=', $request->end_date);
                }

                if ($request->filled('user_id')) {
                    $payments->where('user_id', $request->user_id);
                }

                return DataTables::of($payments)
                    ->addColumn('payment_id', function ($row) {
                        return $row->id;
                    })
                    ->addColumn('razorpay_payment_id', function ($row) {
                        return $row->razorpay_payment_id ?? '-';
                    })
                    ->addColumn('user_name', function ($row) {
                        return $row->user->name ?? '-';
                    })
                    ->addColumn('course_title', function ($row) {
                        return $row->course->title ?? '-';
                    })
                    ->addColumn('amount', function ($row) {
                        return '₹' . number_format($row->amount, 2);
                    })
                    ->addColumn('status', function ($row) {
                        $badgeClass = $row->status === 'completed' ? 'success' : ($row->status === 'failed' ? 'danger' : 'warning');
                        return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                    })
                    ->addColumn('date', function ($row) {
                        return $row->paid_at ? $row->paid_at->format('d M Y') : ($row->created_at ? $row->created_at->format('d M Y') : '-');
                    })
                    ->addColumn('payment_method', function ($row) {
                        return $row->payment_method ?? '-';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="'.route('backend.payments.show', $row->id).'"
                                class="btn btn-sm btn-info">View</a>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('PaymentController index error: ' . $e->getMessage());
                return response()->json(['error' => 'Error loading payments: ' . $e->getMessage()], 500);
            }
        }

        return view('backend.payments.index');
    }

    public function show($id)
    {
        $payment = Payment::with(['user', 'course'])->findOrFail($id);
        return view('backend.payments.show', compact('payment'));
    }
}

