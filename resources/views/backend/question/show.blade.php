@extends('backend.main.index')
@push('title', $page->title ?? 'Level')
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
                                    <li class="breadcrumb-item">
                                        <a href="{!! url(config('master.app.url.backend').'/'.$page->url) !!}"><i class="fa fa-home"></i> FAQ
                                        </a></li>
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
                            <div class="box-body shadow">
                                <h4>{!! $data->title !!}</h4>
                                <hr>
                                <div class="p-2">{!! $data->description !!}</div>
                                @if(!is_null($data->file))
                                    @if($data->file->exists())
                                        <div class="form-group text-center">
                                            @if($data->file->type == 'image')
                                                <img src="{{ url($data->file->link_stream) }}" class="img-fluid img-thumbnail" alt="{{ $data->file->name }}" style="width: 50%">
                                            @else
                                                @if($data->file->type == 'video')
                                                    <video width="320" controls>
                                                        <source src="{{ url($data->file->link_stream) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    @if($data->file->type == 'file')
                                                        <object data="{{ url($data->file->link_stream) }}" type="application/pdf" width="100%" height="600px">
                                                            <p>Alternative text - include a link
                                                                <a href="{{ url($data->file->link_stream) }}">to the PDF!</a>
                                                            </p>
                                                        </object>
                                                    @else
                                                        @if($data->file->type == 'audio')
                                                            <audio controls>
                                                                <source src="{{ url($data->file->link_stream) }}" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        @else
                                                            <a href="{{ url($data->file->link_stream) }}" target="_blank"> {{ $data->file->name }} </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                <div class="box p-2">
                                    <p>Apakah kamu merasa terbantu dengan jawaban ini?</p>
                                    <ul class="list-inline">
                                        <li>
                                            <a href="#" class="link-black text-sm send-response" data-code="yes"><i class=" margin-r-5 fa fa-thumbs-o-up"></i> Ya, Terbantu</a>
                                        </li>
                                        <li>
                                            <a href="#" class="link-black text-sm send-response" data-code="no"><i class=" margin-r-5 fa fa-thumbs-o-down"></i> Tidak</a>
                                        </li>
                                    </ul>
                                </div>
                                @if($data->family->count() > 0)
                                    <div class="box p-2">
                                        <h5>Pertanyaan Terkait :</h5>
                                        <ul>
                                            @foreach($data->family()->whereNot('id',$data->id)->cursor() as $faq)
                                                <li>
                                                    <a href="{!! url(config('master.app.url.backend').'/question/'.$faq->id) !!}">{{ $faq->title }}</a>
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
