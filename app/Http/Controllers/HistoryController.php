<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentReturn;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ดึงข้อมูลการยืม 5 แถวต่อหน้า
        $borrows = EquipmentBorrow::with(['equipment', 'equipment_type'])
            ->where('user_id', $user->id)
            ->orderBy('borrow_date', 'desc')
            ->paginate(5, ['*'], 'borrows_page'); 

        // ดึงข้อมูลการคืน 5 แถวต่อหน้า
        $returns = EquipmentReturn::with(['equipment', 'equipment_type'])
            ->where('user_id', $user->id)
            ->orderBy('return_date', 'desc')
            ->paginate(5, ['*'], 'returns_page'); 

        return view('history.index', compact('borrows', 'returns'));
    }
}
