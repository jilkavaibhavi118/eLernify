<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/img/logo.png') }}" alt="Elearnify Logo" class="brand-logo">Elearnify
            </a>

            <div class="d-flex align-items-center gap-3 ms-auto">
                <a href="{{ route('courses') }}" class="btn btn-outline-secondary btn-sm d-none d-md-block">
                    <i class="bi bi-arrow-left me-1"></i> Back to Course
                </a>
                <div class="vr d-none d-md-block mx-2"></div>

                <button class="search-trigger me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bi bi-search"></i>
                </button>

                <img src="https://ui-avatars.com/?name=User&background=0a2283&color=fff" class="rounded-circle"
                    width="32" height="32" alt="User">
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
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0"
                        placeholder="What do you want to learn today?">
                    <button class="btn btn-primary" type="button">Search</button>
                </div>
                <small class="text-muted">Popular: <em>Python, Graphic Design, Marketing</em></small>
            </div>
        </div>
    </div>
</div>
