<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Payment Checkout | eLEARNIFY</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-light rounded p-5">
                        <h3 class="text-primary mb-4 text-center">Complete Your Payment</h3>

                        <div class="course-info mb-4">
                            <h5>{{ $course->title }}</h5>
                            <p class="text-muted">{{ $course->category->name ?? 'Uncategorized' }}</p>
                            @if ($course->instructor)
                                <p class="text-muted"><i class="fa fa-user me-2"></i>{{ $course->instructor->name }}</p>
                            @endif
                        </div>

                        <div class="payment-details bg-white p-4 rounded mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Course Price:</span>
                                <strong>₹{{ number_format($course->price, 2) }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5>Total Amount:</h5>
                                <h5 class="text-primary">₹{{ number_format($course->price, 2) }}</h5>
                            </div>
                        </div>

                        <button id="rzp-button" class="btn btn-primary w-100 py-3">
                            <i class="fa fa-lock me-2"></i>Pay ₹{{ number_format($course->price, 2) }}
                        </button>

                        <div class="mt-3">
                            <form action="{{ route('payment.verify') }}" method="POST">
                                @csrf
                                <input type="hidden" name="simulate" value="1">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="razorpay_order_id" value="{{ $razorpayOrder['id'] }}">
                                <input type="hidden" name="razorpay_payment_id" value="sim_{{ time() }}">
                                <input type="hidden" name="razorpay_signature" value="simulated">
                                <button type="submit" class="btn btn-outline-success w-100 btn-sm">
                                    <i class="fa fa-bug me-2"></i>Test Mode: Simulate Success (Bypass Payment)
                                </button>
                            </form>
                        </div>

                        <p class="text-center text-muted mt-3 small">
                            <i class="fa fa-shield-alt me-1"></i>Secure payment powered by Razorpay
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ config('razorpay.key_id') }}",
            "amount": "{{ $razorpayOrder['amount'] }}",
            "currency": "INR",
            "name": "eLEARNIFY",
            "description": "{{ $course->title }}",
            "image": "{{ asset('frontend/img/favicon.ico') }}",
            "order_id": "{{ $razorpayOrder['id'] }}",
            "handler": function(response) {
                // Payment successful, verify on backend
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('payment.verify') }}';

                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                var orderId = document.createElement('input');
                orderId.type = 'hidden';
                orderId.name = 'razorpay_order_id';
                orderId.value = response.razorpay_order_id;
                form.appendChild(orderId);

                var paymentId = document.createElement('input');
                paymentId.type = 'hidden';
                paymentId.name = 'razorpay_payment_id';
                paymentId.value = response.razorpay_payment_id;
                form.appendChild(paymentId);

                var signature = document.createElement('input');
                signature.type = 'hidden';
                signature.name = 'razorpay_signature';
                signature.value = response.razorpay_signature;
                form.appendChild(signature);

                var courseId = document.createElement('input');
                courseId.type = 'hidden';
                courseId.name = 'course_id';
                courseId.value = '{{ $course->id }}';
                form.appendChild(courseId);

                document.body.appendChild(form);
                form.submit();
            },
            "prefill": {
                "name": "{{ Auth::user()->name }}",
                "email": "{{ Auth::user()->email }}",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#3b9d91"
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = '{{ route('course.detail', $course->id) }}';
                }
            }
        };

        var rzp = new Razorpay(options);

        document.getElementById('rzp-button').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        }
    </script>
</body>

</html>
