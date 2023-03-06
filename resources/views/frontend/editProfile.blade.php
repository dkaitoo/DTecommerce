@extends('layouts.app')

@section('content')

    <div class="container">
        <ul class="nav nav-tabs" style="margin-top: 20px;">
            <li class="active"><a class="cart-menu" data-toggle="tab" href="#info">Thông tin tài khoản</a></li>
            {{--Tai khoan uy quyen k dc doi mat khau--}}
            @if(!auth()->user()->id_social)
                <li class="pending"><a href="{{route('changePwdClient')}}">Đổi mật khẩu</a></li>
            @endif
        </ul>

        <div class="tab-content">
            <div class="tab-content">
                <div id="info" class="tab-pane active">
                    <main class="main-content">
                        <!-- container -->
                        <div class="container card-edit">
                            <form novalidate id="post-update-edit" method="post"
                                  action="{{route('profileClientEdit')}}" enctype="multipart/form-data">
                                {{--Phai co cai nay--}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-5 col-xs-5 border-right">
                                        <div
                                            class="d-flex flex-column align-items-center text-center p-4 py-6 profile-info-left">
                                            <div class="text-center">
                                                <p class="profile-ava mt-3">Cập nhật hình ảnh</p>
                                                <div class="profile-img w-shadow">
                                                    <div class="profile-img-overlay"></div>
                                                    <img id="avatar-profile" width="150px"
                                                         src="{{ config('app.url_image'). 'storage/users-avatar/'. $user->avatar ?? 'default-avatar.png'}}"
                                                         alt="Avatar" class="avatar img-circle">
                                                    <div class="profile-img-caption">
                                                        <input name="avatar_hidden" type="hidden" class=""
                                                               value="{{ $user->avatar ?? 'default-avatar.png'}}">
                                                        <label for="updateProfilePic" class="upload">
                                                            <i class='bx bxs-camera'></i> Upload
                                                            <input value="" name="avatar" type="file"
                                                                   id="gallery-photo-add" accept="image/"
                                                                   class="text-center upload" onchange="readURL(this);">
                                                        </label>
                                                    </div>
                                                </div>
                                                <p class="profile-fullname mt-3">{{$user->name}}</p>
                                                <p class="profile-username mb-3 text-muted">{{$user->email}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-xs-7 border-right">
                                        <div class=" p-3 py-5">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <p class="profile-edit text-center">Chỉnh sửa thông tin cá nhân</p>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group">
                                                    @include('flash-message')
                                                </div>
                                            </div>

                                            <input name="_id" id="_id" type="hidden" value="">
                                            <div class="row mt-3">
                                                <div class="form-group">
                                                    <label for="name">Họ tên</label>
                                                    <input value="{{$user->name}}" name="name" required
                                                           class="form-control" type="text" placeholder="Nhập Họ tên"
                                                           id="name">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input value="{{$user->email}}" name="email" required
                                                           class="form-control" type="email" placeholder="Nhập Email"
                                                           id="email" readonly>
                                                </div>
                                            </div>
                                            @if($user->profileUser)
                                                <div class="row mt-3">
                                                    <div class="form-group">
                                                        <label for="phone">Số điện thoại</label>
                                                        <input
                                                            value="{{($user->profileUser->phone != null) ? $user->profileUser->phone : ''}}"
                                                            name="phone" required class="form-control" type="text"
                                                            placeholder="Nhập số điện thoại" id="phone" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="form-group">
                                                        <label for="address">Địa chỉ</label>
                                                        <input
                                                            value="{{($user->profileUser->address != null) ? $user->profileUser->address : ''}}"
                                                            name="address" required class="form-control" type="text"
                                                            placeholder="Nhập địa chỉ" id="address">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row mt-3">
                                                    <div class="form-group">
                                                        <label for="phone">Số điện thoại</label>
                                                        <input value=""
                                                               name="phone" required class="form-control" type="text"
                                                               placeholder="Nhập số điện thoại" id="phone"
                                                               maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="form-group">
                                                        <label for="address">Địa chỉ</label>
                                                        <input value=""
                                                               name="address" required class="form-control" type="text"
                                                               placeholder="Nhập địa chỉ" id="address">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="text-center btn-edit">
                                                <button class="btn btn-primary profile-button" type="submit">Cập nhật
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /container -->

                    </main>

                </div>

                <div id="changePassword" class="tab-pane">

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

        $(document).ready(function() {
            $(".tab").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-5").addClass("active");
        });

    </script>

@endsection
