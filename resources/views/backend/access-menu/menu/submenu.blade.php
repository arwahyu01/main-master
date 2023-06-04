<li class="list-group-item no-border">
    {!! Form::checkbox('menu_id[]', $child->id, in_array($child->id, $data->access_menu()->pluck('menu_id')->toArray()) ? TRUE : FALSE, ['id'=>'menu_'.$child->id,'class' => 'checkAll filled-in chk-col-success']) !!}
    <label for="{!! 'menu_'.$child->id !!}" class="text-nowrap">{!! $child->title !!}</label>
    @if(collect($child->children)->count() > 0)
        <ul class="list-group">
            @foreach($child->children as $child)
                @include('backend.access-menu.menu.submenu', ['child' => $child, 'data' => $data])
            @endforeach
        </ul>
    @endif
</li>
