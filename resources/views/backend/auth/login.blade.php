@extends('backend.auth.index')
@push('title', config('master.app.profile.name') . ' - Login')
@section('content')
    <div class="container-custom login-container" role="main" aria-label="Sign in form container">
        <div class="half-circle-bg" aria-hidden="true"></div>

        <section class="left" aria-label="Welcome message and headline">
            <img class="header-img" width="150" src="{{ asset(config('master.app.web.template') . '/images/main-master-logo.png') }}" alt="Logo Aplikasi">
            <h1>{{ config('master.app.profile.name') }}</h1>
            <h2>{{ config('master.app.profile.laravel') }}</h2>
            <p>Energi Anda terlalu berharga untuk tugas berulang. Main Master hadir sebagai Master CRUD, fokuskan daya Anda pada inovasi.</p>
        </section>

        <section class="right" aria-label="Sign in form">
            <h3>Sign in</h3>
            <p class="description">Sign in to continue to {{ config('master.app.profile.short_name') }}</p>

            <form method="POST" id="login-form">
                @csrf
                <div class="form-group mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required aria-label="Email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required aria-label="Password">
                    <button type="button" class="show-hide-password show-btn position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword">SHOW</button>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-row d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" id="go-login" class="btn signin-btn w-100 mb-3">Sign in</button>

                <div class="divider">Or</div>
                <div class="social-icons text-center mb-3">
                    <a class="btn btn-social-icon btn-facebook" href="#" aria-label="Sign in with Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-social-icon btn-twitter" href="#" aria-label="Sign in with Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a class="btn btn-social-icon btn-google" href="#" aria-label="Sign in with Google"><i class="fab fa-google"></i></a>
                </div>

                <p class="signup-text">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
            </form>
        </section>
    </div>
@endsection
@push('css')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000000;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 25vh;
            z-index: 0;
        }

        .container-custom {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
            border: 1px solid #e0e0e0;
        }

        .left {
            color: #37474f;
            flex: 1 1 55%;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Pusatkan horizontal */
            justify-content: center; /* Pusatkan vertikal */
            position: relative;
            z-index: 2;
            background: #e8eaf6;
            text-align: center;
            border-right: 1px solid #d1d1d6;
        }

        .left .header-img {
            max-width: 70%;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.08));
        }

        .left h1,
        .left h2,
        .left p {
            margin-bottom: 18px;
            text-shadow: none;
        }

        .left h1 {
            font-size: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #263238;
        }

        .left h2 {
            font-size: 16px;
            opacity: 0.7;
            text-transform: uppercase;
            color: #546e7a;
        }

        .left p {
            font-size: 13px;
            line-height: 1.7;
            opacity: 0.7;
            max-width: 340px;
        }

        .right {
            background: #fff;
            flex: 1 1 45%;
            padding: 50px;
            z-index: 2;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .right h3 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #263238;
            text-shadow: none;
            text-align: center;
        }

        .right .description {
            font-size: 13px;
            color: #546e7a;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            font-size: 14px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #d1d1d6;
            padding: 12px 35px;
            color: #37474f;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control::placeholder {
            color: #78909c;
        }

        .form-control:focus {
            border-color: #29b6f6;
            outline: none;
            box-shadow: 0 0 8px rgba(41, 182, 246, 0.3);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #78909c;
            font-size: 16px;
            pointer-events: none;
        }

        .show-btn {
            background: none;
            border: none;
            color: #29b6f6;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            transition: opacity 0.3s ease;
        }

        .show-btn:hover {
            opacity: 0.8;
        }

        .checkbox-row {
            font-size: 12px;
            color: #546e7a;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .checkbox-row a {
            color: #29b6f6;
            font-weight: 500;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .checkbox-row a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .signin-btn {
            background: linear-gradient(to right, #29b6f6, #03a9f4);
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            padding: 12px 0;
            border-radius: 6px;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(41, 182, 246, 0.3);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .signin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(41, 182, 246, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #78909c;
            margin: 25px 0;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #d1d1d6;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        .btn-social-icon {
            margin: 0 8px;
            color: #fff;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 16px;
            opacity: 0.7;
            transition: opacity 0.3s ease, transform 0.2s ease-in-out;
        }

        .btn-social-icon:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .btn-facebook {
            background-color: #3b5998;
        }

        .btn-twitter {
            background-color: #1da1f2;
        }

        .btn-google {
            background-color: #db4437;
        }

        .signup-text {
            font-size: 12px;
            color: #78909c;
            margin-top: 30px;
            text-align: center;
        }

        .signup-text a {
            color: #29b6f6;
            font-weight: 500;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .signup-text a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .half-circle-bg {
            position: absolute;
            top: -60px;
            left: -60px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(41, 182, 246, 0.08);
            z-index: 0;
        }

        /* Media query untuk layar dengan lebar maksimum 768px (ukuran umum tablet) */
        @media (max-width: 768px) {
            .container-custom {
                flex-direction: column;
            }

            .left{
                display: none;
            }

            .right {
                width: 100%;
                padding: 40px;
                text-align: center;
                border-right: none;
            }

            #particles-js {
                height: 18vh;
            }

            .right {
                border-radius: 12px;
            }

            .left .header-img {
                max-width: 60%;
                margin-bottom: 20px;
            }
        }

        /* Media query untuk layar dengan lebar maksimum 576px (ukuran umum mobile) */
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }

            #particles-js {
                height: 12vh;
            }

            .left,
            .right {
                padding: 30px;
            }

            .left h1 {
                font-size: 26px;
            }

            .left h2 {
                font-size: 14px;
            }

            .left p {
                font-size: 11px;
            }

            .right h3 {
                font-size: 22px;
            }

            .form-control {
                font-size: 13px;
                padding: 10px 30px;
            }

            .checkbox-row {
                font-size: 11px;
            }

            .signin-btn {
                font-size: 15px;
                padding: 10px 0;
            }

            .divider {
                font-size: 11px;
                margin: 20px 0;
            }

            .signup-text {
                font-size: 11px;
            }

            .btn-social-icon {
                width: 35px;
                height: 35px;
                font-size: 15px;
            }

            .half-circle-bg {
                top: -40px;
                left: -40px;
                width: 80px;
                height: 80px;
            }

            .left .header-img {
                max-width: 80%;
                margin-bottom: 15px;
            }
        }
    </style>
@endpush
