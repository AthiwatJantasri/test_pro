<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentReturn extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางที่ model นี้จะอ้างถึง
    protected $table = 'equipments_return';

    // ระบุคอลัมน์ที่สามารถเพิ่มข้อมูลได้ (fillable)
    protected $fillable = [
        'borrow_id',
        'equipments_id',
        'quantity',
        'equipment_type_id',
        'user_id',
        'return_date',
        'remarks',
        'status', // สถานะการคืน
        'manager_remarks', // ความคิดเห็นของผู้จัดการ
    ];

    // ความสัมพันธ์กับตาราง Equipment
    public function equipment()
    {
        return $this->belongsTo(Equipments::class, 'equipments_id');
    }

    // ความสัมพันธ์กับตาราง Users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function equipment_type()
    {
        return $this->belongsTo(EquipmentType::class,'equipment_type_id');
    }

}
