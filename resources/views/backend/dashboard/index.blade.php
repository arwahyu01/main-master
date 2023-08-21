@extends('backend.main.index')
@push('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row align-items-end">
                    <div class="col-12">
                        <div class="box bg-primary-light pull-up">
                            <div class="box-body p-xl-0">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-3">
                                        <img src="{{ url($template."/images/svg-icon/color-svg/custom-14.svg") }}" alt="" width="274" height="150">
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <h2>Hello {!! $user->name !!}, Welcome Back!</h2>
                                        <p class="text-dark mb-0 fs-16">
                                            Your course Overcoming the fear of public speaking was completed by 11 New users this week!
                                        </p>
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

@endpush
