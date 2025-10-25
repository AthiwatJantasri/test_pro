@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
@if (!in_array(auth()->user()->role, ['admin', 'manager']))
<script>
    window.location.href = "{{ route('frontend.index') }}";
</script>
@endif
<!-- Content Section -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="welcome-section text-center">
                <h1 class="welcome-title mb-4">ยินดีต้อนรับสู่ระบบการยืม-คืนครุภัณฑ์สำนักงานของกองบริหารงานบุคคล</h1>
                <p class="lead mb-4">มหาวิทยาลัยราชภัฏมหาสารคาม</p>
                <hr class="my-4">
                <p>ระบบนี้ช่วยให้การจัดการการยืมและคืนครุภัณฑ์สำนักงานเป็นไปอย่างมีประสิทธิภาพและเป็นระเบียบ</p>
                <img src="02.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-white text-center py-3 mt-5">
    <div class="container">
        <p class="mb-0">&copy; 2024 กองบริหารงานบุคคล | ระบบการยืม-คืนวัสดุอุปกรณ์</p>
    </div>
</footer>
@endsection