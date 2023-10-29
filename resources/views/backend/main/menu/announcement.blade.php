@if($page->announcement()->count() > 0)
    <div id="content-announcement" class="content mb-0">
        @foreach($page->announcement as $announcement)
            <div id="alert-content-{!! $announcement->id !!}" class="box box-inverse bg-{!! config('master.content.announcement.color.'.$announcement->urgency) !!}">
                <div class="box-header with-border">
                    <h4 class="box-title"><span class="fa fa-bullhorn"></span>
                        <strong>  {{ $announcement->title }}</strong>
                        <small class="sidetitle">Tayang {{ date('d M Y', strtotime($announcement->start)) }} - {{ date('d M Y', strtotime($announcement->end)) }} ({!! $announcement->days_left !!} hari lagi)</small>
                    </h4>
                    <div class="box-tools pull-right">
                        <ul class="box-controls">
                            <li><a class="close-alert box-btn-close" data-code="{!! $announcement->id !!}" href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-body box-shadowed box-outline-{!! config('master.content.announcement.color.'.$announcement->urgency) !!} text-dark">
                    {!! \App\support\Helper::sortText($announcement->content,1000) !!}
                    <div class="pull-right">
                        <a href="{{ $announcement->link }}" target="_blank" class="btn btn-sm btn-{!! config('master.content.announcement.color.'.$announcement->urgency) !!}">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
                let content = $('#content-announcement');
                @foreach($page->announcement as $announcement)
                    @if(isset($_COOKIE["content-{$announcement->id}"]))
                        $('#alert-content-{!! $announcement->id !!}').remove();
                        content.children().length === 0 ? content.remove() : null
                    @endif
                @endforeach

                $('.close-alert').click(function () {
                    document.cookie = `content-${$(this).data('code')}=hide;`;
                });
            });
        </script>
    @endpush
@endif
