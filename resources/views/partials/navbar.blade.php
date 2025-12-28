<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/img/logo.png') }}" alt="Elearnify Logo" class="brand-logo">Elearnify
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('instructors') }}">Instructors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>

                <div class="action-group">
                    <button class="search-trigger" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search"></i>
                    </button>
                    @guest
                        <a href="{{ route('login') }}" class="login-link">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-premium">Join Premium</a>
                    @else
                        <!-- Notifications -->
                        <div class="nav-item dropdown ms-2">
                            <a class="nav-link p-2 position-relative" href="#" id="notificationDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5 text-dark"></i>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge"
                                        style="font-size: 0.6rem;">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0"
                                aria-labelledby="notificationDropdown"
                                style="width: 320px; max-height: 450px; overflow-y: auto;">
                                <li class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Notifications</h6>
                                    @if (Auth::user()->unreadNotifications->count() > 0)
                                        <a href="javascript:void(0)" id="markAllRead"
                                            class="small text-primary text-decoration-none">Mark all as read</a>
                                    @endif
                                </li>
                                <div class="notification-list">
                                    @forelse(Auth::user()->notifications->take(5) as $notification)
                                        <li>
                                            <a class="dropdown-item p-3 border-bottom notification-item {{ $notification->read_at ? 'opacity-75' : 'bg-light' }}"
                                                href="{{ $notification->data['link'] ?? '#' }}"
                                                data-id="{{ $notification->id }}">
                                                <div class="d-flex gap-2">
                                                    <div class="bg-primary-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="bi bi-camera-video text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1 small fw-bold text-dark">
                                                            {{ $notification->data['title'] }}</p>
                                                        <p class="mb-1 small text-muted text-wrap">
                                                            {{ $notification->data['message'] }}</p>
                                                        <small class="text-muted"
                                                            style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="p-4 text-center">
                                            <i class="bi bi-bell-slash fs-2 text-muted d-block mb-2"></i>
                                            <span class="text-muted small">No notifications yet</span>
                                        </li>
                                    @endforelse
                                </div>
                                <li class="text-center p-2 border-top">
                                    <a href="#" class="small text-muted text-decoration-none">View all
                                        notifications</a>
                                </li>
                            </ul>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Mark Single as Read
                                $('.notification-item').on('click', function(e) {
                                    const id = $(this).data('id');
                                    const url = `{{ url('my/notifications') }}/${id}/mark-as-read`;
                                    $.get(url); // Background request
                                });

                                // Mark All as Read
                                $('#markAllRead').on('click', function(e) {
                                    e.preventDefault();
                                    const url = "{{ route('user.notifications.markAllRead') }}";
                                    $.get(url, function(response) {
                                        if (response.success) {
                                            $('.notification-item').removeClass('bg-light').addClass('opacity-75');
                                            $('.notification-badge').fadeOut();
                                            $('#markAllRead').fadeOut();
                                        }
                                    });
                                });
                            });
                        </script>
                        <div class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1 px-3 border rounded-pill"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @if (Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt=""
                                        class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; font-weight: bold;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="fw-medium text-dark">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                                aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item py-2" href="{{ route('user.dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('user.profile') }}"><i
                                            class="bi bi-person me-2"></i>Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i
                                                class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Find a Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('courses') }}" method="GET" id="navSearchForm">
                    <div class="input-group mb-3 position-relative">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" id="navSearchInput" class="form-control border-start-0"
                            placeholder="What do you want to learn today?" autocomplete="off">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                    <div id="search-results" class="list-group position-absolute w-100 shadow-sm d-none" style="z-index: 1050; max-height: 300px; overflow-y: auto;">
                        <!-- Results will appear here -->
                    </div>
                </form>
                <small class="text-muted">Popular: <em>Python, Graphic Design, Marketing</em></small>
            </div>
        </div>
    </div>
</div>

<style>
    #search-results {
        top: 100%;
        left: 0;
        border-radius: 0 0 10px 10px;
        background: white;
        border: 1px solid #dee2e6;
    }
    .search-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        transition: background 0.2s;
        text-decoration: none;
        color: #333;
    }
    .search-item:hover {
        background: #f8f9fa;
        color: var(--bs-primary);
    }
    .search-item img {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        object-fit: cover;
    }
    .search-item .title {
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('navSearchInput');
    const resultsContainer = document.getElementById('search-results');
    const searchForm = document.getElementById('navSearchForm');

    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            resultsContainer.classList.add('d-none');
            resultsContainer.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('courses.search.suggestions') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const resultItem = document.createElement('a');
                            resultItem.href = item.link;
                            resultItem.className = 'list-group-item list-group-item-action border-0 search-item';
                            resultItem.innerHTML = `
                                <img src="${item.image}" alt="${item.title}">
                                <div class="title">${item.title}</div>
                            `;
                            resultsContainer.appendChild(resultItem);
                        });
                        resultsContainer.classList.remove('d-none');
                    } else {
                        resultsContainer.innerHTML = '<div class="list-group-item border-0 text-muted small">No courses found</div>';
                        resultsContainer.classList.remove('d-none');
                    }
                })
                .catch(error => console.error('Error fetching suggestions:', error));
        }, 300);
    });

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.add('d-none');
        }
    });

    // Optional: focus input when modal opens
    const searchModal = document.getElementById('searchModal');
    searchModal.addEventListener('shown.bs.modal', function () {
        searchInput.focus();
    });
});
</script>
