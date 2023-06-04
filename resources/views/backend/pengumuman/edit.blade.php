{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => true]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! Form::label('menu_id', 'Target Menu', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::select('menu_id',$menu,$data->menu_id,['class'=>'form-control select2','id'=>'menu_id','placeholder'=>'Pilih Menu']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('title', 'Judul Pengumuman', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::text('title',$data->title,['class'=>'form-control','id'=>'title','placeholder'=>'Ketik Disini']) !!}
        </div>
        <div class="row">
            <div class='form-group col-md-6'>
                {!! Form::label('start', 'Tanggal Mulai', array('class' => 'control-label')) !!}
                <span class="text-danger">*</span>
                {!! Form::date('start',$data->start,['class'=>'form-control','id'=>'start']) !!}
            </div>
            <div class='form-group col-md-6'>
                {!! Form::label('end', 'Tanggal Selesai', array('class' => 'control-label')) !!}
                <span class="text-danger">*</span>
                {!! Form::date('end',$data->end,['class'=>'form-control','id'=>'end']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('content', 'Isi Pengumuman', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::textarea('content',$data->content,['class'=>'form-control','id'=>'content','placeholder'=>'Ketik Disini']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('urgency', 'Tingkat Kepentingan', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::select('urgency',config('master.content.pengumuman.status'),$data->urgency,['class'=>'form-control','id'=>'urgency','placeholder'=>'Pilih Disini']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('parent_id', 'Bagian dari pengumuman lain', array('class' => 'control-label')) !!}
            {!! Form::select('parent_id',$parent,$data->parent_id,['class'=>'form-control select2','id'=>'parent_id','placeholder'=>'Pilih Pengumuman']) !!}
        </div>
        <div class='form-group'>
            <input type="checkbox" name="publish" id="md_checkbox" value="1" class="filled-in chk-col-primary" {!! $data->publish ? 'checked' : '' !!}>
            <label for="md_checkbox">Tampilkan Pengumuman</label>
            <span class="text-danger">*</span>
        </div>
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
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
    $('#content').summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            "fontsize",
            "paragraph",
            "table",
            "insert",
            "codeview",
        ]
    });
</script>
