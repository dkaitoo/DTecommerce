<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    //
    public function changePassword()
    {
        return view('admin.changePassword');
    }

    public function updatePassword(Request $request)
    {

        // custom lỗi
        $messages = [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mói',
            'new_password.min' => 'Mật khẩu phải tối thiểu 8 ký tự',
            'new_password.confirmed' => 'Mật khẩu mới không khớp',
        ];

        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return redirect()->back()->with("error", "Mật khẩu cũ không chính xác!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with("success", "Đã đổi mật khẩu thành công!");
    }

    public function changePasswordClient()
    {
        if(!auth()->user()->id_social)
        {
            return view('frontend.changePassword');
        }
        return redirect()->back()->with("commit", "Tài khoản đã uỷ quyền không được đổi mật khẩu!");
    }

    public function changePasswordSeller()
    {
        if(!auth()->user()->id_social)
        {
            return view('seller.changePassword');
        }
        return redirect()->back()->with("commit", "Tài khoản đã uỷ quyền không được đổi mật khẩu!");
    }
}
