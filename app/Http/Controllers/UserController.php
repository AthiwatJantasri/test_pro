<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * แสดงรายการผู้ใช้ทั้งหมด
     */
    public function index(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('username', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('telephone_number', 'LIKE', "%{$search}%");
        }

        $users = $query->orderBy('id')->paginate(5);

        return view('users.index', compact('users'));
    }


    /**
     * แสดงข้อมูลผู้ใช้ตาม ID ที่ระบุ
     */
    public function show($id)
    {
        // ใช้ findOrFail เพื่อให้ Laravel จัดการข้อผิดพลาดกรณีไม่พบผู้ใช้
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));  // ส่งข้อมูลผู้ใช้ไปยัง View users.show.blade.php
    }

    /**
     * แสดงฟอร์มสำหรับสร้างผู้ใช้ใหม่
     */
    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return view('users.create');  // ส่งไปยังฟอร์มสร้างผู้ใช้ (users.create.blade.php)
    }

    /**
     * บันทึกผู้ใช้ใหม่
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user,manager',
        ]);

        // สร้างผู้ใช้ใหม่พร้อมเข้ารหัสรหัสผ่าน
        User::create([
            'username' => $validatedData['username'],
            'telephone_number' => $validatedData['telephone_number'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],  // บันทึกบทบาท
        ]);

        // ส่งกลับข้อมูลผู้ใช้ที่ถูกสร้าง
        return redirect()->route('users.index')->with('success', 'สร้างข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มสำหรับแก้ไขข้อมูลผู้ใช้
     */
    public function edit($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // ดึงข้อมูลผู้ใช้ที่ต้องการแก้ไข
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));  // ส่งข้อมูลไปยังฟอร์มแก้ไข
    }

    /**
     * อัปเดตข้อมูลผู้ใช้
     */
    /**
     * อัปเดตข้อมูลผู้ใช้
     */
    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // ใช้ findOrFail เพื่อให้ Laravel จัดการกรณีไม่พบข้อมูล
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:255',
            'telephone_number' => 'required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:4',  // ให้รหัสผ่านเป็น nullable และใส่ต้องใส่ขั้นต่ำ4ตัว
            'role' => 'sometimes|required|in:admin,user,manager',
        ]);

        // ถ้ามีการเปลี่ยนแปลงรหัสผ่าน (ไม่ใช่ค่าว่าง) ให้เข้ารหัสใหม่
        if (!empty($request->password)) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);  // ไม่อัปเดตรหัสผ่านถ้าไม่ได้ป้อนใหม่
        }

        // อัปเดตข้อมูลผู้ใช้
        $user->update($validatedData);

        // ส่งกลับไปที่หน้ารายการผู้ใช้
        return redirect()->route('users.index')->with('success', 'แก้ไขข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }

    /**
     * ลบผู้ใช้
     */
    public function destroy($id)
    {
        // ใช้ findOrFail แทน find เพื่อให้ Laravel จัดการกับข้อผิดพลาดกรณีไม่พบข้อมูล
        $user = User::findOrFail($id);

        // ลบข้อมูลผู้ใช้
        $user->delete();

        // ส่งกลับข้อความว่าได้ทำการลบผู้ใช้แล้ว
        return redirect()->route('users.index')->with('success', 'ลบข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }
}
