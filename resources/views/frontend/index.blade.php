@extends('template.backend')

@section('content')
  <!-- Core CSS -->
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

  <div class="container mt-3">
      <h2 class="text-center mb-4">- ประวัติการยืมทั้งหมด -</h2>
      <!-- การ์ดสำหรับข้อมูลพัสดุ -->
      <div class="card shadow-lg">
          <div class="card-header">
              <h3 class="mb-0">ครุภัณฑ์สํานักงานที่ถูกยืม</h3>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered text-center">
                      <thead class="table-primary">
                          <tr>
                              <th>ชื่อผู้ยืม</th>
                              <th>ชื่อพัสดุ</th>
                              <th>วันที่ยืม</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($equipments as $item)
                              <tr>
                                  <td>{{ $item->user ? $item->user->username : 'N/A' }}</td>
                                  <td>{{ $item->equipment ? $item->equipment->equipment_name : 'N/A' }}</td>
                                  <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A' }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="card-footer d-flex justify-content-center">
              {{ $equipments->links() }} <!-- เพจจิเนชั่นของพัสดุ -->
          </div>
      </div>
  </div>
@endsection
