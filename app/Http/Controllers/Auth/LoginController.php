<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth; // them cai nay
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ham dang nhap: override từ login của AuthenticatesUsers
    public function login(Request $request)
    {
        $input = $request->all();
        $messages = [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->route('login')
                ->with('error',$validator->errors()->first());
        }

        if(auth()->attempt(array('email'=>$input['email'],'password'=> $input['password'])))
        {
            // Kiểm tra người dùng có xác thực chưa, tại vì có thể họ đki nhưng chưa xác thực
            if (!Auth::user()->hasVerifiedEmail()) {
                event(new Registered(Auth::user())); // gọi lại hàm send
                return redirect()->route('verification.notice'); // chạy dc nếu tự nhiên ng dùng lỡ quay lại trc
            }

            // lấy type ra so sánh, nhưng type này đã chuyển từ int thành string
            if(auth()->user()->role == 'admin'){
                return redirect()->route('dashboard');
            }elseif (auth()->user()->role == 'seller'){
                return redirect()->route('sellerHome');
            }else{
                return redirect()->route('home');
            }
        }else{
            // bổ sung thêm 1 số check lỗi???
            return redirect()->route('login')->withInput()
                ->with('error','Email hoặc mật khẩu không đúng.');
        }
    }

    // ham dang xuat
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }

}
