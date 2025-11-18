@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">

                <!-- ส่วนหัว -->
                <div class="card-header bg-primary text-dark text-center rounded-top-4 py-3">
                    <h3 class="mb-0 fw-bold">
                        <i></i>แก้ไขข้อมูลผู้ใช้
                    </h3>
                </div>

                <!-- โลโก้อยู่กลาง -->
                <div class="d-flex justify-content-center mt-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                        alt="User Avatar" class="rounded-circle shadow-sm" width="120" height="120">
                </div>

                <!-- ฟอร์ม -->
                <div class="card-body p-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- ชื่อ-นามสกุล -->
                        <div class="mb-3">
                            <label for="username" class="form-label">ชื่อ-นามสกุล:</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username', $user->username) }}" required>
                        </div>

                        <!-- เบอร์โทรศัพท์ -->
                        <div class="mb-3">
                            <label for="telephone_number" class="form-label">เบอร์โทรศัพท์:</label>
                            <input type="tel" class="form-control" id="telephone_number" name="telephone_number"
                                value="{{ old('telephone_number', $user->telephone_number) }}" required>
                        </div>

                        <!-- อีเมล์ -->
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล์:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="เว้นว่างไว้เพื่อเก็บรหัสผ่านปัจจุบัน">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">* เว้นว่างไว้เพื่อเก็บรหัสผ่านปัจจุบัน</small>
                        </div>

                        <!-- บทบาท -->
                        <div class="mb-4">
                            <label for="role" class="form-label">บทบาท:</label>
                            <select class="form-select" name="role" id="role" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                    ผู้ใช้ทั่วไป
                                </option>
                                <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>
                                    ผู้อำนวยการ
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    ผู้ดูแลระบบ
                                </option>
                            </select>
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>บันทึกข้อมูลที่แก้ไข
                            </button>

                            <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i>กลับไปหน้าจัดการ
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Script show/hide password -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
@endsection