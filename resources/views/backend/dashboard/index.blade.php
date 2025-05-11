@extends('backend.main.index')
@push('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row align-items-end">
                    <div class="col-12">
                        <div class="box bg-primary-light overflow-hidden pull-up">
                            <div class="box-body pe-0 ps-lg-50 ps-15 py-0">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <h1 class="fs-40 text-dark">Halo, {{ $user->name }}!</h1>
                                        <p class="text-dark mb-0 fs-20">
                                            Selamat datang di {!! config('master.app.profile.name') !!}, platform CRUD Generator berbasis Laravel {!! config('master.app.profile.laravel') !!} yang dirancang untuk mempercepat dan mempermudah pengembangan aplikasi.
                                        </p>
                                        <p class="text-dark mb-0 fs-20">
                                            Jika Anda menemukan bug atau kendala teknis, silakan laporkan melalui
                                            <a target="_blank" href="https://github.com/arwahyu01/main-master/issues" class="text-blue">GitHub</a>.
                                        </p>
                                        <p class="text-dark mb-0 fs-20">
                                            Dokumentasi lengkap dapat dibaca di
                                            <a target="_blank" href="https://github.com/arwahyu01/main-master/blob/master/README.md" class="text-blue">halaman ini</a>.
                                        </p>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <img src="{{ url($template."/images/svg-icon/color-svg/custom-15.svg") }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('backend.main.menu.announcement')
                </div>
            </section>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url($template.'/assets/vendor_components/jquery-validation-1.17.0/lib/jquery.form.js') }}"></script>
    <script src="{{ url('js/jquery-crud.js?id='.time()) }}"></script>
@endpush
