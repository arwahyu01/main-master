@if($page->pengumuman()->count() > 0)
    <div id="content-announcement" class="content mb-0">
        @foreach($page->pengumuman as $pengumuman)
            <div id="alert-content-{!! $pengumuman->id !!}" class="box box-inverse bg-{!! config('master.content.pengumuman.color.'.$pengumuman->urgency) !!}">
                <div class="box-header with-border">
                    <h4 class="box-title"><span class="fa fa-bullhorn"></span>
                        <strong>  {!! $pengumuman->title !!}</strong>
                        <small class="sidetitle">{{ date('d M Y', strtotime($pengumuman->start)) }} - {{ date('d M Y', strtotime($pengumuman->end)) }}</small>
                    </h4>
                    <div class="box-tools pull-right">
                        <ul class="box-controls">
                            <li><a class="close-alert box-btn-close" data-code="{!! $pengumuman->id !!}" href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-body box-shadowed box-outline-{!! config('master.content.pengumuman.color.'.$pengumuman->urgency) !!} text-dark">
                    {!! \App\support\Helper::sortText($pengumuman->content,1000) !!}
                    <div class="pull-right">
                        <a href="{!! $pengumuman->link !!}" target="_blank" class="btn btn-sm btn-{!! config('master.content.pengumuman.color.'.$pengumuman->urgency) !!}">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
                let content = $('#content-announcement');
                @foreach($page->pengumuman as $pengumuman)
                    @if(isset($_COOKIE["content-{$pengumuman->id}"]))
                        $('#alert-content-{!! $pengumuman->id !!}').remove();
                        console.log('content-{!! $pengumuman->id !!}')
                        content.children().length === 0 ? content.remove() : null
                    @endif
                @endforeach

                $('.close-alert').click(function () {
                    let code = $(this).data('code');
                    document.cookie = `content-${code}=hide;`;
                });
            });
        </script>
    @endpush
@endif
