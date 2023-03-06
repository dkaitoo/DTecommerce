@extends('seller.layouts.app')
@section('content')
<div class="main-panel" id="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
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
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title text-primary text-uppercase"> <b>Danh sách SẢN PHẨM</b></h4>
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <form>
                  <div class="input-group no-border">
                  <input type="text" value="" class="form-control" placeholder="Search...">
                  <div class="input-group-append">
                    <div class="input-group-text">
                    <i class="fa fa-search fa-lg"></i>
                    </div>
                  </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th><b>STT?Mã sản phẩm</b></th>
                  <th><b>Hình ảnh</b></th>
                  <th><b>Tên sản phẩm</b></th>
                  <th><b>Loại sản phẩm</b></th>
                  <th><b>Giá bán</b></th>
                  <th class="text-right"><b>Thao tác</b></th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      Số thứ tự hoặc mã
                    </td>
                    <td>
                      <img src="./img/avatar.jpg" class="img-type-product">
                    </td>
                    <td>
                      components
                    <td>
                      Bao gồm: vga, cpu, mainboard, ...
                    </td>
                    <td>
                    190000 VND
                    </td>
                    <td class="text-right ">
                      <a href="#editAccount" data-toggle="modal" style="margin-right:2vw"><i class="fa fa-pencil fa-2x text-warning" ></i></a>
                      <a href="#deleteAccount" data-toggle="modal"><i class="fa fa-trash fa-2x text-danger" ></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="clearfix">
                <ul class="pagination" style="float:right">
                  <li class="page-item"><a href="#" class="page-link">Previous</a></li>
                  <li class="page-item active"><a href="#" class="page-link">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link">4</a></li>
                  <li class="page-item"><a href="#" class="page-link">5</a></li>
                  <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class=" container-fluid ">
      <div class="copyright" id="copyright">
        &copy; 2022, Designed by DT Coded by Di
      </div>
    </div>
  </footer>
</div>
<script>
    $(document).ready(function() {
        $(".tab").removeClass("active");
        // $(".tab").addClass("active"); // instead of this do the below
        $("#tab-5").addClass("active");
    });
</script>
@endsection
