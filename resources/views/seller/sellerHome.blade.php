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
                            <h4 class="card-title text-primary text-uppercase"><b>THỐNG KÊ DOANH THU</b></h4>
                            @include('flash-message')
                            <form action="{{route('statistic')}}" method="POST">
                                @csrf
                            <table width="68%" border="0" align="center" cellpadding="0" cellspacing="6" class="float-left">
                                    <tr>

                                        <td style="padding-right: 9px;">
                                            Từ ngày: <br><small>(mm/dd/yyyy)</small>
                                        </td>
                                        <td>
                                            <input type="text" name="start_date" id="start_date" class="filter-textfields" placeholder="Từ ngày"
                                                   value="{{Session::get('start_date') ?? '' }}"/>

                                        </td>
                                        <td style="margin-right: 10px;">
                                            &nbsp; &nbsp; &nbsp; &nbsp;
                                        </td>
                                        <td style="padding-right: 9px;">
                                            Đến ngày: <br><small>(mm/dd/yyyy)</small>
                                        </td>
                                        <td style="padding-right: 9px;">
                                            <input type="text" name="end_date" id="end_date" class="filter-textfields" placeholder="Đến ngày"
                                                   value="{{Session::get('end_date') ?? '' }}"/>
                                        </td>
                                        <td>
                                            <button class="btn btn-success" style="font-size: 13px; padding: 9px; margin: 0 5px 0 0px;"><b>Áp dụng</b></button>
                                            <a type="button" href="{{route('clearStatistic')}}" class="btn btn-danger" style="font-size: 13px; padding: 9px;"><b>Xóa lọc</b></a>
                                        </td>
                                    </tr>
                                </table>

                            </form>
{{--                            --}}
{{--                            <div class="float-left">--}}
{{--                                <form action="{{route('clearStatistic')}}" method="get">--}}
{{--                                    @csrf--}}
{{--                                </form>--}}
{{--                            </div>--}}
                            <div class="table-responsive">
                                <table class="table table-bordered data-table" width="99%">
                                    <thead class="text-primary">
                                    <th><b>STT</b></th>
                                    <th><b>Thời gian</b></th>
                                    <th><b>Doanh thu</b></th>
                                    <th><b>Tổng sản phẩm đã bán</b></th>
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
        <!-- Add Modal -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright" id="copyright">
                    &copy; 2022, Designed by DT
                </div>
            </div>
        </footer>
    </div>


    <script type="text/javascript">

        $(function(){
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
            // $( "#start_date" ).datepicker(
            //
            //     {
            //         maxDate: '0',
            //         beforeShow : function()
            //         {
            //             jQuery( this ).datepicker('option','maxDate', jQuery('#end_date').val() );
            //         },
            //         altFormat: "dd/mm/yy",
            //         dateFormat: 'dd/mm/yy'
            //
            //     }
            //
            // );
            $( "#start_date" ).datepicker();
            $( "#end_date" ).datepicker();

            if($("#start_date").val() === '') {
                var todayDate = new Date();
                todayDate.setDate(todayDate.getDate() - 7);
                var $datepicker1 = $( "#start_date" ).datepicker
                (
                    {
                        format: 'dd/mm/yyyy',
                        startDate: '-7d',
                        setDate: 'today'
                    }
                )
                $datepicker1.datepicker("setDate", todayDate);

            }
            if($( "#end_date" ).val() === '') {
                var $datepicker2 = $('#end_date');
                $datepicker2.datepicker(
                    {
                        format: 'dd/mm/yyyy',
                    }
                );
                $datepicker2.datepicker('setDate', new Date());
            }


            // $( "#end_date" ).datepicker(
            //
            //     {
            //         maxDate: '0',
            //         beforeShow : function()
            //         {
            //             jQuery( this ).datepicker('option','minDate', jQuery('#start_date').val() );
            //         } ,
            //         altFormat: "dd/mm/yy",
            //         dateFormat: 'dd/mm/yy'
            //
            //     }
            //
            // );

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
                ajax: "{{ route('sellerHome') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date', name: 'date'},
                    {data: 'sum', name: 'sum'},
                    {data: 'bill', name: 'bill'},
                ],
                // order: [[0, 'desc']]
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $(".tab").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below
            $("#tab-1").addClass("active");
        });
    </script>
@endsection
