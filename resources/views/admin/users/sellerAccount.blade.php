@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endpush

@section('content')
    <div class="main-panel" id="main-panel">

      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body" style="margin: 20px;">
                <h2 class="card-title text-success text-uppercase"> <b>Danh sách tài khoản đăng ký bán hàng</b></h2>
                <div class="row">
{{--                  <div class="col-md-4">--}}
{{--                    <a href="#addAccount" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> <span style="font-size: 1.2rem;">&nbsp;Duyệt đăng ký bán hàng</span></a>--}}
{{--                  </div>--}}
                </div>
                  <div class="table-responsive">
                      <table class="table table-bordered data-table" width="99%">
                          <thead class="text-success">
                      <th><b>STT</b></th>
                      <th><b>Tên cửa hàng</b></th>
                      <th><b>Tên nhà bán hàng</b></th>
                      <th><b>Số điện thoại</b></th>
                      <th><b>Kiểm duyệt</b></th>
                      <th><b>Thao tác</b></th>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" name="categoryForm" class="form-horizontal" enctype="multipart/form-data" >
                        <div id="error" class="alert alert-danger alert-block d-none">
                        </div>
                        {{--                        Dùng cái này vì nó tương ứng id trên csdl--}}

                        <input type="hidden" name="category_id" id="category_id">
                        <div class="form-group">
                            <label for="name">Tên thể loại</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" >
                        </div>
                        <div class="form-group">
                            <label for="slug">Tên miền URI</label>
                            {{--                            Thêm cái span ví dụ /electronics--}}
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug" value="" maxlength="50" >
                        </div>
                        <div class="form-group">
                            <label for="meta_title">Tiêu đề hiển thị</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" value="" maxlength="50" >

                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter Description" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <input type="checkbox" name="status" id="status">

                            <label for="popular">Phổ biến</label>
                            <input type="checkbox" name="popular" id="popular">
                        </div>
                        <div>
                            <input id="image" type="file" placeholder="Choose image" name="image" accept="image/*" onchange="readURL(this);">
                            <input type="hidden" name="hidden_image" id="hidden_image">
                        </div>
                        <img id="modal-preview" src="{{ url('/img/default_category.jpg') }}" alt="Preview" class="form-group hidden mt-1" width="50" height="50">
                        <div class="col-sm-offset-2">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Lưu lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      $(document).ready(function() {
          /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          /*------------------------------------------
          --------------------------------------------
          Render DataTable
          --------------------------------------------
          --------------------------------------------*/
          var table = $('.data-table').DataTable({
              language: {
                  emptyTable:     "Không có dữ liệu trong bảng",
                  info:           "HIển thị _START_ đến _END_ trong số _TOTAL_ mục nhập",
                  infoEmpty:      "Hiển thị 0 đến 0 trong số 0 mục nhập",
                  infoFiltered:   "(Được lọc từ tổng số _MAX_ mục nhập)",
                  infoPostFix:    "",
                  loadingRecords: "Đang tải...",
                  search:         "Tìm kiếm:",
                  searchPlaceholder: "Bạn đang muốn tìm...",
                  zeroRecords:    "Không tìm thấy kết quả",
                  paginate: {
                      'previous': 'Trước',
                      'next': 'Sau'
                  },
                  lengthMenu: 'Hiển thị <select>'+
                      '<option value="10">10</option>'+
                      '<option value="20">20</option>'+
                      '<option value="30">30</option>'+
                      '<option value="-1">Tất cả</option>'+
                      '</select> mục'
              },
              processing: true,
              serverSide: true,
              ajax: "{{ route('seller.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
                  {data: 'store', name: 'store', orderable: false},
                  {data: 'name', name: 'name', orderable: false},
                  // {data: 'email', name: 'email'},
                  {data: 'phone', name: 'phone', orderable: false},
                  {data: 'approved', name: 'approved'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ],
              order: [[4, 'asc']]
          });

          $('body').on('click', '.deleteSeller', function () {

              var seller_id = $(this).data("id");
              if(!confirm("Bạn thật sự muốn hủy bỏ quyền bán hàng của tài khoản này?")){
                  return false;
              } // để ngăn việc delete nếu ấn cancel

              $.ajax({
                  type: "DELETE",
                  url: "{{ route('seller.store') }}"+'/'+seller_id,
                  success: function (response) {
                      table.draw();
                  },
                  error: function (response) {
                      console.log('Error:', response);
                  }
              });
          });
      });
    </script>
@endsection
