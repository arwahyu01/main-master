@extends('backend.auth.index')
@push('title', config('master.app.profile.name').' - Login ')
@section('content')
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100 col-12">
            <div class="row justify-content-center g-0">
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="bg-white rounded10 shadow-lg">
                        <div class="row p-20 pb-0">
                            @if(config('master.app.web.header_animation') == 'on')
                                <div class="col-md-4 col-lg-4 align-items-center hidden-lg-down me-0">
                                    <img id="header-image-vector" class="pull-right p-5" width="90" height="90"
                                         src="{!! url(config('master.app.web.template').'/assets/vector/sleeping.png') !!}"
                                         alt="avatar">
                                </div>
                                <div class="col-md-8 col-lg-8 col-12 pull-left hidden-lg-down ms-0">
                                    <h1 class="text-primary">{!! config('master.app.profile.name') !!}</h1>
                                    <p class="mb-0">Sign in to continue to {!! config('master.app.profile.short_name') !!}.</p>
                                </div>
                                <div class="col-12 content-top-agile hidden-lg-up">
                                    <h2 class="text-primary">{!! config('master.app.profile.name') !!}</h2>
                                    <p class="mb-0">Sign in to continue to {!! config('master.app.profile.short_name') !!}.</p>
                                </div>
                            @else
                                <div class="col-12 content-top-agile">
                                    <h2 class="text-primary">{!! config('master.app.profile.name') !!}</h2>
                                    <p class="mb-0">Sign in to continue to {!! config('master.app.profile.short_name') !!}.</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-40">
                            <form method="post" name="login-form" id="login-form">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                        <input name="email" id="email" type="text" class="form-control ps-15 bg-transparent" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                        <input name="password" type="password" id="password" class="form-control ps-15 bg-transparent" placeholder="Password" autocomplete="off" required>
                                        <span class="input-group-text show-hide-password bg-transparent"><i class="fa fa-eye-slash"></i></span>
                                    </div>
                                    <span class="info-login"></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="checkbox">
                                            <input type="checkbox" id="remember" name="remember">
                                            <label for="remember">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="fog-pwd text-end">
                                            <a href="#" class="hover-warning"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="button" id="go-login" class="btn btn-dark mt-10 text-white fw-bold">SIGN IN</button>
                                    </div>
                                </div>
                            </form>
                            <div class="text-center">
                                <p class="mt-15 mb-0">Don't have an account?
                                    <a href="{{ url('register') }}" class="text-dark fw-bold ms-5">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="mt-20 text-white">- Sign With -</p>
                        <p class="gap-items-2 mb-20">
                            <a class="btn btn-social-icon btn-round btn-facebook" href="#" title="facebook"><i class="fa fa-facebook"></i></a>
                            <a class="btn btn-social-icon btn-round btn-twitter" href="#" title="twitter"><i class="fa fa-twitter"></i></a>
                            <a class="btn btn-social-icon btn-round btn-google" href="#" title="google+"><i class="fa fa-google"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
