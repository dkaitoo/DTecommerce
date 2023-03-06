<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ApprovedMail;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class SellersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = User::select(['id','email','role'])->where('role', '1')->latest()->get(); // bắt buộc phải chọn cột được phép hiển thị hk là hk select dc

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('store', function($row){
                    return $row->profileSeller->store_name ?? 'Chưa cập nhật'; // tên cửa hàng
                })
                ->addColumn('name', function($row){
                    return $row->profileSeller->name ?? 'Chưa cập nhật'; // chủ cửa hàng
                })
                ->addColumn('phone', function($row){
                    return $row->profileSeller->phone ?? 'Chưa cập nhật';
                })
                ->addColumn('approved', function($row){
                    return $row->profileSeller->approved ? 'Đã duyệt' : 'Đang chờ duyệt';
                })
                ->addColumn('action', function($row){ // id lấy trên bảng seller thay vì user
                    if (!$row->profileSeller->approved)
                        return  '<a href="'.route('seller.index').'/' . $row->profileSeller->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-info btn-sm viewProduct"><i class="fa fa-eye" aria-hidden="true"></i> Xem để duyệt</a>'; //dùng id này để sửa

                    $btn = '<a href="'.route('seller.index').'/' . $row->profileSeller->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewProduct" style="margin-right: 9px;"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>'; //dùng id này để sửa
                    return  $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->profileSeller->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSeller" style="margin-right: 9px;"><i class="fa fa-trash" aria-hidden="true"></i> Hủy quyền</a>';

                }) // mai bắt đầu bổ sung view vs trang cửa hàng
                ->rawColumns(['store','name','phone','approved','action'])
                ->make();
        }

        return view('admin.users.sellerAccount');
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
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Seller $seller)
    {
        //
        return view('admin.users.showSeller',compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //thực hiện cập nhật
        $seller = Seller::where('id',$id)->first();
        Seller::where([
            'id' => $id
        ])->update(['approved' => '1']);
        // khi accept, đổi luôn profile cũ (treo luôn edit profile user nếu chưa accpet), cho thành seller
        $details = [
            'name' => $seller->store_name,
        ];
        // nếu k đổi ảnh
        if ($seller->logo == '/img/Default_store.png'){
            $details['avatar'] = 'Default_store.png';
        }
        else{
            $avatar = str_replace('assets/uploads/logo/', '', $seller->logo);
            $details['avatar'] = $avatar;
        }
        User::where([
           'id' =>  $seller->user_id
        ])->update($details);

        $mailData = [
            'title' => 'Mail từ DT Ecommerce',
            'body' => 'Chúng tôi đồng ý cho tài khoản của bạn được bán hàng.'
        ];

        // Gửi email đồng ý
        Mail::to($seller->user->email)->send(new ApprovedMail($mailData));

        return redirect()->route('seller.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
            DB::transaction(function () use ($id) {
                $seller = Seller::where('id',$id)->first(); // k dc gộp chung cái code 143 ở dưới
                Seller::where('id',$id)->delete(); // khi xóa thì những bảng có khóa người là id này cũng bị xóa theo lun
                User::where('id', $seller->user_id)->update([
                    'role'=>'0',
                ]);
                // chỉ cần xóa đi tấm ảnh
            });
            return response()->json(['success'=>'Đã xóa quyền bán hàng của tài khoản này.']);
        }
        // thực hiện xóa - chưa check vs DB transaction
        DB::transaction(function () use ($id) {
            $seller = Seller::where('id',$id)->first();
//            $user = User::where('id',$seller->user_id)->first();
            Seller::where('id',$id)->delete();
            // xóa đi tấm ảnh trong storage và đưa về ảnh mặc định, còn name thì lấy theo tên nhà bán hàng
            // chỉ cần xóa đi tấm ảnh
//            if ($seller->logo != '/img/Default_store.png'){
//                File::delete('storage/users-avatar/'.$user->avatar);
//                File::delete(public_path('assets/uploads/logo/'.$user->avatar));
//            }
            User::where('id', $seller->user_id)->update([
//                    'name' => $seller->name, // lấy theo name của seller (k cần nữa vì ban đầu nó đã chưa thay đổi)
                'role'=>'0',
                'avatar'=>'default-avatar.png', // quay về ảnh mặc định
            ]);
//            $seller->user()->update(['role'=>'0']);
            $mailData = [
                'title' => 'Mail từ DT Ecommerce',
                'body' => 'Chúng tôi không đồng ý cho tài khoản của bạn được bán hàng. Do thông tin của bạn không chính xác. Vui lòng kiểm tra lại và làm lại tờ đăng ký mới.'
            ];
            // gửi mail từ chối
            Mail::to($seller->user->email)->send(new ApprovedMail($mailData));
        });
        return redirect()->route('seller.index');
    }
}
