<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PurchaseController extends Controller
{
    public function initiate(Request $request)
    {
        $type = $request->input('type'); // course, lecture, material, quiz
        $id = $request->input('id');

        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to purchase this item.');
        }

        $item = null;
        $price = 0;
        $title = '';
        $paymentData = [
            'user_id' => Auth::id(),
            'currency' => 'INR',
            'status' => 'pending'
        ];

        switch ($type) {
            case 'course':
                $item = Course::findOrFail($id);
                $price = $item->price;
                $title = $item->title;
                $paymentData['course_id'] = $id;
                break;
            case 'lecture':
                $item = Lecture::findOrFail($id);
                $price = $item->price;
                $title = $item->title;
                $paymentData['lecture_id'] = $id;
                break;
            case 'material':
                $item = Material::findOrFail($id);
                $price = $item->price;
                $title = $item->title;
                $paymentData['material_id'] = $id;
                break;
            case 'quiz':
                $item = Quiz::findOrFail($id);
                $price = $item->price;
                $title = $item->title;
                $paymentData['quiz_id'] = $id;
                break;
            default:
                return redirect()->back()->with('error', 'Invalid item type.');
        }

        if ($price <= 0) {
             return redirect()->back()->with('info', 'This item is free.');
        }

        // Create Razorpay order
        $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
        
        $orderData = [
            'receipt' => 'order_' . time(),
            'amount' => $price * 100, // Amount in paise
            'currency' => 'INR',
            'notes' => [
                'type' => $type,
                'item_id' => $id,
                'user_id' => Auth::id()
            ]
        ];

        $razorpayOrder = $api->order->create($orderData);

        // Store payment record
        $paymentData['razorpay_order_id'] = $razorpayOrder['id'];
        $paymentData['amount'] = $price;
        Payment::create($paymentData);

        return view('frontend.payment-checkout', [
            'item' => $item,
            'type' => $type,
            'razorpayOrder' => $razorpayOrder,
            'title' => $title,
            'price' => $price
        ]);
    }

    public function verify(Request $request)
    {
        // Simulation for testing
        if ($request->has('simulate')) {
            return $this->handleSuccessfulPayment($request->input('payment_id'), 'simulated', 'simulated');
        }

        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        try {
            $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            return $this->handleSuccessfulPayment($request->razorpay_order_id, $request->razorpay_payment_id, $request->razorpay_signature);

        } catch (\Exception $e) {
            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($payment) $payment->markAsFailed();

            return redirect()->route('landing')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    protected function handleSuccessfulPayment($orderId, $paymentId, $signature)
    {
        $payment = Payment::where('razorpay_order_id', $orderId)->firstOrFail();
        $payment->markAsCompleted($paymentId, $signature, 'razorpay');

        // Create Order record
        $order = Order::create([
            'user_id' => $payment->user_id,
            'total_amount' => $payment->amount,
            'status' => 'completed'
        ]);

        // Create Order Item
        OrderItem::create([
            'order_id' => $order->id,
            'course_id' => $payment->course_id,
            'material_id' => $payment->material_id,
            'lecture_id' => $payment->lecture_id,
            'quiz_id' => $payment->quiz_id,
            'price' => $payment->amount
        ]);

        // If it's a course, also create enrollment
        if ($payment->course_id) {
            \App\Models\Enrollment::updateOrCreate(
                ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                ['status' => 'active', 'enrolled_at' => now()]
            );
        }

        return redirect()->route('user.purchases')->with('success', 'Purchase successful! You can now access your content.');
    }
}
