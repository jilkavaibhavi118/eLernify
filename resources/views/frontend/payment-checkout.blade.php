@extends('layouts.frontend')

@section('title', 'Payment Checkout | eLEARNIFY')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="container-xxl py-5 page-margin-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="bg-white p-4 p-md-5 premium-card border-0 mx-2">
                        <h3 class="text-primary mb-4 text-center">Complete Your Payment</h3>

                        <div class="item-info mb-4 border-bottom pb-3">
                            <h5 class="text-dark">{{ $title ?? $item->title }}</h5>
                            <p class="text-muted mb-1">{{ ucfirst($type ?? 'Item') }} Purchase</p>
                        </div>

                        <div class="payment-details bg-white p-4 rounded mb-4 shadow-sm">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Price:</span>
                                <strong>₹{{ number_format($price ?? $item->price, 2) }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total Amount:</h5>
                                <h5 class="text-primary mb-0">₹{{ number_format($price ?? $item->price, 2) }}</h5>
                            </div>
                        </div>

                        <button id="rzp-button" class="btn btn-primary w-100 py-3 rounded-pill shadow mb-3">
                            <i class="fa fa-lock me-2"></i>Secure Payment: Pay
                            ₹{{ number_format($price ?? $item->price, 2) }}
                        </button>

                        <div class="text-center mt-4">
                            <img src="https://razorpay.com/assets/razorpay-glyph.svg" width="20" class="me-2"
                                alt="Razorpay">
                            <span class="text-muted small">Secure payment powered by Razorpay</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ config('razorpay.key_id') }}",
            "amount": "{{ $razorpayOrder['amount'] }}",
            "currency": "INR",
            "name": "eLEARNIFY",
            "description": "{{ addslashes($title ?? $item->title) }}",
            "image": "{{ asset('frontend/img/favicon.ico') }}",
            "order_id": "{{ $razorpayOrder['id'] }}",
            "handler": function(response) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('purchase.verify') }}';

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

                document.body.appendChild(form);
                form.submit();
            },
            "prefill": {
                "name": "{{ Auth::user()->name }}",
                "email": "{{ Auth::user()->email }}",
            },
            "theme": {
                "color": "#1266c2"
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = '{{ url()->previous() }}';
                }
            }
        };

        var rzp = new Razorpay(options);

        document.getElementById('rzp-button').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        }
    </script>
@endpush
