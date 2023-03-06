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
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-8">
                  <div class="card">
                      <div class="card-header"><h5 class="text-primary text-uppercase"><b>Thay đổi mật khẩu</b></h5></div>

                      <form action="{{ route('changePwdSellerEdit') }}" method="POST">
                          @csrf
                          <div class="card-body" style="font-size: 16px;">
                              @include('flash-message')
                              <div class="mb-3 form-group">
                                  <label for="oldPasswordInput" class="form-label">Mật khẩu cũ</label>
                                  <input name="old_password" type="password"
                                         class="form-control @error('old_password') is-invalid @enderror"
                                         id="oldPasswordInput"
                                         placeholder="Nhập mật khẩu cũ">
                                  @error('old_password')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                              <div class="mb-3 form-group">
                                  <label for="newPasswordInput" class="form-label">Mật khẩu mới</label>
                                  <input name="new_password" type="password"
                                         class="form-control @error('new_password') is-invalid @enderror"
                                         id="newPasswordInput"
                                         placeholder="Nhập mật khẩu mới">
                                  @error('new_password')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                              <div class="mb-3 form-group">
                                  <label for="confirmNewPasswordInput" class="form-label">Xác nhận lại mật khẩu
                                      mới</label>
                                  <input name="new_password_confirmation" type="password" class="form-control"
                                         id="confirmNewPasswordInput"
                                         placeholder="Nhập xác nhận lại mật khẩu mới">
                              </div>

                          </div>

                          <div class="card-footer">
                              <button class="btn btn-primary"><b>Lưu</b></button>
                          </div>

                      </form>
                  </div>
              </div>
          </div>
      </div>
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
            $("#tab-3").addClass("active");
        });
    </script>
@endsection
