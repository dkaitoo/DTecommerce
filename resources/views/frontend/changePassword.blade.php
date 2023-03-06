@extends('layouts.app')

@section('content')

<div class="container">
    <ul class="nav nav-tabs" style="margin-top: 20px;">
      <li class="pending"><a class="cart-menu" href="{{route('profileClient')}}">Thông tin tài khoản</a></li>
      <li class="active"><a data-toggle="tab" href="#changePassword">Đổi mật khẩu</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-content">
            <div id="info" class="tab-pane active"></div>

            <div id="changePassword" class="tab-pane active">
                <main class="main-content">
                    <!-- container -->
                    <div class="container card-edit">
                        <form action="{{route('changePwdClientEdit')}}" id="post-update-edit" method="post">
                            @csrf
                            <div class="row justify-content-center" style="margin: auto; max-width: 700px;">
                                <div class=" p-3 py-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <p class="profile-edit text-center">Đổi mật khẩu</p>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group">
                                            @include('flash-message')
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group">
                                            <label class="form-label">Mật khẩu cũ</label>
                                            <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                                   placeholder="Nhập mật khẩu cũ">
                                            @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group">
                                            <label class="form-label">Mật khẩu mới</label>
                                            <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                                   placeholder="Nhập mật khẩu mới">
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group">
                                            <label class="form-label">Xác nhận mật khẩu mới</label>
                                            <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                                   placeholder="Nhập xác nhận lại mật khẩu mới">
                                        </div>
                                    </div>
                                    <div class="text-center btn-edit"><button class="btn btn-primary profile-button" type="submit">Đổi mật khẩu</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /container -->
                </main>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            // change image
            var imagesPreview = function (input) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#avatar-profile').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#gallery-photo-add').on('change', function () {
                imagesPreview(this);
            });
        });
    </script>

@endsection
