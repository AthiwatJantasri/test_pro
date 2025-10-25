@extends('template.backend')

@section('content')
<!-- Core CSS -->
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-left">รายการอนุมัติคำขอยืมครุภัณฑ์</h2>
        </div>

        <div class="text-end mb-3">
            <div class="w-60 mx-5">
                <form action="{{ route('approve.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="ค้นหาคำขออนุมัติ..."
                        value="{{ request('search') }}" autocomplete="off">
                    <div class="d-flex gap-2">
                        <!-- ปุ่มค้นหา -->
                        <button type="submit" class="btn btn-primary px-3 py-1 d-inline-flex align-items-center gap-1" style="font-size: 0.875rem;">
                            <i class="bi bi-search" style="font-size: 1rem;"></i>
                            ค้นหา
                        </button>

                        <!-- ปุ่มเพิ่ม -->
                        <button type="button" class="btn btn-success px-3 py-1 d-inline-flex align-items-center gap-1" style="font-size: 0.875rem;">
                            <i class="bi bi-plus-lg" style="font-size: 1rem;"></i>
                            เพิ่มข้อมูลเพิ่มเติม
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection