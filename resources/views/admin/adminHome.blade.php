@extends('admin.layouts.app')

@section('content')
    <div class="main-panel" id="main-panel">
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body" style="margin: 20px;">
                            <h2 class="card-title text-success text-uppercase" style="margin-bottom: 30px;"> <b>Xin chào, {{Auth::user()->name}}</b></h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg3.jpg')}});">
                                        <h4 class="text-white">Quản lý tài khoản người dùng</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('user.index')}}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg1.jpg')}});">
                                        <h4 class="text-white">Quản lý tài khoản bán hàng</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('seller.index')}}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg2.jpg')}});">
                                        <h4 class="text-white">Quản lý loại sản phẩm</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('category.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg4.jpg')}});">
                                        <h4 class="text-white">Quản lý sản phẩm</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('product.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg5.jpg')}});">
                                        <h4 class="text-white">Quản lý thương hiệu</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('brand.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-image: url({{asset('img/bg6.jpg')}});">
                                        <h4 class="text-white">Quản lý thuộc tính</h4>
                                        <p class="text-white"></p>
                                        <a href="{{ route('attribute') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();
        });

    </script>
@endsection

{{--<script>--}}
{{--  $(document).ready(function() {--}}
{{--      $(".tab").removeClass("active");--}}
{{--      // $(".tab").addClass("active"); // instead of this do the below--}}
{{--      $("#tab-1").addClass("active");--}}
{{--  });--}}
{{--</script>--}}
{{--@endsection--}}
