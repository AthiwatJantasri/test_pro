@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Header Section -->
            <div class="d-flex align-items-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                     alt="User Icon" width="60" height="60" class="me-3">
                <div>
                    <h2 class="fw-bold text-primary mb-0">ข้อมูลของผู้ใช้</h2>
                    <p class="text-muted mb-0">จัดการ ดูรายละเอียด และแก้ไขข้อมูลผู้ใช้ทั้งหมดในระบบ</p>
                </div>
            </div>

            <!-- Flash Message (Success) -->
            @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <script>
                setTimeout(function() {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>
            @endif

            <!-- Search and Add Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="{{ route('users.index') }}" method="GET" class="d-flex" style="width: 50%;">
                    <input type="text" name="search" class="form-control me-2" placeholder="🔍 ค้นหาชื่อผู้ใช้..."
                        value="{{ request('search') }}" autocomplete="off">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> ค้นหา
                    </button>
                </form>

                <a href="{{ route('users.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus-fill me-1"></i> เพิ่มข้อมูลผู้ใช้ใหม่
                </a>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>อีเมล</th>
                            <th>บทบาท</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td class="text-start ps-4 fw-semibold">
                                <i class="bi bi-person-circle text-secondary me-2"></i> {{ $user->username }}
                            </td>
                            <td>{{ $user->telephone_number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger"><i class="bi bi-shield-lock-fill me-1"></i> แอดมิน</span>
                                @elseif($user->role === 'manager')
                                    <span class="badge bg-primary"><i class="bi bi-person-gear me-1"></i> ผู้อำนวยการ</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-person-fill me-1"></i> ผู้ใช้ทั่วไป</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye"></i> ดูข้อมูล
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> แก้ไข
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')">
                                        <i class="bi bi-trash"></i> ลบข้อมูล
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
