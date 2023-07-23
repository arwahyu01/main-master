@extends('backend.auth.index')
@push('title', config('master.app.profile.name').' - Register ')
@section('content')
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">
            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h2 class="text-primary">Get started with Us</h2>
                                <p class="mb-0">Register a new membership</p>
                            </div>
                            <div class="p-40">
                                <form method="post" name="form-register" id="form-register">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                                    <input name="first_name" id="first_name" type="text" class="form-control ps-15 bg-transparent" placeholder="First name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                                    <input name="last_name" id="last_name" type="text" class="form-control ps-15 bg-transparent" placeholder="First name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                            <input name="email" id="email" type="email" class="form-control ps-15 bg-transparent" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input name="password" id="password" type="password" class="form-control ps-15 bg-transparent" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input name="validate_password" id="validate_password" type="password" class="form-control ps-15 bg-transparent" placeholder="Retype Password" required>
                                        </div>
                                        <span class="pass-info"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="checkbox">
                                                <input type="checkbox" id="agree-terms" name="agree_terms">
                                                <label for="agree-terms">I agree to the
                                                    <a href="#" class="text-warning"><b>Terms</b></a></label>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="button" id="register-me" class="btn btn-info margin-top-10">SIGN IN</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <div class="text-center">
                                    <p class="mt-15 mb-0">Already have an account?<a href="{{ url('login') }}" class="text-danger ms-5"> Sign In</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="mt-20 text-white">- Register With -</p>
                            <p class="gap-items-2 mb-20">
                                <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
                                <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
