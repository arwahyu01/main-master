<li class="list-group-item no-border">
    {!! html()->checkbox('menu_id[]',in_array($child->id, $data->access_menu()->pluck('menu_id')->toArray()), $child->id)->id('menu_'.$child->id)->class('checkAll filled-in chk-col-success') !!}
    {!! html()->label($child->title)->for('menu_'.$child->id)->class('text-nowrap') !!}
    @if(collect($child->children)->count() > 0)
        <ul class="list-group">
            @foreach($child->children as $child)
                @include('backend.access-menu.menu.submenu', ['child' => $child, 'data' => $data])
            @endforeach
        </ul>
    @endif
</li>
