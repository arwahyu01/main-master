<aside class="control-sidebar">
    <div class="rpanel-title">
        <span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white" data-toggle="control-sidebar"></i></span>
    </div>
    <div class="tab-content">
        <div class="flexbox">
            <p><i class="fa fa-bullhorn"></i> Hai, ada yang bisa kami bantu ?</p>
        </div>
        <div class="lookup lookup-sm lookup-right d-lg-block">
            <input type="text" id="search-faq" name="search" placeholder="Cari disini ..." class="w-p100">
        </div>
        <div class="media-list media-list-hover mt-20">
            {{-- Content --}}
        </div>
        <div class="flexbox justify-content-center">
            <a href="{!! url(config('master.app.url.backend').'/question') !!}" class="text-center">
                <i class="mdi mdi-playlist-check"></i> Lihat Semua
            </a>
        </div>
    </div>
</aside>
<div class="control-sidebar-bg"></div>
