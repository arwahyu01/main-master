{{ html()->form('POST', route($page->url.'.store'))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() }}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('title')->text('Judul / Nama Grup / Nama Faq')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('title')->placeholder('Ketik disini ...')->class('form-control')->id('title') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('menu_id')->text('Menu')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('menu_id',$menu)->class('form-control select2')->id('menu_id')->placeholder('Choose Menu') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('description')->text('Deskripsi')->class('control-label') !!}
            {!! html()->textarea('description')->placeholder('Ketik disini ...')->class('form-control')->id('description') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('file')->text('Unggah File')->class('control-label') !!}
            <span class="text-danger">Allowed : pdf, video (mp4), image (jpg, png)</span><br>
            {!! html()->file('file')->class('form-control')->id('file')->accept('application/pdf,video/mp4,image/jpeg,image/png') !!}
        </div>
        <div class="row">
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Visitors', 'visitors')->class('control-label') !!}
                    <span class="text-dark">(optional)</span>
                    {!! html()->number('visitors',0)->class('form-control')->id('visitors') !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Like', 'like')->class('control-label') !!}
                    <span class="text-dark">(optional)</span>
                    {!! html()->number('like',0)->class('form-control')->id('like') !!}
                </div>
            </div>
            <div class="col-auto">
                <div class='form-group'>
                    {!! html()->label('Dislike', 'dislike')->class('control-label') !!}
                    <span class="text-dark">(optional)</span>
                    {!! html()->number('dislike',0)->class('form-control')->id('dislike') !!}
                </div>
            </div>
        </div>
        <div class='form-group'>
            {!! html()->checkbox('publish',false)->id('md_checkbox')->class('filled-in chk-col-primary') !!}
            {!! html()->label('Publish', 'md_checkbox')->class('control-label') !!}
        </div>
    </div>
</div>
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
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Tambah Data {{ $page->title }}');
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
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files[0], $(this));
            }
        }
    });
</script>
