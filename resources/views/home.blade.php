@extends('layouts.app')

@section('content')

<!-- SECTION SẢN PHẨM MỚI - Xong -->
<div class="section">

    <!-- container -->
    <div class="container">
        @include('flash-message')
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">SẢN PHẨM MỚI</h3>
                    <ul class="section-tab-nav tab-nav">
                        <li><div id="slick-nav-1" class="products-slick-nav"></div></li>
                    </ul>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                @forelse($product_arrivals as $product)
                                    <!-- product -->
                                    <div class="product">
                                        <div class="product-img">
                                            @if($product->productImages->count() > 0)
                                                <img src="{{url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png')}}" alt="">
                                            @else
                                                <img src="{{url('/img/giftbox.png')}}" alt="">
                                            @endif
                                            <div class="product-label">
{{--                                                <span class="sale">-30%</span>--}}
                                                <span class="new">NEW</span>
                                            </div>
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
                                    <p class="product text-center" style="padding: 10px; background-color:rgb(221, 3, 87); border-radius: 20px; color: white;"><b>Không có sản phẩm nào</b></div>
                                @endforelse
                            </div>

                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <!-- container -->
    <div class="container" style="height: 17em;">
    </div>
    <!-- /container -->
</div>
<!-- /HOT DEAL SECTION -->

<!-- SECTION XU HƯỚNG -- Xong -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">XU HƯỚNG</h3>
                    <ul class="section-tab-nav tab-nav">
                        <div id="slick-nav-2" class="products-slick-nav"></div>
                    </ul>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                @forelse($product_limit as $product)
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
                                <p class="product text-center" style="padding: 10px; background-color:rgb(221, 94, 3); border-radius: 20px; color: white;"><b>Không có sản phẩm nào</b></div>
                                @endforelse


                            </div>

                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION DANH MỤC-->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">DANH MỤC</h3>
                </div>
            </div>
        @forelse($categories as $category)
            <!-- shop -->
            <div class="col-md-3 col-xs-4">
                <div class="shop">
                    <div class="shop-img">
                        <img src="{{($category->image != null) ? url('/assets/uploads/category/'.$category->image) : url('/img/default_category.jpg')}}" alt="">
                    </div>
                    <div class="shop-body">
                        <h4 class="text-uppercase">{{$category->name}}</h4>
                        <a href="{{route('getByCategory',$category->id)}}" class="cta-btn">Mua ngay <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->
        @empty
            <!-- shop -->
            <div class="col-md-4 col-xs-4">
            </div>
            <div class="col-md-4 col-xs-4">
                <div class="shop">

                    <p class="product text-center" style="padding: 10px; background-color:rgb(121, 53, 142); border-radius: 20px; color: white;"><b>Không có loại sản phẩm nào cả.</b></div>
                </div>
            </div>
            <!-- /shop -->
            <div class="col-md-4 col-xs-4">
            </div>
        @endforelse

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
<div id="hot-deal1" class="section">
    <!-- container -->
    <div class="container" style="height: 17em;">
    </div>
    <!-- /container -->
</div>
<!-- SECTION Gợi ý hôm nay -->
<div class="section">
    <!-- container  -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Gợi ý hôm nay</h3>
                    <ul class="section-tab-nav tab-nav">
                        <div id="slick-nav-1" class="products-slick-nav"></div>
                    </ul>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div id="product-more">
                <!-- Ajax here -->
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->

        <div class="col-md-12">
            <div class="hot-deal">
{{--                <a type="button" class="primary-btn cta-btn" href="#">Xem thêm</a>--}}
                <button class="primary-btn cta-btn" id="load-more" data-paginate="2">Xem thêm</button>
                <p class="invisible" style="font-size: 16px; padding: 8px; background-color:#ff6348; border-radius: 20px; color: white;">Hết sản phẩm.</p>
            </div>
        </div>
    </div>
    <!-- /container -->
</div>

<div class="chat-screen">
    <div class="chat-header">
        <div class="chat-header-title">
            Bạn cần giúp đỡ gì?
        </div>
        <div class="chat-header-option">
            <span class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink1" style="will-change: transform;">
                    <a class="dropdown-item end-chat" href="javascript:void(0);">
                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                        &nbsp;&nbsp;Đi đến tin nhắn
                    </a>
                </div>
            </span>
        </div>
    </div>
</div>


<script type="text/javascript">
    var paginate = 1;
    loadMoreData(paginate);

    // khi click load more
    $('#load-more').click(function() {
        var page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1); // tăng thêm 1 vào data-paginate
    });
    // run function when user click load more button
    function loadMoreData(paginate) {
        $.ajax({
            url: '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('Đang tải...');
            }
        })
            .done(function(response) {
                if(response.count_data === 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more').hide();
                    return;
                } else {
                    $('#load-more').text('Xem thêm...');
                    $('#product-more').append(response.data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    // $(document).ready(function () {
	// 			//Toggle fullscreen
	// 			//Đóng mở chat
	// 			$(".chat-bot-icon").click(function (e) {
	// 				$(this).children('img').toggleClass('hide');
	// 				$(this).children('svg').toggleClass('animate');
	// 				$('.chat-screen').toggleClass('show-chat');
	// 			});
	// 			//
	// 			// $('.chat-mail button').click(function () {
	// 			//     $('.chat-mail').addClass('hide');
	// 			//     $('.chat-body').removeClass('hide');
	// 			//     $('.chat-input').removeClass('hide');
	// 			//     $('.chat-header-option').removeClass('hide');
	// 			// });
	// 			$('.end-chat').click(function () {
	// 				$('.chat-body').addClass('hide');
	// 				$('.chat-input').addClass('hide');
	// 				$('.chat-session-end').removeClass('hide');
	// 				$('.chat-header-option').addClass('hide');
	// 			});
	// });
</script>

@endsection
