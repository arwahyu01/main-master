{!! html()->form('DELETE', route($page->code.'.destroy', $data->id))->id('form-create-'.$page->code)->class('form form-horizontal')->open() !!}
<div class="row">
    <div class="col-md-12">
        <label class="control-label h6">Apakah Anda Yakin Ingin Menghapus Data Ini?</label>
        <div class="info-data">
            <div class="panel">
                <div class="panel-body panel-dark bg-dark">
                    @foreach(collect(json_decode($data,TRUE))->except(['id','created_at','updated_at']) as $key => $value)
                        <p>
                            <code>{{ $key }}</code>
                            <span class="text-danger">:</span>
                            <span class="text-info">{{ $value }}</span>
                        </p>
                    @endforeach
                    <div class="mt-3">
                        @if($data->access_menu->count() > 0)
                            <p>
                                <span class="text-info">Menu digunakan oleh :</span>
                                @foreach($data->access_menu as $access)
                                    <span class="badge badge-info">{{ $access->access_group->name }}</span>
                                @endforeach
                            </p>
                            <p>
                                <span class="text-danger">Jika anda menghapus data ini, maka data akses menu yang terkait akan ikut terhapus.</span>
                            </p>
                        @endif
                        <p>
                            <span class="text-danger">Perhatian!</span>
                            <span class="text-info">Data yang sudah dihapus tidak dapat dikembalikan lagi.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <span class="message"></span>
    </div>
</div>
{!! html()->hidden('function')->value('loadMenu,sidebarMenu')->id('function') !!}
{!! html()->form()->close() !!}
<script>
    $('.modal-title').html('<i class="mdi mdi-delete-forever"></i> Hapus Data {{ $page->title }}');
</script>
