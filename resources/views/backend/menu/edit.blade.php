{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => TRUE]) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('title', 'Nama Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('title', $data->title, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Nama Menu']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('subtitle', 'Informasi', ['class' => 'control-label']) !!}
            <span class="text-danger">e.g : Welcome to {!! $data->subtitle ?? 'Menu' !!} page</span>
            {!! Form::text('subtitle', $data->subtitle, ['id' => 'subtitle', 'class' => 'form-control', 'placeholder' => 'Sub Title']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::select('model', $model, collect(explode('\\', $data->model))->last(), ['id' => 'model', 'class' => 'form-control select2', 'placeholder' => 'Pilih Model']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('code', 'Kode Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('code', $data->code, ['id' => 'code', 'class' => 'form-control', 'placeholder' => 'Kode Menu']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('icon', 'Icon', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            <div class="input-group mb-3">
                <span class="input-group-prepend">
                    <i class="input-group-text selected-icon"></i>
                </span>
                {!! Form::text('icon', $data->icon, ['id' => 'icon', 'class' => 'form-control iconpicker', 'placeholder' => 'Icon','autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('type', 'Tipe Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::select('type', ['' => 'Pilih Tipe Menu', 'backend' => 'Backend', 'frontend' => 'Frontend'], $data->type, array('id' => 'type', 'class' => 'form-control')) !!}
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('show', 'Tampilkan', ['class' => 'control-label']) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('show', [1 => 'Ya', 0 => 'Tidak'], $data->show, ['id' => 'show', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('active', 'Status', ['class' => 'control-label']) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('active', [1 => 'Aktif', 0 => 'Tidak Aktif'], $data->active, ['id' => 'active', 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('url', 'Link', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('url', $data->url, ['id' => 'url', 'class' => 'form-control', 'placeholder' => 'Link']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('access_group_id', 'Tentukan Akses', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            <div class="row">
                @php($access_menu = $data->access_menu()->pluck('access_group_id'))
                @foreach($access_group as $key => $value)
                    <div class="col-12">
                        {!! Form::checkbox('access_group_id[]', $key, collect($access_menu)->contains($key), ['id' => 'access_group_'.$key,'onclick'=>"checkAllLevel('access-menu-crud-$key',this)" ,'class' => 'filled-in chk-col-primary access_group_id']) !!}
                        {!! Form::label('access_group_'.$key, $value) !!}
                        <div class="form-control access-menu-crud-{{$key}} m-2">
                            <label class="control-label">Tentukan Hak Akses</label> <span class="text-danger">*</span>
                            <a href="javascript:void(0)" type="button" onclick="checkAll('access-crud-{{$key}}',{{$key}})" class="check-all-{{$key}} btn btn-xs btn-success"><i class="fa fa-check"></i> Check All</a>
                            <div class="row mt-2">
                                @foreach(config('master.app.level') as $i => $v)
                                    <div class="col-md-2 access-crud-{{$key}}">
                                        {!! Form::checkbox('access_crud_'.$key.'[]', $v, collect($data->access_menu()->where('access_group_id',$key)->first()->access ?? [])->contains($v), ['id' => 'crud_'.$i.'_'.$key, 'class' => 'filled-in chk-col-info']) !!}
                                        {!! Form::label('crud_'.$i.'_'.$key, ucwords($v)) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="message"></div>
        <div class="progress" style="display: none;">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div id="statustxt">0%</div>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('function', 'loadMenu(),sidebarMenu()' , ['id' => 'function']) !!}
{!! Form::close() !!}
<style>
    .select2-container {
        z-index: 9999 !important;
        width: 100% !important;
    }

    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script src="{{ url($template.'/assets/vendor_components/bootstrap-iconpicker/dist/iconpicker.js') }}"></script>
<script src="{{ url($template.'/assets/vendor_components/nestable/jquery.nestable.js') }}"></script>
<script>
    $('.modal-title').html('<i class="mdi mdi-bookmark-plus"></i> Tambah Data {!! $page->title !!}');
    $('.select2').select2();

    (async () => {
        const response = await fetch("{{ url($template.'/assets/vendor_components/bootstrap-iconpicker/dist/iconsets/fontawesome4.json') }}")
        const result = await response.json()
        const iconpicker = new Iconpicker(document.querySelector(".iconpicker"), {
            icons: result,
            showSelectedIn: document.querySelector(".selected-icon"),
            defaultValue: "{!! $data->icon !!}",
            valueFormat: val => `fa ${val.replace('fas-', 'fa-')}`,
        });
        iconpicker.set()
        iconpicker.set("{!! str_replace('fa ','',$data->icon) !!}")
    })()

    $('.access_group_id').on('click', function () {
        let count = $('.access_group_id:checked').length;
        if (count > 0) {
            $('.access-menu-crud-'+$(this).val()).show();
        } else {
            $('.access-crud'+$(this).val()).find('input[type="checkbox"]').prop('checked', false);
            $('.access-menu-level'+$(this).val()).hide();
        }
    })

    function checkAll(param,key) {
        let div = $('.' + param),
            checked = div.find('input[type="checkbox"]:checked').length,
            total = div.find('input[type="checkbox"]').length;
        div.find('input[type="checkbox"]').prop('checked', checked !== total)
        $('.check-all-'+key).html(checked !== total ? '<i class="fa fa-check"></i> Uncheck All' : '<i class="fa fa-check"></i> Check All')
    }

    function checkAllLevel(param, obj) {
        $('.' + param).find('input[type="checkbox"]').prop('checked', $(obj).prop('checked'))
    }
</script>
