@extends('backend.main.index')
@push('title', $page->title ?? 'Menu')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.main.menu.announcement')
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title"><i class="{{ $page->icon }}"></i> {{ $page->title ?? 'Page Name' }}
                        </h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"> {{ $page->subtitle ?? 'Welcome to '.$page->title.' page' }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">
                                @if($user->create)
                                    <button type="button" class="btn-action pull-right btn btn-success btn-sm" data-title="Tambah" data-action="create" data-url="{{ $page->url }}">
                                        <span class="fa fa-plus-circle"></span> Tambah
                                    </button>
                                @endif
                            </div>
                            <div class="box-body">
                                <div class="panel-container show">
                                    <div class="panel-content">
                                        {!! html()->form('POST', route($page->url.'.sorted'))->id('form-'.time())->acceptsFiles()->class('form form-horizontal')->open() !!}
                                        <div class="alert alert-success mb-0" role="alert">
                                            <div class="d-flex align-items-center">
                                                <div class="alert-icon width-3">
                                                      <span class="icon-stack icon-stack-sm">
                                                          <i class="ni ni-list color-success-800 icon-stack-2x font-weight-bold"></i>
                                                      </span>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="h5 m-0 fw-700"><i class="{{ $page->icon }}"></i> List Menu {!! config('master.app.profile.name') !!} !</span>
                                                    Susun menu dengan benar.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-12 col-xl-12 ">
                                            <div class="panel-tag">
                                                <p class="loading text-center" style="display: none">
                                                    <button class="btn btn-outline-dark rounded-pill waves-effect waves-themed text-center" type="button" disabled="">
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Loading...
                                                    </button>
                                                </p>
                                                <div class="table-responsive">
                                                    <div class="dd p-10 fit-width" id="nestable" style="min-width: 100%;">
                                                        <div class="list">
                                                            {{--  Nestable Data --}}
                                                        </div>
                                                        <div>
                                                            {!! html()->textarea('sort')->id('nestable-output')->style('display:none')->class('form-control')->placeholder('Nestable Output') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-success">
                                            <a href="#" class="btn btn-sm btn-info-light submit-data">
                                                <i class="fa fa-save"></i> Simpan
                                            </a>
                                        </div>
                                        {!! html()->hidden('function','sidebarMenu')->id('function') !!}
                                        {!! html()->form()->close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url($template.'/assets/vendor_components/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ url($template.'/assets/vendor_components/jquery-validation-1.17.0/lib/jquery.form.js') }}"></script>
    <script src="{{ url('js/'.$backend.'/'.$page->code.'/datatable.js') }}"></script>
    <script src="{{ url('js/jquery-crud.js') }}"></script>
    <script>
        $(document).on("keyup", "#title", function () {
            let title = $(this).val();
            let value = title.replace(/ /g, "-");
            $("#url").val(value.toLowerCase());
            $("#code").val(value.toLowerCase());
        });
    </script>
@endpush
