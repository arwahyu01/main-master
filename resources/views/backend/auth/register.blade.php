@extends('backend.auth.index')

@push('title', config('master.app.profile.name').' - Register ')

@section('content')
    <div class="container-custom register-split">
        <div class="left-side">
            <div class="content">
                <img src="{{ asset(config('master.app.web.template') . '/images/main-master-logo.png') }}"
                     alt="Ilustrasi Pendaftaran" class="illustration">
                <h2>Bangun Lebih Cepat, Lebih Pintar</h2>
                <p>Lupakan repotnya bikin CRUD dari awal. <strong>Main Master</strong> jadi fondasi solid untuk
                    pengembangan aplikasi yang efisien dan scalable.</p>
                <div class="cta">
                    <p>Siap percepat proses development?</p>
                    <a href="{{ url('login') }}">Masuk Sekarang <i class="fas fa-arrow-right"></i></a>
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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000000;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 30vh;
            z-index: 0;
        }

        .container-custom.register-split {
            background: #fff;
            border-radius: 12px;
            max-width: 800px; /* Batasi lebar maksimum container di desktop */
            width: 100%;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .left-side {
            background: linear-gradient(135deg, #5c6bc0 0%, #3f51b5 100%);
            color: #fff;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 45%;
            text-align: center;
        }

        .left-side .content {
            text-align: center;
        }

        .illustration {
            max-width: 40%;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .left-side h2 {
            font-size: 2em;
            font-weight: 600;
            margin-bottom: 15px;
            letter-spacing: 0.8px;
        }

        .left-side p {
            font-size: 1em;
            line-height: 1.6;
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .cta {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .cta a {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .cta a:hover {
            opacity: 0.8;
        }

        .cta i {
            margin-left: 8px;
        }

        .right-side {
            padding: 30px;
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .content-top-agile {
            text-align: left;
            padding: 0 0 20px 0;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .content-top-agile h2 {
            color: #37474f;
            margin-bottom: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1.8em;
        }

        .content-top-agile p {
            color: #78909c;
            font-size: 0.9em;
        }

        .p-40 {
            padding: 0;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group {
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .input-group-text {
            background: transparent;
            color: #546e7a;
            border: none;
            padding-left: 10px;
            padding-right: 8px;
        }

        .form-control {
            font-size: 0.9em;
            background: transparent;
            border: none;
            color: #37474f;
            padding: 10px 15px;
            flex-grow: 1;
            transition: border-color 0.3s ease;
        }

        .form-control::placeholder {
            color: #90a4ae;
        }

        .form-control:focus {
            border-color: #5c6bc0;
            outline: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .pass-info {
            font-size: 0.8em;
            color: #78909c;
            margin-top: 5px;
            display: block;
        }

        .checkbox {
            color: #546e7a;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .checkbox input[type="checkbox"] {
            margin-right: 5px;
        }

        .checkbox a {
            color: #5c6bc0;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .checkbox a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .btn-info {
            background: #5c6bc0;
            color: #fff;
            font-size: 1em;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 8px;
            letter-spacing: 0.75px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            width: 100%;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .text-center p {
            color: #78909c;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .text-center p a {
            color: #5c6bc0;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .text-center p a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Media query untuk layar dengan lebar maksimum 768px (ukuran umum tablet) */
        @media (max-width: 768px) {
            .container-custom.register-split {
                flex-direction: column;
            }

            .left-side {
                display: none; /* Sembunyikan sisi kiri di tablet */
            }

            .right-side {
                width: 100%; /* Gunakan seluruh lebar */
                padding: 30px;
            }

            #particles-js {
                height: 20vh;
            }

            .right-side .content-top-agile {
                text-align: center; /* Pusatkan judul di tablet */
            }
        }

        /* Media query untuk layar dengan lebar maksimum 576px (ukuran umum mobile) */
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }

            #particles-js {
                height: 15vh;
            }

            .right-side {
                padding: 20px; /* Padding lebih kecil untuk mobile kecil */
            }

            .right-side .content-top-agile h2 {
                font-size: 1.6em; /* Ukuran font lebih kecil di mobile kecil */
                text-align: center; /* Pusatkan judul di mobile kecil */
            }

            .form-control {
                font-size: 0.85em;
                padding: 10px 12px;
            }

            .btn-info {
                font-size: 0.95em;
                padding: 10px 20px;
            }

            .checkbox,
            .text-center p {
                font-size: 0.85em;
            }
        }
    </style>
@endpush
