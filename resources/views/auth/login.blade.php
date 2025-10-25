@extends('template.login')

@section('content')

<div class="login-container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%; background-color: #f8f9fa;">
        <!-- Logo -->
        <div class="d-flex justify-content-center mb-3">
            <img src="./rmu.png" alt="Logo" class="img-fluid" style="max-width: 100px; height: auto;">
        </div>

        <!-- ระบบชื่อ -->
        <h5 class="text-center text-secondary mb-3">
            ระบบยืมคืนครุภัณฑ์สํานักงานกองบริหารงานบุคคลมหาวิทยาลัยราชภัฏมหาสารคาม
        </h5>

        <!-- Title -->
        <h2 class="text-center mb-4">เข้าสู่ระบบ</h2>

        <!-- แสดงข้อผิดพลาด -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- ฟอร์มเข้าสู่ระบบ -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">อีเมล์:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="กรุณากรอกอีเมล์" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน:</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
            </div>
        </form>

    </div>
</div>

<!-- Bootstrap & toggle password JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>

@endsection
