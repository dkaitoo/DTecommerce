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
    <div class="panel-header panel-header-sm">
    </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body" style="margin: 20px;">
                <h2 class="card-title text-success text-uppercase"> <b>Danh sách thương hiệu</b></h2>
                <div class="row">
                  <div class="col-md-4" style="margin-bottom: 20px;">
                      <a class="btn btn-success" href="javascript:void(0)" id="createNewBrand"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i><span style="font-size: 1.2rem;">&nbsp;Tạo thương hiệu mới</span></a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered data-table" width="99%">
                    <thead class="text-success">
                      <th><b>STT</b></th>
                      <th><b>Tên thương hiệu</b></th>
                      <th><b>Tên miền</b></th>
                      <th><b>Trạng thái</b></th>
                      <th><b>Thao tác</b></th>
                    </thead>
                    <tbody>
                        {{--Ajax fetch data here--}}
                    </tbody>
                  </table>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>

    {{--Modal box CRD--}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="brandForm" name="brandForm" class="form-horizontal">
                        <div id="error" class="alert alert-danger alert-block d-none">
                        </div>
                        {{--Dùng cái này vì nó tương ứng id trên csdl--}}
                        <input type="hidden" name="brand_id" id="brand_id">
                        <div class="form-group">
                            <label for="name">Tên thương hiệu</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập Tên thương hiệu" value="" maxlength="50" >
                        </div>
                        <div class="form-group">
                            <label for="slug">Tên miền URI</label>
                            {{--Thêm cái span ví dụ /electronics--}}
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập Tên miền URI" value="" maxlength="50" >
                        </div>
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <input type="checkbox" name="status" id="status">
                        </div>
                        <div class="col-sm-offset-2">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Lưu lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var SITEURL = '{{URL::to('')}}';
        $(function () {

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
                ajax: "{{ route('brand.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'slug', name: 'slug'},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                // order: [[0, 'desc']]
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Add Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createNewBrand').click(function () {
                $('#saveBtn').val("create-brand");
                $('#status').attr('checked',true); // jQuery 1.5.x and below
                $('#brand_id').val('');
                $('#brandForm').trigger("reset");
                $('#error').html('<strong id="msg-error"></strong>');
                $('#modelHeading').html("Thêm thương hiệu mới");
                $('#ajaxModel').modal('show');
            });
            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editBrand', function () {
                var brand_id = $(this).data('id'); // id này có thể khác id cột, vì nó phụ thuộc vào csdl

                // url này hướng tới hàm edit trong admin
                $.get("{{ route('brand.index') }}" +'/' + brand_id +'/edit', function (data) {
                    $('#modelHeading').html("Cập nhật thương hiệu");
                    $('#saveBtn').val("edit-brand");
                    $('#ajaxModel').modal('show');
                    $('#brand_id').val(data.id);
                    $('#name').val(data.name);
                    $('#slug').val(data.slug);

                    if (data.status === 1)
                        $('#status').attr("checked", true);
                    else
                        $('#status').attr("checked", false);
                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Category Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('submit', '#brandForm', function (e) {
                e.preventDefault();
                var actionType = $('#saveBtn').val();
                $('#saveBtn').html('Đang gửi...');
                var formData = new FormData($('#brandForm')[0]); // get form not button(this), use [0]
                $.ajax({
                    // data: $('#brandForm').serialize(),
                    type: "POST",
                    url: "{{ route('brand.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // console.log(data);
                        $('#saveBtn').html('Lưu lại');
                        if(response.status == 400){
                            // hien thi thong bao loi
                            $('#error').removeClass('d-none');
                            // console.log(response.errors);
                            $('#error').html('<strong id="msg-error">'+response.error+'</strong>');
                            // $('#msg-error').text(response.error);
                        }else if(response.status == 200){
                            $('#brandForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                            // alert(response.message);
                        }else{
                            $('#brandForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                        }

                    },
                    error: function (response) {
                        console.log('Error:', response);
                        $('#saveBtn').html('Lưu lại');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            Delete Category Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.deleteBrand', function () {

                var brand_id = $(this).data("id");
                if(!confirm("Bạn thật sự muốn xóa?")){
                    return false;
                } // để ngăn việc delete nếu ấn cancel

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('brand.store') }}"+'/'+brand_id,
                    success: function (response) {
                        table.draw();
                    },
                    error: function (response) {
                        console.log('Error:', response);
                    }
                });
            });

            // clear error when focus input
            $('.form-control').focus(function() { $('#error').addClass('d-none'); });

            $(".tab").removeClass("active");
            $("#tab-7").addClass("active");

        });
    </script>
@endsection
