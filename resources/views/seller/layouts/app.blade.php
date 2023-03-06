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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">//cái này gây ra lỗi font--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
{{--    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"--}}
{{--          rel="Stylesheet"type="text/css"/>--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @stack('styles')

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

{{--    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>--}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('javascript')

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/seller.css') }}" rel="stylesheet" />


</head>
<body class="hold-transition sidebar-mini">
<div class=""> {{--có wrapper bị lỗi nền trắng--}}
    {{--nav--}}
    <div class="sidebar" data-color="blue">
        <div class="logo">
            <a class="simple-text logo-mini">
                <img class="avatar border-gray" style="border-radius: 50%;"
                     src="{{(isset(Auth::user()->avatar)) ? (config('app.url_image'). 'storage/users-avatar/'. Auth::user()->avatar) :
                (config('app.url_image'). 'storage/users-avatar/'. 'default-avatar.png')}}" alt="avatar">
            </a>
            <span class="simple-text logo-normal">
            <a class="admin-home" href="#"><b title="Trang chủ">{{Auth::user()->name}}</b></a>&nbsp; &nbsp;
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-lg" title="Đăng xuất" data-fa-transform="shrink-8 down-6"></i></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </span>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav sidebar-menu" data-widget="tree">
                <li class="tab" id="tab-1">
                    <a href="{{ route('sellerHome') }}">
                        <i class="fa fa-dashboard"></i>
                        <p>Thống kê</p>
                    </a>
                </li>
                <li class="tab" id="tab-2">
                    <a href="{{route('profileSeller')}}">
                        <i class="fa fa-vcard"></i>
                        <p>Hồ sơ nhà bán hàng</p>
                    </a>
                </li>
                @if(!auth()->user()->id_social)
                    <li class="tab" id="tab-3">
                        <a href="{{route('changePwdSeller')}}">
                            <i class="fa fa-lock"></i>
                            <p>Đổi mật khẩu</p>
                        </a>
                    </li>
                @endif

                <li class="tab" id="tab-4">
                    <a href="{{ route('productSeller.create') }}">
                        <i class="fa fa-plus-square"></i>
                        <p>Thêm sản phẩm</p>
                    </a>
                </li>
                <li class="tab" id="tab-5">
                    <a href="{{route('productSeller.index')}}">
                        <i class="fa fa-shopping-bag"></i>
                        <p>Quản lý sản phẩm</p>
                    </a>
                </li>

                <li class="tab" id="tab-6">
                   <a href="{{route('order.index')}}"> {{-- {{route('productSeller.show')}}--}}
                        <i class="fa fa-gift"></i>
                        <p>Quản lý đơn đặt hàng</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{--container--}}
    <main>
        @yield('content')
    </main>
</div>
    <!-- Chart JS -->
    <script  type="text/javascript" src="{{asset('js/chartjs.min.js')}}" defer></script>
    <!--  Notifications Plugin    -->
    <!--<script src="../assets/js/plugins/bootstrap-notify.js"></script>-->
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script type="text/javascript" src="{{asset('js/seller.js')}}" defer></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script type="text/javascript" src="{{asset('js/demo.js')}}" defer></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            // $(".tab").click(function () {
            // $(".tab").removeClass("active");
            // // $(".tab").addClass("active"); // instead of this do the below
            // $(this).addClass("active");
            // });
        });

    </script>
    <script type="text/javascript">
        var fade_out = function() {
            $(".alert-block").hide(1000);

        };
        setTimeout(fade_out, 10000);

    </script>

    @if($commit = Session::get('commit'))
        <script>
            alert('{{$commit}}');
        </script>
    @endif
</body>
</html>
