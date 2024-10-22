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
                  Data Hafalan
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
                <a href="{{ url('/daftar-hafalan') }}" class="btn btn-primary mt-2">Lihat</a>
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
          @if($revisi != 0)
          <div class="card-body bg-light-danger">
            @else
            <div class="card-body bg-light">
              @endif
              <div class="row alig n-items-start">
                <div class="col-8">
                  <h5 class="card-title mb-9 fw-semibold">
                    Perlu Diulang
                  </h5>
                  <h4>{{ $revisi }}</h4>
                  @if($revisi != 0)
                  <a href="{{ url('/daftar-hafalan?search=mengulang') }}" class="btn btn-primary mt-2">Revisi</a>
                  @endif
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-end">
                    <div class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                      <i class="ti ti-reload fs-6"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-body bg-success">
              <div class="row alig n-items-start">
                <h5 class="card-title mb-9 fw-semibold text-white">
                  Halaqoh:
                </h5>
                <h3>{{ $santri->halaqoh->nama_halaqoh }}</h3>
                <h4>( {{ $santri->halaqoh->ustad->name }} )</h4>
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