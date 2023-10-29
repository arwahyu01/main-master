@extends('backend.main.index')
@push('title', $page->title ?? 'Pengumuman')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title"><span class="fa fa-bullhorn"></span> {{ $data->title }} </h4>
                            </div>
                            <div class="box-body">
                                <div class="end-date">
                                    <span class="fa fa-calendar"></span>
                                    Berlaku : {{ date('d M Y', strtotime($data->start)) }} - {{ date('d M Y', strtotime($data->end)) }}
                                    <span class="pull-right">Berakhir {!! $data->daysLeft !!} hari lagi</span>
                                </div>
                                <div class="urgency">
                                    <span class="fa fa-exclamation-triangle"></span> Sifat Pengumuman :
                                    <span class="badge badge-{!! config('master.content.announcement.color.'.$data->urgency) !!}">{!! config('master.content.announcement.status.'.$data->urgency) !!}</span>
                                </div>
                                <div class="box-comments p-10 mt-3">
                                    {!! $data->content !!}
                                </div>
                                <div class="file p-10 mt-3">
                                    <span class="fa fa-paperclip"></span> File Pendukung :
                                    @if(!$data->file->isEmpty())
                                        <ul>
                                            @foreach($data->file as $file)
                                                <li class="list-group-item">
                                                    <a href="{!!  $file->link_download !!}" target="_blank"><span class="fa fa-download"></span> Unduh</a> |
                                                    <a href="{!!  $file->link_stream !!}" target="_blank"><span class="fa fa-eye"></span> Lihat </a> |
                                                    {!!  $file->file_name !!}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="badge badge-danger">Tidak ada file</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger pull-right" onclick="window.close();">
                            <span class="fa fa-times"></span> Tutup Halaman
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
