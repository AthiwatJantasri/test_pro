@extends('template.backend')

@section('content')
    <!-- Core CSS -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
    <div class="container my-5">
        <!-- Display Errors if Any -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Edit Form Section -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('equipments.update', $equipments->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                     <!-- Header Section -->
                    <div class="text-center mb-4">
                        <h1>แก้ไขข้อมูลของครุภัณฑ์</h1>
                        <p class="text-muted">ปรับปรุงข้อมูลครุภัณฑ์ที่ต้องการ</p>
                    </div>

                    <!-- Input for Equipment Name -->
                    <div class="mb-3">
                        <label for="equipment_name" class="form-label">ชื่อครุภัณฑ์</label>
                        <input type="text" name="equipment_name" id="equipment_name" class="form-control" value="{{ $equipments->equipment_name }}" required>
                    </div>

                    <!-- Input for Stock -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">จำนวนที่มีอยู่ในคลัง</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ $equipments->stock }}" required>
                    </div>

                    <!-- Input for Equipment Code -->
                    <div class="mb-3">
                        <label for="equipment_code" class="form-label">รหัสครุภัณฑ์ (ถ้ามี)</label>
                        <input type="text" name="equipment_code" id="equipment_code" class="form-control" value="{{ $equipments->equipment_code }}">
                    </div>

                    <!-- Dropdown for Equipment Type -->
                    <div class="mb-3">
                        <label for="equipment_type_id" class="form-label">หน่วยนับของครุภัณฑ์</label>
                        <select name="equipment_type_id" id="equipment_type_id" class="form-select" required>
                            <option value="">-- เลือกประเภท --</option>
                            @foreach ($equipmentType as $type)
                                <option value="{{ $type->id }}" {{ $type->id == $equipments->equipment_type_id ? 'selected' : '' }}>
                                    {{ $type->equipmenttype_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
                        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection