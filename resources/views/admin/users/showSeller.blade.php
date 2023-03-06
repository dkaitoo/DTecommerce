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
                  <img class="avatar border-gray" src="{{url(($seller->logo != null) ? $seller->logo : '/img/logoStore.png')}}" alt="Img">
                  <h5 class="title">{{$seller->store_name}}</h5>
                  <div>
                      @if(!$seller->approved)
                          <form action="{{route('seller.update',$seller->id)}}" method="post">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-success">Duyệt</button>
                          </form>
                          <form action="{{route('seller.destroy',$seller->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger">Từ chối</button>
                          </form>
                      @endif
                  </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <a href="{{route('seller.index')}}" class="text-success"><i class="fa fa-solid fa-2x fa-angle-left mb-2"></i></a>
              <h5 class="title">Hồ sơ nhà bán</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" class="form-control" disabled="" placeholder="Họ tên" value="{{$seller->name}}">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="identity_card">CCCD/CMND</label>
                      <input type="text" class="form-control" disabled="" placeholder="CCCD/CMND" value="{{$seller->identity_card}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 pr-1">
                    <div class="form-group">
                      <label>Tên cửa hàng</label>
                      <input type="text" class="form-control" disabled="" placeholder="Tên cửa hàng" value="{{$seller->store_name}}">
                    </div>
                  </div>
                  <div class="col-md-6 pl-1">
                    <div class="form-group">
                      <label for="Logo">Email</label>
                      <input type="text" class="form-control" disabled="" placeholder="Email" value="{{($seller->user->email != null) ? $seller->user->email : 'Chưa cập nhật email'}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Số điện thoại</label>
                      <input type="text" class="form-control" disabled="" placeholder="Số điện thoại" value="{{$seller->phone}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Địa chỉ bán hàng</label>
                      <input type="text" class="form-control" disabled="" placeholder="Địa chỉ bán hàng" value="{{$seller->address}}">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

@endsection
