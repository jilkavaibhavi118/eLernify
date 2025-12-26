<div class="dashboard-sidebar mb-4">
    <nav class="nav flex-column dashboard-menu">
        <a class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="bi bi-grid"></i> My Dashboard
        </a>
        <a class="nav-link {{ Route::is('user.courses') ? 'active' : '' }}" href="{{ route('user.courses') }}">
            <i class="bi bi-book"></i> My Courses
        </a>
        <a class="nav-link {{ Route::is('user.quizzes') ? 'active' : '' }}" href="{{ route('user.quizzes') }}">
            <i class="bi bi-clipboard-check"></i> My Quizzes
        </a>
        <a class="nav-link {{ Route::is('user.certificates') ? 'active' : '' }}"
            href="{{ route('user.certificates') }}">
            <i class="bi bi-award"></i> My Certificates
        </a>

        <a class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
            <i class="bi bi-person"></i> Profile
        </a>
        <a class="nav-link {{ Route::is('user.purchases') ? 'active' : '' }}" href="{{ route('user.purchases') }}">
            <i class="bi bi-cart"></i> Purchases
        </a>
    </nav>

    {{-- App Download Card removed/commented out as per previous edits in some files, 
         but we can keep it here if consistent. Let's keep it clean for now or add if requested. --}}
</div>
