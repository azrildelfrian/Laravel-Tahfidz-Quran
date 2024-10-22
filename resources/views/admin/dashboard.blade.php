@extends('template.page')
@section('content')
<div class="container-fluid">
  <!--  Row 1 -->
  <div class="row">
    <div class="row">

      <div class="col-lg-4">
        <!-- Monthly Earnings -->
        <div class="card">
          <div class="card-body bg-light">
            <div class="row alig n-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">
                  Jumlah Akun Ustad & Santri
                </h5>
                <h4 class="fw-semibold mb-3">{{ $userCount }}</h4>
                @if($userAddedToday != 0)
                <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-up-left text-success"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+{{ $userAddedToday }}</p>
                  <p class="fs-3 mb-0">hari ini</p>
                </div>
                @elseif($userDeletedToday != 0)
                <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-down-right text-danger"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">-{{ $userDeletedToday }}</p>
                  <p class="fs-3 mb-0">hari ini</p>
                </div>
                @endif
                <a href="{{ url('/admin/daftar-akun') }}" class="btn btn-warning mt-2">Lihat</a>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <div class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-users fs-6"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- Monthly Earnings -->
        <div class="card">
          <div class="card-body bg-light">
            <div class="row alig n-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">
                  Jumlah Data Hafalan
                </h5>
                <h4 class="fw-semibold mb-3">{{ $hafalanCount }}</h4>
                @if($hafalanAddedToday != 0)
                <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-up-left text-success"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+{{ $hafalanAddedToday }}</p>
                  <p class="fs-3 mb-0">Hari ini</p>
                </div>
                @elseif($hafalanDeletedToday != 0)
                <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-down-right text-danger"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">-{{ $hafalanDeletedToday }}</p>
                  <p class="fs-3 mb-0">hari ini</p>
                </div>
                @endif
                <a href="{{ url('/admin/daftar-hafalan') }}" class="btn btn-primary mt-2">Lihat</a>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <div class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-article fs-6"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- Monthly Earnings -->
        <div class="card">
          <div class="card-body bg-light">
            <div class="row alig n-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">
                  Tambah Data
                </h5>
                <a href="{{ url('/admin/daftar-akun/tambah') }}" class="btn btn-warning mt-2">Tambah User</a>
                <a href="{{ url('/admin/tambah-hafalan') }}" class="btn btn-primary mt-2">Tambah Hafalan</a>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <div class="text-white bg-dark rounded-circle p-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-plus fs-6"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- Monthly Earnings -->
        <div class="card">
          <div class="card-body bg-light">
            <div class="row alig n-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">
                  Jumlah Kelas
                </h5>
                <h4 class="fw-semibold mb-3">{{ $kelasCount }}</h4>
                <a href="{{ url('/admin/daftar-kelas') }}" class="btn btn-success mt-2">Lihat</a>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <div class="text-white bg-dark rounded-circle p-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-list-details fs-6"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- Monthly Earnings -->
        <div class="card">
          <div class="card-body bg-light">
            <div class="row alig n-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">
                  Jumlah Halaqoh
                </h5>
                <h4 class="fw-semibold mb-3">{{ $halaqohCount }}</h4>
                <a href="{{ url('admin/daftar-halaqoh') }}" class="btn btn-info mt-2">Lihat</a>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <div class="text-white bg-info rounded-circle p-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-users fs-6"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
@push('script')
@endpush