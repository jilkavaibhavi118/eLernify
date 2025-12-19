@extends('layouts.frontend')

@section('title', 'eLEARNIFY | The Best Online Learning Platform')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('frontend/img/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Learn from industry experts anytime, anywhere with our
                                    comprehensive online courses.</p>
                                <a href="#about" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                    More</a>
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                        class="btn btn-light py-md-3 px-md-5 animated slideInRight">Go to Dashboard</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('frontend/img/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Join thousands of students and transform your career
                                    with eLEARNIFY's expert-led curriculum.</p>
                                <a href="#about" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                    More</a>
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                        class="btn btn-light py-md-3 px-md-5 animated slideInRight">Go to Dashboard</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Skilled Instructors</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Online Classes</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Home Projects</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Book Library</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- About Start -->
    <div class="container-xxl py-5" id="about">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('frontend/img/about.jpg') }}"
                            alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to eLEARNIFY</h1>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                        eos. Clita erat ipsum et lorem et sit.</p>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                        eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate
                            </p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Category Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                <h1 class="mb-5">Courses Categories</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        @if (isset($categories[0]))
                            <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[0]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[0]->image ? asset('storage/' . $categories[0]->image) : asset('frontend/img/cat-1.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[0]->name }}</h5>
                                        <small class="text-primary">{{ $categories[0]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (isset($categories[1]))
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[1]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[1]->image ? asset('storage/' . $categories[1]->image) : asset('frontend/img/cat-2.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[1]->name }}</h5>
                                        <small class="text-primary">{{ $categories[1]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (isset($categories[2]))
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('courses', ['category' => $categories[2]->id]) }}">
                                    <img class="img-fluid"
                                        src="{{ $categories[2]->image ? asset('storage/' . $categories[2]->image) : asset('frontend/img/cat-3.jpg') }}"
                                        alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[2]->name }}</h5>
                                        <small class="text-primary">{{ $categories[2]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if (isset($categories[3]))
                    <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                        <a class="position-relative d-block h-100 overflow-hidden"
                            href="{{ route('courses', ['category' => $categories[3]->id]) }}">
                            <img class="img-fluid position-absolute w-100 h-100"
                                src="{{ $categories[3]->image ? asset('storage/' . $categories[3]->image) : asset('frontend/img/cat-4.jpg') }}"
                                alt="" style="object-fit: cover;">
                            <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                style="margin: 1px;">
                                <h5 class="m-0">{{ $categories[3]->name }}</h5>
                                <small class="text-primary">{{ $categories[3]->courses_count }} Courses</small>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Category End -->

    <!-- Courses Start -->
    <div class="container-xxl py-5" id="courses">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Popular Courses</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($popularCourses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100"
                                    src="{{ $course->image ? asset('storage/' . $course->image) : asset('frontend/img/course-1.jpg') }}"
                                    alt="{{ $course->title }}" style="object-fit: cover;">
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    <a href="{{ route('course.detail', $course->id) }}"
                                        class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                                        style="border-radius: 30px 0 0 30px;">Read More</a>
                                    <form action="{{ route('purchase.initiate') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="type" value="course">
                                        <input type="hidden" name="id" value="{{ $course->id }}">
                                        <button type="submit" class="flex-shrink-0 btn btn-sm btn-primary px-3"
                                            style="border-radius: 0 30px 30px 0;">Join Now</button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center p-4 pb-0">
                                <h3 class="mb-0">₹{{ number_format($course->price, 2) }}</h3>
                                <div class="mb-3">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small>(123)</small>
                                </div>
                                <h5 class="mb-4">{{ $course->title }}</h5>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor->name ?? 'Instructor' }}</small>
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-clock text-primary me-2"></i>1.49 Hrs</small>
                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30
                                    Students</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Courses End -->

    <!-- Featured Lectures Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Lectures</h6>
                <h1 class="mb-5">Featured Lectures</h1>
            </div>
            <div class="row g-4">
                @foreach ($featuredLectures as $lecture)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light h-100 d-flex flex-column">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img class="img-fluid w-100 h-100" src="{{ asset('frontend/img/course-1.jpg') }}"
                                    alt="" style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge {{ $lecture->is_free ? 'bg-success' : 'bg-primary' }}">
                                        {{ $lecture->is_free ? 'FREE' : '₹' . number_format($lecture->price, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-center p-4 flex-grow-1">
                                <h5 class="mb-3 text-truncate">{{ $lecture->title }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ $lecture->short_description ?? Str::limit($lecture->description, 80) }}</p>
                                <div class="d-flex justify-content-center">
                                    @php
                                        $hasAccess =
                                            $lecture->is_free ||
                                            (auth()->check() &&
                                                (auth()->user()->hasRole('admin') ||
                                                    auth()->user()->hasPurchased('lecture', $lecture->id) ||
                                                    auth()->user()->enrolledCourses->contains($lecture->course_id)));
                                    @endphp
                                    @if ($hasAccess)
                                        <a href="{{ route('lecture.view', $lecture->id) }}"
                                            class="btn btn-sm btn-outline-primary px-4" style="border-radius: 30px;">View
                                            Lecture</a>
                                    @else
                                        @guest
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-4"
                                                style="border-radius: 30px;">Buy Now</a>
                                        @else
                                            <form action="{{ route('purchase.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="lecture">
                                                <input type="hidden" name="id" value="{{ $lecture->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary px-4"
                                                    style="border-radius: 30px;">Buy Now</button>
                                            </form>
                                        @endguest
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Featured Lectures End -->

    <!-- Learning Materials Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Resources</h6>
                <h1 class="mb-5">Learning Materials</h1>
            </div>
            <div class="row g-4">
                @foreach ($learningMaterials as $material)
                    @php
                        $hasAccess =
                            $material->is_free ||
                            (auth()->check() &&
                                (auth()->user()->hasRole('admin') ||
                                    auth()->user()->hasPurchased('material', $material->id) ||
                                    ($material->lecture &&
                                        (auth()->user()->hasPurchased('lecture', $material->lecture_id) ||
                                            auth()
                                                ->user()
                                                ->enrolledCourses->contains($material->lecture->course_id)))));

                        $type = 'Link';
                        $icon = 'fa-link';
                        if (!empty($material->video_path)) {
                            $type = 'Video';
                            $icon = 'fa-video';
                        } elseif (!empty($material->file_path)) {
                            $type = 'PDF / Document';
                            $icon = 'fa-file-pdf';
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item bg-white text-center h-100 p-4 pt-5 shadow-sm">
                            <div class="btn-square bg-primary rounded-circle mb-4"
                                style="width: 64px; height: 64px; margin: 0 auto;">
                                <i class="fa {{ $icon }} text-white"></i>
                            </div>
                            <small class="text-primary fw-bold text-uppercase">{{ $type }}</small>
                            <h5 class="mb-3 mt-2">{{ $material->title }}</h5>
                            <p class="text-muted small mb-3">
                                {{ $material->short_description ?? 'High-quality resource for your learning journey.' }}
                            </p>
                            <div class="mb-3">
                                <span class="fw-bold text-primary">
                                    {{ $material->is_free ? 'FREE' : '₹' . number_format($material->price, 2) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-center">
                                @if ($hasAccess)
                                    <a href="{{ route('material.view', $material->id) }}"
                                        class="btn btn-sm btn-outline-primary px-4" style="border-radius: 30px;">Download
                                        / View</a>
                                @else
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-4"
                                            style="border-radius: 30px;">Buy Now</a>
                                    @else
                                        <form action="{{ route('purchase.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="material">
                                            <input type="hidden" name="id" value="{{ $material->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary px-4"
                                                style="border-radius: 30px;">Buy Now</button>
                                        </form>
                                    @endguest
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Learning Materials End -->

    <!-- Practice Quizzes Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Practice</h6>
                <h1 class="mb-5">Quiz Zone</h1>
            </div>
            <div class="row g-4">
                @foreach ($practiceQuizzes as $quiz)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light h-100 d-flex flex-column border">
                            <div class="p-4 text-center flex-grow-1">
                                <div class="mb-3">
                                    <i class="fa fa-question-circle fa-3x text-primary"></i>
                                </div>
                                <h5 class="mb-2">{{ $quiz->title }}</h5>
                                <div class="d-flex justify-content-center mb-3">
                                    <small class="border-end px-2"><i
                                            class="fa fa-clock text-primary me-2"></i>{{ $quiz->duration }} Mins</small>
                                    <small class="px-2"><i
                                            class="fa fa-list text-primary me-2"></i>{{ $quiz->questions_count ?? 0 }}
                                        Questions</small>
                                </div>
                                <p class="text-muted small mb-4">
                                    {{ $quiz->short_description ?? 'Test your knowledge with this interactive quiz.' }}</p>
                                <div class="mb-4">
                                    <h4 class="text-primary">
                                        {{ $quiz->is_free ? 'FREE' : '₹' . number_format($quiz->price, 2) }}</h4>
                                </div>
                            </div>
                            <div class="p-4 pt-0 border-top bg-white text-center">
                                @php
                                    $hasAccess =
                                        $quiz->is_free ||
                                        (auth()->check() &&
                                            (auth()->user()->hasRole('admin') ||
                                                auth()->user()->hasPurchased('quiz', $quiz->id) ||
                                                ($quiz->lecture &&
                                                    (auth()->user()->hasPurchased('lecture', $quiz->lecture_id) ||
                                                        auth()
                                                            ->user()
                                                            ->enrolledCourses->contains($quiz->lecture->course_id)))));
                                @endphp
                                @if ($hasAccess)
                                    <a href="{{ route('quiz.view', $quiz->id) }}" class="btn btn-primary w-100 py-2"
                                        style="border-radius: 0 0 15px 15px;">Attempt Now</a>
                                @else
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-dark w-100 py-2"
                                            style="border-radius: 0 0 15px 15px;">Buy Now</a>
                                    @else
                                        <form action="{{ route('purchase.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="quiz">
                                            <input type="hidden" name="id" value="{{ $quiz->id }}">
                                            <button type="submit" class="btn btn-dark w-100 py-2"
                                                style="border-radius: 0 0 15px 15px;"><i
                                                    class="fa fa-shopping-cart me-2"></i>Buy Now</button>
                                        </form>
                                    @endguest
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Practice Quizzes End -->

    <!-- Instructors Start -->
    <div class="container-xxl py-5" id="instructors">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
                <h1 class="mb-5">Expert Instructors</h1>
            </div>
            <div class="row g-4 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{ asset('frontend/img/team-1.jpg') }}" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{ asset('frontend/img/team-2.jpg') }}" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{ asset('frontend/img/team-3.jpg') }}" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{ asset('frontend/img/team-4.jpg') }}" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Instructors End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-1.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-2.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-3.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3"
                        src="{{ asset('frontend/img/testimonial-4.jpg') }}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection
