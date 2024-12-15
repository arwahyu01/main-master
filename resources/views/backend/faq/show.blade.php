<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="form-group">
                <label>Title :</label> {!!  $data->title  !!}
            </div>
            <div class="form-group">
                <label>Topic Menu :</label> {!!  $data->menu->title  !!}
            </div>
            <div class="form-group">
                <label>Description :</label> {!!  $data->description  !!}
            </div>
            <div class="form-group">
                <label>Visitors : </label> {!!  $data->visitors  !!}
                <label>Like : </label> {!!  $data->like  !!}
                <label>Dislike : </label> {!!  $data->dislike  !!}
                <label>Publish : </label> {!!  $data->publish ? 'Yes' : 'No'  !!}
            </div>
            @if(!is_null($data->file))
                @if($data->file->exists())
                    <div class="form-group text-center">
                        @if($data->file->type == 'video')
                            <video width="320" controls>
                                <source src="{!! url($data->file->link_stream) !!}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            @if($data->file->type == 'file')
                                <object data="{!! url($data->file->link_stream) !!}" type="application/pdf" width="100%" height="600px">
                                    <p> Alternative text - include a link
                                        <a href="{!! url($data->file->link_stream) !!}">to the PDF!</a>
                                    </p>
                                </object>
                            @else
                                @if($data->file->type == 'audio')
                                    <audio controls>
                                        <source src="{!! url($data->file->link_stream) !!}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @else
                                    @if($data->file->type != 'image')
                                        <a href="{!! url($data->file->link_stream) !!}" target="_blank"> {!! $data->file->name !!} </a>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                @endif
            @endif
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
</script>
