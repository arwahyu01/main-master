{!! html()->modelForm($data,'PUT', route($page->url.'.update', $data->id))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! html()->label('Nama Menu','title')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('title',$data->title)->placeholder('Type name here')->class('form-control')->id('title') !!}
        </div>
        <div class="form-group">
            {!! html()->label('Informasi','subtitle')->class('control-label') !!}
            {!! html()->span('e.g : Welcome to Menu page')->class('text-danger') !!}
            {!! html()->text('subtitle',$data->subtitle)->placeholder('Type subtitle here')->class('form-control')->id('subtitle') !!}
        </div>
        <div class="form-group">
            {!! html()->label('Model','model')->class('control-label') !!}
            {!! html()->select('model',$model,collect(explode('\\', $data->model))->last())->placeholder('Pilih Model (optional)')->class('form-control select2')->id('model') !!}
        </div>
        <div class="form-group">
            {!! html()->label('Kode Menu','code')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('code',$data->code)->placeholder('Type code here')->class('form-control')->id('code') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! html()->label('Icon','icon')->class('control-label') !!}
            <span class="text-danger">*</span>
            <div class="input-group mb-3">
                <span class="input-group-prepend">
                    <i class="input-group-text selected-icon"></i>
                </span>
                {!! html()->text('icon',$data->icon)->placeholder('Icon')->class('form-control iconpicker')->id('icon')->attributes(['autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! html()->label('Tipe Menu','type')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('type',['' => 'Pilih Tipe Menu', 'backend' => 'Backend', 'frontend' => 'Frontend'],$data->type)->class('form-select')->id('type') !!}
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! html()->label('Tampilkan','show')->class('control-label') !!}
                    <span class="text-danger">*</span>
                    {!! html()->select('show',[1 => 'Ya', 0 => 'Tidak'],$data->show)->class('form-select')->id('show') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! html()->label('Status','active')->class('control-label') !!}
                    <span class="text-danger">*</span>
                    {!! html()->select('active',[1 => 'Aktif', 0 => 'Tidak Aktif'],$data->active)->class('form-select')->id('active') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! html()->label('Akan Datang','coming_soon')->class('control-label') !!}
                    <span class="text-danger">*</span>
                    {!! html()->select('coming_soon', [1 => 'Ya', 0 => 'Tidak'], $data->coming_soon)->class('form-select')->id('coming_soon') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! html()->label('Maintenance','maintenance')->class('control-label') !!}
                    <span class="text-danger">*</span>
                    {!! html()->select('maintenance', [1 => 'Ya', 0 => 'Tidak'], $data->maintenance)->class('form-select')->id('maintenance') !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! html()->label('Link','url')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('url',$data->url)->placeholder('Type url here')->class('form-control')->id('url') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! html()->label('Tentukan Akses','access_group_id')->class('control-label') !!}
            <span class="text-danger">*</span>
            <div class="row p-5" id="access_group_id">
                @php($access_menu = $data->access_menu()->pluck('access_group_id'))
                @foreach($access_group as $key => $value)
                    <div class="col-12">
                        {!! html()->checkbox('access_group_id[]', collect($access_menu)->contains($key), $key)->id('access_group_'.$key)->class('filled-in chk-col-primary access_group_id')->attributes(['onclick'=>"checkAllLevel('access-menu-crud-$key',this)"]) !!}
                        {!! html()->label($value,'access_group_'.$key) !!}
                        <div class="form-control access-menu-crud-{{$key}} m-2">
                            <label class="control-label">Tentukan Hak Akses</label> <span class="text-danger">*</span>
                            <a href="javascript:void(0)" type="button" onclick="checkAll('access-crud-{{$key}}',{{$key}})" class="check-all-{{$key}} btn btn-xs btn-success"><i class="fa fa-check"></i> Check All</a>
                            <div class="row mt-2">
                                @foreach(config('master.app.level') as $i => $v)
                                    <div class="col-md-2 access-crud-{{$key}}">
                                        {!! html()->checkbox('access_crud_'.$key.'[]', collect($data->access_menu()->where('access_group_id',$key)->first()->access ?? [])->contains($v), $v)->id('crud_'.$i.'_'.$key)->class('filled-in chk-col-info') !!}
                                        {!! html()->label(ucwords($v),'crud_'.$i.'_'.$key) !!}
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
{!! html()->hidden('function')->value('loadMenu,sidebarMenu')->id('function') !!}
{!! html()->form()->close() !!}
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
    $('.modal-title').html('<i class="mdi mdi-bookmark-plus"></i> Tambah Data {{ $page->title }}');
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
            $('.access-menu-crud-' + $(this).val()).show();
        } else {
            $('.access-crud' + $(this).val()).find('input[type="checkbox"]').prop('checked', false);
            $('.access-menu-level' + $(this).val()).hide();
        }
    })

    function checkAll(param, key) {
        let div = $('.' + param);
        let checked = div.find('input[type="checkbox"]:checked').length;
        let total = div.find('input[type="checkbox"]').length;
        div.find('input[type="checkbox"]').prop('checked', checked !== total)
        $('.check-all-' + key).html(checked !== total ? '<i class="fa fa-check"></i> Uncheck All' : '<i class="fa fa-check"></i> Check All')
    }

    function checkAllLevel(param, obj) {
        $('.' + param).find('input[type="checkbox"]').prop('checked', $(obj).prop('checked'))
    }
</script>
