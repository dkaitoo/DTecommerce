<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileStoreController extends Controller
{
    //mai sửa tiếp cái gian hàng thành trang edit chính, bỏ đi cái edit hiện tại.
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * */
    public function index()
    {
        $user = Auth::user();
        $seller = $user->profileSeller;
        if(auth()->user()->role == 'seller'){
            return view('seller.editStore', compact('user','seller'));
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        // custom lỗi
        $messages = [
            'store_name.required' => 'Vui lòng nhập tên cửa hàng',
            'store_name.unique' => 'Tên cửa hàng đã tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
        ];

        $rules = [
            'store_name' => 'required|unique:sellers,store_name,'.$user->profileSeller->id, //'email' => 'unique:table,email_column_to_check,id_to_ignore'
            'address' => 'required',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        $details = [
            'store_name'=>$request->input('store_name'),
            'slug'=>Str::slug(strtolower($request->input('store_name'))),
            'address'=>$request->input('address'),];

        // kiểm tra có ảnh?
        if ($files = $request->file('logo')) {
            //insert new file
            $destinationPath = 'assets/uploads/logo/'; // upload path

            $fileName = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fileName);
            $finalImagePathName = $destinationPath.$fileName;

            $details['logo'] = $finalImagePathName;

            File::copy($finalImagePathName, 'storage/users-avatar/'.$fileName);
            // cập nhật thông tin tương ứng trên user để backup
            User::where('id', $user->id)->update([
                'name' => $request->input('store_name'), // vì để tránh chatbot k nhận ảnh và tên gian hàng
                'avatar' => $fileName
            ]);
        }else{
            User::where('id', $user->id)->update([
                'name' => $request->input('store_name'),
            ]);
        }

        Seller::where('user_id', $user->id)->update($details);

        return redirect()->back()->with('success','Cập nhật thành công!');
    }
}
