<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="{{ asset('assets/img/elearnify (2).png') }}" alt="eLEARNIFY Logo"
            style="height: 120px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto p-4 p-lg-0">
            <div class="nav-item m-auto">
                <form action="{{ route('courses') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search Courses..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="navbar-nav ms-auto p-4 p-lg-0 align-items-center">
            <a href="{{ url('/#about') }}" class="nav-item nav-link">About</a>
            <a href="{{ route('courses') }}" class="nav-item nav-link">Courses</a>
            <a href="{{ route('lectures.index') }}" class="nav-item nav-link">Lectures</a>
            <a href="{{ route('materials.index') }}" class="nav-item nav-link">Materials</a>
            <a href="{{ route('quizzes.index') }}" class="nav-item nav-link">Quizzes</a>
            <a href="{{ url('/#instructors') }}" class="nav-item nav-link">Instructors</a>

            @guest
                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
            @else
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-bell text-secondary" style="font-size: 1.2rem;"></i>
                    </a>
                </div>

                <!-- User Dropdown -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle no-caret d-flex align-items-center"
                        data-bs-toggle="dropdown" title="User dropdown menu for {{ Auth::user()->name }}">
                        @if (Auth::user()->profile_photo)
                            <img class="rounded-circle user-avatar"
                                src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                style="width: 35px; height: 35px; object-fit: cover;" alt="">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center user-avatar"
                                style="width: 35px; height: 35px; font-weight: bold;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end fade-down m-0 shadow border-0">
                        <a href="{{ route('user.dashboard') }}"
                            class="dropdown-item {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ route('user.profile') }}"
                            class="dropdown-item {{ Request::routeIs('user.profile') ? 'active' : '' }}">Profile</a>
                        <a href="{{ route('user.purchases') }}"
                            class="dropdown-item {{ Request::routeIs('user.purchases') ? 'active' : '' }}">My Purchases</a>
                        <hr class="dropdown-divider">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>
<!-- Navbar End -->
