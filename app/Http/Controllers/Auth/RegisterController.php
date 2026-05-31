<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
            'is_approved' => false, // Mặc định chưa được duyệt
        ]);
    }

    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        $title= "Register";
        return view('auth.register', compact('title'));
    }

    // Ghi đè phương thức register
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $user = $this->create($request->all());
        
        return redirect($this->redirectPath())->with('success', 'Đăng ký thành công! Vui lòng chờ admin duyệt tài khoản.');
    }
}