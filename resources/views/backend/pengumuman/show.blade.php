<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul :</label>
                    {!!  $data->title !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Target Menu :</label>
                    {!!  $data->menu->title !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Tanggal Berlaku :</label>
                    {!!  date('d-m-Y', strtotime($data->start)) !!} - {!!  date('d-m-Y', strtotime($data->end)) !!}
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tingkat Kepentingan :</label>
                    {!!  $data->urgency !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status Publikasi :</label>
                    {!!  $data->publish ? "<span class='badge badge-success'>Ditampilkan</span>" : "<span class='badge badge-danger'>Tidak Ditampilkan</span>" !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Relasi :</label>
                    {!!  $data->parent->title ?? 'Tidak Ada' !!}
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
    $('.modal-title').html('<i class="fa fa-eye"></i> Detail Data {!! $page->title !!}');
</script>
