<footer class="footer-section text-white pt-5 pb-4">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4 col-md-6">
                <a class="navbar-brand text-white fw-bold fs-3 mb-3 d-block" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/img/logo.png') }}" alt="Elearnify Logo" class="footer-logo"> <span
                        class="text-white">Elearnify</span>
                </a>
                <p class="text-light opacity-75 small mb-4">
                    Empowering learners worldwide with accessible, high-quality education. Join the revolution today.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="footer-social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Platform</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('courses') }}">Browse Courses</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('instructors') }}">Instructors</a></li>
                    <li><a href="#">Enterprise</a></li>
                    <li><a href="#">Pricing</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Contact Us</h6>
                <ul class="list-unstyled footer-contact">
                    <li class="mb-2 opacity-75 small">
                        <i class="fas fa-envelope me-2 text-primary"></i> support@elearnify.com
                    </li>
                    <li class="mb-2 opacity-75 small">
                        <i class="fas fa-phone me-2 text-primary"></i> +1 (555) 123-4567
                    </li>
                    <li class="opacity-75 small">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i> 123 Education St, Tech City
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Stay Updated</h6>
                <form action="#">
                    <div class="input-group">
                        <input type="email" class="form-control border-0 shadow-none fs-small"
                            placeholder="Enter your email">
                        <button class="btn btn-primary" type="button"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
                <small class="text-light opacity-50 d-block mt-2" style="font-size: 11px;">
                    We respect your privacy. No spam.
                </small>
            </div>
        </div>
        <hr class="my-4 opacity-25">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small mb-0 opacity-75">&copy; 2024 Elearnify Inc. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="small">
                    <a href="#" class="text-white text-decoration-none opacity-75 me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none opacity-75">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>
