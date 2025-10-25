<?php

namespace App\Http\Controllers;

use App\Models\EquipmentBorrow;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // ดึงผู้ใช้ที่ล็อกอินอยู่

        // เงื่อนไขตาม role
        if (in_array($user->role, ['admin', 'manager'])) {
            // admin/manager ดูได้ทั้งหมด
            $equipments = EquipmentBorrow::with('user', 'equipment')->paginate(5);
        } else {
            // user ดูได้เฉพาะของตัวเอง
            $equipments = EquipmentBorrow::with('user', 'equipment')
                ->where('user_id', $user->id)
                ->paginate(5);
        }

        return view('frontend.index', compact('equipments'));
    }
}


