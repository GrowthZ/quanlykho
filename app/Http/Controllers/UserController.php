<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Hiển thị form tạo mới người dùng
    public function create()
    {
        return view('users.create');
    }

    // Xử lý lưu user mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:6|confirmed', // Yêu cầu nhập lại mật khẩu
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);
        
        return redirect()->route('users.index')->with('success', 'Tạo mới người dùng thành công.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required|in:user,manager,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Cập nhật người dùng thành công!');
    }

}
