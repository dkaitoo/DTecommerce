<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

// chỉ quản lý tài khoản client
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::select(['id','name','email','role'])->where('role', '<>', '2')->latest()->get(); // bắt buộc phải chọn cột được phép hiển thị hk là hk select dc

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('phone', function($row){
                    return $row->profileUser->phone ?? 'Chưa cập nhật';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('user.index').'/' . $row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewProduct" style="margin-right: 9px;"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser" style="margin-right: 9px;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>'; //dùng id này để xóa
                    return  $btn; //dùng id này để sửa

                }) // mai bắt đầu bổ sung view vs trang cửa hàng
                ->rawColumns(['phone','action'])
                ->make();
        }

        return view('admin.users.userAccount');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        //
        return view('admin.users.showUser',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        User::where('id',$id)->delete(); // khi xóa thì những bảng có khóa người là id này cũng bị xóa theo lun
        return response()->json(['success'=>'Đã xóa tài khoản người dùng này thành công.']);
    }
}
