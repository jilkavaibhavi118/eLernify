<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login | Learning Platform</title>
    <!-- CoreUI Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            height: 100vh;
            overflow: hidden;
        }

        .split-screen {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .left-pane {
            width: 50%;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{ asset('assets/img/login-bg.jpg') }}') center center/cover no-repeat;
            position: relative;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }

        .left-pane h1 {
            font-family: 'Pacifico', cursive;
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .left-pane p {
            font-size: 1.2rem;
            max-width: 80%;
            line-height: 1.6;
        }

        .right-pane {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .welcome-text {
            color: #00aced;
            /* Light blue similar to image */
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .sub-text {
            color: #6c757d;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.8rem 1rem;
            border: 1px solid #ced4da;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 172, 237, 0.25);
            border-color: #00aced;
        }

        .btn-login {
            background-color: #00aced;
            border: none;
            border-radius: 5px;
            padding: 0.8rem;
            font-weight: 600;
            width: 100%;
            color: white;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: #0090c5;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #6c757d;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ced4da;
        }

        .divider::before {
            margin-right: .5em;
        }

        .divider::after {
            margin-left: .5em;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border: 1px solid #eee;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .register-link {
            text-align: center;
            font-size: 0.9rem;
        }

        .register-link a {
            color: #000;
            font-weight: 600;
            text-decoration: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
                overflow-y: auto;
            }

            .left-pane,
            .right-pane {
                width: 100%;
                height: auto;
                min-height: 50vh;
            }

            .right-pane {
                padding: 2rem;
            }
        }

        /* Cityscape decoration (CSS shapes approximation or simplified) */
        .cityscape {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 60px;
            background-image: linear-gradient(to top, #00aced 10%, transparent 10%),
                linear-gradient(to top, #00aced 20%, transparent 20%);
            background-size: 20px 100%, 40px 100%;
            opacity: 0.2;
            z-index: -1;
            /* Using a simple placeholder for now */
        }
    </style>
</head>

<body>
    <div class="split-screen">
        <div class="left-pane">
            <h1>Learning Platform</h1>
            <p>Education is the passport to the future, for tomorrow belongs to those who prepare for it today.</p>
        </div>
        <div class="right-pane">
            <div class="login-card">
                <h2 class="welcome-text">Welcome</h2>
                <p class="sub-text">Login with Email</p>

                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Email
                            Id</label>
                        <input type="email" class="form-control" name="email" placeholder="thisui@mail.com"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="*****************"
                            required>
                    </div>

                    <div class="text-end mb-3">
                        <a href="#" class="text-muted small text-decoration-none">Forgot your password?</a>
                    </div>

                    <button type="submit" class="btn btn-login">LOGIN</button>

                    <div class="divider">OR</div>

                    <div class="social-buttons">
                        <a href="#" class="social-btn">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
                                alt="Google" width="24">
                        </a>
                        <a href="#" class="social-btn">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                                alt="Facebook" width="24">
                        </a>
                        <a href="#" class="social-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="black">
                                <path
                                    d="M17.05 20.28c-.98.95-2.05 1.94-3.41 1.94-1.35 0-1.74-.8-3.32-.8-1.58 0-2.06.81-3.32.81-1.39 0-2.61-1.12-3.8-2.82-2.33-3.36-1.92-9.69 2.01-9.69 1.63 0 2.82 1.05 3.73 1.05 1 0 2.29-1.25 3.96-1.25.68 0 2.58.11 3.82 1.84-2.98 1.44-2.52 5.95.53 7.15-.65 1.58-1.57 3.16-2.2 3.77zM12.03 7.25c.87-1.07 1.45-2.56 1.29-4.04-1.25.05-2.76.85-3.66 1.93-.8.93-1.51 2.45-1.32 3.86 1.4.11 2.83-.69 3.69-1.75z" />
                            </svg>
                        </a>
                    </div>

                    <div class="register-link">
                        Don't have account? <a href="#">Register Now</a>
                    </div>
                </form>
            </div>
            <!-- Simple Cityscape SVG Decoration at bottom right -->
            <div style="position: absolute; bottom: 0; right: 0; width: 100%; opacity: 0.8; pointer-events: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="display: block; width: 100%;">
                    <path fill="#00aced" fill-opacity="0.2"
                        d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</body>

</html>
