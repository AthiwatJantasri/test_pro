<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login'); // แสดงฟอร์มล็อกอิน
    }

    // Handle the login request
    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if ($user && Hash::check($validated['password'], $user->password)) {
        Auth::login($user);

        // ✅ ตรวจสอบบทบาทและเปลี่ยนเส้นทางตาม role
        if ($user->role === 'admin') {
            return redirect()->route('welcome');
        } elseif ($user->role === 'manager') {
            return redirect()->route('welcome'); // หรือหน้าเฉพาะของ manager
        } else {
            return redirect()->route('frontend.index');
        }
    }

    return back()->withErrors(['email' => 'รหัสผ่านไม่ถูกต้อง'])->withInput();
}

    // Handle logout
    public function logout()
    {
        Auth::logout(); // ออกจากระบบ
        return redirect()->route('login'); // เปลี่ยนเส้นทางไปที่หน้า login
    }
}