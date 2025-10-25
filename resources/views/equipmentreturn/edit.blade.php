@extends('template.backend')

@section('content')
    <!-- Core CSS -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-2">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">กลับไปหน้า Welcome</a>
        <h1>แก้ไขการคืนอุปกรณ์</h1>
    </div>

    <div class="card p-4">
        <h2>แก้ไขข้อมูลการคืนอุปกรณ์</h2>
        <form action="{{ route('equipmentreturn.update', $equipmentReturn->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="borrow_id" class="form-label">เลือกการยืม:</label>
                <select name="borrow_id" id="borrow_id" class="form-select" required>
                    <option value="">-- เลือกไอดีการยืม --</option>
                    @foreach($borrows as $borrow)
                        <option value="{{ $borrow->id }}" 
                            {{ $equipmentReturn->equipments_id == $borrow->equipments_id ? 'selected' : '' }}>
                            ID: {{ $borrow->id }} | 
                            อุปกรณ์: {{ $borrow->equipment->equipment_name }} 
                            ({{ $borrow->quantity }} {{ $borrow->equipment_type->equipmenttype_name }}) | 
                            ผู้ยืม: {{ $borrow->user->username }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="return_date" class="form-label">วันที่คืน:</label>
                <input type="date" name="return_date" id="return_date" class="form-control" 
                    value="{{ $equipmentReturn->return_date }}" required>
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">หมายเหตุ:</label>
                <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ $equipmentReturn->remarks }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
        </form>
    </div>
</div>
@endsection
