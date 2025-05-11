@extends('backend.auth.index')
@push('title', config('master.app.profile.name').' - Register ')
@section('content')
    <div class="container-custom register-split">
        <div class="left-side">
            <div class="content">
                <img src="{{ asset(config('master.app.web.template') . '/images/main-master-logo.png') }}" alt="Ilustrasi Pendaftaran" class="illustration">
                <h2>Main Master</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="cta">
                    <p>Sudah punya akun?</p>
                    <a href="{{ url('login') }}" class="login-link"><i class="fas fa-arrow-left"></i> Masuk Lewat Sini</a>
                </div>
            </div>
        </div>
        <div class="right-side">
            <div class="content-top-agile">
                <h2>Buat Akun</h2>
                <p class="mb-0">Isi form di bawah untuk mendaftar.</p>
            </div>
            <div class="p-40">
                <form method="post" name="form-register" id="form-register">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-user"></i></span>
                                    <input name="first_name" id="first_name" type="text"
                                           class="form-control ps-15 bg-transparent" placeholder="Nama Depan" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-user"></i></span>
                                    <input name="last_name" id="last_name" type="text"
                                           class="form-control ps-15 bg-transparent" placeholder="Nama Belakang"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent"><i class="fas fa-at"></i></span>
                            <input name="email" id="email" type="email" class="form-control ps-15 bg-transparent"
                                   placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                            <input name="password" id="password" type="password"
                                   class="form-control ps-15 bg-transparent" placeholder="Kata Sandi" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                            <input name="validate_password" id="validate_password" type="password"
                                   class="form-control ps-15 bg-transparent" placeholder="Ulangi Kata Sandi" required>
                        </div>
                        <span class="pass-info"></span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="checkbox">
                                <input type="checkbox" id="agree-terms" name="agree_terms">
                                <label for="agree-terms">Saya setuju dengan
                                    <a href="#" class="text-warning"><b>Ketentuan</b></a></label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="button" id="register-me" class="btn btn-info margin-top-10">DAFTAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ url(config('master.app.web.template').'/css/register.css') }}">
@endpush
@push('scripts')
    <script>
        document.querySelector('.login-link').addEventListener('click', function (e) {
            e.preventDefault();
            const link = this;
            link.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Otw login ...';
            link.classList.add('loading');
            link.setAttribute('disabled', 'disabled');
            setTimeout(function () {
                link.innerHTML = '<i class="fas fa-arrow-left"></i> Masuk Lewat Sini';
                link.classList.remove('loading');
                link.removeAttribute('disabled');
            }, 1000);
            window.location.href = link.href;
        });
    </script>
@endpush
