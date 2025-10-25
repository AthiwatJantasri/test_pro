<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ฟังก์ชันแสดงฟอร์มสมัครสมาชิก
    public function showSignUpForm()
    {
        return view('auth.register');
    }

    // ฟังก์ชันสำหรับบันทึกข้อมูลการสมัครสมาชิก
    public function register(Request $request)
    {
        // การตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8', // ตรวจสอบการยืนยันรหัสผ่าน
        ]);

        // บันทึกข้อมูลผู้ใช้ใหม่
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // แปลงรหัสผ่านเป็น hash
        ]);

        // ลงชื่อผู้ใช้เข้าสู่ระบบหลังจากสมัคร
        auth();
        
        return redirect()->route('login')->with('success', 'สมัครสมาชิกเรียบร้อยแล้ว!');
    }
}
