<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul :</label>
                    {!!  $data->title !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Target Menu :</label>
                    {!!  $data->menu->title !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Berlaku :</label>
                    {!!  date('d-m-Y', strtotime($data->start)) !!} s/d {!!  date('d-m-Y', strtotime($data->end)) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tingkat Kepentingan :</label>
                    <span
                        class="badge badge-{!!  config('master.content.pengumuman.color.'.$data->urgency) !!}">{!!  config('master.content.pengumuman.status.'.$data->urgency) !!}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status Publikasi :</label>
                    {!!  $data->publish ? "<span class='badge badge-success'>Ditampilkan</span>" : "<span class='badge badge-danger'>Tidak Ditampilkan</span>" !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Isi Pengumuman :</label>
                    <div class="p-10 shadow-sm">
                        {!!  $data->content !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>File Pendukung :</label>
                    @if($data->file)
                        <a href="{!! $data->file->link_download.'?id='.uniqid() !!}" download="{!! $data->file->link_download.'?id='.uniqid() !!}"
                           target="_blank">{!! $data->file->name !!}</a>
                    @else
                        <span class="badge badge-danger">Tidak ada file</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Relasi :</label>
                    @if($data->parent)
                        <a href="#" type="button" class="btn-action" data-title="Detail" data-action="show" data-url="pengumuman" data-id="{!! $data->parent_id !!}" title="Tampilkan"> {!! $data->parent->title !!}</a>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script>
    $('.submit-data').hide();
    $('.modal-title').html('<i class="fa fa-eye"></i> Detail {!! $page->title !!}');
</script>
