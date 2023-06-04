{{--<script>--}}
    $(function () {
        sidebarMenu();
        $('.search-menu').on('input', function () {
            let keyword = $(this).val();
            let filter = $('.filtered');
            let menu = $('.all-menu');
            keyword = keyword.replace(/^\s+/, '').replace(/\s/g, '-');
            if (keyword !== '') {
                filter.html('').append('<li class="header">Menu & Apps</li>').show();
                menu.hide();
                $('.list-menu').each(function () {
                    let key = $(this).data('key');
                    if (key.indexOf(keyword.toLowerCase()) > -1) {
                        let item = $(this).clone();
                        if(item.find('a').length > 0){
                            filter.append(item);
                        }else{
                            filter.append($(this).parent().clone());
                        }
                    }
                });
            } else {
                filter.html('').hide();
                menu.show();
                $(this).val('').focus().attr('placeholder', 'Type to search ...');
            }
        });
    });

    function sidebarMenu() {
        $.ajax({
            url: '{!! url(config('master.app.url.backend').'/menu/list-menu') !!}',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('.filtered').html('').append('<li class="header">Menu & Apps</li>').hide();
                $('.all-menu').html('');
                $.each(response.menu, function (index, value) {
                    if (value.access_children.length > 0) {
                        $('.all-menu').append(menuChild(value.access_children, value));
                    } else {
                        $('.all-menu').append(`
                                <li class="list-menu" data-key="${value.code.toLowerCase()}">
                                    <a href="{!! url(config('master.app.url.backend')) !!}/${value.url}"><i class="${value.icon}"></i> <span>${value.title}</span></a>
                                </li>
                            `);
                    }
                });
                openActiveMenu();
            },
            error: function (e) {
                console.log('Error load menu : ', e.responseJSON.message);
            }
        });

        const menuChild = function (children, value) {
            let html = '<li class="treeview parent-menu">';
            html += `<a href="#" class="list-menu" data-key="${value.code.toLowerCase()}"><i class="${value.icon}"></i><span>${value.title}</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>`;
            html += '<ul class="treeview-menu">';
            $.each(children, function (index, child) {
                if (child.access_children.length > 0) {
                    html += menuChild(child.access_children, child);
                } else {
                    html += `<li><a href="{!! url(config('master.app.url.backend')) !!}/${child.url}" class="list-menu" data-key="${child.code.toLowerCase()}"><i class="${child.icon}"></i>${child.title}</a></li>`;
                }
            });
            html += '</ul></li>';
            return html;
        }

        const openActiveMenu = function () {
            let url = window.location.href;
            let urlSplit = url.split('/');
            let lastUrl = urlSplit[urlSplit.length - 1];
            let menu = $('.parent-menu');
            let parentMenu = [];
            menu.each(function () {
                let submenu = $(this).find('.list-menu');
                parentMenu.push($(this));
                submenu.each(function () {
                    let code = $(this).attr('data-key');
                    if (code !== undefined) {
                        if (code === lastUrl) {
                            $(this).parent().addClass('active');
                            $.each(parentMenu, function (index, value) {
                                value.addClass('active menu-open');
                                value.parent().parent().addClass('active menu-open');
                            });
                        }
                    }
                });
                parentMenu.pop();
            });
        };

        $(document).on('click', '[data-toggle="control-sidebar"]', function () {
            let page = $(this).data('page') ?? null;
            if (page !== null) {
                $.ajax({
                    url: '{!! url(config('master.app.url.backend').'/question/page') !!}/'+$(this).data('page'),
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function(){
                        $('.control-sidebar .tab-content .media-list').html("<p class='text-center'>Loading...</p>")
                    },
                    success: function (response) {
                        $('.control-sidebar .tab-content .media-list').html('');
                        $.each(response.data,function(i,v){
                            $('.control-sidebar .tab-content .media-list').append(`
                                <div class="media py-5 px-0">
                                    <p class="pt-1 fa fa-info-circle"></p>
                                    <p class="media-body"><a target="_blank" href="{!! url(config('master.app.url.backend').'/question') !!}/${v.id}">${v.title}</a></p>
                                </div>
                            `);
                        });
                    },
                    error: function (e) {
                        $('.control-sidebar .tab-content .media-list').html("<p class='text-center'>Error load faq</p>");
                    }
                });
            }
        });
    }

    function logout() {
        swal({
            title: 'Are you sure?',
            text: "You will be logged out from the system!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            dangerMode: true,
        }, function (willLogout) {
            if (willLogout) {
                $.ajax({
                    url: '{!! url(config('master.app.url.backend').'/logout') !!}',
                    type: 'POST',
                    data: {
                        _token: '{!! csrf_token() !!}',
                        device: `web`
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 200) {
                            window.location.href = "{!! url('login') !!}";
                        }
                    }
                });
            }
        });
    }
{{--</script>--}}
