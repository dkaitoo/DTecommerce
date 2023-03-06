<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('id_social', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('home');

            }else{
                $checkemailuser = User::where('email', $user->email)->first(); // kiểm tra email này đã được ủy quyền của bên khác hay đăng ký trước đó chưa
                if ($checkemailuser){
                    return redirect()->route('login')
                        ->with('error','Email này đã tồn tại.');
                }
                $newUser = User::updateOrCreate(['email' => $user->email, 'id_social'=> $user->id],[
                    'name' => $user->name,
                    'password' => encrypt(str_random(8)),
                    'type_login' => '1', //google
                ]);
                $newUser->forceFill(['email_verified_at' => date('Y-m-d H:i:s')])->save(); // dùng forceFill để truy cập vào lớp protected

                Auth::login($newUser);

                return redirect()->intended('home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
