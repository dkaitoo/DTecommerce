@extends('layouts.app')

@push('javascript')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
@endpush

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                {{-- <h3 class="breadcrumb-header">Thanh toán đơn hàng</h3> --}}
                <ul class="breadcrumb-tree">
                    <li><a href="{{route('home')}}">Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section" style="padding-top: 0px;">
    <!-- container -->
    <div class="container">
        <a href="{{route('cart.index')}}" style="color: #ff9735;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại giỏ hàng</a>

        <!-- row -->
        <div class="row">
            <form action="{{route('checkout.store', $prod_checked)}}" method="POST">
                @csrf
                <div class="col-sm-6">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Địa chỉ giao hàng</h3>
                        </div>
                        @include('flash-message')
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" placeholder="Họ Tên" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="email" placeholder="Email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="tel" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}" maxlength="10">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="address" placeholder="Số nhà/ Tên đường" value="{{old('address')}}">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="ls_province" name="ls_province"></select>

                            <input class="billing_address_1" name="city" type="hidden" value="">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="ls_district" name="ls_district"></select>
                            <select name="ls_ward" hidden></select>
                            <input class="billing_address_2" name="district" type="hidden" value="">
                        </div>
                        <!-- Order notes -->
                        <div class="form-group">
                            <textarea name="message" class="form-control" placeholder="Ghi chú (Nếu có)"></textarea>
                        </div>
                        <!-- /Order notes -->
                    </div>
                    <!-- /Billing Details -->
                </div>

                <!-- Order Details - xong -->
                <div class="col-sm-6 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Đơn hàng của bạn</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>Sản phẩm</strong></div>
                            <div><strong>Số lượng</strong></div>
                            <div><strong>Tổng</strong></div>
                        </div>
                        <div class="order-products">
                            @php
                                $sum_price = 0;
                            @endphp
                        @foreach($chosen_carts as $cart)
                            @php
                                $price_product = $cart->products->selling_price * $cart->qty;
                                $sum_price += $price_product;
                            @endphp
                            <div class="order-col" data-price="{{$price_product}}">
                                <div>
                                    {{$cart->products->name}} <br>
                                    <p class="text-muted small">
                                        @if($attributes_all and json_decode($cart->chosen_attribute))
                                            @foreach($attributes_all as $attribute)
                                                @php
                                                    $chosen_attr = json_decode($cart->chosen_attribute);
                                                @endphp
                                                @if(in_array($attribute->id,$chosen_attr))
                                                    {{ $loop->first ? '' : '/' }}
                                                    @if($attribute->name === 'color')
                                                        <i class='fa fa-paint-brush' style='font-size:12px;color:{{$attribute->value}};' aria-hidden='true'></i>
                                                    @else
                                                        <span>
                                                            {!! $attribute->value !!}
                                                        </span>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <br>
                                    @endif
                                </div>
                                <div>x <span>{{$cart->qty}}</span></div>
                                <div><b>{{number_format($price_product, 0, '', '.')}}đ</b></div>
                            </div>
                        @endforeach
                        </div>
                        <div class="order-col">
                            <div>Phí vận chuyển</div>
                            <div></div>
                            <div><strong>20.000đ</strong></div>
                        </div>
                        @if($sum_price > 100000)
                            <div class="order-col">
                                <div style="color: #ff9035">Miễn phí giao hàng với đơn trên 100.000đ</div>
                                <div></div>
                                <div><del>20.000đ</del></div>
                            </div>
                        @endif
                        <input type="hidden" name="price" value="{{($sum_price < 100000) ? ($sum_price + 20000) :  $sum_price}}">
                        <div class="order-col">
                            <div><strong>TỔNG ĐƠN HÀNG</strong></div>
                            <div></div>
                            <div><strong class="order-total">{{number_format(($sum_price < 100000) ? ($sum_price + 20000) :  $sum_price, 0, '', '.')}}đ</strong></div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1" value="1">
                            <label for="payment-1">
                                <span></span>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-2" value="2">
                            <label for="payment-2">
                                <span></span>
                                Thanh toán online
                            </label>
                            <div class="caption">
                                <div class="form-group">
                                    <label for="bank_code">Ngân hàng</label>
                                    <select name="bank_code" id="bank_code" class="form-control">
                                        <option value="">Không chọn</option>
                                        <option value="NCB"> Ngân hàng NCB</option>
                                        <option value="AGRIBANK"> Ngân hàng Agribank</option>
                                        <option value="SCB"> Ngân hàng SCB</option>
                                        <option value="SACOMBANK">Ngân hàng SacomBank</option>
                                        <option value="EXIMBANK"> Ngân hàng EximBank</option>
                                        <option value="MSBANK"> Ngân hàng MSBANK</option>
                                        <option value="NAMABANK"> Ngân hàng NamABank</option>
                                        <option value="VNMART"> Vi dien tu VnMart</option>
                                        <option value="VIETINBANK">Ngân hàng Vietinbank</option>
                                        <option value="VIETCOMBANK"> Ngân hàng VCB</option>
                                        <option value="HDBANK">Ngân hàng HDBank</option>
                                        <option value="DONGABANK"> Ngân hàng Dong A</option>
                                        <option value="TPBANK"> Ngân hàng TPBank</option>
                                        <option value="OJB"> Ngân hàng OceanBank</option>
                                        <option value="BIDV"> Ngân hàng BIDV</option>
                                        <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                                        <option value="VPBANK"> Ngân hàng VPBank</option>
                                        <option value="MBBANK"> Ngân hàng MBBank</option>
                                        <option value="ACB"> Ngân hàng ACB</option>
                                        <option value="OCB"> Ngân hàng OCB</option>
                                        <option value="IVB"> Ngân hàng IVB</option>
                                        <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="checkbox" id="terms" required/>
                    <label for="terms" style="margin-bottom: 20px;">
                        <span></span>
                        Tôi đã đọc và chấp nhận <a href="#">các điều khoản</a>
                    </label>
                    <button id="order-product" type="submit" class="primary-btn" style="width: 100%;" name="redirect">Đặt hàng</button>
                </div>
                <!-- /Order Details -->

            </form>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<script src="{{asset('js/vietnamlocalselector.min.js')}}"></script>
<script>
    var localpicker = new LocalPicker({
        province: "ls_province",
        district: "ls_district",
        // ward: "ls_ward"
    });

    $('#ls_province').on('change',(e)=>{
        var address_1 = $('select[name="ls_province"] option:selected').text();
        $('input.billing_address_1').attr('value', address_1);
        console.log(address_1);
    })
    $('#ls_district').on('change',(e)=>{
        var address_2 = $('select[name="ls_district"] option:selected').text();
        $('input.billing_address_2').attr('value', address_2);
        console.log(address_2);
    })
</script>

@endsection
