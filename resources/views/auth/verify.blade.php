@extends('layouts.auth.app')

@section('content')
<div class="container py-3 h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-sm-9 col-md-12 col-lg-12 col-xl-9">
        <div class="card" style="border-radius: 1rem;">
          <div class="row">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{asset('img/Ava-Login.jpg') }}"
                alt="Avatar login" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7">
                <div>
                    <a class="text-black pull-right" style="text-decoration: none; padding: 10px;"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

              <div class="card-body p-4 p-lg-5">

                  <div class="d-flex mb-3 pb-1">
                    <div class="col-md-12">
                      <i class="fa fa-shopping-bag fa-2x me-1" style="color: #198754;"></i>
                      <span class="h3 fw-normal mb-0">DT ECOMMERCE</span>
                    </div>

                  </div>


                  <h4 class="fw-bold text-center mb-3 pb-3" style="letter-spacing: 1px;">Xác thực email</h4>

                  @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Một liên kết xác thực mới đã được gửi đến địa chỉ email của bạn.') }}
                        </div>
                  @endif
                  {{ __('Trước khi tiếp tục, vui lòng kiểm tra email của bạn để biết liên kết xác thực.') }}
                  {{ __('Nếu bạn không nhận được email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('hãy nhấp vào đây để yêu cầu gửi lại.') }}</button>.
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
