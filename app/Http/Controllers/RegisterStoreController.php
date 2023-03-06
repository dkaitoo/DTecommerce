<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterStoreController extends Controller
{

    public function registerForm()
    {
        if (Auth::check()){
            $user = Auth::user();
            return view('registerStore',compact('user'));
        }
        return view('registerStore');
    }

    public function addNewSeller(Request $request){

        // custom lỗi
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'identity_card.required' => 'Vui lòng nhập CMND hoặc CCCD',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'store_name.required' => 'Vui lòng nhập tên cửa hàng',
            'store_name.unique' => 'Tên cửa hàng đã tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
        ];

        $rules = [
            'name' => 'required',
            'identity_card' => 'required',
            'phone' => 'required',
            'store_name' => 'required|unique:sellers',
            'address' => 'required',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        $details = [ 'name'=>$request->input('name'),
                    'identity_card'=>$request->input('identity_card'),
                    'phone'=>$request->input('phone'),
                    'store_name'=>$request->input('store_name'),
                    'slug'=>Str::slug($request->input('store_name')),
                    'address'=>$request->input('address'),];

        // kiểm tra có ảnh?
        if ($files = $request->file('logo')) {
            //insert new file
            $destinationPath = 'assets/uploads/logo/'; // upload path

            $fileName = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fileName);
            $finalImagePathName = $destinationPath.$fileName;

            $details['logo'] = $finalImagePathName;
            // 1 bản backup để đổi avatar của seller lun
//            $files_copy = $request->file('logo');
//            $destinationPath_copy = 'storage/users-avatar/'; // upload path
//            $fileName_copy = date('YmdHis') . "." . $files_copy->getClientOriginalExtension();
//            $files_copy->move($destinationPath_copy, $fileName_copy);
            File::copy($finalImagePathName, 'storage/users-avatar/'.$fileName);
        }else{
            // nếu k chọn ảnh thì ảnh mặc định sẽ được thêm vào
            $details['logo'] = '/img/Default_store.png';
        }

        $user = Auth::user();
        $user->update(['role'=>'1']); // nếu hk dc duyệt phải cập nhật chỗ này
        $user->profileSeller()->create($details);
        return redirect()->route('home')->with('success','Hồ sơ đăng ký bán hàng của bạn đã được gửi đi!');
    }
}

// và ở trang seller cho thêm quyền tắt tài khoản(không dc phép chỉnh sửa thông tin của người khác) và xóa tài khoản.
