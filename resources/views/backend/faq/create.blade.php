{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.store'], 'class' => 'form form form-horizontal', 'method' => 'post','files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! Form::label('title', 'Title / Group Name', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::text('title',NULL,['class'=>'form-control','id'=>'title','placeholder'=>'Write Here ...']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('menu_id', 'Menu', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::select('menu_id',$menu,NULL,['class'=>'form-control select2','id'=>'menu_id','placeholder'=>'Choose Menu']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('description', 'Description', array('class' => 'control-label')) !!}
            {!! Form::textarea('description',NULL,['class'=>'form-control hide','id'=>'description','placeholder'=>'Write Here ...']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('file', 'Upload File,  ', array('class' => 'control-label')) !!}
            <span class="text-danger"> Allowed : pdf, video (mp4), image (jpg, png) </span><br>
            {!! Form::file('file',NULL,['class'=>'form-control','id'=>'file',"accept"=>"application/pdf,video/*,image/*"]) !!}
        </div>
        <div class="row">
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('visitors', 'Visitors', array('class' => 'control-label')) !!}
                    {!! Form::number('visitors',0,['class'=>'form-control','id'=>'visitors']) !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('like', 'Like', array('class' => 'control-label')) !!}
                    {!! Form::number('like',0,['class'=>'form-control','id'=>'like']) !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('dislike', 'Dislike', array('class' => 'control-label')) !!}
                    {!! Form::number('dislike',0,['class'=>'form-control','id'=>'dislike']) !!}
                </div>
            </div>
        </div>
        <div class='form-group'>
            <input type="checkbox" name="publish" id="md_checkbox" value="1" class="filled-in chk-col-primary">
            <label for="md_checkbox">Publish</label>
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
    $('#description').summernote({
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
    $("#file").on("change", function () {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidVideoTypes = ["video/mp4", "video/avi", "video/mov"];
        var ValidImageTypes = ["image/jpeg", "image/png"];
        var ValidPdfTypes = ["application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0 && $.inArray(fileType, ValidVideoTypes) < 0 && $.inArray(fileType, ValidPdfTypes) < 0) {
            $("#file").val('');
            swal("Oops!", "File not allowed, please choose a PDF, Video or Image file.", "error");
        }
    });
</script>
