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
                            <h2 class="card-title text-success text-uppercase" style="margin-bottom: 30px;"> <b>Quản lý thuộc tính</b></h2>
                            <div class="row">
                                <div class="col-md-4"> {{-- {{ route('attribute') }} --}}
                                    <div class="card card-body" style="background-color: #2ed573">
                                        <h4 class="text-white">Quản lý mã màu</h4>
                                        <p class="text-white">Hiển thị thông tin màu sắc của sản phẩm</p>
                                        <a href="{{ route('color.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-color: #8965e0;">
                                        <h4 class="text-white">Quản lý bộ nhớ</h4>
                                        <p class="text-white">Hiển thị thông tin bộ nhớ của sản phẩm</p>
                                        <a href="{{ route('memory.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-color: #1e90ff;">
                                        <h4 class="text-white">Quản lý kích cỡ</h4>
                                        <p class="text-white">Hiển thị thông tin kích cỡ của sản phẩm</p>
                                        <a href="{{ route('size.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-color: #ff6348;">
                                        <h4 class="text-white">Quản lý kích thước</h4>
                                        <p class="text-white">Hiển thị thông tin kích thước, độ dài của sản phẩm</p>
                                        <a href="{{ route('dimension.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-body" style="background-color: #ffa502;">
                                        <h4 class="text-white">Quản lý thể tích, trọng lượng, diện tích</h4>
                                        <p class="text-white">Hiển thị thông tin thể tích, khối lượng, dung lượng, diện tích của sản phẩm</p>
                                        <a href="{{ route('volume.index') }}" class="text-white">Xem</a>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="me-md-3 me-xl-5">--}}
{{--            <h2>Quản lý thuộc tính</h2>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="card card-body  bg-primary text-white mb-3">--}}
{{--                    <label>Quản lý mã màu</label>--}}
{{--                    <a href="{{ route('color.index') }}" class="text-white"></a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
