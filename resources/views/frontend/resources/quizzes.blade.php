@extends('layouts.frontend')

@section('title', 'eLEARNIFY | Quiz Zone')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Quiz Zone</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Quizzes</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Quizzes Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Practice</h6>
                <h1 class="mb-5">All Mock Tests & Quizzes</h1>
            </div>

            @if (request('search'))
                <div class="mb-4 text-center">
                    <h4>Search results for: "{{ request('search') }}"</h4>
                    <a href="{{ route('quizzes.index') }}" class="btn btn-sm btn-outline-secondary">Clear Search</a>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @forelse($quizzes as $quiz)
                    @php
                        $hasAccess =
                            $quiz->is_free ||
                            (auth()->check() &&
                                (auth()->user()->hasRole('admin') ||
                                    auth()->user()->hasPurchased('quiz', $quiz->id) ||
                                    ($quiz->lecture &&
                                        (auth()->user()->hasPurchased('lecture', $quiz->lecture_id) ||
                                            auth()->user()->enrolledCourses->contains($quiz->lecture->course_id)))));
                    @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-white h-100 d-flex flex-column border shadow-sm rounded-3 transition-all hover-shadow-lg"
                            style="transition: all 0.3s ease;">
                            <div class="p-4 text-center flex-grow-1">
                                <div class="mb-3">
                                    <i class="fa fa-question-circle fa-4x text-primary opacity-25"></i>
                                </div>
                                <h5 class="mb-2">{{ $quiz->title }}</h5>
                                <div class="d-flex justify-content-center mb-3">
                                    <small class="border-end px-2"><i
                                            class="fa fa-clock text-primary me-2"></i>{{ $quiz->duration }} Mins</small>
                                    <small class="px-2"><i class="fa fa-list text-primary me-2"></i>Questions</small>
                                </div>
                                <p class="text-muted small mb-4">
                                    {{ $quiz->short_description ?? 'Test your knowledge with this interactive quiz.' }}</p>
                                <div class="mb-4">
                                    <h4 class="text-primary">
                                        {{ $quiz->is_free ? 'FREE' : '₹' . number_format($quiz->price, 2) }}
                                    </h4>
                                </div>
                            </div>
                            <div class="p-4 pt-0 text-center">
                                @if ($hasAccess)
                                    <a href="{{ route('quiz.view', $quiz->id) }}"
                                        class="btn btn-primary w-100 py-2 rounded-pill">Attempt Now</a>
                                @else
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-dark w-100 py-2 rounded-pill">Buy Now</a>
                                    @else
                                        <form action="{{ route('purchase.initiate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="quiz">
                                            <input type="hidden" name="id" value="{{ $quiz->id }}">
                                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill">
                                                <i class="fa fa-shopping-cart me-2"></i>Buy Now
                                            </button>
                                        </form>
                                    @endguest
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No quizzes found.</h4>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Start -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $quizzes->links() }}
                </div>
            </div>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- Quizzes End -->
@endsection
