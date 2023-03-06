@extends('layouts.app')

@push('styles')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endpush
@push('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
@endpush

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
                    <li><a href="{{route('getByCategory', $product->category->id)}}">{{$product->category->name}}</a></li>
                    <li class="active">{{$product->name}}</li>
                </ul>
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
            <!-- Product main img -->
            @include('flash-message')
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    @if($product->productImages)
                        @forelse($product->productImages as $image)
                            <div class="product-preview">
                                <img src="{{url($image->image)}}" alt="Img"/>
                            </div>
                        @empty
                            <div class="product-preview">
                                <img src="{{url('img/giftbox.png')}}" alt=""/>
                            </div>
                        @endforelse
                    @else
                        <div class="product-preview">
                            <img src="{{url('img/giftbox.png')}}" alt=""/>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <div id="product-imgs">
{{--                    <div class="product-preview">--}}
{{--                        <img src="{{url('img/img.png')}}" alt="">--}}
{{--                    </div>--}}
                    @if($product->productImages)
                        @forelse($product->productImages as $image)
                            <div class="product-preview">
                                <img src="{{url($image->image)}}" alt="Img"/>
                            </div>
                        @empty
                            <div class="product-preview">
                                <img src="{{url('img/giftbox.png')}}" alt=""/>
                            </div>
                        @endforelse
                    @else
                        <div class="product-preview">
                            <img src="{{url('img/giftbox.png')}}" alt=""/>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->
            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name">{!! $product->tittle !!}</h2>
                    <div>

                        <div class="product-rating">

                            @for($i = 1; $i <= number_format($rating_value); $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                            @for($j = number_format($rating_value) + 1; $j <= 5; $j++)
                                <i class="fa fa-star-o"></i>
                            @endfor
                        </div>
                        @if($rating_value == 0)
                            <a class="review-link" href="#">Không có Đánh giá</a>
                        @else
                            <a class="review-link" href="#"><b>{{$ratings->count()}}</b> Đánh giá</a>
                        @endif
                        |
                        @if($product->sold == 0)
                            <a class="review-link" href="#">Chưa bán sản phẩm nào</a>
                        @else
                            <a class="review-link" href="#"><b>{{$product->sold}}</b> Đã bán</a>
                        @endif
                    </div>
                    <div>
                        <h3 class="product-price">{{number_format($product->selling_price, 0, '', '.')}}đ <del class="product-old-price">{{number_format($product->original_price, 0, '', '.')}}đ</del></h3>
                    </div>
                    <div>
                        <p>
                            (Còn <strong>{{$product->qty}}</strong> sản phẩm)
                        </p>
                    </div>
                    <div class="product-options">
                        @if(in_array('color',$attributes_name))
                            <label >Màu sắc &nbsp;&nbsp;&nbsp;
                                @forelse($colors as $colorItem)
                                    @if($attributes and in_array($colorItem->id,$attributes))
                                        &nbsp;&nbsp;&nbsp;<input class="color-radio" type="radio" name="id_attribute[]" value="{{$colorItem->id}}">
                                        <label for="{{$colorItem->id}}" style="background-color:{{$colorItem->value}}; color: {{$colorItem->value}}; padding: 8px 0px 0px 0px; font-size: 9px;">{{$colorItem->value}}</label>
                                        {{-- <input type="radio" name="id_attribute[]" value="{{$colorItem->id}}">
                                        <label for="{{$colorItem->id}}" style="background-color:{{$colorItem->value}}; color: {{$colorItem->value}}; padding: 8px 0px 0px 0px; font-size: 9px;">{{$colorItem->value}}</label> --}}
                                    @endif
                                @empty
                                @endforelse
                            </label>
                            <br>
                        @endif

                        @if(in_array('size',$attributes_name))
                            <label>Kích cỡ
                                <select name="id_attribute[]" class="input-select">
                                    @forelse($sizes as $sizeItem)
                                        @if($attributes and in_array($sizeItem->id,$attributes))
                                            <option value="{{$sizeItem->id}}">
                                                    {{$sizeItem->value}}
                                            </option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </label>
                        @endif

                        @if(in_array('dimension',$attributes_name))
                            <label>Kích thước
                                <select name="id_attribute[]" class="input-select">
                                    @forelse($dimensions as $dimensionItem)
                                        @if($attributes and in_array($dimensionItem->id,$attributes))
                                            <option value="{{$dimensionItem->id}}">
                                                {{$dimensionItem->value}}
                                            </option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </label>
                        @endif

                        @if(in_array('memory',$attributes_name))
                            <label>Bộ nhớ
                                <select name="id_attribute[]" class="input-select">
                                    @forelse($memories as $memoryItem)
                                        @if($attributes and in_array($memoryItem->id,$attributes))
                                            <option value="{{$memoryItem->id}}">
                                                {{$memoryItem->value}}
                                            </option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </label>
                        @endif

                        @if(in_array('volume',$attributes_name))
                            <label>Thể tích/trọng lượng/diện tích
                                <select name="id_attribute[]" class="input-select">
                                    @forelse($volumes as $volumeItem)
                                        @if($attributes and in_array($volumeItem->id,$attributes))
                                            <option value="{{$volumeItem->id}}">
                                                {!! $volumeItem->value!!}
                                            </option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </label>
                        @endif
                    </div>

                    <div class="add-to-cart product_data">
                        <input type="hidden" value="{{$product->id}}" class="prod_id">
                        <div class="qty-label">
                            Số lượng
                            <div class="input-number">
                                <input class="qty-input" name="qty" type="number" value="1"/>
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user())
                        @if(Auth::user()->role == 'user')
                            {{--Ngan admin vs seller mua hang--}}
                            <div class="add-to-cart">
                                <button name="addCart" class="add-to-cart-btn" {{$product->qty > 0 ? '' : 'disabled'}}><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                            </div>
                        @endif
                    @else
                        <div class="add-to-cart">
                            <button name="addCart" class="add-to-cart-btn" {{$product->qty > 0 ? '' : 'disabled'}}><i class="fa fa-shopping-cart" ></i> Thêm vào giỏ</button>
                        </div>
                    @endif

                    <ul class="product-links add-to-cart">
                        <li>Danh mục:</li>
                        <li><a href="{{route('getByCategory',$product->category->id)}}" class="text-info">{{$product->category->name}}</a></li>
                    </ul>

                    {{--Cua hang--}}
                    <div class="row">
                        <div class="d-flex col-md-2-handmade col-xs-1">
                            <a href="{{route('showStall',$product->seller->id)}}"><img src="{{url($product->seller->logo ?? 'img/giftbox.png')}}" alt=""
                                             style="height:50px; width:50px; border-radius: 50%;"></a>
                        </div>
                        <div class="d-flex col-md-10 col-xs-11">
                            <a href="{{route('showStall',$product->seller->id)}}"><p style="margin-bottom: 5px; margin-left: 5px;">{{$product->seller->store_name}}</p></a>
                            {{-- <a type="button" href="{{url('/chatify/'.$product->seller->id)}}" style="height:30px; width:100px;
                            background-color: aquamarine; position: relative;
                            border-radius:20px; transition: 0.2s all; border: 2px solid transparent">
                                <i class="fa fa-shopping-cart" style="margin-right:5px;"></i>Nhắn tin
                            </a> --}}
                            <a type="button" href="{{url('/chatify/'.$product->seller->user_id)}}" class="mess-shop-cart"><i class="icon fa fa-commenting" style="margin-right: 3px; margin-left: 0px"></i>Nhắn tin</a>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /Product details -->

            <!-- Product tab -->
            <div class="col-md-12">
                <div id="product-tab">
                    <!-- product tab nav -->
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Thông tin chi tiết</a></li>
                        <!-- <li><a data-toggle="tab" href="#tab2">Details</a></li> -->
                        <li><a data-toggle="tab" href="#tab3">Đánh giá ({{$ratings->count()}})</a></li>
                    </ul>
                    <!-- /product tab nav -->

                    <!-- product tab content -->
                    <div class="tab-content">
                        <!-- tab1  -->
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                        <!-- /tab1  -->

                        <!-- tab2  -->
                        <div id="tab3" class="tab-pane fade in">
                            <div class="row">
                                <!-- Rating -->
                                <div class="col-md-3">
                                    <div id="rating" class="text-center">
                                        <div class="rating-avg">
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= number_format($rating_value); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @for($j = number_format($rating_value) + 1; $j <= 5; $j++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            </div><br>
                                            <span>{{number_format($rating_value)}}/5</span>

                                        </div>
                                        <ul class="rating">
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
{{--                                                <div class="rating-progress">--}}
{{--                                                    <div style="width: 80%;"></div>--}}
{{--                                                </div>--}}
                                                <span class="sum">{{$rating_sum_5star}}</span>
                                            </li>
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <span class="sum">{{$rating_sum_4star}}</span>
                                            </li>
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
{{--                                                <div class="rating-progress">--}}
{{--                                                    <div></div>--}}
{{--                                                </div>--}}
                                                <span class="sum">{{$rating_sum_3star}}</span>
                                            </li>
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
{{--                                                <div class="rating-progress">--}}
{{--                                                    <div></div>--}}
{{--                                                </div>--}}
                                                <span class="sum">{{$rating_sum_2star}}</span>
                                            </li>
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
{{--                                                <div class="rating-progress">--}}
{{--                                                    <div></div>--}}
{{--                                                </div>--}}
                                                <span class="sum">{{$rating_sum_1star}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Rating -->

                                <!-- Reviews - xong -->
                                <div class="col-md-6">
                                    <div id="reviews">
                                        <ul class="reviews">
                                            @foreach($rating_paginate as $rating)
                                            <li>
                                                <div class="review-heading">
                                                    <h5 class="name">{{App\Models\User::where('id',$rating->user_id)->first()->name}}</h5>
                                                    <p class="date">{{ date('d-m-Y H:i', strtotime($rating->created_at))}}</p>
                                                    <div class="review-rating">
                                                        @for($i = 1; $i <= $rating->stars_rated; $i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                        @for($j = $rating->stars_rated + 1; $j <= 5; $j++)
                                                            <i class="fa fa-star-o"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="review-body">
                                                    @if($rating->user_review)
                                                        <p>{{$rating->user_review}}</p>
                                                    @else
                                                        <p>Không có ý kiến.</p>
                                                    @endif
                                                </div>
                                            </li>
                                                <hr>
                                            @endforeach

                                        </ul>
                                        {{--Phan trang, chưa bik nó tọa độ ở đâu vì k có dữ liệu--}}
                                        {{ $rating_paginate->links() }}
                                    </div>
                                </div>
                                <!-- /Reviews -->

                                <!-- Review Form - xong -->
                                <div class="col-md-3">
                                    <div id="review-form">
                                        <h4>ĐÁNH GIÁ SẢN PHẨM</h4>
                                        <form action="{{route('rating.store')}}" method="POST" class="review-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <textarea name="user_review" class="input"
                                                      placeholder="Xin mời chia sẻ một số kinh nghiệm về sản phẩm..">{{$user_rating->user_review ?? ''}}</textarea>
                                            <div class="input-rating" style="margin: 0px; padding: 0px;">
                                                <span>Bạn thấy sản phẩm này như thế nào?</span><br>
                                                <div class="stars"></div>
                                            </div>
                                            <div class="rating-css" style="text-align: center; margin-bottom: 50px; padding-top: 0px;">
                                                <div class="star-icon" style="padding-top: 0px;">
                                                    @if(!$user_rating)
                                                        <input type="radio" value="1" name="rating" checked id="rating1">
                                                        <label for="rating1" class="fa fa-star"></label>
                                                        <input type="radio" value="2" name="rating" checked id="rating2">
                                                        <label for="rating2" class="fa fa-star"></label>
                                                        <input type="radio" value="3" name="rating" checked id="rating3">
                                                        <label for="rating3" class="fa fa-star"></label>
                                                        <input type="radio" value="4" name="rating" id="rating4">
                                                        <label for="rating4" class="fa fa-star"></label>
                                                        <input type="radio" value="5" name="rating" id="rating5">
                                                        <label for="rating5" class="fa fa-star"></label>
                                                    @else
                                                        @for($i = 1; $i <= $user_rating->stars_rated; $i++)
                                                            <input type="radio" value="{{$i}}" name="rating" checked id="rating{{$i}}">
                                                            <label for="rating{{$i}}" class="fa fa-star" ></label>
                                                        @endfor
                                                        @for($j = $user_rating->stars_rated + 1; $j <= 5; $j++)
                                                            <input type="radio" value="{{$j}}" name="rating" id="rating{{$j}}">
                                                            <label for="rating{{$j}}" class="fa fa-star"></label>
                                                        @endfor
                                                    @endif
                                                </div>
                                                @if(Auth::user())
                                                    @if(Auth::user()->role == 'user')
                                                        {{--Ngan admin vs seller mua hang--}}
                                                            <button class="primary-btn" type="submit">Gửi đánh giá</button>
                                                    @endif
                                                @else
                                                    <a type="button" class="primary-btn" href="{{route('login')}}">Đăng nhập để đánh giá</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /Review Form -->
                            </div>
                        </div>
                        <!-- /tab3  -->
                    </div>
                    <!-- /product tab content  -->
                </div>
            </div>
            <!-- /product tab -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- Section san pham lien quan -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <div class="col-md-12">
                <div class="section-title text-center">
                    <h3 class="title">Các sản phẩm cùng Danh mục</h3>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                @forelse($related_product->take(10)->sortByDesc('created_at') as $product)
                                    <!-- product -->
                                    <div class="product">
                                        <div class="product-img">
                                            @if($product->productImages->count() > 0)
                                                <img src="{{url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png')}}" alt="">
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
                                            <p class="product-category">{{$product->category->name}}</p>
                                            <h3 class="product-name"><a href="{{url('/category/'.$product->category->slug.'/'.$product->id)}}">{{$product->name}}</a></h3>

                                            <div class="product-rating">
                                                @for($i = 1; $i <= number_format($product->average_star); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @for($j = number_format($product->average_star) + 1; $j <= 5; $j++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            </div>
                                            <div class="product-btns">
                                                <h4 class="product-price">{{number_format($product->selling_price, 0, '', '.')}}đ <br>
                                                    <del class="product-old-price">{{number_format($product->original_price, 0, '', '.')}}đ</del>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /product -->
                                @empty
                                    <div class="product">Không có sản phẩm nào</div>
                                @endforelse
                </div>
            </div>
            <!-- /product -->

        </div>
        <!-- /row -->
    </div>

    <!-- /container -->
</div>
<!-- /Section san pham khac -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <div class="col-md-12">
                <div class="section-title text-center">
                    <h3 class="title">Các sản phẩm khác của Cửa hàng {{$related_product_seller[0]->seller->store_name}}</h3>
                </div>
            </div>

            <!-- product -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                @forelse($related_product_seller->take(10)->sortByDesc('created_at') as $product)
                                    <!-- product -->
                                    <div class="product">
                                        <div class="product-img">
                                            @if($product->productImages->count() > 0)
                                                <img src="{{url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png')}}" alt="">
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
                                            <p class="product-category">{{$product->category->name}}</p>
                                            <h3 class="product-name"><a href="{{url('/category/'.$product->category->slug.'/'.$product->id)}}">{{$product->name}}</a></h3>

                                            <div class="product-rating">
                                                @for($i = 1; $i <= number_format($product->average_star); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @for($j = number_format($product->average_star) + 1; $j <= 5; $j++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            </div>
                                            <div class="product-btns">
                                                <h4 class="product-price">{{number_format($product->selling_price, 0, '', '.')}}đ <br>
                                                    <del class="product-old-price">{{number_format($product->original_price, 0, '', '.')}}đ</del>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /product -->
                                @empty
                                    <div class="product">Không có sản phẩm nào</div>
                                @endforelse
                            </div>
                        </div>
            <!-- /product -->

        </div>
        <!-- /row -->

{{--        <div class="col-md-12">--}}
{{--            <div class="hot-deal">--}}
{{--                <a class="primary-btn cta-btn" href="#">Xem thêm</a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <!-- /container -->
</div>
<script>
    $(function () {
        // Input number
        $('.input-number').each(function() {
            var $this = $(this),
                $input = $this.find('input[type="number"]'),
                up = $this.find('.qty-up'),
                down = $this.find('.qty-down');

            down.on('click', function () {
                var value = parseInt($input.val()) - 1;
                value = value < 1 ? 1 : value;
                $input.val(value);
                $input.change();
                updatePriceSlider($this , value)
            })

            up.on('click', function () {
                var value = parseInt($input.val()) + 1;
                value = value > {{$product->qty}} ? {{$product->qty}} : value;
                $input.val(value);
                $input.change();
                updatePriceSlider($this , value)
            })
        });

        function updatePriceSlider(elem , value) {
            if ( elem.hasClass('price-min') ) {
                console.log('min')
                priceSlider.noUiSlider.set([value, null]);
            } else if ( elem.hasClass('price-max')) {
                console.log('max')
                priceSlider.noUiSlider.set([null, value]);
            }
        }

        // Price Slider
        var priceSlider = document.getElementById('price-slider');
        if (priceSlider) {
            noUiSlider.create(priceSlider, {
                start: [1, 999],
                connect: true,
                step: 1,
                range: {
                    'min': 1,
                    'max': 999
                }
            });

            priceSlider.noUiSlider.on('update', function( values, handle ) {
                var value = values[handle];
                handle ? priceInputMax.value = value : priceInputMin.value = value
            });
        }
    })
</script>

<script>
    // Insert and Update Record with Dependent Dropdown
    $(function () {
        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.add-to-cart-btn').click((e)=>{
            e.preventDefault();
            let product_id = $('.prod_id').val();
            let product_qty = $('.qty-input').val();
            let selected_value = [];
            if($( "input" ).hasClass( "color-radio" )){
                if(!$('.color-radio').is(':checked')){
                    alert('Vui lòng chọn màu sắc!');
                    return;
                }
                let color_radio = $('input[class=color-radio]:checked').val();
                selected_value.push(color_radio);
            }
            $("label .input-select option:selected").each(function()
            {
                // Add $(this).val() to your list
                selected_value.push($(this).val());

            });
            // console.log(selected_value);
            // alert(product_id);
            // alert(product_qty);
            let data = {
                'product_id': product_id,
                'product_qty': product_qty,
                'chosen_attribute': selected_value,
            }// chua phai json format

            $.ajax({
                method: "POST",
                url: '{{route('cart.store')}}',
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify(data), // đưa về đúng format
                success: (response)=>{
                    if(response.code === 3){
                        // $('#qty-cart').html(response.count);
                        window.location.reload();
                    }

                    alert(response.status);
                },
                error: (jqXHR, textStatus)=> {
                    alert( "Request failed: " + textStatus );
                    // dùng cái dưới nếu xảy ra lỗi
                    // alert( "Request failed: " + jqXHR.responseText );
                }
            })
        });
        // $('.qty-up').click((e)=>{
        //     e.preventDefault();
        //
        //     var inc_val = $('.qty-input').val();
        //     var value = parseInt(inc_val, 10);
        //     value = isNaN(value) ? 0 : value;
        //     if(value < 10)
        //     {
        //         value++;
        //         $('.qty-input').val(value);
        //     }
        // });
        // $('.qty-down').click((e)=>{
        //     e.preventDefault();
        //
        //     var inc_val = $('.qty-input').val();
        //     var value = parseInt(inc_val, 10);
        //     value = isNaN(value) ? 0 : value;
        //     if(value > 1)
        //     {
        //         value--;
        //         $('.qty-input').val(value);
        //     }
        // });
    });
</script>
<!-- /Section -->
@endsection
