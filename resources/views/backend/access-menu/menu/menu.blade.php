{!! html()->checkbox('menu_id[]', in_array($menu->id, $data->access_menu()->pluck('menu_id')->toArray()), $menu->id)->id('menu_'.$menu->id)->class('filled-in chk-col-success') !!}
{!! html()->label($menu->title)->for('menu_'.$menu->id)->class('text-nowrap') !!}
@if(collect($menu->children)->count() > 0)
    <ul class="list-group">
        @foreach($menu->children as $child)
            @include('backend.access-menu.menu.submenu', ['child' => $child, 'data' => $data])
        @endforeach
    </ul>
@endif
