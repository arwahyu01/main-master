<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-1 me-10 p-0 w-10">
                <span class="fa fa-bullhorn {!! $data->color !!} fa-2x"></span>
            </div>
            <div class="col-auto ps-20">
                <h4>{!! $data->title !!}</h4>
            </div>
            <div class="col-md-12">
                <div class="blockquote">
                    <small class="pull-right"><i class="fa fa-clock-o"></i> {!! $data->created_at !!}</small><br>
                    {!! $data->content !!}
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
    $('.modal-title').html('<i class="fa fa-bell"></i> Detail Notifikasi');
</script>
