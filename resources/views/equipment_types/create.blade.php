@extends('template.backend')

@section('content')
    <!-- Core CSS -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
    <div class="container mt-5">
        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('equipment_types.store') }}" method="POST">
                    @csrf
                    <!-- Header -->
                    <h1 class="mb-4 text-center">เพิ่มหน่วยนับครุภัณฑ์</h1>
                    <!-- Input Field -->
                    <div class="mb-3">
                        <label for="equipmenttype_name" class="form-label">หน่วยนับของครุภัณฑ์</label>
                        <input type="text" class="form-control" id="equipmenttype_name" name="equipmenttype_name" required>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">บันทึก</button>
                        <a href="{{ route('equipment_types.index') }}" class="btn btn-secondary">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
