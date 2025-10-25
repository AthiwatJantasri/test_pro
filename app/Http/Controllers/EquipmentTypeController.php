<?php

namespace App\Http\Controllers;

use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    /**
     * แสดงรายการประเภทอุปกรณ์ทั้งหมด.
     */
    public function index()
    {
        $equipmentTypes = EquipmentType::orderBy('id')->get();
        return view('equipment_types.index', compact('equipmentTypes'));
    }

    /**
     * แสดงฟอร์มสร้างประเภทอุปกรณ์ใหม่.
     */
    public function create()
    {
        return view('equipment_types.create');
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    /**
     * บันทึกประเภทอุปกรณ์ใหม่.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipmenttype_name' => 'required|string|max:255',
        ]);

        EquipmentType::create($validated);
        return redirect()->route('equipment_types.index')->with('success', 'เพิ่มประเภทของอุปกรณ์สำเร็จแล้ว');
    }

    /**
     * //
     */
    public function show(EquipmentType $equipmentType)
    {
        //
    }

    /**
     * แสดงฟอร์มแก้ไขประเภทอุปกรณ์.
     */
    public function edit(EquipmentType $equipmentType)
    {
        return view('equipment_types.edit', compact('equipmentType'));

        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    /**
     * อัปเดตข้อมูลประเภทอุปกรณ์.
     */
    public function update(Request $request, EquipmentType $equipmentType)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
        
        $validated = $request->validate([
            'equipmenttype_name' => 'required|string|max:255',
        ]);

        $equipmentType->update($validated);
        return redirect()->route('equipment_types.index')->with('success', 'แก้ไขประเภทของอุปกรณ์สำเร็จแล้ว');
    }

    /**
     * ลบประเภทอุปกรณ์.
     */
    public function destroy(EquipmentType $equipmentType)
    {
        $equipmentType->delete();
        return redirect()->route('equipment_types.index')->with('success', 'ลบประเภทของอุปกรณ์สำเร็จแล้ว');
    }
}
