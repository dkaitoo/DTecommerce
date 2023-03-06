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
                <h2 class="card-title text-success text-uppercase"> <b>Danh sách danh mục</b></h2>
                <div class="row" style="margin-bottom: 20px;">
                  <div class="col-md-4">
                      <a class="btn btn-success" href="javascript:void(0)" id="createNewCategory"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i><span style="font-size: 1.2rem;">&nbsp;Tạo danh mục mới</span></a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered data-table" width="99%">
                    <thead class="text-success">
                      <th><b>STT</b></th>
                      <th><b>Hình ảnh</b></th>
                      <th><b>Tên danh mục</b></th>
                      <th><b>Mô tả</b></th>
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
{{--    Modal box CRD--}}
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
                            <label for="name">Tên danh mục</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập Tên danh mục" value="" maxlength="50" >
                        </div>
                        <div class="form-group">
                            <label for="slug">Tên miền URI</label>
{{--                            Thêm cái span ví dụ /electronics--}}
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập Tên miền URI" value="" maxlength="50" >
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="meta_title">Tiêu đề hiển thị</label>--}}
{{--                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" value="" maxlength="50" >--}}

{{--                        </div>--}}
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Nhập Mô tả" ></textarea>
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
                ajax: "{{ route('category.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'image', name: 'image', orderable: false},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                // order: [[0, 'desc']]
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Add Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createNewCategory').click(function () {
                $('#saveBtn').val("create-category");
                $('#category_id').val('');
                $('#categoryForm').trigger("reset");
                $('#error').html('<strong id="msg-error"></strong>');
                $('#modal-preview').attr('src', '{{ url('/img/default_category.jpg') }}');
                $('#modelHeading').html("Thêm danh mục mới");
                $('#ajaxModel').modal('show');
            });
            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editCategory', function () {
                var category_id = $(this).data('id'); // id này có thể khác id cột, vì nó phụ thuộc vào csdl

                // url này hướng tới hàm edit trong admin
                $.get("{{ route('category.index') }}" +'/' + category_id +'/edit', function (data) {
                    $('#modelHeading').html("Cập nhật danh mục");
                    $('#saveBtn').val("edit-category");
                    $('#ajaxModel').modal('show');
                    $('#category_id').val(data.id);
                    $('#name').val(data.name);
                    $('#slug').val(data.slug);
                    $('#modal-preview').attr('alt', 'No image available');
                    if(data.image){
                        $('#modal-preview').attr('src', SITEURL +'/assets/uploads/category/'+data.image);
                        $('#hidden_image').attr('src', SITEURL +'/assets/uploads/category/'+data.image);
                    }
                    $('#description').val(data.description);
                    if (data.status === 1)
                        $('#status').attr("checked", true);
                    else
                        $('#status').attr("checked", false);

                    if (data.popular === 1)
                        $('#popular').attr("checked", true);
                    else
                        $('#popular').attr("checked", false);

                    // $('#meta_title').val(data.meta_title);
                    // $('#meta_description').val(data.meta_description);
                    // $('#meta_keywords').val(data.meta_keywords);
                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Category Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('submit', '#categoryForm', function (e) {
                e.preventDefault();
                var actionType = $('#saveBtn').val();
                $('#saveBtn').html('Đang gửi...');
                var formData = new FormData($('#categoryForm')[0]); // get form not button(this), use [0]
                $.ajax({
                    // data: $('#categoryForm').serialize(),
                    type: "POST",
                    url: "{{ route('category.store') }}",
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
                            $('#categoryForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                            // alert(response.message);
                        }else{
                            $('#categoryForm').trigger("reset");
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
            $('body').on('click', '.deleteCategory', function () {

                var category_id = $(this).data("id");
                if(!confirm("Bạn thật sự muốn xóa?")){
                    return false;
                } // để ngăn việc delete nếu ấn cancel

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('category.store') }}"+'/'+category_id,
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
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-5").addClass("active");

        });
        function readURL(input, id) {
            id = id || '#modal-preview';
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $('#modal-preview').removeClass('hidden');
                $('#start').hide();
            }
        }
    </script>
@endsection
