<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('id_social', $user->id)->first();

            // kiểm tra user có tồn tại để bik là login hay register
            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('home');

            }else{
                $checkemailuser = User::where('email', $user->email)->first(); // kiểm tra email này đã được ủy quyền của bên khác hay đăng ký trước đó chưa
                if ($checkemailuser){
                    return redirect()->route('login')
                        ->with('error','Email này đã tồn tại.');
                }
                // tìm xem có email vs id_social đã tạo hay chưa, nếu có r thì chỉ update thông tin, còn chưa thì tạo mới (cho trường hợp bên FB đã cập nhật thông tin cá nhân)
                $newUser = User::updateOrCreate(['email' => $user->email, 'id_social'=> $user->id],[
                    'name' => $user->name,
                    'password' => encrypt(str_random(8)),
                    'type_login' => '2', //facebook
                ]);
                $newUser->forceFill(['email_verified_at' => date('Y-m-d H:i:s')])->save(); // dùng forceFill để truy cập vào lớp protected

                Auth::login($newUser);

                return redirect()->intended('home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
//            return redirect()->intended('login');
        }
    }
}
