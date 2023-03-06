@extends('layouts.app')

@section('content')

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{route('home')}}">Trang chủ</a></li>
{{--                        <li><a href="{{route('getByCategory', $product->category->id)}}">{{$product->category->name}}</a></li>--}}
                        <li class="active">Tìm kiếm, lọc sản phẩm</li>
                    </ul>
{{--                    <ul class="breadcrumb-tree">--}}
{{--                        <li><a href="#">Home</a></li>--}}
{{--                        <li><a href="#">All Categories</a></li>--}}
{{--                        <li class="active">Search</li>--}}
{{--                    </ul>--}}
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->

                    <div id="aside" class="col-sm-3">
                        <form action="{{route('searchPost')}}" method="POST">
                            @csrf
                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Danh mục</h3>
                            <div class="checkbox-filter">
                                <div class="checkbox-filter">
                                    @foreach($categories as $category)
                                        <div>
                                            <input type="checkbox" name="category_checked[]"
                                                   id="category-{{$loop->index + 1}}" value="{{$category->id}}"
                                                {{$category->products->count() < 1 ? 'disabled' : ''}}
                                                @if(Session::has('category_filter'))
                                                    {{in_array($category->id, Session::get('category_filter')) ? 'checked' : '' }}
                                                @endif
                                            >
                                            <label for="category-{{$loop->index + 1}}" style="font-weight: normal;">
                                                <span>{{$category->name}}</span>

                                                <small>({{$category->products->count()}})</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Giá tiền</h3>
                            <div class="price-filter">
                                <div id="price-slider"></div>
                                <div class="input-number price-min">
                                    <input name="price_min" id="price-min" type="number" value="{{Session::get('price_min') ?? ''}}">
                                </div>
                                <span>-</span>
                                <div class="input-number price-max">
                                    <input name="price_max" id="price-max" type="number" value="{{Session::get('price_max') ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Thương hiệu</h3>
                            <div class="checkbox-filter" style="height:300px; overflow:auto;">
                                @foreach($brands as $brand)
                                    <div>
                                        <input type="checkbox" name="brand_checked[]" id="brand-{{$loop->index + 1}}"
                                               value="{{$brand->name}}"
                                        @if(Session::has('brand_filter'))
                                            {{in_array($brand->name,Session::get('brand_filter')) ? 'checked' : '' }}
                                        @endif
                                            >
                                        <label for="brand-{{$loop->index + 1}}" style="font-weight: normal;">
                                            <span>{{$brand->name}}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->

                        <!-- aside Widget -->
                        {{--                <div class="aside">--}}
                        {{--                    <h3 class="aside-title">Top selling</h3>--}}
                        {{--                    <div class="product-widget">--}}
                        {{--                        <div class="product-img">--}}
                        {{--                            <img src="./img/product01.png" alt="">--}}
                        {{--                        </div>--}}
                        {{--                        <div class="product-body">--}}
                        {{--                            <p class="product-category">Category</p>--}}
                        {{--                            <h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                        {{--                            <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}

                        {{--                </div>--}}
                        <!-- /aside Widget -->
                        <button class="btn btn-success" style="float:right; margin-top: 8px;">Áp dụng</button>
                        </form>
                        <form action="{{route('clear')}}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="float:right; margin-right: 10px;  margin-top: 8px;">Xóa tất cả</button>
                        </form>
                    </div>

                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-sm-9">
                    <!-- store top filter -->
                    <form id="sort-form" action="{{route('sort')}}" method="POST">
                        @csrf
                        <div class="store-filter clearfix">
                            <div class="store-sort">
                                <label>
                                    Sắp xếp theo:
                                    <select class="input-select" name="sort" id="sort">
                                        @if(Session::has('sort_filter'))
                                            <option value="popular" {{Session::get('sort_filter') == 'popular' ? 'selected' : ''}} >Phổ biến</option>
                                            <option value="low-to-high" {{Session::get('sort_filter') == 'low-to-high' ? 'selected' : ''}}>Giá thấp đến cao</option>
                                            <option value="high-to-low" {{Session::get('sort_filter') == 'high-to-low' ? 'selected' : ''}}>Giá cao đến thấp</option>
                                        @else
                                            <option value="popular" selected>Phổ biến</option>
                                            <option value="low-to-high">Giá thấp đến cao</option>
                                            <option value="high-to-low">Giá cao đến thấp</option>
                                        @endif
                                    </select>
                                </label>
                            </div>
                        </div>
                    </form>
                    <!-- /store top filter -->

                    <!-- store products -->
                    <div class="row">
                        <!-- product -->

                        @forelse($products_search as $product)
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <a href="{{url('/category/'.$product->category->slug.'/'.$product->id)}}">
                                    <div class="product">
                                        <div class="product-img">
                                            @if($product->productImages->count() > 0)
                                                <img
                                                    src="{{url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png')}}"
                                                    alt="">
                                            @else
                                                <img src="{{url('/img/giftbox.png')}}" alt="">
                                            @endif
                                            @if ($product->created_at >= date('Y-m-d', strtotime(config('app.new_arrival'))) )
                                                <div class="product-label">
                                                    <span class="new">NEW</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-body">
                                            <strong>
                                                <p class="product-name" style="font-size: 12px;">
                                                    {!! $product->tittle !!}
                                                </p>
                                            </strong>

                                            <div class="product-rating">
                                                @for($i = 1; $i <= number_format($product->average_star); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @for($j = number_format($product->average_star) + 1; $j <= 5; $j++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            </div>
                                            <div class="product-btns">
                                                <h4 class="product-price">{{number_format($product->selling_price, 0, '', '.')}}
                                                    đ <br>
                                                    <del
                                                        class="product-old-price">{{number_format($product->original_price, 0, '', '.')}}
                                                        đ
                                                    </del>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /product -->
                        @empty
                            <div class="row text-center" style="margin-top: 100px;"><h2>Không tìm thấy sản phẩm nào.</h2></div>
                        @endforelse


                    </div>
                    <!-- /store products -->

                    {{ $products_search->links('custom-pagination')  }}
                    <!-- /store bottom filter -->
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    <script>
        $(function () {
            $('#sort').on('change', function() {
                // alert( this.value );
                $('#sort-form').submit();
            });
        })
    </script>
@endsection
