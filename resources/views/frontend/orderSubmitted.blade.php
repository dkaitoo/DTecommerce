@extends('layouts.app')

@section('content')

{{--        <div class="alert alert-warning alert-block">--}}
{{--            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>--}}
{{--            <strong>{{$message}}</strong>--}}
{{--        </div>--}}
<div class="container page-content">
    <div class="card">
        <div class="card-body">
            <div class="text-center py-3" style="margin:50px 0 50px 0;">
                <i data-feather="check-circle" class="text-success" width="48" height="48"></i>
                <h1>Cảm ơn bạn đã mua hàng!</h1>
                <p>Đơn hàng của bạn đã được đặt thành công và sẽ được xử lý trong thời gian sớm nhất.</p>
                @if(isset($order))
                    <p class="mb-0">
                        <span class="text-muted">Mã đơn hàng:  </span>
                        <span class="text-info">#<span>{{$order->bill_id}}</span></span>
                    </p>

                    <p><span class="text-muted">Hình thức thanh toán: </span> Tiền mặt</p>
                    <p>
                        <span class="text-muted">Tổng hóa đơn: </span>
                        <span style="color:rgb(252, 82, 82)"><span>{{number_format($order->price, 0, '', '.')}}đ </span></span>
                    </p>
                @elseif(isset($order_payed))
                    <p class="mb-0">
                        <span class="text-muted">Mã đơn hàng:  </span>
                        <span class="text-info">#<span>{{$order_payed->bill_id}}</span></span>
                    </p>

                    <p><span class="text-muted">Hình thức thanh toán: </span> Thanh toán online</p>
                    <p>
                        <span class="text-muted">Tổng hóa đơn: </span>
                        <span class="text-info"><span>{{number_format($order_payed->price, 0, '', '.')}}đ </span></span>
                    </p>

                @endif
                    {{--          <p>Thời gian giao hàng ước tính là <span "${#dates.format(order.shippingDate, 'dd-MMM-yyyy')}"></span></p>--}}
                    <a href="{{route('home')}}" class="btn btn-success rounded mb-3">TIẾP TỤC MUA SẮM</a>
                    <a href="{{route('cart.index')}}" class="btn btn-primary rounded mb-3">XEM TÌNH TRẠNG ĐƠN HÀNG</a>
            </div>
        </div>
    </div>
</div>

        <!-- end container -->

@endsection
