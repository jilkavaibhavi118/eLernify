<div class="dashboard-sidebar mb-4">
    <nav class="nav flex-column dashboard-menu">
        <a class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="bi bi-grid"></i> My Dashboard
        </a>
        <a class="nav-link {{ Route::is('user.courses') ? 'active' : '' }}" href="{{ route('user.courses') }}">
            <i class="bi bi-book"></i> My Courses
        </a>
        <a class="nav-link" href="#">
            <i class="bi bi-people"></i> Referrals
        </a>
        <a class="nav-link" href="#">
            <i class="bi bi-file-earmark-text"></i> Resume Builder
        </a>
        <a class="nav-link" href="#">
            <i class="bi bi-calendar3"></i> Calendar
        </a>
        <a class="nav-link" href="#">
            <i class="bi bi-chat-left-text"></i> Forums
        </a>
        <a class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
            <i class="bi bi-person"></i> Profile
        </a>
        <a class="nav-link" href="#">
            <i class="bi bi-gear"></i> Settings
        </a>
    </nav>

    {{-- App Download Card removed/commented out as per previous edits in some files, 
         but we can keep it here if consistent. Let's keep it clean for now or add if requested. --}}
</div>
