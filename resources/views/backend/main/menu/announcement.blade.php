@if($page->announcement()->count() > 0)
    <div id="content-announcement" class="mb-3 p-3">
        <h5 class="mb-3 text-secondary"><i class="fa fa-bullhorn me-2"></i> Pengumuman Terbaru</h5>
        <ul class="list-group">
            @foreach($page->announcement as $announcement)
                <li id="alert-content-{!! $announcement->id !!}" class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                    <div>
                        <strong>{{ $announcement->title }}</strong>
                        <br>
                        <small class="text-muted">Tayang {{ date('d M Y', strtotime($announcement->start)) }} - {{ date('d M Y', strtotime($announcement->end)) }}</small>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger close-alert" data-code="{!! $announcement->id !!}">
                            <i class="fa fa-times"></i>
                        </button>
                        <a href="{{ $announcement->link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye me-1"></i> Lihat
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
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
    @push('css')
        <style>

            .list-group-item {
                border: none;
                border-bottom: 1px solid #e9ecef;
                padding: 15px 20px;
                transition: background-color 0.3s ease-in-out;
            }

            .list-group-item:hover {
                background-color: #f8f9fa;
            }

            .btn-outline-primary:hover {
                color: white;
                background-color: #007bff;
            }

        </style>
    @endpush
@endif
