<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            color: #333;
            margin-bottom: 30px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }
        .form-label {
            font-size: 14px;
        }
        .mt-3 a {
            color: #007bff;
            text-decoration: none;
        }
        .mt-3 a:hover {
            text-decoration: underline;
        }
        .alert {
            margin-bottom: 20px;
        }
        .invalid-feedback {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">สมัครสมาชิก</h2>

        <!-- ข้อความแจ้งเตือนหลังสมัครสำเร็จ -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- ฟอร์มสมัครสมาชิก -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">ชื่อ-นามสกุล</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">อีเมล์</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
        </form>

        <p class="mt-3 text-center">มีบัญชีแล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบ</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
