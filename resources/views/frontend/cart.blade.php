@extends('layouts.app')

@section('content')

    @if($message = Session::get('message'))
        <script lang="javascript">
            alert('{{$message}}');
        </script>
    @endif

    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="active"><a class="cart-menu" data-toggle="tab" href="#cart">Giỏ hàng <span>
                            ({{App\Models\Cart::where(['user_id'=>Auth::user()->id])->count()}})
                        </span></a></li>
                <li class="pending"><a data-toggle="tab" href="#pending">Tình trạng đơn hàng
                        <span>({{$count_process}})</span></a></li>
                <li><a data-toggle="tab" href="#history">Lịch sử mua hàng <span>({{$count}})</span></a></li>
            </ul>

            <div class="tab-content">
                {{--  Giỏ hàng --}}
                <div id="cart" class="tab-pane fade in active">
                    <main class="main-content">
                        <section class="summary-cart">
                            <div class="container">
                                <div class="row">
                                    @if(count($carts) > 0)
                                        <aside class="col-lg-9 col-sm-8 no-padding">
                                            <div class="card">
                                                <div class="table-responsive">

                                                    <table class="table table-borderless table-shopping-cart cart-title" style="margin-bottom: 0px;">
                                                        <thead class="text-muted">
                                                        <tr class="text-uppercase cart-title-product">
                                                            <th><input type="checkbox" class="check_all"
                                                                       onClick="check_uncheck_checkbox(this.checked);"/>
                                                            </th>
                                                            <th scope="col">Sản phẩm</th>
                                                            <th scope="col" width="100">Số lượng</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col" class="text-right d-none d-md-block"
                                                                width="200">Thao tác
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @foreach($carts as $cart)
                                                            <tbody>
                                                            <tr data-id="{{$cart->id}}">
                                                                <td>
                                                                    <input class="is_checked" name="is_checked"
                                                                           type="checkbox" value=""
                                                                           data-price="{{$cart->products->selling_price}}">
                                                                    <input type="hidden" name="id_cart"
                                                                           value="{{$cart->id}}">
                                                                </td>
                                                                <td>
                                                                    <figure class="itemside align-items-center">
                                                                        <div class="aside">
                                                                            @if($cart->products->productImages->count() > 0)
                                                                                <img src="{{url(($cart->products->productImages[0]->image != null) ?
                                                                                            $cart->products->productImages[0]->image : '/img/giftbox.png')}}"
                                                                                     class="img-sm">
                                                                            @else
                                                                                <img src="{{url('/img/giftbox.png')}}"
                                                                                     class="img-sm">
                                                                            @endif
                                                                        </div>
                                                                        <figcaption class="info">
                                                                            <a href="{{url('/category/'.$cart->products->category->slug.'/'.$cart->products->id)}}"
                                                                               class="title text-dark">
                                                                                @php
                                                                                    $hidden_str = strlen(strip_tags($cart->products->tittle)) > 30 ? '...' : '';
                                                                                    print_r(substr(strip_tags($cart->products->tittle),0, 30) . $hidden_str);
                                                                                @endphp
                                                                            </a>
                                                                            <p class="text-muted small">
                                                                                @if($attributes_all and json_decode($cart->chosen_attribute))
                                                                                    @foreach($attributes_all as $attribute)
                                                                                        @php
                                                                                            $chosen_attr = json_decode($cart->chosen_attribute);
                                                                                        @endphp
                                                                                        @if(in_array($attribute->id,$chosen_attr))
                                                                                            @if($attribute->name === 'color')
                                                                                                <i class='fa fa-paint-brush'
                                                                                                   style='font-size:12px;color:{{$attribute->value}};'
                                                                                                   aria-hidden='true'></i>
                                                                                            @else
                                                                                                <span>
                                                                                                        {!! $attribute->value !!}
                                                                                                    </span>
                                                                                            @endif
                                                                                            /
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <br>
                                                                                @endif
                                                                                Thương hiệu: {{$cart->products->brand}}
                                                                            </p> <br>
                                                                            <a href="{{route('showStall',$cart->products->seller->id)}}" class="text-success"><i
                                                                                    class="icon text-success fa fa-shopping-basket"></i> {{$cart->products->seller->store_name}}
                                                                            </a> <br> <br>
{{--                                                                            <span class="mess-shop-cart"><i--}}
{{--                                                                                    class="icon fa fa-commenting"--}}
{{--                                                                                    style="margin-right: 3px"></i></span>--}}
                                                                        </figcaption>
                                                                    </figure>
                                                                </td>
                                                                <td data-qty="{{$cart->products->qty}}">
                                                                    @if($cart->qty <= $cart->products->qty)
                                                                        <input name="qty" type="number"
                                                                               class="form-control text-center product_qty"
                                                                               value="{{$cart->qty}}">
                                                                    @else
                                                                        <p style="color: red;">Đã hết hàng</p>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="price-wrap">
                                                                        <var
                                                                            class="price cart-price">{{number_format($cart->products->selling_price, 0, '', '.')}}
                                                                            đ</var> <br>
                                                                        <del
                                                                            class="text-muted">{{number_format($cart->products->original_price, 0, '', '.')}}
                                                                            đ
                                                                        </del>
                                                                    </div> <!-- price-wrap .// -->
                                                                </td>
                                                                <td class="text-right d-none d-md-block">
                                                                    <a type="button" href=""
                                                                       class="btn btn-light btn-delete"><i
                                                                            class="fa fa-trash"
                                                                            style="margin-right: 5px;"></i>Xóa</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            @php
                                                                $total += $cart->qty * $cart->products->selling_price;
                                                            @endphp
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div> <!-- card.// -->
                                        </aside> <!-- col.// -->
                                        <aside class="col-lg-3 col-sm-4 bill-cart">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h3></h3>
                                                </div> <!-- card-body.// -->
                                            </div> <!-- card.// -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <dl class="dlist-align">
                                                        <dt class="text-secondary">Tạm tính:</dt>
                                                        <dd class="text-right sum-price" data-original="0">0đ</dd>
                                                    </dl>
                                                    <hr style="background-color: rgb(196, 195, 195); height: 1px; border: none;">
                                                    @if($carts->count() > 0)
                                                        <a href="#" class="btn btn-danger btn-block disabled"
                                                           id="payment">Đi tới thanh toán</a>
                                                    @endif
                                                </div> <!-- card-body.// -->
                                            </div> <!-- card.// -->
                                        </aside> <!-- col.// -->
                                        <!-- table-responsive.// -->

                                    @else
                                        <div class="table-responsive text-center">
                                            <div style="margin-top: 50px; color: rgb(250, 157, 27); font-size: 18px;"><strong>Không có sản phẩm nào trong giỏ
                                                    hàng :<</strong></div>
                                        </div>
                                    @endif
                                </div> <!-- row.// -->
                            </div>
                        </section>
                    </main>

                </div>

                {{--  Chờ xác nhận --}}
                <div id="pending" class="tab-pane fade">
                    <main class="main-content">
                        <section class="summary-cart">
                            <div class="container">
                                <div class="row" style="width:75vw; height:500px; overflow:auto;">
                                    @if(count($orders_wait) > 0)
                                        <aside class="col-lg-9 col-sm-12 no-padding">
                                            @php $isDone = false; @endphp
                                            @foreach($orders_wait as $order)
                                                @php $isCancel = []; $c=0; $d=0; @endphp
                                                {{--Chạy 1 vòng để check trc--}}
                                                @foreach($order->order_items as $key => $item)
                                                    @if($item->process_status >= '3')
                                                        {{-- d dùng để check vs c khi đủ = nhau thì xóa khỏi tiến trình đơn đặt hàng     --}}
                                                        @php $isDone = true; $d++; @endphp
                                                    @endif
                                                    @php $c++; @endphp
                                                @endforeach
                                                {{-- Còn sản phẩm--}}
                                                @if(($isDone === false || $c > 1) && ($d < $c))
                                                    <div class="card waiting-confirm" data-order="{{$order->id}}">
                                                        <div class="table-responsive" style="width:75vw;">

                                                            <table
                                                                class="table table-borderless table-shopping-cart cart-title">
                                                                <thead class="text-muted">
                                                                @if($loop->first)
                                                                    <tr class="small text-uppercase">
                                                                        <th scope="col">Mã hóa đơn</th>
                                                                        <th scope="col">Sản phẩm</th>
                                                                        <th scope="col" width="100">Số lượng</th>
                                                                        <th scope="col"
                                                                            class="text-right d-none d-md-block">Giá
                                                                        </th>
                                                                        <th scope="col">Trạng thái</th>
                                                                    </tr>
                                                                @else
                                                                    <tr class="small text-uppercase">
                                                                        <th scope="col"></th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col" width="100"></th>
                                                                        <th scope="col"
                                                                            class="text-right d-none d-md-block"></th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                @endif

                                                                </thead>
                                                                <tbody>
                                                                @foreach($order->order_items as $key => $item)

                                                                        {{--Nếu vào đây thì set = fasle--}}
                                                                        <tr data-id="{{$item->id}}">
                                                                            @if($key === 0)
                                                                                <td rowspan="{{$item->count()}}">
                                                                                    #{{$order->bill_id}}
                                                                                    <br>
                                                                                    (<span style="font-size: 12px;">Ngày đặt: {{ date('d-m-Y', strtotime($item->created_at))}}</span>)
                                                                                </td>
                                                                            @endif

                                                                            <td>
                                                                                <figure
                                                                                    class="itemside align-items-center">
                                                                                    <div class="aside">
                                                                                        @if($item->products->productImages->count() > 0)
                                                                                            <img src="{{url(($item->products->productImages[0]->image != null) ?
                                                                                                $item->products->productImages[0]->image : '/img/giftbox.png')}}"
                                                                                                 class="img-sm">
                                                                                        @else
                                                                                            <img
                                                                                                src="{{url('/img/giftbox.png')}}"
                                                                                                class="img-sm">
                                                                                        @endif
                                                                                    </div>
                                                                                    <figcaption class="info">
                                                                                        <a href="{{url('/category/'.$item->products->category->slug.'/'.$item->products->id)}}"
                                                                                           class="title text-dark">
                                                                                            @php
                                                                                                $hidden_str = strlen(strip_tags($item->products->tittle)) > 30 ? '...' : '';
                                                                                                print_r(substr(strip_tags($item->products->tittle),0, 30) . $hidden_str);
                                                                                            @endphp
                                                                                        </a>
                                                                                        <p class="text-muted small">
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
                                                                                            Thương
                                                                                            hiệu: {{$item->products->brand}}
                                                                                        </p> <br>
                                                                                        <a href="{{route('showStall',$item->products->seller->id)}}"
                                                                                           class="text-success"><i
                                                                                                class="icon text-success fa fa-shopping-basket"></i> {{$item->products->seller->store_name}}
                                                                                        </a> <br> <br>
                                                                                    </figcaption>
                                                                                </figure>
                                                                            </td>
                                                                            <td>
                                                                                <input name="qty" type="number"
                                                                                       class="form-control text-center product_qty"
                                                                                       value="{{$item->qty}}" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <div class="price-wrap">
                                                                                    <div class="price-wrap text-right">
                                                                                        <var
                                                                                            class="price cart-price">{{number_format($item->products->selling_price * $item->qty, 0, '', '.')}}
                                                                                            đ</var>
                                                                                        @if($item->qty > 1)
                                                                                            <br>
                                                                                            <small
                                                                                                class="text-muted"> {{number_format($item->products->selling_price, 0, '', '.')}}
                                                                                                đ / sản phẩm</small>
                                                                                        @endif
                                                                                    </div> <!-- price-wrap .// -->
                                                                                </div> <!-- price-wrap .// -->
                                                                            </td>
                                                                            @if($item->process_status == '0')
                                                                                @php $isCancel[] = true; @endphp
                                                                                <td><span style="color: rgb(53, 101, 184); padding-top: 8px;">Chờ xác nhận</span></td>
                                                                            @elseif($item->process_status == '1')
                                                                                @php $isCancel[] = false; @endphp
                                                                                <td>Đã xác nhận</td>
                                                                            @elseif($item->process_status == '2')
                                                                                @php $isCancel[] = false; @endphp
                                                                                <td>
                                                                                    <p>Đang vận chuyển</p>
                                                                                    <small style="color: #e75b3c;"><b>Đã nhận
                                                                                        được hàng?</b></small>
                                                                                    <form
                                                                                        action="{{route('accept',$item->id)}}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        @method('put')
                                                                                        <button class="btn-success" style="border-radius: 2px; padding: 5px 10px;"
                                                                                                onclick="return confirm('Bạn có chắc muốn thanh toán cho sản phẩm này?')">
                                                                                            Đồng ý
                                                                                        </button>
                                                                                    </form>

                                                                                </td>
                                                                            @elseif($item->process_status == '3')
                                                                                @php $isCancel[] = false; @endphp
                                                                                <td>Đã giao</td>
                                                                            @endif
                                                                        </tr>

                                                                @endforeach

                                                                </tbody>

                                                            </table>
                                                        </div> <!-- table-responsive.// -->

                                                        <div class="shop-cart">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-xs-6"
                                                                     style="margin-top: 12px;">
                                                                    </div>
                                                                <div class="col-lg-6 col-xs-6 text-right">
                                                                    <span class="total-cart">Tổng tiền: {{number_format($order->price, 0, '', '.')}}đ</span>
                                                                    @if(isset($isCancel))
                                                                        @if(count(array_unique($isCancel)) === 1 && end($isCancel) === true)
                                                                            <form>
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                        class="cancel-shop-cart">Hủy
                                                                                    đơn hàng
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div> <!-- card-body.// -->

                                                    </div> <!-- card.// -->

                                                @else
                                                    @php $isDone = false; @endphp
                                                @endif
                                            @endforeach
                                        </aside> <!-- col.// -->
                                    @else
                                        <div class="table-responsive text-center">
                                            <div style="margin-top: 50px; color: rgb(27, 157, 250); font-size: 18px;"><strong>Không có sản phẩm nào trong tình trạng đơn hàng :<
                                                    </strong></div>
                                        </div>
                                    @endif
                                </div> <!-- row.// -->
                            </div>
                        </section>
                    </main>
                </div>

                {{--  Lịch sử mua hàng --}}
                <div id="history" class="tab-pane fade">
                    <main class="main-content">
                        <section class="summary-cart">
                            <div class="container">
                                <div class="row">
                                    @if(count($orders_wait) > 0)
                                        <aside class="col-lg-9 col-sm-12 no-padding">
                                            <div class="card waiting-confirm" data-order="{{$order->id}}">
                                                <div class="table-responsive" style="width:75vw; height:500px; overflow:auto;">
                                                    <table
                                                        class="table table-borderless table-shopping-cart cart-title">
                                                        <thead class="text-muted">
                                                        <tr class="small text-uppercase">
                                                            <th scope="col">Mã hóa đơn</th>
                                                            <th scope="col">Sản phẩm</th>
                                                            <th scope="col" width="100">Số lượng</th>
                                                            <th scope="col" class="text-right d-none d-md-block">Giá
                                                            </th>
                                                            <th scope="col">Trạng thái</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody   style="overflow: hidden;">
                                                        @foreach($orders_wait as $order)

                                                            @foreach($order->order_items as $key => $item)
                                                                @if($item->process_status == '3')
                                                                    <tr data-id="{{$item->id}}">
                                                                        <td>#{{$order->bill_id}}<br>
                                                                            (<span
                                                                                style="font-size: 12px;">Ngày đặt: {{ date('d-m-Y', strtotime($item->created_at))}}</span>)
                                                                        </td>
                                                                        <td>
                                                                            <figure class="itemside align-items-center">
                                                                                <div class="aside">
                                                                                    @if($item->products->productImages->count() > 0)
                                                                                        <img src="{{url(($item->products->productImages[0]->image != null) ?
                                                                                                $item->products->productImages[0]->image : '/img/giftbox.png')}}"
                                                                                             class="img-sm">
                                                                                    @else
                                                                                        <img
                                                                                            src="{{url('/img/giftbox.png')}}"
                                                                                            class="img-sm">
                                                                                    @endif
                                                                                </div>
                                                                                <figcaption class="info">
                                                                                    <a href="{{url('/category/'.$item->products->category->slug.'/'.$item->products->id)}}"
                                                                                       class="title text-dark">
                                                                                        @php
                                                                                            $hidden_str = strlen(strip_tags($item->products->tittle)) > 30 ? '...' : '';
                                                                                            print_r(substr(strip_tags($item->products->tittle),0, 30) . $hidden_str);
                                                                                        @endphp
                                                                                    </a>
                                                                                    <p class="text-muted small">
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
                                                                                        Thương
                                                                                        hiệu: {{$item->products->brand}}
                                                                                    </p> <br>
                                                                                    <a href="{{route('showStall',$item->products->seller->id)}}" class="text-success"><i
                                                                                            class="icon text-success fa fa-shopping-basket"></i> {{$item->products->seller->store_name}}
                                                                                    </a> <br> <br>
{{--                                                                                    <span class="mess-shop-cart"><i--}}
{{--                                                                                            class="icon fa fa-commenting"--}}
{{--                                                                                            style="margin-right: 3px"></i></span>--}}
                                                                                </figcaption>
                                                                            </figure>
                                                                        </td>
                                                                        <td>
                                                                            <input name="qty" type="number"
                                                                                   class="form-control text-center product_qty"
                                                                                   value="{{$item->qty}}" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <div class="price-wrap">
                                                                                <div class="price-wrap text-right">
                                                                                    <var
                                                                                        class="price cart-price">{{number_format($item->products->selling_price * $item->qty, 0, '', '.')}}
                                                                                        đ</var>
                                                                                    @if($item->qty > 1)
                                                                                        <br>
                                                                                        <small
                                                                                            class="text-muted"> {{number_format($item->products->selling_price, 0, '', '.')}}
                                                                                            đ / sản phẩm</small>
                                                                                    @endif
                                                                                </div> <!-- price-wrap .// -->
                                                                            </div> <!-- price-wrap .// -->
                                                                        </td>
                                                                        <td>
                                                                            Đã giao <br><br><br>
                                                                            <span><a type="button" class="btn btn-warning" href="{{url('/category/'.$item->products->category->slug.'/'.$item->products->id)}}">Đánh giá</a></span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                </div> <!-- table-responsive.// -->
                                            </div> <!-- card.// -->

                                        </aside> <!-- col.// -->
                                    @else
                                        <div class="table-responsive text-center">
                                            <div style="margin-top: 50px; color: rgb(138, 27, 250); font-size: 18px;"><strong>Không có sản phẩm nào trong lịch sử mua hàng :<</strong></div>
                                        </div>
                                    @endif
                                </div> <!-- row.// -->
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>

    <script>
        var start_price = parseInt($('.sum-price').attr('data-original')); // giá ban đầu của tổng tiền

        // Insert and Update Record with Dependent Dropdown
        function deleteProductAwayCart(cart_id) {
            let url = '{{route('cart.destroy', ':id')}}';
            url = url.replace(':id', cart_id);
            // console.log(url);
            $.ajax({
                method: "DELETE",
                url: url,
                success: (response) => {
                    if (response.code === 3) {
                        window.location.reload();
                        // Swal.fire(
                        //     '',
                        //     response.status,
                        //     'success'
                        // );

                        // $('#qty-cart').html(response.count);
                        // $(e.target).closest('tr').attr('data-id').remove();
                    }
                    alert(response.status);
                },
                error: (jqXHR, textStatus) => {
                    alert("Request failed: " + textStatus);
                    // dùng cái dưới nếu xảy ra lỗi
                    // alert( "Request failed: " + jqXHR.responseText );
                }
            })
        }

        function check_uncheck_checkbox(isChecked) {
            if (isChecked) {
                $('input[name="is_checked"]').each(function () {
                    this.checked = true;
                    $('#payment').addClass('disabled');
                });
            } else {
                $('input[name="is_checked"]').each(function () {
                    this.checked = false;
                    $('#payment').removeClass('disabled');
                });
            }
            calculatePriceByCheckbox();
        }

        function calculatePriceByCheckbox() {
            var amountToAdd = 0; //reset value
            // check each button to see if it has a clicked state.
            var checked = false;
            $("input[name='is_checked']").each(function () {
                if ($(this).is(":checked")) {
                    // cần tìm số lượng
                    var qty = $(this).closest('tr').find("input[name='qty']").val();
                    // console.log(qty);
                    amountToAdd += parseInt($(this).attr('data-price')) * parseInt(qty); // cộng dồn value
                    $('#payment').removeClass('disabled');
                    checked = true;
                }
            });

            if (!checked) {
                $('#payment').addClass('disabled');
            }

            var x = parseInt(amountToAdd + start_price);
            x = x.toLocaleString('it-IT', {style: 'currency', currency: 'VND'}); // convert to VND

            $('.sum-price').text(x.replace('VND', 'đ').replace(/\u00a0/g, ""));
        }

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
            $('.btn-delete').click((e) => {
                e.preventDefault();
                let cart_id = $(e.target).closest('tr').attr('data-id'); // phair dung e.target
                // let product_qty = $('.qty-input').val();
                // console.log(cart_id);

                // let data = {
                //     'cart_id': cart_id,
                //     'product_qty': product_qty,
                // }// chua phai json format
                if (!confirm("Bạn có muốn xóa sản phẩm đang chọn?")) {
                    return false;
                } // để ngăn việc delete nếu ấn cancel

                deleteProductAwayCart(cart_id);
            });

            // cập nhật số lượng
            $('.product_qty').on('change', (e) => {
                let cart_id = $(e.target).closest('tr').attr('data-id');
                let qty_input = $(e.target).html();
                let qty = parseInt($(e.target).val()); // phair dung e.target
                let product_qty = parseInt($(e.target).closest('td').attr('data-qty'));
                // if input value is changed, run the ajax call here
                // console.log(qty); //lay dc
                // console.log(cart_id);
                let url = '{{route('cart.update', ':id')}}';
                url = url.replace(':id', cart_id);
                // let data = {
                //     'product_qty': qty,
                // }// chua phai json format
                if (qty <= 0) {
                    if (!confirm("Bạn có muốn xóa sản phẩm đang chọn?")) {
                        window.location.reload();
                        return false;
                    } // để ngăn việc delete nếu ấn cancel
                    deleteProductAwayCart(cart_id);
                } else if (qty => 0 && qty <= product_qty) {
                    $.ajax({
                        method: "PUT",
                        url: url,
                        data: {
                            'product_qty': qty,
                        },
                        beforeSend: function () {
                            //We add this before send to disable the button once we submit it so that we prevent the multiple click
                            //prevent double click and disable the button after click
                            //also added content "Processing..." to the button
                            $(e.target).attr('disabled', true).html("Đang xử lý...");
                        },
                        success: function (response) {
                            // then on ajax success, display the results from your backend
                            if (response.code === 1) {
                                // $(e.target).val(response.qty); // cập nhật lại giá trị
                                // thay đổi lại giá tổng
                                calculatePriceByCheckbox(); // thành công
                                // window.location.reload();
                                $(e.target).attr('disabled', false).html(qty_input);
                            }else if (response.code === 2) {
                                window.location.reload();
                                alert(response.status);
                            }else {
                                window.location.reload();
                                alert(response.status);
                            }
                        },
                        error: (jqXHR, textStatus) => {
                            // alert( "Request failed: " + textStatus );
                            // dùng cái dưới nếu xảy ra lỗi
                            alert("Request failed: " + jqXHR.responseText);
                        }
                    })
                } else {
                    // $(e.target).val(product_qty);
                    alert('Sản phẩm trong kho không đủ');
                    window.location.reload();
                    return false;
                }
            })

            // change price
            // var start_price = parseInt($('.sum-price').attr('data-original'));

            $("input[name='is_checked']").click(function () {
                calculatePriceByCheckbox();
            });

            //
            $('#payment').on('click', (e) => {
                e.preventDefault();
                var prod_checked = [];
                $("input[name='is_checked']").each(function () {
                    if ($(this).is(":checked")) {
                        prod_checked.push($(this).closest('tr').attr('data-id')); // lay id of tr
                    }
                });
                // console.log(prod_checked)
                // neu checkbox dc click it nhat 1 sp
                if (prod_checked.length > 0) {
                    var prod_checked_enc = encodeURIComponent(JSON.stringify(prod_checked));
                    var url = '{{route('checkout.index', ':cart')}}';
                    url = url.replace(':cart', prod_checked_enc);
                    window.location.href = url;
                    // console.log(prod_checked_enc)
                    // console.log(url)
                }
            })

            $('.cancel-shop-cart').on('click', (e) => {
                e.preventDefault();

                if (!confirm("Bạn thật sự muốn hủy đơn hàng này?")) {
                    return false;
                } // để ngăn việc delete nếu ấn cancel

                let order_id = $(e.target).closest('div.waiting-confirm').attr('data-order');
                let url = '{{route('cancel', ':id')}}';
                url = url.replace(':id', order_id);
                // console.log(url);
                $.ajax({
                    method: "DELETE",
                    url: url,
                    success: (response) => {
                        if (response.status === 3) {
                            // window.location.reload();
                            // $('#qty-cart').html(response.count);
                            $(e.target).closest('div.waiting-confirm').attr('data-order', response.id).remove(); // xoa hang do di
                        }
                        alert(response.message);
                    },
                    error: (jqXHR, textStatus) => {
                        // alert( "Request failed: " + textStatus );
                        // dùng cái dưới nếu xảy ra lỗi
                        // alert( "Request failed: " + jqXHR.responseText );
                        console.log(jqXHR.responseText);
                    }
                })
            })
        });

        $(document).ready(function() {

            $("#btnSubmit").on("click", function() {
                var $this = $(this);

                $this.attr('disabled', true);
            });

        });
    </script>

@endsection
