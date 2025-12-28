<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        $categories = \App\Models\Category::where('status', 'active')
            ->withCount(['courses' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('courses_count', '>', 0)
            ->get();

        $courses = Course::with(['instructor', 'category'])
            ->where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(9);

        return view('courses', compact('courses', 'search', 'categoryId', 'categories'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json([]);
        }

        $courses = Course::where('status', 'active')
            ->where('title', 'like', '%' . $query . '%')
            ->select('id', 'title', 'image')
            ->take(5)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'link' => route('course.detail', $course->id),
                    'image' => $course->image ? asset('storage/' . $course->image) : 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&w=100&q=80'
                ];
            });

        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'category', 'lectures', 'quizzes'])
            ->withCount(['lectures', 'quizzes'])
            ->findOrFail($id);

        // Check if user is already enrolled
        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $id)
                ->exists();
        }

        // Fetch related courses
        $relatedCourses = Course::with(['instructor', 'category'])
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->take(5)
            ->get();

        if ($relatedCourses->isEmpty()) {
            $relatedCourses = Course::with(['instructor', 'category'])
                ->where('id', '!=', $id)
                ->where('status', 'active')
                ->take(5)
                ->get();
        }

        return view('course-detail', compact('course', 'isEnrolled', 'relatedCourses'));
    }

    public function initiatePayment($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to enroll in this course.');
        }

        $course = Course::findOrFail($id);

        // Check if already enrolled
        $existing = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $id)
            ->first();

        if ($existing) {
            return redirect()->route('user.dashboard')
                ->with('info', 'You are already enrolled in this course!');
        }

        // Create Razorpay order
        $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
        
        $orderData = [
            'receipt' => 'order_' . time(),
            'amount' => $course->price * 100, // Amount in paise
            'currency' => 'INR',
            'notes' => [
                'course_id' => $course->id,
                'user_id' => Auth::id()
            ]
        ];

        $razorpayOrder = $api->order->create($orderData);

        // Store payment record
        Payment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'razorpay_order_id' => $razorpayOrder['id'],
            'amount' => $course->price,
            'currency' => 'INR',
            'status' => 'pending'
        ]);

        return view('frontend.payment-checkout', compact('course', 'razorpayOrder'))->with([
            'item' => $course,
            'type' => 'course'
        ]);
    }

    public function verifyPayment(Request $request)
    {
        // ✅ BYPASS FOR TESTING: Specify 'simulate' parameter to force success
        if ($request->has('simulate')) {
            $courseId = $request->input('course_id');
            // Create payment record for simulation
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'course_id' => $courseId,
                'razorpay_order_id' => 'sim_' . time(),
                'razorpay_payment_id' => 'sim_' . time(),
                'amount' => 0, // Mock amount
                'currency' => 'INR',
                'status' => 'completed',
                'payment_method' => 'simulated',
                'paid_at' => now()
            ]);

            // Create enrollment
            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $courseId,
                'status' => 'active',
                'progress' => 0,
                'enrolled_at' => now()
            ]);

            // Create Order for Simulation
            $course = Course::findOrFail($courseId);
            $order = \App\Models\Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $course->price,
                'status' => 'completed'
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->price
            ]);

            return redirect()->route('user.dashboard')
                ->with('success', 'Payment successful (Simulated)! You are now enrolled.');
        }

        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        try {
            // Verify signature
            $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment verified successfully
            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();
            
            // Update payment status
            $payment->markAsCompleted(
                $request->razorpay_payment_id,
                $request->razorpay_signature,
                $request->payment_method ?? 'razorpay'
            );

            // Create enrollment
            Enrollment::create([
                'user_id' => $payment->user_id,
                'course_id' => $payment->course_id,
                'status' => 'active',
                'progress' => 0,
                'enrolled_at' => now()
            ]);

            // Create Order
            $order = \App\Models\Order::create([
                'user_id' => $payment->user_id,
                'total_amount' => $payment->amount,
                'status' => 'completed'
            ]);

            // Create Order Item
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $payment->course_id,
                'price' => $payment->amount
            ]);

            return redirect()->route('user.dashboard')
                ->with('success', 'Payment successful! You are now enrolled in the course.');

        } catch (\Exception $e) {
            // Payment verification failed
            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($payment) {
                $payment->markAsFailed();
            }

            return redirect()->route('course.detail', $request->course_id ?? 1)
                ->with('error', 'Payment verification failed. Please try again.');
        }
    }
}
