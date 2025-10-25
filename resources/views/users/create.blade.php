@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-4">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                    <h3 class="mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>เพิ่มผู้ใช้ใหม่
                    </h3>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('users.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <!-- ชื่อ-สกุล -->
                        <div class="mb-3">
                            <label for="username" class="form-label">ชื่อ-สกุล:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อ-สกุล</div>
                        </div>

                        <!-- เบอร์โทร -->
                        <div class="mb-3">
                            <label for="telephone_number" class="form-label">เบอร์โทรศัพท์:</label>
                            <input type="tel" name="telephone_number" id="telephone_number" class="form-control" required>
                            <div class="invalid-feedback">กรุณากรอกเบอร์โทรศัพท์</div>
                        </div>

                        <!-- อีเมล์ -->
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล์:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <div class="invalid-feedback">กรุณากรอกอีเมล์</div>
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน:</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" minlength="4" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">รหัสผ่านอย่างน้อย 4 ตัวอักษร</small>
                            <div class="invalid-feedback">กรุณากรอกรหัสผ่านให้ถูกต้อง</div>
                        </div>

                        <!-- บทบาท -->
                        <div class="mb-3">
                            <label for="role" class="form-label">บทบาท:</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- เลือกบทบาท --</option>
                                <option value="user">ผู้ใช้ทั่วไป</option>
                                <option value="manager">ผู้จัดการ</option>
                                <option value="admin">ผู้ดูแลระบบ</option>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกบทบาท</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            บันทึกผู้ใช้
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script show/hide password + bootstrap validation -->
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
    }
});

// Bootstrap validation
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
@endsection
