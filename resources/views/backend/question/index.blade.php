@extends('backend.main.index')
@push('title', $page->title ?? 'Level')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.main.menu.announcement')
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">
                            <i class="{{ $page->icon }}"></i> All {{ $page->title ?? 'Page Name' }}
                        </h3>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box mt-3">
                            <div class="box-body">
                                <table id="datatable" class="table table-borderless" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th class="w-0">No</th>
                                        <th>Pertanyaan</th>
                                        <th>Menu</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url($template.'/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ url('/js/'.$backend.'/'.$page->code.'/datatable.js') }}"></script>
@endpush
