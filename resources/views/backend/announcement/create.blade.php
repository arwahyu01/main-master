{{ html()->form('POST', route($page->url.'.store'))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() }}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('Target Menu','menu_id')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('menu_id',$menu)->class('form-control select2')->id('menu_id')->placeholder('Pilih Menu')->required() !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Judul Pengumuman','title')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('title')->placeholder('Ketik Disini')->class('form-control')->id('title')->required() !!}
        </div>
        <div class="row">
            <div class='form-group col-md-6'>
                {!! html()->label('Tanggal Mulai','start')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->date('start')->class('form-control')->id('start')->required() !!}
            </div>
            <div class='form-group col-md-6'>
                {!! html()->label('Tanggal Selesai','end')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->date('end')->class('form-control')->id('end')->required() !!}
            </div>
        </div>
        <div class='form-group'>
            {!! html()->label('Isi Pengumuman','content')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->textarea('content')->class('form-control')->id('content')->placeholder('Ketik Disini')->required() !!}
        </div>
        <div class='form-group'>
            {!! html()->label('File Pendukung','file')->class('control-label') !!}
            <span class="text-danger">*</span>
            <div class="file-loading">
                {!! html()->file('file[]')->id('file')->class('file-drag-drop')->multiple()->data('overwrite-initial',false)->data('min-file-count',1) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! html()->label('Tingkat Kepentingan','urgency')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('urgency',config('master.content.announcement.status'))->class('form-select')->id('urgency')->placeholder('Pilih Urgensi')->required() !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Berkaitan dengan pengumuman lain ?','parent_id')->class('control-label') !!}
            {!! html()->select('parent_id',$parent)->class('form-control select2')->id('parent_id')->placeholder('Pilih Pengumuman') !!}
        </div>
        <div class='form-group'>
            {!! html()->checkbox('publish',false,1)->id('md_checkbox')->class('filled-in chk-col-primary') !!}
            {!! html()->label('Tampilkan Pengumuman','md_checkbox')->class('control-label') !!}
            <span class="text-danger">*</span>
        </div>
    </div>
</div>
{!! html()->hidden('table-id','datatable')->id('table-id') !!}
{!! html()->form()->close() !!}
<link href="{{ url($template.'/fileupload/css/fileinput.css') }}" rel="stylesheet">
<link href="{{ url($template.'/fileupload/css/font_bootstrap-icons.min.css') }}" rel="stylesheet">
<style>
    .kv-file-upload, .fileinput-upload, .file-upload-indicator{
        display: none;
    }
    .select2-container {
        z-index: 9999 !important;
        width: 100% !important;
    }

    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script src="{{ url($template.'/fileupload/js/fileinput.js') }}"></script>
<script>
    $('#menu_id, #parent_id').select2().parent().css('z-index', 9999)
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Tambah Data {{ $page->title }}');
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
            "link",
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36'],
    });
    var noteModal = document.querySelector('.note-modal');
    noteModal.style.zIndex = 9999;
    noteModal.querySelector('.checkbox').style.display = 'none';
    noteModal.querySelector('.note-modal-content').style.padding = '3px';

    $(".file-drag-drop").fileinput({
        theme: 'fa',
        uploadUrl: "/#",
        allowedFileExtensions:['jpg','jpeg','png','pdf','doc','docx','xls','xlsx'],
        overwriteInitial: false,
        maxFileSize: 2048,
        maxFilesNum: 10,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        },
        initialPreviewAsData: true,
    });
</script>
