<ol class="dd-list">
    @foreach($menu as $mn)
        <li class="dd-item dd3-item" data-id="{{$mn->id}}">
            <div class="dd-handle dd3-handle"></div>
            <div class="dd3-content" title="{{$mn->title ?? ''}}">
                @if($mn->icon) <span class="{{$mn->icon}}"></span> @endif {{$mn->title}}
                <div class="pull-right btn-group">
                    <button type="button" class="btn-action btn btn-xs btn-outline" title="Ubah data menu" data-title="Edit" data-action="edit" data-url="{{ $page->url }}" data-id="{{ $mn->id }}">
                        <i class="fa fa-edit text-warning"> </i>
                    </button>
                    <button type="button" class="btn-action btn btn-xs btn-outline" title="Hapus menu" data-title="Delete" data-action="delete" data-url="{{ $page->url }}" data-id="{{ $mn->id }}">
                        <i class="fa fa-trash text-danger"> </i>
                    </button>
                </div>
            </div>
            @include($backend.'.menu.list-menu.list-menu', ['menu'=>$mn->children])
        </li>
    @endforeach
</ol>
