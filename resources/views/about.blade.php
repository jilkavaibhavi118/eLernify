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
                        <i class="fas fa-sun shape-star" data-aos="zoom-in" data-aos-delay="600"></i>

                        <!-- Images -->
                        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80"
                            class="collage-img img-main" alt="Instructor" data-aos="fade-up">

                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80"
                            class="collage-img img-secondary-top" alt="Students Learning" data-aos="fade-down"
                            data-aos-delay="300">

                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80"
                            class="collage-img img-secondary-bottom" alt="Study Materials" data-aos="fade-up"
                            data-aos-delay="500">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <span class="text-primary fw-semibold">Our Academic System</span>
            <h2 class="fw-bold mt-2">Structured & Practical Learning</h2>
            <p class="text-muted mt-3 mb-5">
                Our academic system is designed to keep learning simple, effective
                and industry focused.
            </p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <h5 class="fw-semibold">Step-by-Step Learning</h5>
                        <p class="text-muted mb-0">
                            Courses are structured from basics to advanced topics.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <h5 class="fw-semibold">Practical Approach</h5>
                        <p class="text-muted mb-0">
                            Learn with real-world examples and projects.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <h5 class="fw-semibold">Progress Tracking</h5>
                        <p class="text-muted mb-0">
                            Track performance using quizzes and milestones.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <span class="text-primary fw-semibold">Instructors</span>
            <h2 class="fw-bold mt-2">Learn from Industry Experts</h2>
            <p class="text-muted mt-3 mb-5">
                Our instructors focus on teaching skills that are actually
                required in real projects.
            </p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h5 class="fw-semibold">Experienced Mentors</h5>
                        <p class="text-muted mb-0">
                            Professionals with strong industry experience.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h5 class="fw-semibold">Clear Teaching Style</h5>
                        <p class="text-muted mb-0">
                            Simple explanations with practical examples.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h5 class="fw-semibold">Continuous Guidance</h5>
                        <p class="text-muted mb-0">
                            Support throughout the learning journey.
                        </p>
                    </div>
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
                    <div class="p-5 bg-white shadow-sm rounded" data-aos="fade-left">
                        <!-- Illustration / image placeholder -->
                        <h5 class="fw-semibold mb-0">Elearnify Learning Experience</h5>
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
