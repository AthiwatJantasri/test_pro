<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    /**
     * ชื่อของตารางในฐานข้อมูล.
     *
     * @var string
     */
    protected $table = 'equipment_type';

    /**
     * กำหนดว่าฟิลด์ใดบ้างที่สามารถเพิ่มหรือแก้ไขข้อมูลได้ (Mass Assignable).
     *
     * @var array
     */
    protected $fillable = [
        'equipmenttype_name',
    ];

    /**
     * ความสัมพันธ์กับอุปกรณ์ (Equipment).
     */
    public function equipment()
    {
        return $this->hasMany(Equipments::class, 'equipment_type_id');
    }
}
