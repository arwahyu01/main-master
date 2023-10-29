<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            @foreach(collect($data['menu'])->whereNull('parent_id')->sortBy('sort') as $menu)
                <div class="col-auto">
                    <div class="box box-shadowed">
                        <div class="box-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    @include('backend.access-menu.menu.menu', ['menu' => $menu, 'data' => $data])
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
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
    $('.modal-title').html('<i class="fa fa-eye"></i> Detail Data {{ $page->title }}');
    $('input[type="checkbox"]').prop('disabled', true);
</script>
