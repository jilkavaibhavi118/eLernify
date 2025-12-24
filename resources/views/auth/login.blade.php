<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login | Learning Platform</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary-blue: #0a2283;
            --soft-blue: #eef2ff;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --white: #ffffff;
            --bg-light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--white);
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* --- Left Pane (Carousel Section) --- */
        .left-pane {
            width: 55%;
            background-color: var(--primary-blue);
            padding: 4rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            overflow: hidden;
        }

        /* Abstract Background Icons */
        .edu-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.15);
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        .icon-1 {
            top: 10%;
            left: 10%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
        }

        .icon-2 {
            top: 20%;
            right: 15%;
            width: 50px;
            height: 50px;
            animation-delay: 1s;
        }

        .icon-3 {
            bottom: 15%;
            left: 15%;
            width: 70px;
            height: 70px;
            animation-delay: 2s;
        }

        .icon-4 {
            bottom: 25%;
            right: 10%;
            width: 40px;
            height: 40px;
            animation-delay: 3.5s;
        }

        .icon-5 {
            top: 40%;
            left: 5%;
            width: 45px;
            height: 45px;
            animation-delay: 0.5s;
        }

        .carousel {
            width: 100%;
            max-width: 500px;
            text-align: center;
            z-index: 10;
        }

        .slide {
            display: none;
            animation: fadeIn 0.8s ease-out;
        }

        .slide.active {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .carousel-scene {
            position: relative;
            height: 450px;
            width: 100%;
            margin-bottom: 3rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .float-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            position: absolute;
            transition: all 0.5s ease;
            text-align: left;
            z-index: 5;
        }

        .card-main {
            width: 240px;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: float-main 8s ease-in-out infinite;
        }

        .card-float {
            z-index: 11;
            animation: float-sub 6s ease-in-out infinite;
        }

        @keyframes float-main {

            0%,
            100% {
                transform: translate(-50%, -50%) translateY(0);
            }

            50% {
                transform: translate(-50%, -50%) translateY(-10px);
            }
        }

        @keyframes float-sub {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Positions and Sizes */
        .pos-top-left {
            top: 15%;
            left: 10%;
            width: 140px;
            transform: rotate(-8deg);
            animation-delay: 0s;
        }

        .pos-bottom-right {
            bottom: 15%;
            right: 10%;
            width: 180px;
            transform: rotate(5deg);
            animation-delay: 1s;
        }

        .pos-center-right {
            top: 40%;
            right: 5%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(12deg);
            animation-delay: 0.5s;
        }

        .pos-bottom-left {
            bottom: 20%;
            left: 5%;
            width: 120px;
            transform: rotate(-5deg);
            animation-delay: 1.5s;
        }

        /* Background Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0.4;
            filter: blur(2px);
        }

        .shape-1 {
            width: 40px;
            height: 40px;
            background: #fbbf24;
            top: 10%;
            right: 20%;
            transform: rotate(45deg);
            border-radius: 10px;
        }

        .shape-2 {
            width: 30px;
            height: 30px;
            background: #60a5fa;
            bottom: 20%;
            right: 30%;
        }

        .shape-3 {
            width: 50px;
            height: 15px;
            background: #f472b6;
            top: 40%;
            left: 15%;
            border-radius: 20px;
            transform: rotate(-30deg);
        }

        .shape-4 {
            width: 20px;
            height: 20px;
            background: #34d399;
            bottom: 40%;
            left: 30%;
        }

        .tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .tag-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .tag-green {
            background: #dcfce7;
            color: #166534;
        }

        .tag-orange {
            background: #ffedd5;
            color: #9a3412;
        }

        .progress-bar {
            height: 6px;
            background: #f1f5f9;
            border-radius: 10px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-blue);
            width: 70%;
        }

        .carousel-text h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .carousel-text p {
            font-size: 0.95rem;
            opacity: 0.8;
            max-width: 350px;
            margin: 0 auto;
        }

        .dots {
            display: flex;
            gap: 8px;
            margin-top: 3rem;
            justify-content: center;
        }

        .dot {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active {
            width: 24px;
            border-radius: 4px;
            background: var(--white);
        }

        /* --- Right Pane (Login Section) --- */
        .right-pane {
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5rem;
            background: var(--white);
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .logo {
            margin-bottom: 0.5rem;
            color: var(--primary-blue);
            display: flex;
            justify-content: center;
        }

        .logo img {
            max-height: 120px;
            width: auto;
        }

        .logo svg {
            width: 40px;
            height: 40px;
        }

        .form-header h2 {
            font-size: 2.2rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--text-gray);
            margin-bottom: 2.5rem;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            width: 20px;
            height: 20px;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            font-size: 0.95rem;
            transition: all 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(52, 89, 230, 0.05);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-gray);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-google {
            width: 100%;
            padding: 12px;
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }

        .btn-google:hover {
            background: #f8fafc;
        }

        .footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .footer-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 1024px) {
            .left-pane {
                display: none;
            }

            .right-pane {
                width: 100%;
                padding: 2rem;
            }
        }

        /* Validation Errors */
        .error-message {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background-color: #fef2f2;
        }
    </style>
</head>

<body>
    <div class="split-container">
        <!-- Left Pane with Carousel -->
        <div class="left-pane">
            <i data-lucide="book" class="edu-icon icon-1"></i>
            <i data-lucide="graduation-cap" class="edu-icon icon-2"></i>
            <i data-lucide="pencil" class="edu-icon icon-3"></i>
            <i data-lucide="laptop" class="edu-icon icon-4"></i>
            <i data-lucide="brain" class="edu-icon icon-5"></i>

            <div class="carousel">
                <!-- Slide 1: Interactive Learning -->
                <div class="slide active" id="slide1">
                    <div class="carousel-scene">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                        <div class="shape shape-4"></div>

                        <div class="float-card card-main">
                            <img src="{{ asset('assets/img/image4.jpg') }}"
                                style="width:100%; border-radius:10px; margin-bottom:0.8rem;">
                            <span class="tag tag-blue">Computer Science</span>
                            <h4 style="color:var(--text-dark); font-size:1rem; line-height:1.4;">Foundation of
                                Algorithms & Logic</h4>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%;"></div>
                            </div>
                        </div>
                        <div class="float-card card-float pos-top-left" style="z-index: 12;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="background:#eef2ff; padding:6px; border-radius:10px;"><i data-lucide="video"
                                        style="width:16px; height:16px; color:var(--primary-blue)"></i></div>
                                <div>
                                    <div style="font-weight:700; color:var(--text-dark); font-size:0.8rem;">Lesson 08
                                    </div>
                                    <div style="color:var(--text-gray); font-size:0.65rem;">Live Class Available</div>
                                </div>
                            </div>
                        </div>
                        <div class="float-card card-float pos-bottom-right"
                            style="padding: 1rem; width: 160px; z-index: 12;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div
                                    style="width:40px; height:40px; background:#f8fafc; border: 2px solid #e2e8f0; border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--primary-blue); font-weight:800; font-size:0.9rem;">
                                    92</div>
                                <div>
                                    <div style="color:var(--text-dark); font-weight:700; font-size:0.8rem;">Average
                                    </div>
                                    <div style="color:var(--text-gray); font-size:0.65rem;">Course Score</div>
                                </div>
                            </div>
                        </div>
                        <div class="float-card card-float pos-center-right"
                            style="background: var(--white); border-radius: 14px; padding: 0.6rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 11;">
                            <i data-lucide="zap" style="width:28px; height:28px; color:#fbbf24"></i>
                        </div>
                    </div>
                    <div class="carousel-text">
                        <h2>Master New Skills Every Day</h2>
                        <p>Learn at your own pace with interactive lessons and expert-led tutorials.</p>
                    </div>
                </div>

                <!-- Slide 2: Career Growth -->
                <div class="slide" id="slide2">
                    <div class="carousel-scene">
                        <div class="shape shape-1" style="background:#f472b6"></div>
                        <div class="shape shape-2" style="background:#fbbf24"></div>
                        <div class="shape shape-4" style="background:#60a5fa"></div>

                        <div class="float-card card-main" style="padding: 2rem; width: 260px;">
                            <div
                                style="background:#f1f5f9; padding:2rem; border-radius:16px; border:3px dashed #cbd5e1; text-align:center;">
                                <div
                                    style="width:60px; height:60px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                    <i data-lucide="award" style="width:32px; height:32px; color:#f59e0b;"></i>
                                </div>
                                <h4 style="color:var(--text-dark); font-size:1.1rem; font-weight:700;">Verified
                                    Certificate</h4>
                                <p style="font-size:0.8rem; color:var(--text-gray); margin-top:5px;">Full-Stack
                                    Developer</p>
                            </div>
                        </div>
                        <div class="float-card card-float pos-top-left"
                            style="width: 170px; transform: rotate(-10deg);">
                            <span class="tag tag-green">Success</span>
                            <div style="color:var(--text-dark); font-weight:700; font-size:0.85rem;">Job Offer Received
                            </div>
                            <div style="color:var(--text-gray); font-size:0.7rem;">Senior Web Engineer</div>
                        </div>
                        <div class="float-card card-float pos-bottom-left"
                            style="width: 140px; transform: rotate(8deg);">
                            <div style="color:#64748b; font-size:0.7rem; margin-bottom:8px; font-weight:600;">Top
                                Technologies</div>
                            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                <span
                                    style="background:#e0f2fe; padding:4px 10px; border-radius:8px; font-size:0.7rem; color:#0369a1; font-weight:600;">React</span>
                                <span
                                    style="background:#fef3c7; padding:4px 10px; border-radius:8px; font-size:0.7rem; color:#92400e; font-weight:600;">Laravel</span>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-text">
                        <h2>Build Your Future Career</h2>
                        <p>Gain industry-recognized certifications and land your dream job tech role.</p>
                    </div>
                </div>

                <!-- Slide 3: Global Community -->
                <div class="slide" id="slide3">
                    <div class="carousel-scene">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-3" style="background:#34d399"></div>
                        <div class="shape shape-4"></div>

                        <div class="float-card card-main" style="width: 260px;">
                            <div style="display:flex; flex-direction:column; gap:15px;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div
                                        style="width:40px; height:40px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; border: 2px solid white;">
                                        <i data-lucide="user" style="width:18px; color:#94a3b8"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div style="height:10px; width:70%; background:#e2e8f0; border-radius:5px;">
                                        </div>
                                        <div
                                            style="height:8px; width:40%; background:#f1f5f9; border-radius:4px; margin-top:6px;">
                                        </div>
                                    </div>
                                </div>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div
                                        style="width:40px; height:40px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border: 2px solid white;">
                                        <i data-lucide="user" style="width:18px; color:#cbd5e1"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div style="height:10px; width:50%; background:#e2e8f0; border-radius:5px;">
                                        </div>
                                        <div
                                            style="height:8px; width:60%; background:#f1f5f9; border-radius:4px; margin-top:6px;">
                                        </div>
                                    </div>
                                </div>
                                <button
                                    style="background:var(--primary-blue); color:white; border:none; border-radius:12px; padding:12px; font-size:0.85rem; font-weight:700; cursor:pointer; box-shadow: 0 5px 15px rgba(10, 34, 131, 0.2); margin-top:5px;">Join
                                    Discussion</button>
                            </div>
                        </div>
                        <div class="float-card card-float pos-top-left"
                            style="width: 140px; text-align:center; transform: rotate(-12deg);">
                            <div style="font-size:1.4rem; font-weight:800; color:var(--primary-blue);">5k+</div>
                            <div style="font-size:0.75rem; color:var(--text-gray); font-weight:600;">Active Today</div>
                        </div>
                        <div class="float-card card-float pos-bottom-right"
                            style="width: 180px; transform: rotate(10deg);">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="background:#ffedd5; padding:8px; border-radius:10px;"><i
                                        data-lucide="help-circle" style="width:18px; height:18px; color:#9a3412"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700; color:var(--text-dark); font-size:0.85rem;">24/7
                                        Support</div>
                                    <div style="color:var(--text-gray); font-size:0.7rem;">Mentors are active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-text">
                        <h2>Learn Better Together</h2>
                        <p>Connect with a global network of students and mentors for collaborative growth.</p>
                    </div>
                </div>

                <div class="dots">
                    <div class="dot active" onclick="showSlide(0)"></div>
                    <div class="dot" onclick="showSlide(1)"></div>
                    <div class="dot" onclick="showSlide(2)"></div>
                </div>
            </div>
        </div>

        <!-- Right Pane with Form -->
        <div class="right-pane">
            <div class="form-container">
                <div class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                </div>

                <div class="form-header">
                    <h2>Welcome To Elearnify</h2>
                    <p>Enter your credentials to access your account.</p>
                </div>

                <form action="{{ route('login.post') }}" method="POST" novalidate>
                    @csrf
                    <div class="form-group">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                        <a href="#" class="forgot-link">Recovery Password</a>
                    </div>

                    <button type="submit" class="btn-login">Login</button>

                    <a href="{{ route('auth.google') }}" class="btn-google" style="text-decoration:none;">
                        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20"
                            alt="Google">
                        Sign in with Google
                    </a>

                    <div class="footer-text">
                        Don't have an account yet? <a href="{{ route('register') }}">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Carousel Logic
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');

            currentSlide = index;

            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        // Auto rotate
        setInterval(() => {
            let nextSlide = (currentSlide + 1) % slides.length;
            showSlide(nextSlide);
        }, 5000);
    </script>
</body>

</html>
