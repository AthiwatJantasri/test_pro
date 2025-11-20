@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

<div class="container my-5">
    <!-- Display Success Alert -->
    @if (session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('equipments.store') }}" method="POST">
                @csrf

                <!-- Header Section -->
                <div class="text-center mb-4">
                    <h1>เพิ่มครุภัณฑ์</h1>
                    <p class="text-muted">กรอกข้อมูลครุภัณฑ์ใหม่เพื่อเพิ่มลงในคลัง</p>
                </div>

                <!-- Equipment Name -->
                <div class="mb-3">
                    <label for="equipment_name" class="form-label">ชื่อครุภัณฑ์</label>
                    <input type="text" name="equipment_name" id="equipment_name" class="form-control" placeholder="ป้อนชื่อพัสดุ" required>
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label">จำนวนที่เพิ่มในคลัง</label>
                    <input type="number" name="stock" id="stock" class="form-control" placeholder="ป้อนจำนวน" required>
                </div>

                <!-- Equipment Code -->
                <div class="mb-3">
                    <label for="equipment_code" class="form-label">รหัสครุภัณฑ์ (ถ้ามี)</label>
                    <input type="text" name="equipment_code" id="equipment_code" class="form-control" placeholder="ป้อนรหัสครุภัณฑ์">
                </div>

                <!-- Equipment Type -->
                <div class="mb-3">
                    <label for="equipment_type_id" class="form-label">ประเภทของครุภัณฑ์</label>
                    <select name="equipment_type_id" id="equipment_type_id" class="form-select" required>
                        <option value="">-- เลือกประเภท --</option>
                        @foreach ($equipmentType as $type)
                        <option value="{{ $type->id }}">{{ $type->equipmenttype_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('equipments.index') }}" class="btn btn-secondary">กลับไปที่หน้าข้อมูลครุภัณฑ์</a>
                    <button type="submit" class="btn btn-success">บันทึกครุภัณฑ์</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
