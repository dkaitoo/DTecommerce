@extends('seller.layouts.app')

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
                    <a class="navbar-brand" href="{{route('home')}}" style="font-size: 17px;"><i
                            class="fa fa-home fa-lg" aria-hidden="true"></i></a>

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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
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
                            <h4 class="card-title text-primary text-uppercase"><b>Danh sách ĐƠN ĐẶT HÀNG</b></h4>
                            @include('flash-message')
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered data-table" width="99%">
                                    <thead class="text-primary">
                                    <th><b>Mã đơn hàng</b></th>
                                    <th><b>Các sản phẩm</b></th>
                                    <th><b>Giá tiền</b></th>
                                    <th><b>Tên khách hàng</b></th>
                                    <th width="18%"><b>Trạng thái</b></th>
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
                        <form id="productForm" name="productForm" class="form-horizontal">
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Details</label>
                                <div class="col-sm-12">
                                    <textarea id="detail" name="detail" required="" placeholder="Enter Details"
                                              class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                            </div>
                        </form>
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
                    emptyTable: "Không có dữ liệu trong bảng",
                    info: "HIển thị _START_ đến _END_ trong số _TOTAL_ mục nhập",
                    infoEmpty: "Hiển thị 0 đến 0 trong số 0 mục nhập",
                    infoFiltered: "(Được lọc từ tổng số _MAX_ mục nhập)",
                    infoPostFix: "",
                    loadingRecords: "Đang tải...",
                    search: "Tìm kiếm:",
                    searchPlaceholder: "Bạn đang muốn tìm...",
                    zeroRecords: "Không tìm thấy kết quả",
                    paginate: {
                        'previous': 'Trước',
                        'next': 'Sau'
                    },
                    lengthMenu: 'Hiển thị <select>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="-1">Tất cả</option>' +
                        '</select> mục'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('order.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
                    {data: 'name_product', name: 'name_product', orderable: false},
                    {data: 'selling_price', name: 'selling_price', orderable: false},
                    {data: 'name_client', name: 'name_client', orderable: false},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[4, 'asc']]
            });

            /*------------------------------------------
                --------------------------------------------
                Delete Product Code
                --------------------------------------------
                --------------------------------------------*/
            $('body').on('click', '.deleteCategory', function () {

                var order_id = $(this).data("id");
                if (!confirm("Bạn thật sự muốn xóa?")) {
                    return false;
                } // để ngăn việc delete nếu ấn cancel
                let url = '{{route('order.destroy', ':id')}}';
                url = url.replace(':id', order_id);

                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function (response) {
                        table.draw();
                    },
                    error: function (response) {
                        console.log('Error:', response);
                    }
                });
            });
        });

        $(document).ready(function () {
            $(".tab").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-6").addClass("active");
        });
    </script>
@endsection
