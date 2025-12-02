<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    // คำสั่งสร้างข้อมูลผู้ใช้ php artisan db:seed --class=UserSeeder

        User::create([
            'username' => 'ใส่Username',
            'telephone_number' => 'ใส่เบอร์โทร',
            'email' => 'ใส่Email',
            'password' => Hash::make('ใส่รหัสผ่าน'),
            'role' => 'admin',
        ]);
    }
}
