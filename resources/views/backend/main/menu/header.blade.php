<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <a href="#" title="{!! config('master.app.profile.name') !!}"
           class="waves-effect waves-green nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent"
           data-toggle="push-menu" role="button">
            <i class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        </a>
        <a href="#" class="logo p-0">
            <div class="logo-lg">
                <i class="light-logo"><img src="{{ url($template).config('master.app.web.logo_light')}}" alt="logo" width="140" ></i>
                <i class="dark-logo"><img src="{{ url($template).config('master.app.web.logo_dark')}}" alt="logo" width="140" ></i>
{{--                <h2 class="light-logo"><span>{{ config('master.app.profile.name') }}</span></h2>--}}
{{--                <h2 class="dark-logo"><span class="text-white">{{ config('master.app.profile.name') }}</span></h2>--}}
            </div>
        </a>
    </div>
    <nav class="navbar navbar-static-top">
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item d-md-none">
                    <a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
                        <i class="icon-Align-left"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>
                    </a>
                </li>
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen" title="Full Screen">
                        <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <li class="btn-group d-lg-inline-flex d-none">
                    <div class="app-menu">
                        <div class="search-bx mx-5">
                            <div class="input-group">
                                <input type="search" class="form-control search-menu" placeholder="Cari menu disini ..." aria-label="Search" aria-describedby="button-addon2" name="search_menu">
                                <div class="input-group-append">
                                    <button class="btn" type="button" id="button-addon3" title="Search"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="Notifications">
                        <div class="icon-Notifications" id="notification-button"><span class="path1"></span><span class="path2"></span></div>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="p-20">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Notifikasi</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger" id="clear-notification">Bersihkan</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <ul class="menu sm-scrol notification-list">
                                {{-- list of notification --}}
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="{!! url(config('master.app.url.backend').'/notification') !!}">Lihat Semua</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="User">
                        <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <a class="dropdown-item btn-action text-center" href="#" data-action="edit"
                               data-url="{{ url(config('master.app.url.backend').'/user') }}" data-title="Profil User"
                               data-id="{{ $user->id }}">
                                <i class="ti-user text-muted me-2"></i>{!! $user->name !!}<br>
                                <span class="fs-12">( {{ $user->level->name }} )</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li class="user-body">
                            <a class="dropdown-item logoutBtn" href="#"><i class="ti-lock text-muted me-2"></i>
                                Sign Out</a>
                        </li>
                    </ul>
                </li>
                {{--<li>--}}
                {{--    <a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect waves-light">--}}
                {{--        <i class="icon-Settings"><span class="path1"></span><span class="path2"></span></i>--}}
                {{--    </a>--}}
                {{--</li>--}}
                <li>
                    <a href="javascript:void(0)" class="switch waves-effect waves-green" id="themeSwitchToggle">
                        <input type="checkbox" id="themeSwitch" data-mainsidebarskin="toggle" style="display: none;">
                        <span class="switch-on font-size-30">
                            <i class="mdi mdi-lightbulb-on"></i>
                        </span>
                        <span class="switch-off font-size-30">
                            <i class="mdi mdi-lightbulb"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
