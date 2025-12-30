<!DOCTYPE html><!--
    * CoreUI - Free Bootstrap Admin Template
    * @version v5.3.0
    * @link https://coreui.io/product/free-bootstrap-admin-template/
    * Copyright (c) 2025 creativeLabs Łukasz Holeczek
    * Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
    -->
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Admin Panel</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendors styles -->
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">

    <!-- Main styles for this application -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/examples.css') }}" rel="stylesheet">

    <!-- CoreUI scripts -->
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/color-modes.js') }}"></script>

    <link href="{{ asset('vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        .notification-item-wrapper:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .admin-notification-item:active {
            color: inherit !important;
            background-color: rgba(0, 0, 0, 0.05) !important;
        }

        .admin-notification-badge {
            border: 2px solid #fff;
        }

        /* Custom scrollbar for the notification dropdown */
        .notification-list-admin::-webkit-scrollbar {
            width: 4px;
        }

        .notification-list-admin::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .notification-list-admin::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .notification-list-admin::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
</head>

<body>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
        <div class="sidebar-header border-bottom">
            <div class="sidebar-brand">
                <img class="sidebar-brand-full" src="{{ asset('assets/img/elearnify.png') }}" alt="eLearnify Logo"
                    height="46">

                <span class="sidebar-brand-full h5 mb-0 ms-2">
                    eLearnify
                </span>

                <img class="sidebar-brand-narrow" src="{{ asset('assets/img/elearnify.png') }}" alt="eLearnify Logo"
                    width="40" height="40">
            </div>

            <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
                onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores') ? route('instructor.dashboard') : route('backend.dashboard') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-speedometer"></use>
                    </svg> Dashboard
                </a>
            </li>

            <li class="nav-title">Application Management</li>

            @hasrole('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.users.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user"></use>
                        </svg>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.instructors.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-people"></use>
                        </svg>
                        Instructors
                    </a>
                </li>
            @endhasrole

            @hasanyrole('Admin|Instructor|Instructores')
                <li class="nav-title">Course Management</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.categories.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-list"></use>
                        </svg>
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.courses.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-education"></use>
                        </svg>
                        Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.lectures.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-book"></use>
                        </svg>
                        Lectures
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.materials.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-folder"></use>
                        </svg>
                        Materials
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.quizzes.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-puzzle"></use>
                        </svg>
                        Quizzes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.quizzes.results') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-notes"></use>
                        </svg>
                        Quiz Results
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.comments.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-comment-square"></use>
                        </svg>
                        Comments & Discussion
                    </a>
                </li>
            @endhasanyrole

            @hasrole('Admin')
                <li class="nav-title">System & Finance</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.orders.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-money"></use>
                        </svg>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.payments.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-credit-card"></use>
                        </svg>
                        Payments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.contact_messages.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-comment-square"></use>
                        </svg>
                        Contact Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.roles.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-shield-alt"></use>
                        </svg>
                        Roles & Permissions
                    </a>
                </li>
            @endhasrole
        </ul>
        <div class="sidebar-footer border-top d-none d-md-flex">
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100">
        <header class="header header-sticky p-0 mb-4">
            <div class="container-fluid border-bottom px-4">
                <button class="header-toggler" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                    style="margin-inline-start: -14px;">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-menu"></use>
                    </svg>
                </button>
                <ul class="header-nav d-none d-lg-flex">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores') ? route('instructor.dashboard') : route('backend.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    @hasrole('Admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('backend.users.index') }}">Users</a>
                        </li>
                    @endhasrole
                    <li class="nav-item"><a class="nav-link" href="{{ route('backend.profile.edit') }}">Settings</a>
                    </li>
                </ul>
                <ul class="header-nav ms-auto px-3">
                    <li class="nav-item dropdown notifications-dropdown">
                        <a class="nav-link position-relative d-flex align-items-center" href="#"
                            data-coreui-toggle="dropdown" aria-expanded="false" id="adminNotificationDropdown">
                            <svg class="icon icon-lg">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-bell"></use>
                            </svg>
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger admin-notification-badge"
                                    style="font-size: 0.6rem; padding: 0.25em 0.4em;">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0"
                            aria-labelledby="adminNotificationDropdown"
                            style="width: 320px; max-height: 450px; overflow-y: auto; border-radius: 12px !important;">
                            <div
                                class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                                <h6 class="mb-0 fw-bold">Notifications</h6>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <a href="javascript:void(0)" id="markAllReadAdmin"
                                        class="small text-primary text-decoration-none fw-semibold">Mark all as
                                        read</a>
                                @endif
                            </div>
                            <div class="notification-list-admin">
                                @forelse(Auth::user()->notifications->take(10) as $notification)
                                    <div
                                        class="notification-item-wrapper border-bottom {{ $notification->read_at ? '' : 'bg-light' }}">
                                        <a class="dropdown-item p-3 d-flex align-items-start gap-3 admin-notification-item"
                                            href="{{ $notification->data['link'] ?? '#' }}"
                                            data-id="{{ $notification->id }}"
                                            style="white-space: normal; transition: background 0.2s;">
                                            <div class="bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center text-white"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <svg class="icon" style="width: 20px; height: 20px;">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-cart">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span
                                                        class="small fw-bold text-dark">{{ $notification->data['title'] }}</span>
                                                    @if (!$notification->read_at)
                                                        <span class="badge rounded-circle bg-primary p-1"
                                                            style="width: 8px; height: 8px;"></span>
                                                    @endif
                                                </div>
                                                <p class="mb-1 small text-muted lh-sm">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                <small class="text-muted" style="font-size: 0.65rem;">
                                                    <svg class="icon icon-sm me-1">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-clock">
                                                        </use>
                                                    </svg>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="p-4 text-center">
                                        <svg class="icon icon-3xl text-muted opacity-50 mb-3 d-block mx-auto">
                                            <use
                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-bell-excl">
                                            </use>
                                        </svg>
                                        <span class="text-muted small">No notifications yet</span>
                                    </div>
                                @endforelse
                            </div>
                            <div class="text-center p-2 border-top bg-light rounded-bottom">
                                <a href="#" class="small text-muted text-decoration-none fw-semibold">View all
                                    notifications</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="header-nav">
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                            aria-expanded="false" data-coreui-toggle="dropdown">
                            <svg class="icon icon-lg theme-icon-active">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-contrast">
                                </use>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                            <li>
                                <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="light">
                                    <svg class="icon icon-lg me-3">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-sun">
                                        </use>
                                    </svg>Light
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="dark">
                                    <svg class="icon icon-lg me-3">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-moon">
                                        </use>
                                    </svg>Dark
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center active" type="button"
                                    data-coreui-theme-value="auto">
                                    <svg class="icon icon-lg me-3">
                                        <use
                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-contrast">
                                        </use>
                                    </svg>Auto
                                </button>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md"><img class="avatar-img"
                                    src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets/img/avatars/8.jpg') }}"
                                    alt="{{ auth()->user()->name }}"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div
                                class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                                Account ({{ auth()->user()->name }})
                            </div>
                            <a class="dropdown-item" href="{{ route('backend.profile.edit') }}">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user">
                                    </use>
                                </svg> Profile</a>
                            <a class="dropdown-item" href="{{ route('backend.profile.edit') }}">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-settings">
                                    </use>
                                </svg> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg class="icon me-2">
                                    <use
                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-account-logout">
                                    </use>
                                </svg> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="container-fluid px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active"><span>Dashboard</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </header>
        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                @yield('content')
            </div>
        </div>
        <footer class="footer px-4">
            <div><a href="{{ route('landing') }}">eLearnify </a> © {{ date('Y') }} Learning Platform.</div>
            <div class="ms-auto">Powered by&nbsp;<a href="#">eLearnify Team</a></div>
        </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('vendors/chart.js/js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/utils/js/index.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Mark single admin notification as read
            $(document).on('click', '.admin-notification-item', function(e) {
                const id = $(this).data('id');
                const url = `{{ url('my/notifications') }}/${id}/mark-as-read`;
                $.get(url); // Background request
            });

            // Mark all admin notifications as read
            $('#markAllReadAdmin').on('click', function(e) {
                e.preventDefault();
                const $this = $(this);
                const url = "{{ route('user.notifications.markAllRead') }}";

                $.get(url, function(response) {
                    if (response.success) {
                        $('.admin-notification-item').closest('.notification-item-wrapper')
                            .removeClass('bg-light');
                        $('.admin-notification-item').find('.badge.rounded-circle.bg-primary')
                            .fadeOut();
                        $('.admin-notification-badge').fadeOut();
                        $this.fadeOut();
                    }
                });
            });
        });
    </script>

    @include('layouts.crud_ajax')
    @stack('scripts')

</body>

</html>
