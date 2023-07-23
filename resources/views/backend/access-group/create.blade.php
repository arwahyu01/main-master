{{ html()->form('POST', route($page->url.'.store'))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() }}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label()->class('control-label')->for('name')->text('Name') !!}
            {!! html()->text('name')->placeholder('Type name here')->class('form-control')->id('name') !!}
        </div>
        <div class='form-group'>
            {!! html()->label()->class('control-label')->for('code')->text('Code') !!}
            {!! html()->text('code')->placeholder('Type code here')->class('form-control')->id('code') !!}
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
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Tambah Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
</script>
