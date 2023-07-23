{!! html()->modelForm($data,'PUT', route($page->url.'.update', $data->id))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('name')->text('Name')->class('control-label') !!}
            {!! html()->text('name',$data->name)->placeholder('Type name here')->class('form-control')->id('name') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('code')->text('Code')->class('control-label') !!}
            {!! html()->text('code',$data->code)->placeholder('Type code here')->class('form-control')->id('code') !!}
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
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
</script>
