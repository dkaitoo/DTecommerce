<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //trả về 1 trong 3 trang profile admin/seller/client
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * */
    public function index()
    {
        $user = Auth::user();
        if(auth()->user()->role == 'admin'){
            return view('admin.editProfile', compact('user'));
        }
        if(auth()->user()->role == 'seller'){
            return view('seller.editProfile', compact('user'));
        }
        if(auth()->user()->role == 'user'){
            return view('frontend.editProfile', compact('user'));
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // custom lỗi
        $messages = [
            'name.required' => 'Tên không được để trống',
            'phone.required'=> 'Số điện thoại không được để trống',
            'phone.numeric'=> 'Số điện thoại phải là chữ số',
            'phone.digits'=> 'Số điện thoại phải đủ 10 chữ số',
        ];
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric|digits:10',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        $user = User::findOrFail(Auth::user()->id);

        $details = ['name' => $request->input('name')];
        // kiểm tra có ảnh?
        if ($files = $request->file('avatar')) {

            //delete old file
            $destinationFile= 'storage/users-avatar'.$request->input('avatar_hidden');
            if(File::exists($destinationFile)){
                File::delete($destinationFile);
            }


            //insert new file
            $destinationPath = 'storage/users-avatar/'; // upload path

            $fileName = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fileName);
//            $finalImagePathName = $destinationPath.$fileName;

            $details['avatar'] = $fileName;
        }

        $user->update($details);

        $user->profileUser()->updateOrCreate(
            ['user_id'=>$user->id],
            ['phone'=>$request->input('phone'),
             'address'=>$request->input('address'),]);


        return redirect()->back()->with('success','Cập nhật thành công!');
    }

    public function updateSeller(Request $request){
        // custom lỗi
        $messages = [
            'name.required' => 'Tên không được để trống',
            'identity_card.required'=> 'CMND/CCCD không được để trống',
            'identity_card.numeric'=> 'CMND/CCCD phải là chữ số',
            'identity_card.digits'=> 'CMND/CCCD phải đủ 12 chữ số',
            'phone.required'=> 'Số điện thoại không được để trống',
            'phone.numeric'=> 'Số điện thoại phải là chữ số',
            'phone.digits'=> 'Số điện thoại phải đủ 10 chữ số',
        ];
        $rules = [
            'name' => 'required',
            'identity_card' =>'required|numeric|digits:12',
            'phone' => 'required|numeric|digits:10',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        $user = User::findOrFail(Auth::user()->id);

        $details = [
            'name' => $request->input('name'),
            'identity_card' => $request->input('identity_card'),
            'phone' => $request->input('phone'),
        ];

        $user->profileSeller()->updateOrCreate(
            ['user_id'=>$user->id],
            $details
        );

        return redirect()->back()->with('success','Cập nhật thành công!');
    }

}

