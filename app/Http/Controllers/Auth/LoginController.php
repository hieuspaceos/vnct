<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Ghi đè phương thức đăng nhập
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        
        // Kiểm tra thông tin đăng nhập
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user) {
            if (!$user->is_approved && !$user->is_admin) {
                return false;
            }
        }
        
        return $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user && !$user->is_approved && !$user->is_admin) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors(['email' => 'Tài khoản chưa được admin duyệt. Vui lòng chờ duyệt!']);
        }
        
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}