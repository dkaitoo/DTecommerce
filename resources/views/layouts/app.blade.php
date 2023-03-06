<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('img/DT-Ecom.png')}}">
    <title>DT Ecommerce</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap -->
    @stack('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
{{--    <link rel="stylesheet" href="/resources/demos/style.css">--}}
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <style>
        /* rating */
        .rating-css div {
            color: #FA5571;
            font-size: 30px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            padding: 20px 0;
        }
        .rating-css input {
            display: none;
        }
        .rating-css input + label {
            font-size: 30px;
            text-shadow: 1px 1px 0 #922f39;
            cursor: pointer;
        }
        .rating-css input:checked + label ~ label {
            color: #b4afaf;
        }
        .rating-css label:active {
            transform: scale(0.8);
            transition: 0.3s ease;
        }
        #search-form {
            color: #555;
            display: flex;
            /*padding: 2px;*/
            /*border: 1px solid currentColor;*/
            border-radius: 5px;
            padding-right: 20px;
        }
        input[type="search"] {
            border: none;
            background: transparent;
            margin: 0;
            padding: 7px 8px;
            font-size: 14px;
            color: inherit;
            border: 1px solid transparent;
            border-radius: inherit;
        }

        #search-form input[type="search"]::placeholder {
            color: #bbb;
        }
        #search-form button[type="submit"] {
            text-indent: -999px;
            overflow: hidden;
            width: 40px;
            padding: 0;
            margin: 0;
            border: 1px solid transparent;
            border-radius: inherit;
            background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat center;
            cursor: pointer;
            opacity: 0.7;
            position: absolute;
            bottom: 10px;
            right: 20px;
        }

        #search-form button[type="submit"]:hover {
            opacity: 1;
        }
        #search-form button[type="submit"]:focus,
        #search-form input[type="search"]:focus {
            box-shadow: 0 0 3px 0 #1183d6;
            border-color: #1183d6;
            outline: none;
        }
        #ui-id-1{
            background-color: white;
            width: 100px;
            height: 200px;
            border-radius: 20px;
        }
        .ui-menu-item {
            color: black;
            margin-left: 10px;
            padding-top: 10px;
        }
        .ui-menu{
            z-index: 3500 !important;
        }

        .product-name {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        }
    </style>

    @stack('javascript')
