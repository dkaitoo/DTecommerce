@extends('layouts.auth.app')

@section('content')
<div class="container py-3 h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-sm-9 col-md-12 col-lg-12 col-xl-9">
        <div class="card" style="border-radius: 1rem;">
          <div class="row">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{asset('img/Ava-Login.jpg')}}"
                alt="Avatar login" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7">
              <div class="card-body p-4 p-lg-5">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form novalidate method="POST" action="{{ route('password.email') }}">
                @csrf
                  <div class="d-flex mb-3 pb-1">
                    <div class="col-md-1">
                      <a href="../login" class="link-dark"><i class="fa fa-solid fa-2x me-3 fa-angle-left"></i></a>
                    </div>
                    <div class="col-md-11">
                      <i class="fa fa-shopping-bag fa-2x me-1" style="color: #198754;"></i>
                      <span class="h3 fw-normal mb-0">DT ECOMMERCE</span>
                    </div>
                  </div>

                  <h4 class="fw-bold text-center mb-3 pb-3" style="letter-spacing: 1px;">{{ __('Quên mật khẩu') }}</h4>

                  <div class="form-floating mb-3">
                    <input type="email" id="email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <label for="email">{{ __('Email') }}</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="d-grid pt-1 mb-2">
                    <button class="btn btn-success btn-lg btn-block" type="submit">{{ __('Xác nhận') }}</button>
                  </div>
                  <p class="mt-4 mb-2 pb-lg-2" style="color: #693981;">Bạn chưa có tài khoản? <a href="./register.html"
                      style="color: #693981;">Đăng ký ngay</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
