@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-dark text-center rounded-top-4 py-3">
          <h3 class="fw-bold mb-0"><i class="bi bi-person-circle me-2"></i>รายละเอียดของผู้ใช้</h3>
        </div>

        <div class="card-body text-center">
          <!-- รูปโปรไฟล์ -->
          <div class="mt-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                 alt="User Avatar" class="rounded-circle shadow-sm" width="120" height="120">
          </div>

          <!-- ชื่อผู้ใช้ -->
          <h4 class="fw-bold text-primary mb-1">{{ $user->username }}</h4>
          <p class="text-muted mb-3">
            <i class="bi bi-envelope-at me-1"></i>{{ $user->email ?? 'ไม่มีอีเมล' }}
          </p>

          <!-- ตารางรายละเอียด -->
          <table class="table table-bordered align-middle shadow-sm rounded-3">
            <tbody>
              <tr>
                <th class="bg-light text-end" style="width: 35%">
                  <i class="bi bi-telephone me-2 text-primary"></i>เบอร์โทรศัพท์
                </th>
                <td>{{ $user->telephone_number ?? '-' }}</td>
              </tr>
              <tr>
                <th class="bg-light text-end">
                  <i class="bi bi-person-badge me-2 text-primary"></i>บทบาท
                </th>
                <td>
                  @if($user->role === 'admin')
                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                      <i class="bi bi-shield-lock-fill me-1"></i>แอดมิน
                    </span>
                  @elseif($user->role === 'manager')
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                      <i class="bi bi-person-gear me-1"></i>ผู้อำนวยการ
                    </span>
                  @else
                    <span class="badge bg-secondary px-3 py-2 rounded-pill">
                      <i class="bi bi-person-fill me-1"></i>ผู้ใช้ทั่วไป
                    </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>

          <!-- ปุ่มกลับ -->
          <div class="mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary rounded-pill px-4">
              <i class="bi bi-arrow-left-circle me-1"></i> กลับไปหน้าจัดการ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
