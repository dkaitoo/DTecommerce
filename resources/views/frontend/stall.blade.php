@extends('layouts.app')

@section('content')

<div class="">
    <div class="container">
        <div class="row" style="background-image: url({{asset('img/background-stall.png')}}); height: 182px;">
            <div class="col-xs-6 col-md-5" style="padding: 1.5vw 0 0 5vw;">
                <div class="col-xs-6 col-md-4">
                    <a href="#"><img src="{{url(($seller->logo != null) ? $seller->logo : '/img/logoStore.png')}}"
                               class="stall-avatar" title=""></a>
                </div>
                <div class="col-xs-6 col-md-8" style="margin: 0px; padding: 0px;">
                    <div class="row">
                        <div class="col-xs-12" style="margin: 5px 0px 5px 0;">
                            <a class="stall-name">{{$seller->store_name}}</a>
                        </div>
                       <div class="col-xs-12">
                            <img src="{{asset('img/logo-stall.png')}}" style="width: 100px; height: 20px; margin: 0 0 10px 5px;"/>
                       </div>
                        <div class="col-xs-12">
                            <a class="mess-shop-cart" href="{{url('/chatify/'.$seller->user_id)}}">
                                <i class="icon fa fa-commenting" style="margin-right: 3px"></i>Nhắn tin</a>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-xs-6 col-md-7 stall-info" style="padding: 1.5vw 0 0 5vw; margin: 20px 0 10px 0;">
                <div style="border-left: 3px solid rgb(255, 255, 255); height: 50px; padding-left: 15px;">
                    <p> Tham gia vào: <b>{{ date('d-m-Y', strtotime($seller->created_at))}}</b></p>
                    <p> Tổng số sản phẩm: <b>{{$count_products}}</b></p>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="tab-content">
    <div id="allProduct">
      <main class="main-content">
        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title">TẤT CẢ SẢN PHẨM</h3>
                    </div>
                    <!-- Products tab & slick -->
{{--                    <div class="col-md-12">--}}
{{--                        <div class="row">--}}
{{--                            <div class="products-tabs">--}}
{{--                                <!-- tab -->--}}
{{--                                <div id="tab2" class="tab-pane fade in active">--}}
{{--                                    <div class="products-slick" data-nav="#slick-nav-2">--}}
{{--                                        <!-- product -->--}}
{{--                                        <div class="product">--}}
{{--                                            <div class="product-img">--}}
{{--                                                <img src="{{asset('img/product06.png')}}" alt="">--}}
{{--                                                <div class="product-label">--}}
{{--                                                    <span class="sale">-30%</span>--}}
{{--                                                    <span class="new">NEW</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="product-body">--}}
{{--                                                <p class="product-category">Category</p>--}}
{{--                                                <h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
{{--                                                --}}
{{--                                                <div class="product-rating">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-btns">--}}
{{--                                                    <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="add-to-cart">--}}
{{--                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- /product -->--}}
{{--                                    </div>--}}
{{--                                    --}}
{{--                                </div>--}}
{{--                                <!-- /tab -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- /Products tab & slick -->

                    <!-- Products tab & slick -->
                    <div id="product-more">
                        <!-- Ajax here -->
                    </div>
                    <!-- /Products tab & slick -->
                </div>
                <!-- /row -->
                <div class="col-md-12">
                    <div class="hot-deal">
                        <button class="primary-btn cta-btn" id="load-more" data-paginate="2">Xem thêm</button>
                        <p class="invisible" style="font-size: 16px; padding: 8px; background-color:#ff6348; border-radius: 20px; color: white;">Hết sản phẩm.</p>
                    </div>
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->
      </main>

    </div>

{{--    <div id="type1" class="tab-pane fade">--}}
{{--        <main class="main-content">--}}
{{--            <p>1aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>--}}
{{--        </main>--}}

{{--    </div>--}}

{{--    <div id="type2" class="tab-pane fade">--}}
{{--        <main class="main-content">--}}
{{--            <p>2bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb</p>--}}
{{--        </main>--}}

{{--    </div>--}}
  </div>

<script type="text/javascript">
    var paginate = 1;
    loadMoreData(paginate); // load trc 1 lần

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
</script>


@endsection
