{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => TRUE]) !!}
<div class="row">
    @foreach(collect($data['menu'])->whereNull('parent_id')->sortBy('sort') as $menu)
        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-shadowed">
                <div class="box-header">
                    {!! Form::checkbox('checkAll', $menu->id, FALSE, ['id'=>'parent_'.$menu->id,'class' => 'filled-in chk-col-success checkAll']) !!}
                    <label for="{!! 'parent_'.$menu->id !!}">Pilih Semua</label>
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
{!! Form::hidden('access_group_id',$data->id,['id'=>'access_group_id']) !!}
{!! Form::hidden('function','sidebarMenu()',['id'=>'function']) !!}
{!! Form::close() !!}
<style>
    .select2-container {
        z-index: 9999 !important;
        width: 100% !important;
    }

    .modal-lg {
        max-width: 1300px !important;
    }
</style>
<script>
    $('.select2').select2();
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
    $(document).on('click', '.checkAll', function() {
        let checkbox = $(this).parent().parent().find('ul').find('li').find('input[type="checkbox"]');
        if ($(this).is(':checked')) {
            checkbox.prop('checked', true);
        } else {
            checkbox.prop('checked', false);
        }
    });
</script>
