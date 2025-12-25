<!DOCTYPE html>
<html lang="en">

<head>
    <title>About Us | Elearnify</title>
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

<body>
    @include('partials.navbar')

    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-right">About Us</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-right" data-aos-delay="100">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Elearnify</a></li>
                            <span class="breadcrumb-separator">></span>
                            <li class="breadcrumb-item active" aria-current="page"><span>About Us</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Left Content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="text-primary fw-semibold">About Elearnify</span>
                    <h2 class="fw-bold mt-2 mb-3">
                        A Complete Learning Platform for Developers
                    </h2>
                    <p class="text-muted">
                        Elearnify is a modern e-learning platform where users can purchase courses
                        and get complete access to all included learning content.
                    </p>
                    <p class="text-muted">
                        Elearnify is a modern e-learning platform built to help learners grow practical, industry-ready
                        skills. Our goal is to make high-quality education accessible through well-structured courses
                        designed by experienced instructors. Once a user purchases a course, they get complete access to
                        all learning resources, including video lessons, downloadable materials, quizzes, and other
                        supporting content. For selected courses, learners can also participate in live lectures and
                        interactive sessions. Elearnify focuses on real-world learning, helping users learn, practice,
                        and confidently apply their knowledge in real projects.
                    </p>
                </div>

                <!-- Right Image Collage -->
                <div class="col-lg-6">
                    <div class="about-image-collage">
                        <!-- Decorative Shapes -->
                        <div class="shape-dots dots-left-bottom" data-aos="fade-up"></div>
                        <div class="shape-dots dots-right-top" data-aos="fade-down"></div>
                        <div class="shape-arc" data-aos="zoom-in"></div>
                        <div class="shape-triangle" data-aos="fade-right" data-aos-delay="400"></div>
                        <i class="fas fa-star shape-star" data-aos="zoom-in" data-aos-delay="600"></i>

                        <!-- images -->
                        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80"
                            class="collage-img img-main" alt="Instructor" data-aos="fade-right" data-aos-delay="200">

                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80"
                            class="collage-img img-secondary-top shadow-lg" alt="Students Learning" data-aos="fade-down"
                            data-aos-delay="400">

                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80"
                            class="collage-img img-secondary-bottom shadow-lg" alt="Study Materials" data-aos="fade-up"
                            data-aos-delay="600">

                        <!-- Floating Badges -->
                        <div class="experience-badge-float" data-aos="fade-right" data-aos-delay="800">
                            <div class="icon-circle">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="badge-text">
                                <h4>10+</h4>
                                <p>Years of Academic Excellence</p>
                            </div>
                        </div>

                        <div class="stats-card-float" data-aos="fade-left" data-aos-delay="900">
                            <div class="stat-item-mini">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <h5>25k+</h5>
                                    <p>Happy Students</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ACADEMIC SYSTEM SECTION -->
    <section class="academic-section">
        <!-- Background Decorations -->
        <div class="academic-bg-shape shape-wave-top" data-aos="fade-left">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#0A2283"
                    d="M44.7,-76.4C58.1,-69.2,69.2,-58.1,76.4,-44.7C83.7,-31.3,87.1,-15.7,87.1,0C87.1,15.7,83.7,31.3,76.4,44.7C69.2,58.1,58.1,69.2,44.7,76.4C31.3,83.7,15.7,87.1,0,87.1C-15.7,87.1,-31.3,83.7,-44.7,76.4C-58.1,69.2,-69.2,58.1,-76.4,44.7C-83.7,31.3,-87.1,15.7,-87.1,0C-87.1,-15.7,-83.7,-31.3,-76.4,-44.7C-69.2,-58.1,-58.1,-69.2,-44.7,-76.4C-31.3,-83.7,-15.7,-87.1,0,-87.1C15.7,-87.1,31.3,-83.7,44.7,-76.4Z"
                    transform="translate(100 100)" opacity="0.05" />
            </svg>
        </div>
        <div class="academic-bg-shape shape-wave-bottom" data-aos="fade-right">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#22D3EE"
                    d="M38.1,-65.4C50.1,-58.5,61.1,-49.4,68.6,-37.7C76.1,-26,80.1,-13,79.1,-0.6C78,11.8,71.9,23.6,63.6,33.9C55.3,44.2,44.8,53.1,32.9,59.8C20.9,66.4,7.5,70.9,-5.8,70.9C-19.1,70.9,-32.2,66.4,-43.8,58.1C-55.5,49.8,-65.7,37.7,-71.4,24C-77.1,10.3,-78.3,-4.9,-75.1,-19.1C-71.9,-33.3,-64.3,-46.5,-53.1,-53.9C-41.9,-61.2,-27.1,-62.7,-14.2,-64.8C-1.3,-66.9,12.5,-69.6,26.1,-72.3C39.7,-75,53.1,-77.7,38.1,-65.4Z"
                    transform="translate(100 100)" opacity="0.1" />
            </svg>
        </div>

        <div class="container text-center">
            <div class="section-title-wrapper" data-aos="fade-up">
                <h2 class="fw-extrabold mt-2 display-6 title-underline">Modern & Industry Focused Curriculum</h2>
            </div>

            <div class="academic-cards-row">
                <!-- Card 1: Live Zoom -->
                <div class="academic-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper icon-zoom">
                        <i class="fas fa-video"></i>
                    </div>
                    <h5>Live Zoom sessions</h5>
                </div>

                <!-- Card 2: Skilled Educators -->
                <div class="academic-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper icon-expert">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5>Highly skilled online educators</h5>
                </div>

                <!-- Card 3: Teaching Methods -->
                <div class="academic-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper icon-methods">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h5>Modern Teaching Methods & Materials</h5>
                </div>

                <!-- Card 4: 10-Min Support -->
                <div class="academic-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-wrapper icon-support">
                        <i class="fas fa-history"></i>
                    </div>
                    <h5>10-minute academic support after class</h5>
                </div>

                <!-- Card 5: Weekly Help -->
                <div class="academic-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon-wrapper icon-help">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>Weekly extra help & guidance</h5>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3">Why Elearnify?</h2>
                    <p class="text-muted">
                        Elearnify provides everything a learner needs in one platform
                        to grow skills and build a strong foundation.
                    </p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2">✔ Lifetime course access</li>
                        <li class="mb-2">✔ High-quality video lessons</li>
                        <li class="mb-2">✔ Downloadable materials</li>
                        <li class="mb-2">✔ Quizzes & assessments</li>
                        <li class="mb-2">✔ Live sessions support</li>
                    </ul>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="feature-showcase-wrapper" data-aos="fade-left">
                        <!-- Main Illustration Image -->
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop"
                            class="main-feature-img shadow-lg" alt="Elearnify Learning Experience">

                        <!-- Floating Badge 1: Support -->
                        <div class="feature-badge-float badge-support">
                            <div class="badge-icon icon-blue">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="badge-info">
                                <h6>Access Materials</h6>
                                <p>vedios, pdf, quizes</p>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Certificate -->
                        <div class="feature-badge-float badge-certificate">
                            <div class="badge-icon icon-orange">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="badge-info">
                                <h6>Official Certificates</h6>
                                <p>Verified & Valid</p>
                            </div>
                        </div>

                        <!-- Floating Badge 3: Feedback -->
                        <div class="feature-badge-float badge-feedback">
                            <div class="badge-icon icon-green">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="badge-info">
                                <h6>98% Positive</h6>
                                <p>Student Feedback</p>
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
