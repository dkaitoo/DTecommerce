@extends('layouts.auth.app')

@section('content')
<div class="container py-3 h-100">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col col-sm-9 col-md-12 col-lg-12 col-xl-9">
            <div class="card" style="border-radius: 1rem;">
                <div class="row">
                    {{-- left image--}}
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="./img/Ava-Login.jpg"
                             alt="Avatar login" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>

                    {{-- form--}}
                    <div class="col-md-6 col-lg-7">
                        <div class="card-body p-lg-4">
                            <form novalidate method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <a href="./home" class="link-dark"><i class="fa fa-solid fa-2x me-3 fa-angle-left"></i></a>
                                    <i class="fa fa-shopping-bag fa-2x me-1" style="color: #198754;"></i>
                                    <span class="h3 fw-normal mb-0">DT ECOMMERCE</span>
                                </div>

                                <h4 class="fw-bold text-center mb-3" style="letter-spacing: 1px;">Đăng nhập</h4>

                                @include('flash-message')

                                <div class="input-field">
                                    <input id="email" type="text" class="form-control inputEmail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    <label>{{ __('Email') }}</label>

                                </div>
                                <div class="input-field">
                                    <input id="password" type="password" class="form-control pswrd inputEmail" name="password" required autocomplete="current-password">

                                    <label>Mật khẩu</label>
                                    <span class="show"><p style="background-color: #ffffff; color:#198754; margin:auto" > SHOW </p></span>

                                </div>

                                <div class="d-grid pt-1 mb-2">

                                    <button class="btn btn-success btn-lg btn-block" type="submit">Đăng nhập</button>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="mt-4 small text-muted" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                                @endif

                                @if (Route::has('register'))
                                    <p class="mb-2 pb-lg-2" style="color: #693981;">Bạn chưa có tài khoản? <a href="{{ route('register') }}"
                                                                                                              style="color: #693981;">{{ __('Đăng ký ngay') }}</a></p>
                                @endif

                                <div class="or-seperator" style><b>Hoặc</b></div>
                                <div class="row-md-6 justify-content-center text-center">
                                    <a class="fb btn-login" href="{{ route('auth.facebook') }}" style="text-decoration: none;"><i class="fa fa-facebook-f me-2"></i><span>Đăng nhập với Facebook</span></a>
                                </div>
                                    <div class="row-md-6 justify-content-center text-center">
                                        <a class="google btn-login" href="{{ route('auth.google') }}" style="text-decoration: none;"><i class="fa fa-google me-2"></i>Đăng nhập với Google</a>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '602785314866176',
            cookie     : true,
            xfbml      : true,
            version    : '{v2.7}'
        });

        FB.AppEvents.logPageView();

    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@endsection
