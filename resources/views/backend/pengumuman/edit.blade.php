{!! html()->modelForm($data,'PUT', route($page->url.'.update', $data->id))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class='form-group'>
            {!! html()->label('Target Menu','menu_id')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('menu_id',$menu,$data->menu_id)->class('form-control select2')->id('menu_id')->placeholder('Pilih Menu') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Judul Pengumuman','title')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('title',$data->title)->placeholder('Ketik Disini')->class('form-control')->id('title') !!}
        </div>
        <div class="row">
            <div class='form-group col-md-6'>
                {!! html()->label('Tanggal Mulai','start')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->date('start'.$data->start)->class('form-control')->id('start') !!}
            </div>
            <div class='form-group col-md-6'>
                {!! html()->label('Tanggal Selesai','end')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->date('end'.$data->end)->class('form-control')->id('end') !!}
            </div>
        </div>
        <div class='form-group'>
            {!! html()->label('Isi Pengumuman','content')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->textarea('content',$data->content)->class('form-control')->id('content')->placeholder('Ketik Disini') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Tingkat Kepentingan','urgency')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->select('urgency',config('master.content.pengumuman.status'),$data->urgency)->class('form-control')->id('urgency')->placeholder('Pilih Urgensi') !!}
        </div>
        <div class='form-group'>
            {!! html()->label('Bagian dari pengumuman lain','parent_id')->class('control-label') !!}
            {!! html()->select('parent_id',$parent,$data->parent_id)->class('form-control select2')->id('parent_id')->placeholder('Pilih Pengumuman') !!}
        </div>
        <div class='form-group'>
            {!! html()->checkbox('publish',$data->publish,1)->id('md_checkbox')->class('filled-in chk-col-primary') !!}
            {!! html()->label('Tampilkan Pengumuman','md_checkbox')->class('control-label') !!}
            <span class="text-danger">*</span>
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
    $('#menu_id, #parent_id').select2().parent().css('z-index', 9999)
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
    $('.submit-data').html('<i class="fa fa-save"></i> Simpan Data');
    $('#content').summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            "fontsize",
            "fontname",
            "forecolor",
            "paragraph",
            "table",
            "insert",
            "codeview",
            "link",
            "color"
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36'],
    });
    var noteModal = document.querySelector('.note-modal');
    noteModal.style.zIndex = 9999;
    noteModal.querySelector('.checkbox').style.display = 'none';
    noteModal.querySelector('.note-modal-content').style.padding = '3px';
</script>
