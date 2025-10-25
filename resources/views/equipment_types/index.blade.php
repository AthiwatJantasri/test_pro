@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/1642/1642366.png"
                    alt="Equipment Icon" width="60" height="60" class="me-3">
                <div>
                    <h2 class="fw-bold text-primary mb-0">หน่วยนับครุภัณฑ์</h2>
                    <p class="text-muted mb-0">ดู แก้ไข และจัดการหน่วยนับครุภัณฑ์ในระบบ</p>
                </div>
            </div>

            <!-- Success Message Section -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Add Button -->
            <div class="mb-4 text-start">
                <a href="{{ route('equipment_types.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-1"></i> เพิ่มหน่วยนับใหม่
                </a>
            </div>

            <!-- Equipment Types Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 10%;">ลำดับ</th>
                            <th style="width: 60%;">ชื่อหน่วยนับ</th>
                            <th style="width: 30%;">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipmentTypes as $equipmentType)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-start ps-4">
                                <i class="fas fa-cubes text-secondary me-2"></i>
                                {{ $equipmentType->equipmenttype_name }}
                            </td>
                            <td>
                                <a href="{{ route('equipment_types.edit', $equipmentType->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i> แก้ไข
                                </a>
                                <form action="{{ route('equipment_types.destroy', $equipmentType->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                        <i class="fas fa-trash-alt"></i> ลบข้อมูล
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- FontAwesome Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
