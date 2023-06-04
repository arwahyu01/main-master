{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.store'], 'class' => 'form form form-horizontal', 'method' => 'post','files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
			{!! Form::label('access_group_id', 'Access Group', array('class' => 'control-label')) !!}
			{!! Form::select('access_group_id',[],NULL,['class'=>'form-control select2','id'=>'access_group_id','placeholder'=>'Pilih Access Group']) !!}
		</div>
		<div class='form-group'>
			{!! Form::label('menu_id', 'Menu', array('class' => 'control-label')) !!}
			{!! Form::select('menu_id',[],NULL,['class'=>'form-control select2','id'=>'menu_id','placeholder'=>'Pilih Menu']) !!}
		</div>
    </div>
</div>
{!! Form::hidden('table-id','datatable',['id'=>'table-id']) !!}
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
