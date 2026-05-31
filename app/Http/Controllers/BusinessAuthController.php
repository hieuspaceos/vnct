<?php
// app/Http/Controllers/BusinessAuthController.php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
class BusinessAuthController extends Controller
{
    // Hiển thị trang đăng ký/đăng nhập
    public function showForm()
    {
        if(Session('business_logged_in'))
        {
            return redirect()->route('home');
        }
        $title = "Business form";
      
        return view('business.auth', compact('title'));
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $json_file = public_path('template/files/auth_'.App::currentLocale().'.json');

        if (file_exists($json_file)) {

            $json_content = file_get_contents($json_file);

            $data_intro = json_decode($json_content, true);   
            if ($data_intro === null) {
                $data_intro = [];
            }
        } else {
            $data_intro = [];
        }

        //dd($data_intro);
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'tax_code' => [
                'required',
                'string',
                Rule::unique('businesses')->where(function ($query) {
                    return $query->whereIn('status', ['accepted', 'pending']);
                }),
            ],
                    
            'website' => 'nullable|url|max:255',
            'industry' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            
            'phone' => [
                'required',
                'string',
                Rule::unique('businesses')->whereIn('status', ['accepted', 'pending']),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('businesses')->whereIn('status', ['accepted', 'pending']),
            ],
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                Rule::unique('businesses')->whereIn('status', ['accepted', 'pending']),
            ],
            
            'password' => 'required|string|min:6|confirmed',
            'description' => 'nullable|string'
        ], [
            'tax_code.unique' => $data_intro["ma_so_thue_da_ton_tai"],
            'phone.unique' => $data_intro["so_dien_thoai_da_dang_ky"],
            'email.unique' => $data_intro["email_da_dang_ky"],
            'username.unique' => $data_intro["ten_tai_khoan_da_ton_tai"],
            'password.confirmed' => $data_intro["xac_nhan_mat_khau_khong_khop"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $business = Business::create($request->all());
        $adminEmail = 'info@vnct.org'; // Thay bằng email admin của bạn
        $content = "Có doanh nghiệp mới đăng ký:\n"
                 . "Công ty: {$business->company_name}\n"
                 . "MST: {$business->tax_code}\n"
                 . "Người đại diện: {$business->representative_name}\n"
                 . "Email: {$business->email}\n"
                 . "SĐT: {$business->phone}";
        Mail::raw($content, function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('🔔 Thông báo: Có doanh nghiệp mới đăng ký hệ thống');
                });
        return response()->json([
            'success' => true,
            'message' => $data_intro["dangky_thanhcong"]
        ]);
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $json_file = public_path('template/files/auth_'.App::currentLocale().'.json');

        if (file_exists($json_file)) {

            $json_content = file_get_contents($json_file);

            $data_intro = json_decode($json_content, true);   
            if ($data_intro === null) {
                $data_intro = [];
            }
        } else {
            $data_intro = [];
        }
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $business = Business::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$business) {
            return response()->json([
                'success' => false,
                'message' => $data_intro["tai_khoan_khong_ton_tai"]
            ], 401);
        }

        if ($business->status === 'pending') {
            return response()->json([
                'success' => false,
                'message' => $data_intro["lien_he_admin"]
            ], 401);
        }

        if ($business->status === 'rejected') {
            return response()->json([
                'success' => false,
                'message' => $data_intro["tai_khoan_tu_choi"]
            ], 401);
        }

        if (!Hash::check($request->password, $business->password)) {
            return response()->json([
                'success' => false,
                'message' => $data_intro["mat_khau_khong_chinh_xac"]
            ], 401);
        }

        Session::put('business_logged_in', true);
        Session::put('business_id', $business->id);
        Session::put('business_name', $business->company_name);
        Session::put('business_role', 'business');

        return response()->json([
            'success' => true,
            'message' => $data_intro["dangnhap_thanhcong"],
            'redirect' => route('home')
        ]);
    }

    

    // Đăng xuất
    public function logout()
    {
        Session::forget('business_logged_in');
        Session::forget('business_id');
        Session::forget('business_name');
        Session::forget('business_role');

        return redirect()->route('business.login.form')->with('success', 'Đã đăng xuất thành công');
    }

    // =============== ADMIN FUNCTIONS ===============

    
}