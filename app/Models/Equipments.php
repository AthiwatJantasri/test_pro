<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_name',
        'stock',
        'equipment_type_id',
        'equipment_code',
    ];

    /**
     * ความสัมพันธ์กับ EquipmentType
     */
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }
}
