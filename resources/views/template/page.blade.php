<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HafalanQu - Sistem Monitoring Quran</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/mystyle/styles.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  @stack('style')
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ url('/') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
          </a>
          <!--<h4>Assalamualaikum, {{ Auth::user()->name }}</h4>-->
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" 
              @if (Auth::user()->role === 'admin')
              href="{{ url('/admin/dashboard') }}"
              @elseif (Auth::user()->role === 'ustad')
              href="{{ url('/ustad/dashboard') }}"
              @elseif (Auth::user()->role === 'santri')
              href="{{ url('/dashboard') }}"
              @endif
              aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Hafalan</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" 
              @if (Auth::user()->role === 'admin')
              href="{{ url('/admin/daftar-hafalan') }}"
              @elseif (Auth::user()->role === 'ustad')
              href="{{ url('/ustad/daftar-hafalan') }}"
              @elseif (Auth::user()->role === 'santri')
              href="{{ url('/daftar-hafalan') }}"
              @endif 
              aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Daftar Hafalan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link"
              @if (Auth::user()->role === 'admin')
              href="{{ url('/admin/tambah-hafalan') }}"
              @elseif (Auth::user()->role === 'ustad')
              href="{{ url('/ustad/tambah-hafalan') }}"
              @elseif (Auth::user()->role === 'santri')
              href="{{ url('/tambah-hafalan') }}"
              @endif  
              aria-expanded="false">
                <span>
                  <i class="ti ti-plus"></i>
                </span>
                <span class="hide-menu">Tambah Hafalan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" 
              @if (Auth::user()->role === 'admin')
              href="{{ url('/admin/riwayat-hafalan') }}"
              @elseif (Auth::user()->role === 'ustad')
              href="{{ url('/ustad/riwayat-hafalan') }}"
              @elseif (Auth::user()->role === 'santri')
              href="{{ url('/riwayat-hafalan') }}"
              @endif 
              aria-expanded="false">
                <span>
                  <i class="ti ti-history"></i>
                </span>
                <span class="hide-menu">Riwayat Hafalan</span>
              </a>
            </li>
            @if (Auth::user()->role === 'admin')
            <li class="sidebar-item">
              <a class="sidebar-link" 
              href="{{ url('/admin/daftar-akun') }}"
              aria-expanded="false">
              <span>
                <i class="ti ti-users"></i>
              </span>
              <span class="hide-menu">Daftar Akun</span>
            </a>
          </li>
          @endif
          </ul>

        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            {{ Auth::user()->name }}
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="ti ti-user-circle"></i>
                  <!-- <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle"> -->
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <!--<a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>-->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" class="btn btn-outline-danger mx-3 mt-2 d-block">Keluar</a>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  @stack('script')
</body>

</html>