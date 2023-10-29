{!! html()->modelForm($data,'PUT', route($page->url.'.update', $data->id))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() !!}
<div class="row">
    @foreach(collect($data['menu'])->whereNull('parent_id')->sortBy('sort') as $menu)
        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-shadowed">
                <div class="box-header">
                    {!! html()->checkbox('checkAll', FALSE, $menu->id)->id('parent_'.$menu->id)->class('filled-in chk-col-success checkAll') !!}
                    {!! html()->label("Pilih Semua")->for('parent_'.$menu->id)->class('text-nowrap') !!}
                </div>
                <div class="box-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            @include('backend.access-menu.menu.menu', ['menu' => $menu, 'data' => $data])
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
{!! html()->hidden('access_group_id',$data->id)->id('access_group_id') !!}
{!! html()->hidden('function','sidebarMenu()')->id('function') !!}
{!! html()->form()->close() !!}
<style>
    .modal-lg {
        max-width: 1300px !important;
    }
</style>
<script>
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {{ $page->title }}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
    $(document).on('click', '.checkAll', function () {
        let checkbox = $(this).parent().parent().find('ul').find('li').find('input[type="checkbox"]');
        if ($(this).is(':checked')) {
            checkbox.prop('checked', true);
        } else {
            checkbox.prop('checked', false);
        }
    });
</script>
