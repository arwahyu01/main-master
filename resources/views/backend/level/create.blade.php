{{ html()->form('POST', route($page->url.'.store'))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() }}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('Nama Level','name')->class('control-label') !!}
            {!! html()->text('name')->placeholder('Ketik nama levl disini')->class('form-control')->id('name') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Kode Level','code')->class('control-label') !!}
            {!! html()->text('code')->placeholder('Ketik kode disini')->class('form-control')->id('code') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Apa saja hak akses yang dimiliki oleh level ini?','access')->class('control-label') !!}
            <div class="row mt-2">
                @foreach(collect(config('master.app.level')) as $key => $level)
                    <div class="col-auto">
                        {!! html()->checkbox('access[]',false)->id('md_checkbox_'.$key)->class('filled-in chk-col-primary') !!}
                        {!! html()->label($level, 'md_checkbox_'.$key)->class('text-uppercase') !!}
                    </div>
                @endforeach
                <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Ini akan membatasi seluruh aksi yang dapat dilakukan oleh user yang memiliki level ini.</span>
            </div>
        </div>
    </div>
</div>
{!! html()->hidden('table-id','datatable')->id('table-id') !!}
{!! html()->form()->close() !!}
<style>
    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script>
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Tambah Data {{ $page->title }}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
</script>
