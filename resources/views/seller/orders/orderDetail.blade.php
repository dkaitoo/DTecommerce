@extends('seller.layouts.app')

@push('javascript')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
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
                    <a class="navbar-brand" href="{{route('home')}}" style="font-size: 17px;"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>

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
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                </button>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('order.index')}}" class="text-primary"><i class="fa fa-solid fa-2x fa-angle-left"></i></a>
                            <h4 class="card-title text-primary text-uppercase text-center" style="margin-top: 0px;"><b>Chi tiết ĐƠN ĐẶT HÀNG</b></h4>
                            @include('flash-message')
                            {{-- <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                            </div> --}}
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-6" style="padding-left: 3rem;">
                                        <!-- Billing Details -->
                                        <div class="billing-details">
                                            <div class="section-title">
                                                <h4 class="title">Thông tin khách hàng</h4>
                                            </div>
                                            <div class="form-group">
                                                <label>Mã hóa đơn:</label>
                                                <span><b>#{{$order->bill_id}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Ngày đặt:</label>
                                                <span><b>{{ date('d-m-Y', strtotime($order->created_at))}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tên khách hàng:</label>
                                                <span><b>{{$order->name}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ email:</label>
                                                <span><b>{{$order->email}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Số điện thoại:</label>
                                                <span><b>{{$order->phone}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ giao hàng:</label>
                                                <span><b>{{$order->address}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Quận / Huyện:</label>
                                                <span><b>{{$order->ward}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tỉnh / Thành phố:</label>
                                                <span><b>{{$order->city}}</b></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Ghi chú:</label>
                                                <span><b>{{$order->message}}</b></span>
                                            </div>
                                        </div>
                                        <!-- /Billing Details -->
                                    </div>

                                    <!-- Order Details - xong -->
                                    <div class="col-sm-6 order-details">
                                        <div class="section-title">
                                            <h4 class="title">Đơn hàng</h4>
                                        </div>
                                        <div class="order-summary">
                                            <div class="order-products">
                                                @php
                                                    $sum_price = 0;
                                                @endphp
                                                @foreach($order->order_items as $key => $item)
                                                    @if($item->products->seller_id == $seller_id)
                                                        @php
                                                            $price_product = $item->products->selling_price * $item->qty;
                                                            $sum_price += $price_product;
                                                        @endphp
                                                            <!-- Mỗi sản phẩm trong đơn đặt hàng -->
                                                        <div class="row order-col" data-price="{{$price_product}}">
                                                            <div class="row">
                                                                <div class="col-sm-6" style="width: 150px;" style="margin-left: 50px;">
                                                                    @if($item->products->productImages->count() > 0)
                                                                        <img src="{{url(($item->products->productImages[0]->image != null) ?
                                                                                                $item->products->productImages[0]->image : '/img/giftbox.png')}}"
                                                                                class="img-sm">
                                                                    @else
                                                                        <img src="{{url('/img/giftbox.png')}}"
                                                                                class="img-sm">
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-6" style="padding: 0px;">
                                                                    <b>{{$item->products->name}}</b> <br>
                                                                    <span class="text-muted small">
                                                                        @if($attributes_all and json_decode($item->chosen_attribute))
                                                                            @foreach($attributes_all as $attribute)
                                                                                @php
                                                                                    $chosen_attr = json_decode($item->chosen_attribute);
                                                                                @endphp
                                                                                @if(in_array($attribute->id,$chosen_attr))
                                                                                    {{ $loop->first ? '' : '/' }}
                                                                                    @if($attribute->name === 'color')
                                                                                        <i class='fa fa-paint-brush'
                                                                                            style='font-size:12px;color:{{$attribute->value}};'
                                                                                            aria-hidden='true'></i>
                                                                                    @else
                                                                                        <span>
                                                                                        {!! $attribute->value !!}
                                                                                        </span>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                            <br>
                                                                        @endif
                                                                        Thương hiệu: {{$item->products->brand}}</span>
                                                                        <div>{{number_format($item->products->selling_price, 0, '', '.')}}
                                                                            đ x <span>{{$item->qty}}</span></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div style="font-size: 18px; margin-top: 10px;">Tổng tiền: <b class="text-danger">{{number_format($price_product, 0, '', '.')}}
                                                                đ</b></div>
                                                        <div class="payment-method" style="font-size: 14px;">
                                                            <label>Phương thức thanh toán:</label>
                                                            @if($order->payed  == 'Chưa thanh toán')
                                                                <span>Thanh toán khi nhận hàng (COD)</span>
                                                            @else
                                                                <span>Thanh toán online</span>
                                                            @endif
                                                        </div>
                                                        {{--nút button phải ở đây, không dc đem ra ngoài--}}
                                                        <form action="{{route('order.update',$item->id)}}" method="post">
                                                            @csrf
                                                            @method('put')
                                                            @if($item->process_status == '0')
                                                                <input type="hidden" name="status" value="1">
                                                                <button id="order-product" type="submit" class="btn btn-success" style="font-size: 15px;"
                                                                        style="width: 50%;" name="redirect">Xác nhận sản phẩm này
                                                                </button>
                                                            @elseif($item->process_status == '1')
                                                                <input type="hidden" name="status" value="2">
                                                                <button id="order-product" type="submit" class="btn btn-primary" style="font-size: 15px;"
                                                                        style="width: 50%;" name="redirect">Giao cho nhà vận chuyển
                                                                </button>
                                                            @endif
                                                        </form>
                                                    @endif
                                                @endforeach
                                            </div>
                                                <br>
                                                <div class="order-col mt-3 mb-3">
                                                    <div><strong>TỔNG TIỀN BẠN SẼ NHẬN (HÓA ĐƠN NHÁNH): </strong>
                                                        <span><strong
                                                            class="order-total text-danger" style="font-size: 16px;">{{number_format($sum_price, 0, '', '.')}}
                                                            đ</strong></span>
                                                    </div>
                                                </div>
                                                <div class="order-col mt-3 mb-3">

                                                    <div><strong>TỔNG TIỀN KHÁCH TRẢ (HÓA ĐƠN CHÍNH): </strong>
                                                        <span><strong
                                                            class="order-total text-warning" style="font-size: 16px;">{{number_format($order->price, 0, '', '.')}}
                                                            đ</strong></span>

                                                    </div>
                                                    <small>(Tổng tiền của hóa đơn bao gồm của nhiều sản phẩm ở nhiều của
                                                        hàng khác nhau)</small>
                                                </div>
                                        </div>

                                    </div>
                                <!-- /Order Details -->
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".tab").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-6").addClass("active");
        });
    </script>

@endsection
