{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
            {!! Form::text('name',$data->name,['class'=>'form-control','id'=>'name','placeholder'=>'Ketik Disini']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('code', 'Code', array('class' => 'control-label')) !!}
            {!! Form::text('code',$data->code,['class'=>'form-control','id'=>'code','placeholder'=>'Ketik Disini']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('access', 'Access', array('class' => 'control-label')) !!}
            <div class="row">
                @foreach(collect(config('master.app.level')) as $key => $level)
                    <div class="col-auto">
                        <input type="checkbox" name="access[]" {{ in_array($level, ($data->access ?? [])) ? (($data->access[$level] ?? false) ? 'checked' : '') : '' }} id="md_checkbox_{{$key}}"  value="{{ $level }}"  class="filled-in chk-col-primary">
                        <label for="md_checkbox_{{$key}}" class="text-uppercase">{{ $level }}</label>
                    </div>
                @endforeach
            </div>
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
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
</script>
