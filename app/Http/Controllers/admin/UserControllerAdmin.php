<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserControllerAdmin extends Controller
{
    /**
     * Hiển thị danh sách người dùng.
     */
    public function index()
    {
        
        $users = User::latest()->paginate(10);
        $title = "Danh sách User";
        return view('admin.page.users.index', compact('users','title'));
    }

    /**
     * Hiển thị form tạo người dùng mới.
     */
    public function create()
    {
        $title = "Thêm User";
        return view('admin.page.users.create',compact('title'));
    }

    /**
     * Lưu trữ người dùng mới vào database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
            
        ], [
            'required' => 'Trường :attribute là bắt buộc.',
            'unique' => 'Địa chỉ email này đã được sử dụng.',
            'min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Level' => $request->Level
            
        ]);

        return redirect()->route('users.index')->with('success', 'Thêm người dùng mới thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     */
    public function edit(User $user)
    {
        $title = "Sửa User";
        return view('admin.page.users.edit', compact('user','title'));
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(Request $request, User $user)
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            // Đảm bảo email là duy nhất, ngoại trừ email hiện tại của người dùng này
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ];

        $request->validate($validationRules, [
            'required' => 'Trường :attribute là bắt buộc.',
            'unique' => 'Địa chỉ email này đã được sử dụng.',
            'min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'Level' => $request->Level
        ];

        // Chỉ cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Xóa người dùng.
     */
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'Không thể tự xóa tài khoản của chính mình.');
        }
        
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
    }
    // Duyệt thành viên
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        // Gửi email thông báo
        Mail::to($user->email)->send(new UserApprovedMail($user));

        return redirect()->route('admin.users.index')->with('success', 'Đã duyệt thành viên và gửi email thông báo!');
    }
}