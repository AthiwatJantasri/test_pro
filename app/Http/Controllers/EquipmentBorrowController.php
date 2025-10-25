<?php

namespace App\Http\Controllers;

use App\Models\EquipmentBorrow;
use App\Models\Equipments;
use App\Models\EquipmentType;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class EquipmentBorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function checkOverdue()
    {
        $now = Carbon::now()->toDateString();

        // ดึงรายการที่ยังไม่คืนและ due_date < วันนี้
        $borrows = EquipmentBorrow::whereIn('status', ['pending', 'approved'])
            ->where('due_date', '<', $now)
            ->get();

        foreach ($borrows as $borrow) {
            $borrow->status = 'overdue';
            $borrow->save();
        }
    }

    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager', 'user'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // ตรวจสอบ role
        if (auth()->user()->role === 'user') {
            // ผู้ใช้ทั่วไปเห็นเฉพาะของตัวเอง
            $borrows = EquipmentBorrow::where('user_id', auth()->id())
                ->orderBy('id', 'asc')
                ->paginate(5);
        } else {
            // admin หรือ manager เห็นทั้งหมด
            $borrows = EquipmentBorrow::orderBy('id', 'asc')->paginate(5);
        }

        return view('equipmentborrow.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ดึงข้อมูลอุปกรณ์ทั้งหมด
        $equipments = Equipments::all();

        // ดึงข้อมูลผู้ใช้ทั้งหมด
        $users = User::all();

        $equipmentTypes = EquipmentType::all();
        return view('equipmentborrow.create', compact('equipments', 'users', 'equipmentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipments_id' => 'required|exists:equipments,id',
            'quantity' => 'required|integer|min:1',
            'equipment_type_id' => 'required|exists:equipment_type,id',
            'user_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'remarks' => 'nullable|string',
        ]);

        // สร้างสถานะเริ่มต้นเป็น pending (รออนุมัติ)
        $validated['status'] = 'pending';

        // บันทึกข้อมูลยืมโดยยังไม่หัก stock
        EquipmentBorrow::create($validated);

        return redirect()->route('equipmentborrow.index')->with('success', 'เพิ่มข้อมูลการยืมอุปกรณ์เรียบร้อย รออนุมัติ');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        $borrows = EquipmentBorrow::findOrFail($id);
        // ดึงข้อมูลอุปกรณ์และประเภทอุปกรณ์ทั้งหมด
        $equipments = Equipments::all();
        $equipmentTypes = EquipmentType::all();

        // ดึงข้อมูลผู้ใช้ทั้งหมด
        $users = User::all();

        return view('equipmentborrow.edit', compact('borrows', 'equipments', 'equipmentTypes', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $equipmentBorrow = EquipmentBorrow::findOrFail($id);

        $validated = $request->validate([
            'equipments_id' => 'required|exists:equipments,id',
            'quantity' => 'required|integer|min:1',
            'equipment_type_id' => 'required|exists:equipment_type,id',
            'user_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'remarks' => 'nullable|string',
        ]);

        // กำหนดสถานะเป็น pending ทุกครั้งเมื่อแก้ไข (หรือจะรับจาก request ก็ได้)
        $validated['status'] = 'pending';

        // อัปเดตข้อมูลโดยยังไม่หัก stock
        $equipmentBorrow->update($validated);

        return redirect()->route('equipmentborrow.index')->with('success', 'แก้ไขข้อมูลการยืมอุปกรณ์เรียบร้อย รออนุมัติ');
    }

    public function updateStatus(Request $request, $id, $status)
    {
        // ตรวจสอบว่ามีการกรอกความคิดเห็น
        $request->validate([
            'manager_remarks' => 'required|string|max:255'
        ]);

        $equipmentRequest = EquipmentBorrow::findOrFail($id);

        // ห้ามเปลี่ยนสถานะหากไม่ใช่ pending
        if ($equipmentRequest->status !== 'pending') {
            return redirect()->route('equipmentborrow.index')->with('error', 'ไม่สามารถเปลี่ยนสถานะได้');
        }

        // ตรวจสอบว่าค่าสถานะถูกต้องหรือไม่
        if (!in_array($status, ['approved', 'rejected'])) {
            return redirect()->route('equipmentborrow.index')->with('error', 'สถานะไม่ถูกต้อง');
        }

        // ตรวจสอบสต็อกถ้าอนุมัติ
        if ($status === 'approved') {
            $equipment = $equipmentRequest->equipment;

            if ($equipment->stock < $equipmentRequest->quantity) {
                return redirect()->route('equipmentborrow.index')->with('error', 'จำนวนอุปกรณ์ในคลังไม่เพียงพอ');
            }

            // หักจำนวนในสต็อก
            $equipment->stock -= $equipmentRequest->quantity;
            $equipment->save();
        }

        // บันทึกสถานะและความคิดเห็น
        $equipmentRequest->status = $status;
        $equipmentRequest->manager_remarks = $request->manager_remarks;
        $equipmentRequest->save();

        return redirect()->route('equipmentborrow.index')->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request = EquipmentBorrow::findOrFail($id);

        $equipment = Equipments::findOrFail($request->equipments_id);
        $equipment->increment('stock', $request->quantity);

        $request->delete();

        return redirect()->route('equipmentborrow.index')->with('success', 'ลบข้อมูลการยืมอุปกรณ์แล้ว');
    }

    public function exportPdf()
    {
        // ดึงข้อมูลการยืมพัสดุเรียงตาม ID
        $borrows = EquipmentBorrow::orderBy('id', 'asc')->get();

        // สร้าง PDF
        $pdf = PDF::loadView('equipmentborrow.pdf', compact('borrows'));

        // ส่งออก PDF
        return $pdf->download('equipment_borrow_list.pdf');
    }
}
