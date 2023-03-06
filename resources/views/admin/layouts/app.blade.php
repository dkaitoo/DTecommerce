<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href= "{{url('/img/logoStore.png')}}">

    <title>DT Ecommerce</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    @stack('styles')
    <!-- Nucleo Icons -->
    <link href="{{asset('/css/nucleo-icons.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('/css/black-dashboard.css?v=1.0.0')}}" rel="stylesheet" />
    <link href="{{ asset('/demo/demo.css')}}" rel="stylesheet" />

    <!-- Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('javascript')

</head>
<body class="white-content">
<div class="wrapper">
    <div class="sidebar">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
      -->
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="javascript:void(0)" class="simple-text logo-mini">
                    DT
                </a>
                <a href="javascript:void(0)" class="simple-text logo-normal">
                    Creative Thai
                </a>
            </div>
            <ul class="nav">
                <li class="{{(Request::is('admin') or Request::is('admin/dashboard')) ? 'active' : ''}}">
                    <a href="{{ route('dashboard') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/user') ? 'active' : ''}}">
                    <a href="{{ route('user.index')}}">
                        <i class="fa fa-users"></i>
{{--                        <i class="tim-icons icon-atom"></i>--}}
                        <p>Tài khoản người dùng</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/seller') ? 'active' : ''}}">
                    <a href="{{ route('seller.index')}}">
                        <i class="tim-icons icon-bank"></i>
                        <p>Tài khoản bán hàng</p>
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a href="./notifications.html">--}}
{{--                        <i class="tim-icons icon-bell-55"></i>--}}
{{--                        <p>Notifications</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="{{Request::is('admin/profile') ? 'active' : ''}}">
                    <a href="{{route('profileAdmin')}}">
                        <i class="tim-icons icon-badge"></i>
                        <p>Hồ sơ cá nhân</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/category') ? 'active' : ''}}">
                    <a href="{{ route('category.index') }}">
                        <i class="tim-icons icon-tag"></i>
                        <p>Quản lý loại sản phẩm</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/product') ? 'active' : ''}}">
                    <a href="{{ route('product.index') }}">
                        <i class="tim-icons icon-app"></i>
                        <p>Quản lý sản phẩm</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/brand') ? 'active' : ''}}">
                    <a href="{{ route('brand.index') }}">
                        <i class="tim-icons icon-atom"></i>
                        <p>Quản lý thương hiệu</p>
                    </a>
                </li>
                <li class="{{Request::is('admin/attribute','admin/attribute/color','admin/attribute/size','admin/attribute/dimension','admin/attribute/volume','admin/attribute/memory') ? 'active' : ''}}">
                    <a href="{{ route('attribute') }}">
                        <i class="tim-icons icon-vector"></i>
                        <p>Quản lý thuộc tính</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle d-inline">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
{{--                    @yield('title')--}}
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse" id="navigation" style="background-color: pink;">

                    <ul class="navbar-nav ml-auto" >
                        <li class="dropdown nav-item">
                            <a href="{{url('/chatify')}}" class="dropdown-toggle nav-link">
                                <i class="tim-icons icon-chat-33 text-black"></i>
                                @if($wait_mess = \App\Models\ChMessage::where(['to_id'=>Auth::user()->id, 'seen'=> '0'])->count())
                                    @if($wait_mess > 0)
                                        <div class="notification"></div>
                                    @endif
                                @endif
                            </a>
                        </li>
{{--                        <li class="search-bar input-group">--}}
{{--                            <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split" ></i>--}}
{{--                                <span class="d-lg-none d-md-block">Search</span>--}}
{{--                            </button>--}}
{{--                        </li>--}}
                        @if($seller_isApproved > 0 )
                        <li class="dropdown nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <div class="notification d-none d-lg-block d-xl-block"></div>
                                <i class="tim-icons icon-sound-wave"></i>
                                <p class="d-lg-none">
                                    Thông báo
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">

                                <li class="nav-link"><a href="{{route('seller.index')}}" class="nav-item dropdown-item">Có <b>{{ $seller_isApproved }}</b>
                                    Tài khoản đăng ký bán hàng cần được phê duyệt.</a>
                                </li>
                                {{--<li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">You have 5 more tasks</a></li>--}}
                            </ul>
                        </li>
                        @else
                            <li class="dropdown nav-item" >
                                <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <div class="d-none d-lg-block d-xl-block"></div>
                                    <i class="tim-icons icon-sound-wave"></i>
                                    <p class="d-lg-none">
                                        Thông báo
                                    </p>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                                    <li class="nav-link"><a href="#" class="nav-item dropdown-item">Không có thông báo nào.</a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown nav-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <div class="photo">
                                    <img src="{{ config('app.url_image'). 'storage/users-avatar/'. Auth::user()->avatar ?? 'default-avatar.png'}}" alt="Profile Photo">
                                </div>
                                <b class="caret d-none d-lg-block d-xl-block"></b>
{{--                                <p class="d-lg-none">--}}
{{--                                </p>--}}
{{--                                <a class="d-lg-none" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>--}}

                            </a>
                            <ul class="dropdown-menu dropdown-navbar">
                                <li class="nav-link"><a href="{{route('profileAdmin')}}" class="nav-item dropdown-item">Hồ sơ</a></li>
                                <li class="nav-link"><a href="{{ route('changePwdAdmin')}}" class="nav-item dropdown-item">Đổi mật khẩu</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="nav-link">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item dropdown-item">Đăng xuất</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="separator d-lg-none"></li>
                    </ul>
                </div>
            </div>
        </nav>
{{--        <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">--}}
{{--            <div class="modal-dialog" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <i class="tim-icons icon-simple-remove"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- End Navbar -->

        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>2022 made <i class="tim-icons icon-heart-2"></i> by
                    <a href="javascript:void(0)" target="_blank">Thai</a>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title"> Sidebar Background</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors text-center">
                        <span class="badge filter badge-primary active" data-color="primary"></span>
                        <span class="badge filter badge-info" data-color="blue"></span>
                        <span class="badge filter badge-success" data-color="green"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line text-center color-change">
{{--                <span class="color-label">LIGHT MODE</span>--}}
{{--                <span class="badge light-badge mr-2"></span>--}}
{{--                <span class="badge dark-badge ml-2"></span>--}}
{{--                <span class="color-label">DARK MODE</span>--}}
            </li>
        </ul>
    </div>
</div>
<script src="{{asset('/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<!-- Chart JS -->
<script src="{{asset('/js/plugins/chartjs.min.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('/js/plugins/bootstrap-notify.js')}}"></script>
<script src="{{asset('/js/black-dashboard.min.js')}}"></script>
<!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('/demo/demo.js')}}"></script>
<script>
    $(document).ready(function() {
        $().ready(function() {
            $sidebar = $('.sidebar');
            $navbar = $('.navbar');
            $main_panel = $('.main-panel');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');
            sidebar_mini_active = true;
            white_color = false;

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



            $('.fixed-plugin a').click(function(event) {
                if ($(this).hasClass('switch-trigger')) {
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                }
            });

            $('.fixed-plugin .background-color span').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data', new_color);
                }

                if ($main_panel.length != 0) {
                    $main_panel.attr('data', new_color);
                }

                if ($full_page.length != 0) {
                    $full_page.attr('filter-color', new_color);
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.attr('data', new_color);
                }
            });

            $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                var $btn = $(this);

                if (sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    sidebar_mini_active = false;
                    blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
                } else {
                    $('body').addClass('sidebar-mini');
                    sidebar_mini_active = true;
                    blackDashboard.showSidebarMessage('Sidebar mini activated...');
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                    clearInterval(simulateWindowResize);
                }, 1000);
            });

            $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                var $btn = $(this);

                if (white_color == true) {

                    $('body').addClass('change-background');
                    setTimeout(function() {
                        $('body').removeClass('change-background');
                        $('body').removeClass('white-content');
                    }, 900);
                    white_color = false;
                } else {

                    $('body').addClass('change-background');
                    setTimeout(function() {
                        $('body').removeClass('change-background');
                        $('body').addClass('white-content');
                    }, 900);

                    white_color = true;
                }
            });

            $('.light-badge').click(function() {
                $('body').addClass('white-content');
            });

            $('.dark-badge').click(function() {
                $('body').removeClass('white-content');
            });
        });
        // trong cái profileUser ở sql thêm thuộc tính làm sao để khi tới trang này nó bik màu trắng hay đen, màu như thế nào...
    });
</script>

@yield('js-dashboard')

<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script>
    window.TrackJS &&
    TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
    });
</script>
<script type="text/javascript">
    var fade_out = function() {
        $(".alert-block").hide(1000);

    };
    setTimeout(fade_out, 10000);

</script>

</body>
</html>
