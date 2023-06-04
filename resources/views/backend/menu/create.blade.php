{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.store'], 'class' => 'form form-horizontal', 'method' => 'post','files' => TRUE]) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('title', 'Nama Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('title', NULL, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Nama Menu']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('subtitle', 'Informasi', ['class' => 'control-label']) !!}
            <span class="text-danger">e.g : Welcome to Menu page</span>
            {!! Form::text('subtitle', NULL, ['id' => 'subtitle', 'class' => 'form-control', 'placeholder' => 'Sub Title']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::select('model', $model, [],['id' => 'model', 'class' => 'form-control select2', 'placeholder' => 'Pilih Model (optional)']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('code', 'Kode Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('code', NULL, ['id' => 'code', 'class' => 'form-control', 'placeholder' => 'Kode Menu']) !!}
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
                {!! Form::text('icon', NULL, ['id' => 'icon', 'class' => 'form-control iconpicker', 'placeholder' => 'Icon','autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('type', 'Tipe Menu', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::select('type', ['' => 'Pilih Tipe Menu', 'backend' => 'Backend', 'frontend' => 'Frontend'], NULL, array('id' => 'type', 'class' => 'form-control')) !!}
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('show', 'Tampilkan', ['class' => 'control-label']) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('show', [1 => 'Ya', 0 => 'Tidak'], NULL, ['id' => 'show', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('active', 'Status', ['class' => 'control-label']) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('active', [1 => 'Aktif', 0 => 'Tidak Aktif'], NULL, ['id' => 'active', 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('url', 'Link', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            {!! Form::text('url', NULL, ['id' => 'url', 'class' => 'form-control', 'placeholder' => 'Link']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('access_group_id', 'Yang dapat mengakses menu ini ?', ['class' => 'control-label']) !!}
            <span class="text-danger">*</span>
            <div class="row">
                @foreach($access_group as $key => $value)
                    <div class="col-12">
                        <input type="checkbox" name="access_group_id[]" onclick="checkAllLevel('access-menu-crud-{{$key}}',this)" value="{{ $key }}" id="md_checkbox_{{$key}}" class="filled-in chk-col-primary access_group_id">
                        <label for="md_checkbox_{{$key}}">{{ $value }}</label>
                        <div class="form-control access-menu-crud-{{$key}} m-2" style="display: none;">
                            <label class="control-label">Tentukan Hak Akses</label> <span class="text-danger">*</span>
                            <a href="javascript:void(0)" type="button" onclick="checkAll('access-crud-{{$key}}',{{$key}})" class="check-all-{{$key}} btn btn-xs btn-success"><i class="fa fa-check"></i> Check All</a>
                            <div class="row mt-2">
                                @foreach(config('accessmenu.crud') as $i => $v)
                                    <div class="col-md-2 access-crud-{{$key}}">
                                        <input type="checkbox" onclick="checkAllLevel('crud_{{$i}}',this)" name="access_crud_{{$key}}[]" value="{{$v}}" id="crud_{{$i}}_{{$key}}" class="filled-in chk-col-info">
                                        <label for="crud_{{$i}}_{{$key}}">{{ucwords($v)}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span class="message"></span>
        <div class="progress" style="display: none;">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div id="statustxt">0%</div>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('function', 'loadMenu()' , ['id' => 'function']) !!}
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
            defaultValue: 'fa-arrow-right',
            valueFormat: val => `fa ${val.replace('fas-', 'fa-')}`,
        });
        iconpicker.set()
        iconpicker.set('fa-arrow-right')
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
