@extends('admin.layouts.app')

@section('content')
<div class="main-panel" id="main-panel">
  <div class="panel-header panel-header-sm"></div>

    <div class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-user">
            <div class="image">
              <img src="{{asset('img/background-Login.jpg')}}" alt="...">
            </div>
            <div class="card-body">
              <div class="author">
                @if($user->profileUser)
                  <img class="avatar border-gray" src="{{url(($user->profileUser->avatar != null) ? $user->profileUser->avatar : '/img/avatar.jpg')}}" alt="Img">
                @else
                  <img class="avatar border-gray" src="{{asset('img/avatar.jpg')}}" alt="Img">
                @endif
                <h5 class="title">{{$user->name}}</h5>
                <p class="description">
                    {{$user->email}}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <a href="{{route('user.index')}}" class="text-success"><i class="fa fa-solid fa-2x fa-angle-left mb-2"></i></a>
              <h5 class="title">Hồ sơ của {{$user->name}}</h5>
            </div>
            <div class="card-body">
              @if($user->profileUser)
              <form>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                      <label>Họ tên</label>
                      <input type="text" class="form-control" disabled="" placeholder="Username" value="{{$user->name}}">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" disabled="" placeholder="Email" value="{{$user->email}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Số điện thoại</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="{{($user->profileUser->phone != null) ? $user->profileUser->phone : 'Chưa cập nhật'}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="{{($user->profileUser->address != null) ? $user->profileUser->address : 'Chưa cập nhật'}}">
                    </div>
                  </div>
                </div>
              </form>
              @else
              <form>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" disabled="" placeholder="Username" value="{{$user->name}}">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" disabled="" placeholder="Email" value="{{$user->email}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Số điện thoại</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="Chưa cập nhật">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Địa chỉ</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="Chưa cập nhật">
                    </div>
                  </div>
                </div>
              </form>
              @endif
            </div>
          </div>
        </div>
      </div>



      {{-- <div class="row">
        <div class="col-md-4">
          <div class="card card-user">
            <div class="image">
              <img src="{{asset('img/background-Login.jpg')}}" alt="...">
            </div>
            <div class="card-body">
              <div class="author">
                  <img class="avatar border-gray" src="{{asset('img/avatar.jpg')}}" alt="Img">
                  <h5 class="title">SELLER</h5>
                  <p class="description">
                    seller@gmail.com
                  </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <a href="{{route('user.index')}}" class="text-success"><i class="fa fa-solid fa-2x fa-angle-left mb-2"></i></a>
              <h5 class="title">View Profile</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" disabled="" placeholder="Username" value="user">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="identity_card">Identity Card</label>
                      <input type="text" class="form-control" disabled="" placeholder="identity_card" value="identity_card">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                      <label>Store Name</label>
                      <input type="text" class="form-control" disabled="" placeholder="store_name" value="store_name">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="Logo">Logo</label>
                      <input type="text" class="form-control" disabled="" placeholder="Logo" value="Logo">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Số điện thoại</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="0918999888">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control" disabled="" placeholder="Home Address" value="Q7, HCM">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>  --}}
    </div>

</div>

@endsection
