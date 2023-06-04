{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! Form::label('title', 'Title / Group Name', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::text('title',$data->title,['class'=>'form-control','id'=>'title','placeholder'=>'Write Here ...']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('menu_id', 'Menu', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::select('menu_id',$menu,$data->menu_id,['class'=>'form-control select2','id'=>'menu_id','placeholder'=>'Choose Menu']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('description', 'Description', array('class' => 'control-label')) !!}
            {!! Form::textarea('description',$data->description,['class'=>'form-control hide','id'=>'description','placeholder'=>'Write Here ...']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('file', 'Upload File,  ', array('class' => 'control-label')) !!}
            <span class="text-danger"> Allowed : pdf, video (mp4), image (jpg, png) </span><br>
            {!! Form::file('file',NULL,['class'=>'form-control','id'=>'file',"accept"=>"application/pdf,video/*,image/*"]) !!}
        </div>
        @if(!is_null($data->file))
            @if($data->file->exists())
                <div class='form-group'>
                    <table class="table table-{!! $data->id !!}">
                        <tr>
                            <td>
                                File :
                                <a href="{{ url($data->file->link_stream) }}" target="_blank"> {{ $data->file->name }} </a><br>
                            </td>
                            <td>
                                Size : {{ $data->file->size }}
                            </td>
                            <td>
                                <a href="{{ url($data->file->link_download) }}" target="_blank" class="btn btn-xs btn-primary">
                                    <i class="fa fa-download"></i> Download </a>
                                <a href="#delete" data-url="{{ url($data->file->link_delete) }}" class="delete btn btn-danger btn-xs">Delete File</a>
                            </td>
                        </tr>
                    </table>
                </div>
            @endif
        @endif
        <div class="row">
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('visitors', 'Visitors', array('class' => 'control-label')) !!}
                    {!! Form::number('visitors',$data->visitors,['class'=>'form-control','id'=>'visitors']) !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('like', 'Like', array('class' => 'control-label')) !!}
                    {!! Form::number('like',$data->like,['class'=>'form-control','id'=>'like']) !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! Form::label('dislike', 'Dislike', array('class' => 'control-label')) !!}
                    {!! Form::number('dislike',$data->dislike,['class'=>'form-control','id'=>'dislike']) !!}
                </div>
            </div>
        </div>
        <div class='form-group'>
            <input type="checkbox" name="publish" id="md_checkbox" value="1" class="filled-in chk-col-primary" @if($data->publish) checked @endif>
            <label for="md_checkbox">Publish</label>
        </div>
    </div>
</div>
<div class="progress-bar bg-success" role="progressbar" style="width: 0;height: 15px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
    $('.delete').on("click", function () {
        let url = $(this).data('url');
        $.ajax({
            url: `${url}`,
            type: 'GET',
            success: function (data) {
                if (data.status) {
                    swal("Success!", data.message, "success");
                    $(this).closest('tr').remove();
                    $('.table-{!! $data->id !!}').remove();
                } else {
                    swal("Oops!", data.message, "error");
                }
            },
            error: function () {
                swal("Oops!", "Something went wrong, please try again later.", "error");
            }
        });
    })
</script>
