<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us | Elearnify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-light">
    @include('partials.navbar')

    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 data-aos="fade-right">Contact Us</h2>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>Contact</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="py-5">
        <div class="container pb-5">
            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="0">
                    <div class="bg-white p-4 p-md-5 rounded-3 shadow-sm border h-100">
                        <h3 class="fw-bold mb-2">Get in Touch</h3>
                        <p class="text-muted mb-4">Have questions or feedback? We'd love to hear from you.</p>

                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-medium text-dark small">Your Name</label>
                                    <input type="text" class="form-control bg-light border-0 py-3 px-3"
                                        id="name" placeholder="John Doe">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium text-dark small">Email
                                        Address</label>
                                    <input type="email" class="form-control bg-light border-0 py-3 px-3"
                                        id="email" placeholder="name@example.com">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label fw-medium text-dark small">Subject</label>
                                    <input type="text" class="form-control bg-light border-0 py-3 px-3"
                                        id="subject" placeholder="How can we help?">
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-medium text-dark small">Message</label>
                                    <textarea class="form-control bg-light border-0 py-3 px-3" id="message" rows="5"
                                        placeholder="Write your message here..."></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill">Send
                                        Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="h-100 d-flex flex-column gap-4">
                        <!-- Info Card -->
                        <div class="bg-white p-4 rounded-3 shadow-sm border">
                            <h4 class="fw-bold mb-4">Contact Information</h4>

                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <span
                                        class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-map-marker-alt fs-5"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Our Location</h6>
                                    <p class="text-muted small mb-0">123 Education Street, Tech City<br>Innovation
                                        District, CA 94043</p>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <span
                                        class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-envelope fs-5"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Email Address</h6>
                                    <p class="text-muted small mb-0">hello@elearnify.com<br>support@elearnify.com</p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span
                                        class="d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-phone-alt fs-5"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Phone Number</h6>
                                    <p class="text-muted small mb-0">+1 (555) 123-4567<br>Mon - Fri, 9am - 6pm EST</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/components.js') }}"></script>
</body>

</html>
