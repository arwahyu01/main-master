{{--<script>--}}
    function loadMenu(){
        $('.loading').show();
        $.ajax({
            url: "{{ url(config('master.app.url.backend').'/'.$url.'/data') }}",
            type: "GET",
            dataType: 'HTML',
            success: function (data) {
                $('.table-responsive #nestable .list').html(data);

                $('.loading').hide();
                var updateOutput = function (e) {
                    var list = e.length ? e : $(e.target), output = list.data('output');
                    if (window.JSON) {
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    } else {
                        output.val('JSON browser support required for this demo.');
                    }
                };

                let nestable = $('#nestable');

                nestable.nestable({
                    group: 1,
                    {{--  maxDepth: 1--}}
                }).on('change', updateOutput);

                updateOutput(nestable.data('output', $('#nestable-output')));
            },
            error: function (e) {
                if (error++ < 3) {
                    loadMenu();
                    console.log("%cx " + e['responseJSON'].message + ",  reconect ...", "color: #ff2222");
                } else {
                    console.log("🙂 %c sorry we tried, but the server did not respond", "color: orange;");
                }
            }
        });
    }
    loadMenu(); // load nestable menu

{{--</script>--}}
