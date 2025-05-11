@extends('backend.auth.index')
@push('title', config('master.app.profile.name') . ' - Login')
@section('content')
    <div class="container-custom login-container" role="main" aria-label="Sign in form container">
        <div class="half-circle-bg" aria-hidden="true"></div>

        <section class="left" aria-label="Pesan sambutan dan judul">
            <img class="header-img" width="150"
                 src="{{ asset(config('master.app.web.template') . '/images/main-master-logo.png') }}"
                 alt="Logo Aplikasi">
            <h1>{{ config('master.app.profile.name') }}</h1>
            <h2>Laravel {{ config('master.app.profile.laravel') }}</h2>
            <p>Selamat datang di <strong>Main Master</strong> — CRUD siap pakai untuk Laravel. Semua fitur dasar
                seperti <em>login, user management, role & permission,</em> hingga notifikasi sudah tersedia. Tinggal
                fokus ke fitur utama aplikasi kamu.</p>
        </section>

        <section class="right" aria-label="Sign in form">
            <h3>Sign in</h3>
            <p class="description">Sign in to continue to {{ config('master.app.profile.short_name') }}</p>

            <form method="post" name="login-form" id="login-form">
                <div class="form-group mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" value="{{ old('email') }}" required aria-label="Email">
                </div>
                <div class="form-group mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                           aria-label="Password">
                    <button type="button"
                            class="show-hide-password show-btn position-absolute top-50 end-0 translate-middle-y me-3"
                            id="togglePassword">SHOW
                    </button>
                </div>

                <div class="checkbox-row d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="button" id="go-login" class="btn signin-btn w-100 mb-3">Sign in</button>

                <div class="divider">Or</div>
                <div class="social-icons text-center mb-3">
                    <a class="btn btn-social-icon btn-facebook" href="#" aria-label="Sign in with Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-social-icon btn-twitter" href="#" aria-label="Sign in with Twitter"><i
                            class="fab fa-x-twitter"></i></a>
                    <a class="btn btn-social-icon btn-google" href="#" aria-label="Sign in with Google"><i
                            class="fab fa-google"></i></a>
                </div>

                <p class="signup-text">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
            </form>
        </section>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ url(config('master.app.web.template').'/css/auth.css') }}">
@endpush
