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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->unsignedInteger('stock')->default(0);  // จำนวนใน stock (unsigned integer)
            $table->foreignId('equipment_type_id')->references('id')->on('equipment_type')->onDelete('cascade'); // ความสัมพันธ์กับ equipmenttype
            $table->string('equipment_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