</head>
<body>
    <div id="app">
        <!-- HEADER -->
        <header>
            <!-- TOP HEADER -->
            <!-- /TOP HEADER -->

            <!-- MAIN HEADER -->
            <div id="header">
                <!-- container -->
                <div class="container">
                    <!-- row -->
                    <div class="row">
                        <!-- LOGO -->
                        <div class="col-md-3">
                            <div class="header-logo">
                                <a class="logo" href="{{ url('/') }}">
                                    <img src="{{asset('./img/logo2.png')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- /LOGO -->

                        <!-- SEARCH BAR -->
                        <div class="col-md-6">
                            <div class="header-search ">
                                <form id="search-form" method="Post" action="{{route('searchPost')}}">
                                    @csrf
                                    <input type="hidden" name="postSearch" value="postSearch">
                                    <input class="form-control" id="input-search" name="product_name"
                                           placeholder="Nhập gì đó để tìm kiếm.." style="width: 100%;"
                                           @if (Session::has('search_key'))
                                                value="{{Session::get('search_key')}}"
                                           @endif
                                    >
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <!-- /SEARCH BAR -->

                        <!-- ACCOUNT -->
                        <div class="col-md-12 col-lg-3" style="padding-left: 0px; padding-right: 0px;">
                            <div class="header-ctn" style="padding-top: 20px;">
                                @guest
                                    <ul class="header-links pull-left">
                                    <!-- Authentication Links -->

                                        @if (Route::has('login'))
                                            <li class="nav-item" style="margin-top: 5px;">

                                                <a class="nav-link" href="{{ route('login') }}" style="color: white; font-size: 1.25em;"> <i class="fa fa-user" aria-hidden="true" style="font-size: 24px; color: white;"></i>Đăng nhập</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li class="nav-item" style="margin-top: 5px;">
                                                <a class="nav-link" href="{{ route('register') }}" style="color: white; font-size: 1.25em;"><i class="fa fa-user-plus" aria-hidden="true" style="font-size: 24px; color: white;"></i>Đăng ký</a>
                                            </li>
                                        @endif
                                    </ul>
                                @else
                                    <div>
                                        <a href="{{url('/chatify')}}">
                                            <i class="fa fa-comments-o" aria-hidden="true" style="font-size: 22px;"></i>
                                            <span>Tin nhắn</span>
                                            {{--Người đến có xem tin chưa?--}}
                                            @if($wait_mess = \App\Models\ChMessage::where(['to_id'=>Auth::user()->id, 'seen'=> '0'])->count())
                                                @if($wait_mess > 0)
                                                    <div class="qty">{{$wait_mess}}</div>
                                                @endif
                                            @endif
                                        </a>
                                    </div>
                                    <div>
                                        @if(Auth::user()->role === 'user')
                                            <a href="{{route('cart.index')}}">
                                                <i class="fa fa-shopping-cart" style="font-size: 22px;"></i>
                                                <span>Giỏ hàng</span>
                                                @if($count_cart = App\Models\Cart::where(['user_id'=>Auth::user()->id])->count())
                                                    @if($count_cart > 0)
                                                        <div id="qty-cart" class="qty">{{$count_cart}}</div>
                                                    @endif
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                    <ul class="header-links pull-right">
                                        <li class="nav-item dropdown text-center">
                                            <span style="color: white; font-size: 1.25em;">Xin chào,</span> <br>
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <b style="color: #fddd6b; font-size: 1.25em;">
                                                    {{ explode(' ', Auth::user()->name)[count(explode(' ', Auth::user()->name))-1]}}
                                                </b>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="background-color: #27986e; border-radius: 8px;">
                                                @if(Auth::user()->role === 'seller')
                                                    {{--La seller--}}
                                                    <a href="{{route('sellerHome')}}" style="margin-right: 10px;"><i class="fa fa-shopping-basket" aria-hidden="true" style="padding: 7px 0 7px 0px; margin-bottom: 8px;"></i>Vào Cửa hàng</a>
                                                @elseif(Auth::user()->role === 'admin')
                                                    {{--La admin--}}
                                                    <a href="{{route('dashboard')}}" style="margin-right: 10px;"><i class="fa fa-shopping-basket" aria-hidden="true" style="padding: 7px 0 7px 0px; margin-bottom: 8px;"></i>Vào Hệ thống</a>
                                                @elseif(Auth::user()->role === 'user')
                                                {{--Dang cho duyet hoac bi tat chuc nang ban hang tro thanh khach hang--}}
                                                <a href="{{route('sellerForm')}}"><i class="fa fa-dollar" style="padding: 7px 0 7px 3px; margin-bottom: 8px;"></i>Đăng ký bán hàng</a>
                                                <a href="{{route('profileClient')}}"><i class="fa fa-user-circle-o" aria-hidden="true" style="padding: 7px 0 7px 0px; margin-bottom: 8px;"></i>Thông tin tài khoản</a>
                                                <br>
                                                @endif

                                                <a href="{{ route('logout') }}" style="padding: 7px 0 7px 0;"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out"></i>Đăng xuất
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    </ul>

                                @endguest
                                <!-- Cart -->

                                <!-- /Cart -->
                            </div>
                        </div>
                        <!-- /ACCOUNT -->
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- /MAIN HEADER -->
        </header>
        <!-- /HEADER -->

        <!-- NAVIGATION -->
        <nav id="navigation">
            <!-- container -->
            <div class="container">
                <!-- responsive-nav -->
                <div id="responsive-nav">
                    <!-- NAV -->
                    <ul class="main-nav nav navbar-nav">
                        <li class=""><a href="{{route('home')}}">Trang chủ</a></li>
{{--                        <li><a href="#">Hot Deals</a></li>--}}
                        @foreach($categories as $category)
                            <li><a href="{{route('getByCategory',$category->id)}}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                    <!-- /NAV -->
                </div>
                <!-- /responsive-nav -->
            </div>
            <!-- /container -->
        </nav>
        <!-- /NAVIGATION -->

        <main class="py-4">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer id="footer">
            <!-- top footer -->
            <div class="section">
                <!-- container -->
                <div class="container">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Về chúng tôi</h3>
                                <p>Dự án CNTT2 của nhóm 2 sinh viên năm 4 HK1 2022</p>
                                <ul class="footer-links">
                                    <li><a><i class="fa fa-map-marker"></i>TDTU</a></li>
                                    <li><a><i class="fa fa-phone"></i>51900053-51900214</a></li>
                                    <li><a><i class="fa fa-envelope-o"></i>admin@gmail.com</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Danh mục</h3>
                                <ul class="footer-links">
                                    @foreach($categories as $category)
                                        @if($loop->index == 4)
                                            @break
                                        @endif
                                        <li><a href="{{route('getByCategory',$category->id)}}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="clearfix visible-xs"></div>

                        <div class="col-md-3 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Hỗ trợ khách hàng</h3>
                                <ul class="footer-links">
                                    <li><a>Hotline: 1900-6035</a></li>
                                    <li><a>(1000 đ/phút, 8-21h kể cả T7, CN)</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Dịch vụ</h3>
                                <ul class="footer-links">
                                    @guest
                                        <li><a href="{{ route('login') }}">Thông tin tài khoản</a></li>
                                        <li><a href="{{ route('login') }}">Xem giỏ hàng</a></li>
                                        <li><a href="{{ route('login') }}">Nhắn tin</a></li>
                                    @else
                                        <li><a href="{{route('profileClient')}}">Thông tin tài khoản</a></li>
                                        <li><a href="{{route('cart.index')}}">Xem giỏ hàng</a></li>
                                        <li><a href="{{url('/chatify')}}">Nhắn tin</a></li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- /top footer -->

            <!-- bottom footer -->
            <div id="bottom-footer" class="section">
                <div class="container">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <ul class="footer-payments">
                                <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                                <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                                <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                                <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                                <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                                <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                            </ul>
                            <span class="copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- /bottom footer -->
        </footer>
        @if($commit = Session::get('commit'))
            <script>
                alert('{{$commit}}');
            </script>
        @endif
    </div>
    <!-- jQuery Plugins -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript">
        var fade_out = function() {
            $(".alert-block").hide(1000);

        };
        setTimeout(fade_out, 10000);

    </script>
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">--}}
    <script>
        var botmanWidget = {
            chatServer: '{{url('botman')}}', // kênh chat->k dc đổi tên
            frameEndpoint: '{{route('chatbot')}}', // giao diện chat -> k đc đổi tên
            aboutText: 'Chatbot',
            title:'Hộp thoại trả lời tự động DT Chatbot',
            introMessage: 'Xin chào, Tôi là Ari Ecommerce! Quý khách cần giúp gì ạ?',
            mainColor:'#ff6b6b',
            bubbleBackground:'#00b894',
            headerTextColor: '#fff',
            placeholderText: 'Nhập gì đó để hỏi...',
            dateTimeFormat: 'm/d/yy HH:MM',
            bubbleAvatarUrl: '{{asset('img/chatbot.png')}}'
        };
    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>
        $( function() {
            $.ajax({
                method: "GET",
                url: '{{url('/product-list')}}',
                success: function(response){
                    completeSearch(response);
                }
            })

            function completeSearch(availableTags){
                $( "#input-search" ).autocomplete({
                    source: availableTags
                });
            }
        } );
    </script>
</body>
</html>
