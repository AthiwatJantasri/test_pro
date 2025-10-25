@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

<div class="container mt-5">
    <div class="card mb-2">
        <div class="card-body">
            <!-- Header -->
            <h2 class="mb-4">รายการครุภัณฑ์ในระบบ</h2>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Add Equipment Buttons -->
            <div class="mb-3">
                <a href="{{ route('equipment_types.index') }}" class="btn btn-primary me-2">เพิ่มหน่วยนับของครุภัณฑ์</a>
                <a href="{{ route('equipments.create') }}" class="btn btn-success me-2">เพิ่มข้อมูลครุภัณฑ์</a>
                <a href="{{ route('equipments.pdf') }}" class="btn btn-info">
                    <i class="fas fa-file-pdf me-1"></i> ดาวน์โหลด PDF
                </a>
            </div>

            <!-- Equipment List Table -->
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อครุภัณฑ์</th>
                            <th>จำนวนที่มีอยู่ในคลัง</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $equipment)
                        <tr>
                            <td>{{ ($equipments->currentPage() - 1) * $equipments->perPage() + $loop->iteration }}</td>
                            <td>{{ $equipment->equipment_name }}</td>
                            <td>{{ $equipment->stock }} {{ $equipment->equipmentType->equipmenttype_name }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-warning btn-sm me-1">แก้ไข</a>
                                <!-- Delete Form -->
                                <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">ลบข้อมูล</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-2">
                    {{ $equipments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
