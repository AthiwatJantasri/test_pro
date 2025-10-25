<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers; // ใช้ Trait สำหรับจัดการฟังก์ชันการลงทะเบียน

    /**
     * เส้นทางที่ผู้ใช้จะถูกนำไปหลังจากลงทะเบียนเสร็จสิ้น
     *
     * @var string
     */
    protected $redirectTo = '/home'; // หน้าแรกที่ผู้ใช้จะถูกเปลี่ยนไปหลังการลงทะเบียนสำเร็จ

    /**
     * สร้างอินสแตนซ์ของคอนโทรลเลอร์
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest'); // อนุญาตให้เฉพาะผู้ที่ยังไม่ได้เข้าสู่ระบบเท่านั้นที่สามารถเข้าถึงฟังก์ชันนี้ได้
    }

    /**
     * รับตัวตรวจสอบข้อมูลสำหรับคำขอลงทะเบียนที่เข้ามา
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'], // ต้องระบุชื่อผู้ใช้, เป็นข้อความ, และไม่เกิน 255 ตัวอักษร
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // ต้องระบุอีเมล, เป็นอีเมลที่ถูกต้อง, และไม่ซ้ำกับฐานข้อมูล
            'password' => ['required', 'string', 'min:8', 'confirmed'], // รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร และต้องยืนยันรหัสผ่านให้ตรงกัน
        ]);
    }

    /**
     * สร้างอินสแตนซ์ผู้ใช้ใหม่หลังจากการลงทะเบียนที่ถูกต้อง
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // สร้างบัญชีผู้ใช้ใหม่ในฐานข้อมูล
        return User::create([
            'name' => $data['name'], // ชื่อผู้ใช้
            'email' => $data['email'], // อีเมล
            'password' => Hash::make($data['password']), // เข้ารหัสรหัสผ่านก่อนบันทึก
        ]);
    }
}
