@extends('admin.layouts.app')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <div class="main-panel" id="main-panel">
        <div class="panel-header panel-header-sm">
        </div>

        <div class="content">

            <form action="{{route('profileAdminEdit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-user m-auto">
                            <div class="card-body">
                                <div class="picture-container">
                                    <div class="picture">
                                        <input name="avatar_hidden" type="hidden" class="" value="{{ $user->avatar ?? 'default-avatar.png'}}">
                                        <img src="{{ config('app.url_image'). 'storage/users-avatar/'. $user->avatar ?? 'default-avatar.png'}}"
                                             class="picture-src" id="avatar-profile" title="">
                                        <input name="avatar" type="file" id="gallery-photo-add" class=""
                                               accept="image/*">
                                    </div>
                                    <p class="mt-2" style="font-size:16px;"><b>Chọn ảnh</b></p><br>
                                    <p class="profile-fullname" style="font-size:18px; margin:0px;"><b>{{$user->name}}</b></p>
                                    <p class="text-muted" style="font-size:14px;">{{$user->email}}</p>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="title mt-3">Hồ sơ quản trị viên</h3>
                                @include('flash-message')

                            </div>
                            <div class="card-body" style="font-size: 22px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <input name="name" type="text" class="form-control" placeholder="Họ tên"
                                                   value="{{$user->name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input name="email" type="email" class="form-control" placeholder="Email"
                                                   value="{{$user->email}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                @if($user->profileUser)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input name="phone" type="text" class="form-control"
                                                       placeholder="Nhập số điện thoại"
                                                       value="{{($user->profileUser->phone != null) ? $user->profileUser->phone : ''}}"  maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <input name="address" type="text" class="form-control"
                                                       placeholder="Nhập địa chỉ"
                                                       value="{{($user->profileUser->address != null) ? $user->profileUser->address : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input name="phone" type="text" class="form-control"
                                                       placeholder="Nhập số điện thoại" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="address" type="text" class="form-control"
                                                       placeholder="Nhập địa chỉ" value="">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-success btn--m btn--inline"
                                        aria-disabled="false">Lưu
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>


        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
