<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register | Learning Platform</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{ asset('assets/img/login.avif') }}') center center/cover no-repeat;
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
            overflow-y: auto;
        }

        .register-card {
            width: 100%;
            max-width: 400px;
        }

        .welcome-text {
            color: #3b9d91;
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
            box-shadow: 0 0 0 0.25rem rgba(59, 157, 145, 0.25);
            border-color: #3b9d91;
        }

        .btn-register {
            background-color: #3b9d91;
            border: none;
            border-radius: 5px;
            padding: 0.8rem;
            font-weight: 600;
            width: 100%;
            color: white;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: #2f8177;
            color: white;
        }

        .login-link {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .login-link a {
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
    </style>
</head>

<body>
    <div class="split-screen">
        <div class="left-pane">

        </div>
        <div class="right-pane">
            <div class="register-card">
                <h2 class="welcome-text">Join Us</h2>
                <p class="sub-text">Create your account</p>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Full
                            Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="John Doe" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Email
                            Id</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="thisui@mail.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="*****************" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted"
                            style="position:absolute; margin-top:-0.6rem; margin-left:0.8rem; background:white; padding:0 5px;">Confirm
                            Password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="*****************" required>
                    </div>

                    <button type="submit" class="btn btn-register">REGISTER</button>

                    <div class="login-link">
                        Already have an account? <a href="{{ route('login') }}">Login Now</a>
                    </div>
                </form>
            </div>
            <!-- Simple Cityscape SVG Decoration at bottom right -->
            <div style="position: absolute; bottom: 0; right: 0; width: 100%; opacity: 0.8; pointer-events: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="display: block; width: 100%;">
                    <path fill="#3b9d91" fill-opacity="0.2"
                        d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</body>

</html>
