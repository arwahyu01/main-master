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
                        <i class="{{ $page->icon }}"></i> {{ $page->title ?? 'Page Name' }}
                    </h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{!! url(config('master.app.url.backend').'/'.$page->url) !!}">
                                    <i class="fa fa-home"></i> FAQ
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ $page->subtitle ?? 'Welcome to '.$page->title.' page' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="card-title text-primary">{!! $data->title !!}</h4>
                            <hr>

                            <div class="p-2">
                                <p>{!! $data->description !!}</p>
                            </div>

                            @if(!is_null($data->file) && $data->file->exists())
                                <div class="form-group text-center mt-4">
                                    @if($data->file->type == 'video')
                                        <video class="w-100 rounded" controls>
                                            <source src="{{ url($data->file->link_stream) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif($data->file->type == 'file')
                                        <object data="{{ url($data->file->link_stream) }}" type="application/pdf" width="100%" height="600px" class="rounded border">
                                            <p>
                                                Alternative text - include a link
                                                <a href="{{ url($data->file->link_stream) }}" target="_blank">to the PDF!</a>
                                            </p>
                                        </object>
                                    @elseif($data->file->type == 'audio')
                                        <audio controls class="w-100">
                                            <source src="{{ url($data->file->link_stream) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @elseif($data->file->type != 'image')
                                        <a href="{{ url($data->file->link_stream) }}" target="_blank">{{ $data->file->name }}</a>
                                    @endif
                                </div>
                            @endif

                            <div class="alert alert-light border mt-4">
                                <p class="mb-2">Apakah kamu merasa terbantu dengan jawaban ini?</p>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" class="btn btn-success btn-sm send-response" data-code="yes">
                                            <i class="fa fa-thumbs-o-up"></i> Ya, Terbantu
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="btn btn-danger btn-sm send-response" data-code="no">
                                            <i class="fa fa-thumbs-o-down"></i> Tidak
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            @if($data->family->count() > 0)
                                <div class="mt-4">
                                    <h5 class="text-secondary">Pertanyaan Terkait:</h5>
                                    <ul class="list-group">
                                        @foreach($data->family()->whereNot('id', $data->id)->cursor() as $faq)
                                            <li class="list-group-item">
                                                <a href="{!! url(config('master.app.url.backend').'/question/'.$faq->id) !!}" class="text-decoration-none">
                                                    {{ $faq->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
@push('js')
    <script>
        setTimeout(function () {
            $.post('{!! url(config('master.app.url.backend').'/question/viewer') !!}', {
                _token: '{!! csrf_token() !!}',
                id: "{!! $data->id !!}"
            }, function (data) {
                console.log(data);
            })
        }, 5000);

        $('.send-response').on('click', function () {
            let code = $(this).data('code');
            $('[data-code="yes"]').find('i').removeClass('fa fa-thumbs-up').addClass('fa fa-thumbs-o-up');
            $('[data-code="no"]').find('i').removeClass('fa fa-thumbs-down').addClass('fa fa-thumbs-o-down');
            if (code === 'yes') {
                $(this).find('i').removeClass('fa fa-thumbs-o-up').addClass('fa fa-thumbs-up');
            } else {
                $(this).find('i').removeClass('fa fa-thumbs-o-down').addClass('fa fa-thumbs-down');
            }
            swal({
                title: "Yeay !",
                text: "Terima kasih atas tanggapannya !",
                icon: "success",
                button: "OK",
            });
            $.ajax({
                url: '{!! url(config('master.app.url.backend').'/question/response') !!}',
                type: 'POST',
                data: {
                    _token: '{!! csrf_token() !!}',
                    code: `${code}`,
                    id: "{!! $data->id !!}"
                },
                beforeSend: function () {
                    $(this).attr('disabled', true);
                },
                success: function (data) {
                    $(this).attr('disabled', false);
                },
                error: function () {
                    $(this).attr('disabled', false);
                }
            })
        })
    </script>
@endpush
