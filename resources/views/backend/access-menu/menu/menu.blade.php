{!! Form::checkbox('menu_id[]', $menu->id, in_array($menu->id, $data->access_menu()->pluck('menu_id')->toArray()) ? TRUE : FALSE, ['id'=>'menu_'.$menu->id,'class' => 'filled-in chk-col-success']) !!}
<label for="{!! 'menu_'.$menu->id !!}" class="text-nowrap">{!! $menu->title !!}</label>
@if(collect($menu->children)->count() > 0)
    <ul class="list-group">
        @foreach($menu->children as $child)
            @include('backend.access-menu.menu.submenu', ['child' => $child, 'data' => $data])
        @endforeach
    </ul>
@endif
