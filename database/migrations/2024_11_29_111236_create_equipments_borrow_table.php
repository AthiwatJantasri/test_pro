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
        Schema::create('equipments_borrow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipments_id')->constrained('equipments', 'id')->onDelete('cascade');  // ความสัมพันธ์กับ equipment
            $table->integer('quantity'); // จำนวนที่ยืม
            $table->foreignId('equipment_type_id')->references('id')->on('equipment_type')->onDelete('cascade'); // ความสัมพันธ์กับ equipmentType
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // ความสัมพันธ์กับ users
            $table->date('borrow_date');  // วันที่ยืม
            $table->date('due_date'); // ⬅ เพิ่มกำหนดวันคืน
            $table->text('remarks')->nullable();  // หมายเหตุ
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending'); // สถานะการยืม
            $table->text('manager_remarks')->nullable(); // หมายเหตุของผู้จัดการ
            $table->timestamps();  // เวลาเพิ่มข้อมูลและอัปเดต
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments_borrow');
    }
};
