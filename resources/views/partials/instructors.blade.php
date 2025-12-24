<!DOCTYPE html>
<html lang="en">

<head>
    <title>Our Instructors | Elearnify</title>
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
                    <h2 data-aos="fade-right">Our Instructors</h2>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>Instructors</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- INSTRUCTORS GRID -->
    <section class="py-5">
        <div class="container pb-5">
            <div class="row g-4">

                <!-- Instructor 1 -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="0">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 1">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                CEO & Founder
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">James Anderson</h5>
                        <p class="text-muted small mb-3">Business Strategy Expert</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 2 -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 2">
                            <span
                                class="badge bg-info text-dark position-absolute bottom-0 start-50 translate-middle-x">
                                Senior Dev
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Sarah Jenkins</h5>
                        <p class="text-muted small mb-3">Full Stack Developer</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 3 -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 3">
                            <span
                                class="badge bg-warning text-dark position-absolute bottom-0 start-50 translate-middle-x">
                                Marketing Pro
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Michael Chen</h5>
                        <p class="text-muted small mb-3">Digital Marketing Lead</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 4 -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="300">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 4">
                            <span class="badge bg-danger position-absolute bottom-0 start-50 translate-middle-x">
                                UI/UX Lead
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Emily Roberts</h5>
                        <p class="text-muted small mb-3">Product Designer</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-dribbble"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 5 (New) -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="0">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 5">
                            <span class="badge bg-success position-absolute bottom-0 start-50 translate-middle-x">
                                Data Science
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">David Kim</h5>
                        <p class="text-muted small mb-3">Lead Data Scientist</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>


                <!-- Instructor 6 (New) -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 6">
                            <span class="badge bg-secondary position-absolute bottom-0 start-50 translate-middle-x">
                                Mobile Dev
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Maria Garcia</h5>
                        <p class="text-muted small mb-3">iOS & Android Developer</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 7 (New) -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 7">
                            <span class="badge bg-dark position-absolute bottom-0 start-50 translate-middle-x">
                                Cyber Security
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Robert Fox</h5>
                        <p class="text-muted small mb-3">Security Analyst</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="fas fa-lock"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Instructor 8 (New) -->
                <div class="col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="300">
                    <div class="mentor-card text-center p-4 border rounded-3 bg-white h-100">
                        <div class="img-wrapper mb-3 mx-auto position-relative">
                            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=400&q=80"
                                class="rounded-circle img-fluid shadow-sm" alt="Instructor 8">
                            <span class="badge bg-primary position-absolute bottom-0 start-50 translate-middle-x">
                                Cloud Arch
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Amanda Wilson</h5>
                        <p class="text-muted small mb-3">AWS Certified Architect</p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="fas fa-cloud"></i></a>
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
