<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments_return', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained('equipments_borrow', 'id')->onDelete('cascade'); // ความสัมพันธ์กับ borrow
            $table->foreignId('equipments_id')->constrained('equipments', 'id')->onDelete('cascade');  // ความสัมพันธ์กับ equipment
            $table->integer('quantity'); // จำนวนที่ยืม
            $table->foreignId('equipment_type_id')->references('id')->on('equipment_type')->onDelete('cascade'); // ความสัมพันธ์กับ equipmentType
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // ความสัมพันธ์กับ users
            $table->date('return_date');  // วันที่ยืม
            $table->text('remarks')->nullable();  // หมายเหตุ
            $table->enum('status', ['returned', 'not_returned'])->default('returned'); // สถานะการยืม
            $table->text('manager_remarks')->nullable(); // หมายเหตุของผู้จัดการ
            $table->timestamps();  // เวลาเพิ่มข้อมูลและอัปเดต
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments_return');
    }
};
