<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="vuexy/assets/"
  data-template="vertical-menu-template"
  data-style="light">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>ระบบยืมคืนครุภัณฑ์</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="vuexy/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="/vuexy/assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/apex-charts/apex-charts.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/swiper/swiper.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/pages/cards-advance.css" />

  <!-- Helpers -->
  <script src="/vuexy/assets/vendor/js/helpers.js"></script>

  <!-- Config -->
  <script src="/vuexy/assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="welcome" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img class="mt-1" src="/rmu.png" alt="" width="50" height="50">
            </span>
            <span class="app-brand-text demo menu-text fw-bold mt-2">ยินดีต้อนรับ</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- เช็คสถานะการเข้าสู่ระบบ -->
          @if(Auth::check())
          <!-- ใช้ dropdown สำหรับการแสดงชื่อผู้ใช้และออกจากระบบ -->
          <li class="menu-item dropdown">
            <a href="" class="menu-link dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div>สวัสดี, {{ Auth::user()->username }}</div>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <!-- ออกจากระบบ -->
              <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="dropdown-item btn btn-danger">ออกจากระบบ</button>
                </form>
              </li>
            </ul>
          </li>
          @else
          <li class="menu-item">
            <a href="{{ route('login') }}" class="menu-link btn btn-primary">เข้าสู่ระบบ</a>
          </li>
          @endif

          <!-- เมนูสำหรับ Admin -->
          @if(Auth::check() && Auth::user()->role === 'admin')
          <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-smart-home"></i>
              <div data-i18n="เมนูทั้งหมด">เมนูทั้งหมด</div>
            </a>

            <ul class="menu-sub">
              <li class="menu-item">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                  <div data-i18n="จำนวนในคลัง">จำนวนในคลัง</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('users.index') }}" class="menu-link">
                  <div data-i18n="ข้อมูลผู้ใช้">ข้อมูลผู้ใช้</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('equipments.index') }}" class="menu-link">
                  <div data-i18n="รายการครุภัณฑ์">รายการครุภัณฑ์</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('equipmentborrow.index') }}" class="menu-link">
                  <div data-i18n="รายการยืมครุภัณฑ์">รายการยืมครุภัณฑ์</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('equipmentreturn.index') }}" class="menu-link">
                  <div data-i18n="รายการคืนครุภัณฑ์">รายการคืนครุภัณฑ์</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('frontend.index') }}" class="menu-link">
                  <div data-i18n="ข้อมูลการยืมคืน">ข้อมูลการยืมคืน</div>
                </a>
              </li>
            </ul>
          </li>
          @endif


          <!-- เมนูสำหรับ Manager (เห็นเฉพาะ รายการยืมครุภัณฑ์) -->
          @if(Auth::check() && Auth::user()->role === 'manager')
          <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-list"></i>
              <div data-i18n="เมนูผู้จัดการ">เมนูผู้จัดการ</div>
            </a>

            <ul class="menu-sub">
              <li class="menu-item">
                <a href="{{ route('equipmentborrow.index') }}" class="menu-link">
                  <div data-i18n="รายการยืมครุภัณฑ์">รายการยืมครุภัณฑ์</div>
                </a>
              </li>
            </ul>
          </li>
          @endif

          <!-- แสดงเมนูเฉพาะสำหรับ User -->
          @if(Auth::check() && Auth::user()->role === 'user')
          <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-smart-home"></i>
              <div data-i18n="เมนูทั้งหมด">เมนูทั้งหมด</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                  <div data-i18n="จำนวนในคลัง">จำนวนในคลัง</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('equipmentborrow.create') }}" class="menu-link">
                  <div data-i18n="ยืมครุภัณฑ์">ยืมครุภัณฑ์</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('equipmentreturn.create') }}" class="menu-link">
                  <div data-i18n="คืนครุภัณฑ์">คืนครุภัณฑ์</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('history.index') }}" class="menu-link">
                  <div data-i18n="ประวัติการยืมคืน">ประวัติการยืมคืน</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        </li>
        @endif
        </ul>

      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          @yield('content')
          <!-- / Content -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="/vuexy/assets/vendor/libs/popper/popper.js"></script>
  <script src="/vuexy/assets/vendor/js/bootstrap.js"></script>
  <script src="/vuexy/assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="/vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="/vuexy/assets/vendor/libs/hammer/hammer.js"></script>
  <script src="/vuexy/assets/vendor/libs/i18n/i18n.js"></script>
  <script src="/vuexy/assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="/vuexy/assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/vuexy/assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="/vuexy/assets/vendor/libs/swiper/swiper.js"></script>
  <script src="/vuexy/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

  <!-- Main JS -->
  <script src="/vuexy/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="/vuexy/assets/js/dashboards-analytics.js"></script>
</body>

</html>