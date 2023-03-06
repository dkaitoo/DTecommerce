@extends('seller.layouts.app')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="main-panel" id="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <!-- Hiện thanh menu khi thu nhỏ -->
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="{{route('home')}}" title="Đến trang chủ" style="font-size: 17px;"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>

        <ul class="nav navbar-nav" id="notify-menu">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
                <a href="{{url('/chatify')}}" class="dropdown-toggle" style="font-size: 17px;">
                    <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i>
                    @if($wait_mess = \App\Models\ChMessage::where(['to_id'=>Auth::user()->id, 'seen'=> '0'])->count())
                            @if($wait_mess > 0)
                                <span class="label label-success label-float">
                                    {{$wait_mess}}
                                </span>
                            @endif
                        @endif

                </a>

            </li>
        </ul>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      </button>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
      <form action="{{route('profileSellerEdit')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row justify-content-center">
{{--              <div class="col-md-4">--}}
{{--                  <div class="card card-user m-auto">--}}
{{--                      <div class="card-body">--}}
{{--                          <div class="picture-container">--}}
{{--                              <h6 class="">Ảnh tài khoản</h6>--}}
{{--                              <div class="picture">--}}
{{--                                  <input name="avatar_hidden" type="hidden" class="" value="{{ $user->avatar ?? 'default-avatar.png'}}">--}}
{{--                                  <img src="{{ config('app.url_image'). 'storage/users-avatar/'. $user->avatar ?? 'default-avatar.png'}}"--}}
{{--                                       class="picture-src" id="avatar-profile" title="">--}}
{{--                                  <input name="avatar" type="file" id="gallery-photo-add" class=""--}}
{{--                                         accept="image/*">--}}
{{--                              </div>--}}
{{--                              <p class="mt-2" style="font-size:16px;"><b>Chọn ảnh</b></p><br>--}}
{{--                              <p class="profile-fullname" style="font-size:18px; margin:0px;"><b>{{$user->name}}</b></p>--}}
{{--                              <p class="text-muted" style="font-size:16px;">{{$user->email}}</p>--}}
{{--                          </div>--}}
{{--                      </div>--}}

{{--                  </div>--}}
{{--              </div>--}}
              <div class="col-md-8">
                  <div class="card">
                      <a href="{{route('profileStore')}}" style="float: right; font-size: 1.15em;" class="text-primary m-4">Thông tin gian hàng</a>
                      <div class="card-header">
                          <h5 class="title text-primary">THÔNG TIN NHÀ BÁN HÀNG</h5>
                          @include('flash-message')
                      </div>
                      <div class="card-body" style="font-size: 16px;">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label>Họ và tên người quản lý gian hàng</label>
                                      <input name="name" type="text" class="form-control" placeholder="Họ và tên người quản lý gian hàng"
                                             value="{{$user->profileSeller->name}}">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label>CMND/CCCD</label>
                                      <input name="identity_card" type="text" class="form-control" placeholder="CMND/CCCD" maxlength="12"
                                             value="{{$user->profileSeller->identity_card}}">
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
                                                 placeholder="Số điện thoại"
                                                 value="{{($user->profileSeller->phone != null) ? $user->profileSeller->phone : ''}}"  maxlength="10">
                                      </div>
                                  </div>
                              </div>
                          @else
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label>Số điện thoại</label>
                                          <input name="phone" type="text" class="form-control"
                                                 placeholder="Số điện thoại" value="">
                                      </div>
                                  </div>
                              </div>
                          @endif
                          <button type="submit" class="btn btn-primary btn--m btn--inline"
                                  aria-disabled="false"><b>Lưu</b>
                          </button>

                      </div>
                  </div>
              </div>
          </div>
      </form>
  </div>
  <footer class="footer">
    <div class=" container-fluid ">
      <div class="copyright" id="copyright">
        &copy; 2022, Designed by DT
      </div>
    </div>
  </footer>
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
            $("#tab-2").addClass("active");
        });
    </script>
@endsection
