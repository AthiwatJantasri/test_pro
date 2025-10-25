<?php

namespace App\Http\Controllers;

use App\Models\EquipmentBorrow;
use App\Models\EquipmentReturn;
use App\Models\Equipments;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipmentReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('frontend.index')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        // ใช้ paginate แบ่งหน้า
        $returned = EquipmentReturn::orderBy('id', 'asc')->paginate(5); // 5 รายการต่อหน้า

        return view('equipmentreturn.index', compact('returned'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ดึง borrow_id ที่มีการคืนแล้ว (เช่น สถานะ 'returned' หรือ อาจจะ 'approved' หรืออื่น ๆ)
        $returnedBorrowIds = EquipmentReturn::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'returned']) // กำหนดสถานะที่ถือว่าคืนแล้วตามต้องการ
            ->pluck('borrow_id')
            ->toArray();

        // ดึงข้อมูลยืมที่ยังไม่มีการคืน (ยังไม่มีบันทึกคืน หรือยังไม่ผ่านสถานะเหล่านี้)
        $borrows = EquipmentBorrow::with(['equipment', 'equipment_type'])
            ->where('user_id', auth()->id())
            ->whereNotIn('id', $returnedBorrowIds)
            ->get();

        // ดึงจำนวนคืนรวม (pending+approved) เพื่อใช้แสดงใน select
        $returnedQuantities = EquipmentReturn::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->groupBy('borrow_id')
            ->selectRaw('borrow_id, SUM(quantity) as total_returned')
            ->pluck('total_returned', 'borrow_id')
            ->toArray();

        return view('equipmentreturn.create', compact('borrows', 'returnedQuantities'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrow_id' => 'required|exists:equipments_borrow,id',
            'return_date' => 'required|date',
            'remarks' => 'nullable|string',
            'quantity' => 'required|numeric|min:1',
        ]);

        $borrow = EquipmentBorrow::with('equipment')->findOrFail($validated['borrow_id']);
        $equipment = $borrow->equipment;

        // หาผลรวมจำนวนที่คืนไปแล้ว (pending+approved)
        $totalReturnedQuantity = EquipmentReturn::where('equipments_id', $borrow->equipments_id)
            ->where('user_id', $borrow->user_id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('quantity');

        // เช็คว่า คืนเกินจำนวนยืมหรือไม่
        if (($totalReturnedQuantity + $validated['quantity']) > $borrow->quantity) {
            return redirect()->route('equipmentreturn.create')
                ->with('error', 'จำนวนที่คืนรวมกับที่คืนไปแล้ว ไม่สามารถเกินจำนวนที่ยืมได้');
        }

        // เพิ่ม stock กลับเข้าคลัง (เหมือนเดิม)
        $equipment->increment('stock', $validated['quantity']);

        EquipmentReturn::create([
            'borrow_id' => $validated['borrow_id'],
            'equipments_id' => $borrow->equipments_id,
            'quantity' => $validated['quantity'],
            'equipment_type_id' => $borrow->equipment_type_id,
            'user_id' => $borrow->user_id,
            'return_date' => $validated['return_date'],
            'remarks' => $validated['remarks'],
            'status' => 'returned',
        ]);

        return redirect()->route('frontend.index')->with('success', 'การคืนอุปกรณ์เสร็จสิ้น');
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

        // ดึงข้อมูลการคืน
        $equipmentReturn = EquipmentReturn::findOrFail($id);

        // ดึงข้อมูลการยืมทั้งหมด (สำหรับกรณีแก้ไข Borrow ID)
        $borrows = EquipmentBorrow::with(['equipment', 'user'])->get();

        return view('equipmentreturn.edit', compact('equipmentReturn', 'borrows'));
    }

    public function updateStatus(Request $request, $id, $status)
    {
        $request->validate([
            'manager_remarks' => 'required|string|max:255'
        ]);

        $return = EquipmentReturn::findOrFail($id);

        // ห้ามเปลี่ยนสถานะถ้าไม่ใช่ pending
        if ($return->status !== 'pending') {
            return redirect()->route('equipmentreturn.index')->with('error', 'ไม่สามารถเปลี่ยนสถานะได้');
        }

        // ตรวจสอบสถานะที่ส่งมา
        if (!in_array($status, ['approved', 'rejected'])) {
            return redirect()->route('equipmentreturn.index')->with('error', 'สถานะไม่ถูกต้อง');
        }

        // อนุมัติการคืน → เพิ่ม stock กลับ
        if ($status === 'approved') {
            $equipment = Equipments::findOrFail($return->equipments_id);
            $equipment->increment('stock', $return->quantity);
        }

        // อัปเดตสถานะและความคิดเห็น
        $return->status = $status;
        $return->manager_remarks = $request->manager_remarks;
        $return->save();

        return redirect()->route('equipmentreturn.index')->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $equipmentReturn = EquipmentReturn::findOrFail($id);

        $validated = $request->validate([
            'borrow_id' => 'required|exists:equipment_borrow,id',
            'return_date' => 'required|date',
            'remarks' => 'nullable|string',
            'quantity' => 'required|numeric|min:1',
        ]);

        $borrow = EquipmentBorrow::with('equipment')->findOrFail($validated['borrow_id']);
        $equipment = $borrow->equipment;

        // หาผลรวมจำนวนที่คืนไปแล้ว (ยกเว้น record ที่กำลังแก้ไข)
        $totalReturnedQuantityExceptCurrent = EquipmentReturn::where('equipments_id', $borrow->equipments_id)
            ->where('user_id', $borrow->user_id)
            ->where('id', '!=', $id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('quantity');

        if (($totalReturnedQuantityExceptCurrent + $validated['quantity']) > $borrow->quantity) {
            return redirect()->route('equipmentreturn.edit', $id)
                ->with('error', 'จำนวนที่คืนรวมกับที่คืนไปแล้ว ไม่สามารถเกินจำนวนที่ยืมได้');
        }

        // คำนวณความต่างของจำนวนที่คืนกับเดิมเพื่อปรับ stock
        $quantityDifference = $validated['quantity'] - $equipmentReturn->quantity;
        if ($quantityDifference != 0) {
            $equipment->increment('stock', $quantityDifference);
        }

        $equipmentReturn->update([
            'equipments_id' => $borrow->equipments_id,
            'quantity' => $validated['quantity'],
            'user_id' => $borrow->user_id,
            'return_date' => $validated['return_date'],
            'remarks' => $validated['remarks'],
        ]);

        return redirect()->route('equipmentreturn.index')->with('success', 'แก้ไขข้อมูลการคืนอุปกรณ์สำเร็จ');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request = EquipmentReturn::findOrFail($id);

        $equipment = Equipments::findOrFail($request->equipments_id);
        $equipment->increment('stock', $request->quantity);

        $request->delete();

        return redirect()->route('equipmentreturn.index')->with('success', 'ลบข้อมูลการคืนอุปกรณ์แล้ว');
    }

    public function exportPdf()
    {
        // ดึงข้อมูลการคืนพัสดุเรียงตาม ID
        $returned = EquipmentReturn::orderBy('id', 'asc')->get();

        // สร้าง PDF
        $pdf = PDF::loadView('equipmentreturn.pdf', compact('returned'));

        // ส่งออก PDF
        return $pdf->download('equipment_return_list.pdf');
    }
}
