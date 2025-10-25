@extends('template.backend')

@section('content')
    <!-- Core CSS -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<div class="container mt-5">
    <h1 class="text-center mb-4">แก้ไขการยืมพัสดุ</h1>
    <form action="{{ route('equipmentborrow.update', $borrows->id) }}" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')
        
        <!-- Equipment Selection -->
        <div class="mb-3">
            <label for="equipments_id" class="form-label">พัสดุ</label>
            <select name="equipments_id" id="equipments_id" class="form-select" required>
                @foreach($equipments as $equipment)
                    <option value="{{ $equipment->id }}" {{ $borrows->equipments_id == $equipment->id ? 'selected' : '' }}>
                        {{ $equipment->equipment_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantity Input -->
        <div class="mb-3">
            <label for="quantity" class="form-label">จำนวน</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $borrows->quantity }}" required>
        </div>

        <!-- Equipment Type Selection -->
        <div class="mb-3">
            <label for="equipment_type_id" class="form-label">ประเภทพัสดุ</label>
            <select name="equipment_type_id" id="equipment_type_id" class="form-select" required>
                @foreach($equipmentTypes as $type)
                    <option value="{{ $type->id }}" {{ $borrows->equipment_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->equipmenttype_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- User Selection -->
        <div class="mb-3">
            <label for="user_id" class="form-label">ผู้ยืม</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $borrows->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Borrow Date Input -->
        <div class="mb-3">
            <label for="borrow_date" class="form-label">วันที่ยืม</label>
            <input type="date" name="borrow_date" id="borrow_date" class="form-control" value="{{ $borrows->borrow_date }}" required>
        </div>

        <!-- Due Date Input -->
        <div class="mb-3">
            <label for="due_date" class="form-label">วันที่กำหนดคืน</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $borrows->due_date }}" required>
        </div>

        <!-- Remarks Input -->
        <div class="mb-3">
            <label for="remarks" class="form-label">หมายเหตุ</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="4">{{ $borrows->remarks }}</textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success w-100">อัปเดต</button>
    </form>
</div>
@endsection
