@extends('seller.layouts.app')

@push('javascript')
    <script src="{{config('app.key_tiny')}}" referrerpolicy="origin"></script>
{{--    <script src="https://cdn.tiny.cloud/1/4r7wne3vt2vooka291s9beziyj4dij9bxso4ftvmg81k1t6t/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>    --}}
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endpush
@section('content')
    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="{{route('home')}}" title="Đến trang chủ" style="font-size: 17px;"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>
                    
                    <ul class="nav navbar-nav" id="notify-menu">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="{{url('/chatify')}}" class="dropdown-toggle" style="font-size: 17px;">
                                <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i>
                                @if($wait_mess = \App\Models\ChMessage::where(['to_id'=>Auth::user()->id, 'seen'=> '0'])->count())
                                        @if($wait_mess > 0)
                                            <span class="label label-success label-float">
                                                {{$wait_mess}}
                                            </span>
                                        @endif
                                    @endif

                            </a>
                            
                        </li>
                    </ul>

                    <ul class="nav navbar-nav" id="notify-menu">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o fa-lg"></i>
                                <span class="label label-success label-float">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#" class="lineMessage">
                                                <div class="pull-left">
                                                    <img src="./img/user2-160x160.jpg" class="img-circle"
                                                         alt="User Image">
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        <li>
                                            <a href="#" class="lineMessage">
                                                <div class="pull-left">
                                                    <img src="./img/user3-128x128.jpg" class="img-circle"
                                                         alt="User Image">
                                                </div>
                                                <h4>
                                                    AdminLTE Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="lineMessage">
                                                <div class="pull-left">
                                                    <img src="./img/user4-128x128.jpg" class="img-circle"
                                                         alt="User Image">
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="lineMessage">
                                                <div class="pull-left">
                                                    <img src="./img/user4-128x128.jpg" class="img-circle"
                                                         alt="User Image">
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="SeeAll footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o fa-lg"></i>
                                <span class="label label-warning">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#" class="lineMessage">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="SeeAll footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->

                        <!-- User Account: style can be found in dropdown.less -->
                        <!-- Control Sidebar Toggle Button -->
                    </ul>

                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                </button>
            </div>
        </nav>
    </div>
    <div class="main-panel" id="main-panel">
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('productSeller.index')}}" class="text-primary"><i class="fa fa-solid fa-2x fa-angle-left"></i></a>
                    <form novalidate action="{{route('productSeller.update',$product->id)}}" enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PUT')
                        {{--Chia ra làm 2 part--}}
                        {{--1. Thông tin chung--}}
                        @include('flash-message')
                        <div class="row justify-content-md-center">
                            <div class="col-md col-sm col-xs">
                                <div class="form-group">
                                    <label><b>Loại sản phẩm</b></label>
                                    <select name="category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$category->id == $product->category_id ? 'selected':''}}>
                                                {{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><b>Thương hiệu</b></label>
                                    <select name="brand" class="form-control">
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->name}}" {{$brand->name == $product->brand ? 'selected':''}}>
                                                {{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><b>Tên sản phẩm</b></label>
                                    <input name="name" type="text" class="form-control" value="{{$product->name}}" required placeholder="Tên sản phẩm">
                                </div>

                                <div class="form-group" style="padding-top: 10px;">
                                    <label><b>Tiêu đề hiển thị</b></label>
                                    <h6>{!! $product->tittle !!}</h6>
                                </div>
                            </div>
                            <div style="border-left: 1px solid rgb(114, 114, 114); height: 310px;">
                            </div>
                            <div class="col-md col-sm col-xs">
                                <div class="form-group">
                                    <label class="form-label"><b>Giá bán ban đầu</b></label>
                                    <input name="original_price" placeholder="Giá bán ban đầu" type="number" class="form-control" value="{{$product->original_price}}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><b>Giá bán khi giảm</b></label>
                                    <input name="selling_price" placeholder="Giá bán khi giảm" type="number" class="form-control" value="{{$product->selling_price}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title"><b>Số lượng</b></label>
                                    <input type="text" class="form-control" id="meta_title" name="qty" placeholder="Số lượng" value="{{$product->qty}}" maxlength="9" >
                                </div>
                                <div class="form-group">
                                    
                                    <input type="checkbox" name="status" {{$product->status === 1 ? 'checked':''}}>
                                    <label for="status">Trạng thái</label>
                                    <br>
                                    
                                    <input type="checkbox" name="trending" {{$product->trending === 1 ? 'checked':''}}>
                                    <label for="trending">Xu hướng</label>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="meta_keywords">Từ khóa tìm kiếm (vd: áo đẹp, giày xanh,...)</label>--}}
{{--                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Từ khóa tìm kiếm" value="{{$product->meta_keywords}}" />--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        {{--Cần xử lý được các thuộc tính name khác nhau (dạng radio) r lưu về cùng 1 mảng trc khi đưa vào csdl--}}
                        @php
                            $attributes = json_decode($product->attributes ?? '');
                            //dd($attributes);
                        @endphp
                        <div class="form-group">
                            <label><b>Màu sắc <span style="font-style: italic; color: red;">(* Nếu có)</span></b></label>
                            <div class="row">
                                @forelse($colors as $colorItem)
                                    <div class="col-md-1 text-center">
                                        <div class="p-2 border mb-3">
                                            <label>
                                                @if($attributes)
                                                    <input type="checkbox" name="attribute[]" value="{{ $colorItem->id }}" {{in_array($colorItem->id,$attributes) ? 'checked' : ''}}/>
                                                    <i class="fa fa-paint-brush" style="font-size:24px;color:{{$colorItem->value}};"></i>
                                                @else
                                                    <input type="checkbox" name="attribute[]" value="{{ $colorItem->id }}"/>
                                                    <i class="fa fa-paint-brush" style="font-size:24px;color:{{$colorItem->value}};"></i>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <p>Không có màu nào.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group">
                            <label><b>Kích cỡ <span style="font-style: italic; color: red;">(* Nếu có)</span> </b></label>
                            <div class="row">
                                @forelse($sizes as $sizeItem)
                                    <div class="col-md-1">
                                        <div class="p-2 border mb-3">
                                            <label>
                                                @if($attributes)
                                                    <input type="checkbox" name="attribute[]" value="{{ $sizeItem->id }}"
                                                        {{in_array($sizeItem->id,$attributes) ? 'checked' : ''}}
                                                    />
                                                    {{$sizeItem->value}}
                                                @else
                                                    <input type="checkbox" name="attribute[]" value="{{ $sizeItem->id }}"
                                                    />
                                                    {{$sizeItem->value}}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <p>Không có kích cỡ nào.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="row justify-content-md-center">
                            <div class="col-md col-sm col-xs">
                                <div class="form-group">
                                    <label><b>Kích thước <span style="font-style: italic; color: red;">(* Nếu có)</span> </b><br>
                                        <small>Kích thước sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>
        
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="dimension" class="input-select">
                                                <option value="">
                                                    Chọn Kích thước
                                                </option>
                                                @forelse($dimensions as $dimensionItem)
                                                    @if($attributes)
                                                        <option value="{{$dimensionItem->id}}" {{in_array($dimensionItem->id,$attributes) ? 'selected' : ''}}>
                                                            {!! $dimensionItem->value !!}
                                                        </option>
                                                    @else
                                                        <option value="{{$dimensionItem->id}}">
                                                            {!! $dimensionItem->value !!}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><b>Bộ nhớ <span style="font-style: italic; color: red;">(* Nếu có)</span> </b>
                                        <br>
                                        <small>Bộ nhớ sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="memory" class="input-select">
                                                <option value="">
                                                    Chọn Bộ nhớ
                                                </option>
                                                @forelse($memories as $memoryItem)
                                                    @if($attributes)
                                                        <option value="{{$memoryItem->id}}" {{in_array($memoryItem->id,$attributes) ? 'selected' : ''}}>
                                                            {!! $memoryItem->value !!}
                                                        </option>
                                                    @else
                                                        <option value="{{$memoryItem->id}}">
                                                            {!! $memoryItem->value !!}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div style="border-left: 1px solid rgb(114, 114, 114); height: 220px;">
                            </div>
                            <div class="col-md col-sm col-xs">
                                <div class="form-group">
                                    <label><b>Thể tích/trọng lượng/diện tích <span style="font-style: italic; color: red;">(* Nếu có)</span></b>
                                        <br>
                                        <small>Thể tích/trọng lượng/diện tích sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="volume" class="input-select">
                                                <option value="">
                                                    Chọn Thể tích/trọng lượng/diện tích
                                                </option>
                                                @forelse($volumes as $volumeItem)
                                                    @if($attributes)
                                                        <option value="{{$volumeItem->id}}" {{in_array($volumeItem->id,$attributes) ? 'selected' : ''}}>
                                                            {!! $volumeItem->value !!}
                                                        </option>
                                                    @else
                                                        <option value="{{$volumeItem->id}}">
                                                            {!! $volumeItem->value !!}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Thuộc tính khác <span style="font-style: italic; color: red;">(* Nếu có)</span></b></label><br>
                                    <small>Mỗi sản phẩm chỉ được nhập một "Thuộc tính khác", thuộc tính này mặc định luôn có trong sản phẩm.</small><br>
                                    <input name="other_attribute" type="text" class="form-control" placeholder="Thuộc tính khác" value="{{$product->other_attribute}}">
                                </div>

                                
                            </div>
                        </div>


                        {{--2. Mô tả chi tiết--}}
                        <div class="mb-3">
                            <label class="form-label"><b>Hình ảnh</b></label>
                            <input name="image[]" id="file-upload-button" type="file" accept="image/*" class="form-control"
                                   required multiple>
                        </div>
                        <div>
                            @if($product->productImages)
                                <div class="row">
                                    @foreach($product->productImages as $image)
                                        <div class="col-md-2">
                                            <img src="{{url($image->image)}}" alt='Img'
                                                 width="80px" height="80px" class="me-4"/>
                                            <a href="{{route('productImageDelSeller',$image->id)}}" class="d-block text-danger">Xóa</a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h5>Không có ảnh</h5>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>Mô tả chi tiết sản phẩm</b></label>
                            <textarea class="form-control" name="description">{{$product->description}}</textarea>
                        </div>

                        <div class="modal-footer justify-content-md-start">
                            <input type="submit" class="btn btn-success" value="Lưu lại">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".tab").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-5").addClass("active");
        });
    </script>

@endsection
