@extends('layouts.auth.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
                <form>
                  <div class="d-flex mb-3 pb-1">
                    <div class="col-md-1">
                      <a href="./login.html" class="link-dark"><i class="fa fa-solid fa-2x me-3 fa-angle-left"></i></a>
                    </div>
                    <div class="col-md-11">
                      <i class="fa fa-shopping-bag fa-2x me-1" style="color: #198754;"></i>
                      <span class="h3 fw-normal mb-0">DT ECOMMERCE</span>
                    </div>
                  </div>

                  <h4 class="fw-bold text-center mb-3 pb-3" style="letter-spacing: 1px;">Quên mật khẩu</h4>

                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="formEmail" placeholder="Email">
                    <label for="formEmail">Email</label>
                  </div>
                  <div class="d-grid pt-1 mb-2">
                    <button class="btn btn-success btn-lg btn-block" type="button">Xác nhận</button>
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
