<?php

namespace App\Http\Controllers;

use App\Models\Equipments;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipmentsController extends Controller
{
    // ฟังก์ชันแสดงฟอร์มเพิ่มอุปกรณ์
    public function create()
    {
        $equipmentType = EquipmentType::all();
        return view('equipments.create', compact('equipmentType'));
    }

    // ฟังก์ชันสำหรับบันทึกข้อมูลการเพิ่มอุปกรณ์
    public function store(Request $request)
    {

        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // การตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'equipment_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'equipment_type_id' => 'required|exists:equipment_type,id',
        ]);

        // บันทึกข้อมูลอุปกรณ์ใหม่
        Equipments::create([
            'equipment_name' => $validated['equipment_name'],
            'stock' => $validated['stock'],
            'equipment_type_id' => $validated['equipment_type_id'],
        ]);

        // รีไดเร็กต์กลับไปที่หน้าแสดงรายการอุปกรณ์
        return redirect()->route('equipments.index')->with('success', 'อุปกรณ์ถูกเพิ่มสำเร็จแล้ว');
    }

    // ฟังก์ชันแสดงรายการอุปกรณ์
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // ใช้ paginate แบ่งหน้า
        $equipments = Equipments::orderBy('id', 'asc')->paginate(5); // แสดง 5 รายการต่อหน้า
        $equipmentType = EquipmentType::all();

        return view('equipments.index', compact('equipments', 'equipmentType'));
    }


    // ฟังก์ชันแสดงฟอร์มแก้ไขอุปกรณ์
    public function edit($id)
    {

        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        $equipments = Equipments::findOrFail($id); // ค้นหาอุปกรณ์ตาม ID
        $equipmentType = EquipmentType::all();

        return view('equipments.edit', compact('equipments', 'equipmentType')); // ส่งข้อมูลอุปกรณ์ไปยัง view
    }

    // ฟังก์ชันสำหรับบันทึกการอัปเดตอุปกรณ์
    public function update(Request $request, $id)
    {
        // การตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'equipment_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'equipment_type_id' => 'required|exists:equipment_type,id',
        ]);

        // ค้นหาอุปกรณ์ตาม ID และอัปเดตข้อมูล
        $equipment = Equipments::findOrFail($id);
        $equipment->update([
            'equipment_name' => $validated['equipment_name'],
            'stock' => $validated['stock'],
            'equipment_type_id' => $validated['equipment_type_id'],
        ]);

        // รีไดเร็กต์กลับไปที่หน้าแสดงรายการอุปกรณ์
        return redirect()->route('equipments.index')->with('success', 'อุปกรณ์ถูกแก้ไขสำเร็จแล้ว');
    }

    // ฟังก์ชันสำหรับลบอุปกรณ์
    public function destroy($id)
    {
        $equipment = Equipments::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'อุปกรณ์ถูกลบสำเร็จแล้ว');
    }

    public function exportPDF()
    {
        $equipments = Equipments::orderBy('id')->get();

        $pdf = Pdf::loadView('equipments.pdf', compact('equipments'));

        return $pdf->download('equipments_list.pdf');
    }
}
