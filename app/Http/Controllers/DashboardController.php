<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลอุปกรณ์ทั้งหมดพร้อมประเภท
        $equipments = DB::table('equipments')
            ->join('equipment_type', 'equipments.equipment_type_id', '=', 'equipment_type.id')
            ->select(
                'equipments.id',
                'equipments.equipment_name',
                'equipments.stock',
                'equipment_type.equipmenttype_name as equipmenttype_name'
            )
            ->orderBy('equipment_name')
            ->get();

        // ดึงข้อมูลอุปกรณ์สำหรับกราฟ (อุปกรณ์และจำนวนใน stock)
        $equipmentData = DB::table('equipments')
            ->select('equipments.equipment_name', 'equipments.stock')
            ->orderBy('equipment_name')
            ->get();

        // อุปกรณ์ที่มี stock น้อยที่สุด
        $lowStockEquipments = DB::table('equipments')
            ->select('equipment_name', 'stock')
            ->where('stock', '<', 5) // อุปกรณ์ที่เหลือน้อยกว่า 5 ชิ้น
            ->orderBy('stock')
            ->get();

        // ส่งข้อมูลอุปกรณ์ไปยัง View
        return view('dashboard.index', compact(
            'equipments', 'equipmentData', 'lowStockEquipments'
        ));
    }
}
