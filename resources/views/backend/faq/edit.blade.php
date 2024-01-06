{!! html()->modelForm($data,'PUT', route($page->url.'.update', $data->id))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('title')->text('Judul / Nama Grup / Nama Faq')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('title',$data->title)->placeholder('Type title here')->class('form-control')->id('title') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('menu_id')->class('control-label')->for('menu_id')->text('Menu') !!}
            <span class="text-danger">*</span>
            {!! html()->select('menu_id',$menu,$data->menu_id)->class('form-control select2')->id('menu_id')->placeholder('Choose Menu') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('description')->text('Deskripsi')->class('control-label') !!}
            {!! html()->textarea('description',$data->description)->placeholder('Write Here ...')->class('form-control hie')->id('description') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('file')->text('Unggah File')->class('control-label') !!}
            <span class="text-danger">Allowed : pdf, video (mp4), image (jpg, png)</span><br>
            {!! html()->file('file')->class('form-control')->id('file')->accept('application/pdf,video/*,image/*') !!}
        </div>
        @if(!is_null($data->file))
                <div class='form-group'>
                    <table class="table table-{!! $data->id !!}">
                        @foreach($data->files()->whereNull('alias')->cursor() as $file)
                            @if($file->exists())
                                <tr>
                                    <td>
                                        File :
                                        <a href="{{ url($file->link_stream) }}" target="_blank"> {{ $file->name }} </a>
                                    </td>
                                    <td>
                                        Size : {!! $file->size !!}
                                    </td>
                                    <td>
                                        {!! html()->a(url($data->file->link_download),'<i class="fa fa-download"></i> Download')->class('btn btn-xs btn-primary')->target('_blank') !!}
                                        {!! html()->a('#delete','<i class="fa fa-trash"></i> Delete File')->class('delete btn btn-danger btn-xs')->attribute('data-url',url($data->file->link_delete)) !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
        @endif
        <div class="row">
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Visitors')->class('control-label')->for('visitors') !!}
                    {!! html()->number('visitors',$data->visitors)->class('form-control')->id('visitors') !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Like')->class('control-label')->for('like') !!}
                    {!! html()->number('like',$data->like)->class('form-control')->id('like') !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Dislike')->class('control-label')->for('dislike') !!}
                    {!! html()->number('dislike',$data->dislike)->class('form-control')->id('dislike') !!}
                </div>
            </div>
        </div>
        <div class='form-group'>
            {!! html()->checkbox('publish',$data->publish)->id('md_checkbox')->class('filled-in chk-col-primary') !!}
            {!! html()->label('Publish')->class('control-label')->for('md_checkbox') !!}
        </div>
    </div>
</div>
<div class="progress-bar bg-success" role="progressbar" style="width: 0;height: 15px;" aria-valuenow="0"
     aria-valuemin="0" aria-valuemax="100"></div>
{!! html()->hidden('table-id','datatable')->id('table-id') !!}
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
<script>
    $('.select2').select2();
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {{ $page->title }}');
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
    function sendFile(file, editor) {
        data = new FormData();
        data.append("file", file);
        data.append("_token", "{{ csrf_token() }}");
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ url(config('master.app.url.backend').'/file/upload-image-editor') }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    let url = response.data.url;
                    $('#description').summernote('insertImage', url);
                }
            }
        });
    }

    $('#description').summernote({
        tabsize: 2,
        height: 250,
        spellCheck: false,
        dialogsInBody: true,
        toolbar: [
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['fontname', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
        ],
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files[0], $(this));
            },
            onMediaDelete: function (target) {
                let id = $(target).attr('id');
                let alt = $(target).attr('alt');
                let url = "{{ url(config('master.app.url.backend').'/file/delete') }}" + '/' + id + '/' + alt;
                fileDelete(url, function (status) {
                    if (status) {
                        swal("Success!", "File deleted successfully.", "success");
                    }
                });
            }
        }
    });

    $('.delete').on("click", function () {
        let url = $(this).data('url');
        let row = $(this).closest('tr');
        row.hide();
        fileDelete(url, function (status) {
            if (status) {
                swal("Success!", "File deleted successfully.", "success");
            } else {
                row.show();
                swal("Oops!", "Something went wrong, please try again later.", "error");
            }
        });
    });

    function fileDelete(url, callback) {
        $.ajax({
            type: 'GET',
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                callback(response.status);
            },
            error: function () {
                callback(false);
            }
        });
    }
</script>
