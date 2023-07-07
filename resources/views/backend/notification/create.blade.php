{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.store'], 'class' => 'form form form-horizontal', 'method' => 'post','files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        
    </div>
</div>
{!! Form::hidden('table-id','datatable',['id'=>'table-id']) !!}
{{--{!! Form::hidden('function', 'loadMenu(),sidebarMenu()' , ['id' => 'function']) !!}--}}
{{--{!! Form::hidden('redirect', url($link.'/dashboard') , ['id' => 'redirect']) !!}--}}
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
<script>
    $('.select2').select2();
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Tambah Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
</script>
