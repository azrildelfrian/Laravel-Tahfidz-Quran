@extends('template.page')
@section('content')
<div class="container-fluid">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Detail Hafalan</h5>
                    <div class="row">
                    <div class="col-md-4">
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Nama Santri</label>
                      <p>{{ $hafalan->user->name }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="Surat" class="form-label">Surat Hafalan</label>
                      <p>{{ $hafalan->surat_1->nama_surat }} Ayat {{ $hafalan->ayat_setoran_1 }}</p>
                      <p>Sampai</p>
                      <p>{{ $hafalan->surat_2->nama_surat }} Ayat {{ $hafalan->ayat_setoran_2 }}</p>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Status</label>
                      <p>{{ $hafalan->status }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Kelancaran</label>
                      @if($hafalan->kelancaran)
                      <p>{{ $hafalan->kelancaran }}</p>
                      @else
                      <p>Belum Diperiksa</p>
                      @endif
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Tanggal Hafalan</label>
                      <p>{{ $hafalan->tanggal_hafalan }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Mengulang</label>
                      <p>{{ $hafalan->ulang }}</p>
                    </div>
                    </div>
                    <h6>File Hafalan</h6>
                    @if(auth()->user() && auth()->user()->role === 'santri')
                        @if(isset($hafalan) && $hafalan->file_hafalan)
                            <audio controls>
                                <source src="{{ asset('file/hafalan/' . $hafalan->file_hafalan) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <p>Tidak ada file hafalan</p>
                        @endif
                    @endif
                    </div>
                    <div class="mb-3">
                    <label for="NamaSantri" class="form-label">Catatan</label>
                    <div class="p-3 bg-light-primary rounded">
                      @if($hafalan->catatan_teks)
                      <p>{{ $hafalan->catatan_teks }}</p>
                      @else
                          <p>Belum ada catatan...</p>
                      @endif
                      @if($hafalan->catatan_suara)
                          <audio controls>
                              <source src="{{ asset('file/catatan_suara/' . $hafalan->catatan_suara) }}" type="audio/mp3">
                              Your browser does not support the audio element.
                          </audio>
                      @endif
                    </div>
                    </div>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.pages.periksa-hafalan', $hafalan->id) }}" class="btn btn-warning">Periksa</a>
                    <a href="{{ url('/admin/daftar-hafalan') }}" class="btn btn-primary">Kembali</a>
                    @elseif(auth()->user()->role === 'ustad')
                    <a href="{{ route('ustad.pages.periksa-hafalan', $hafalan->id) }}" class="btn btn-warning">Periksa</a>
                    <a href="{{ url('/ustad/daftar-hafalan') }}" class="btn btn-primary">Kembali</a>
                    @elseif(auth()->user()->role === 'santri')
                    @if($hafalan->ulang === 'mengulang')
                    <a href="{{ route('pages.edit-hafalan', $hafalan->id) }}" class="btn btn-warning">Revisi</a>
                    @endif
                    <a href="{{ url('/daftar-hafalan') }}" class="btn btn-primary">Kembali</a>
                    @endif
            </div>
          </div>
@endsection