@extends('template.page')
@section('content')
<div class="container-fluid">
              <h5 class="card-title fw-semibold mb-4">Periksa Hafalan</h5>
                <form action="{{ 
                      (auth()->user()->role === 'admin' ? 
                          route('admin.hafalan.reviewed', $hafalan->id) : 
                          route('ustad.hafalan.reviewed', $hafalan->id)
                      )
                  }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')
                    <div class="row">
                    <div class="col-md-4">
                    <div class="mb-3">
                      <input name="diperiksa_oleh" type="hidden" class="form-control" value="{{ Auth::user()->id }}">
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
                        <label for="Kelancaran" class="form-label">Kelancaran</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelancaran" value="lancar" id="lancar" required>
                            <label class="form-check-label" for="lancar">Lancar</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelancaran" value="agak lancar" id="agak_lancar" required>
                            <label class="form-check-label" for="agak_lancar">Agak Lancar</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelancaran" value="kurang lancar" id="kurang_lancar" required>
                            <label class="form-check-label" for="kurang_lancar">Kurang Lancar</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelancaran" value="tidak lancar" id="tidak_lancar" required>
                            <label class="form-check-label" for="tidak_lancar">Tidak Lancar</label>
                        </div>
                    </div>

                    </div>
                    <div class="col-md-4">
                    <div class="mb-3">
                      <label for="NamaSantri" class="form-label">Tanggal Hafalan</label>
                      <p>{{ $hafalan->tanggal_hafalan }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="Ulang" class="form-label">Mengulang</label>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ulang" value="mengulang" id="mengulang" required>
                            <label class="form-check-label" for="mengulang">Mengulang</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ulang" value="tidak" id="tidak_ulang" required>
                            <label class="form-check-label" for="tidak_ulang">Tidak</label>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="mb-3">
                    <label for="NamaSantri" class="form-label">Hafalan</label>
                    <div class="p-3 bg-light-info rounded">
                    @if($hafalan->file_hafalan)
                    <audio controls>
                    <source src="{{ asset('file/hafalan/' . $hafalan->file_hafalan) }}">
                    Your browser does not support the audio element.
                    </audio>
                    @else
                      <p>Tidak ada file hafalan</p>
                    @endif
                    </div>
                    </div>
                    <div class="mb-3">
                    <label for="NamaSantri" class="form-label">Catatan</label>
                    <div class="p-3 bg-light-primary rounded">
                    <textarea name="catatan_teks" id="" cols="30" rows="5" class="form-control m-2" placeholder="Berikan catatan untuk santri...">{{ $hafalan->catatan_teks }}</textarea>
                    <input type="file" name="catatan_suara" id="file" accept="audio/mp3" class="form-control form-control-lg m-2" placeholder="Upload catatan suara disini...">
                    <div id="emailHelp" class="form-text">Silahkan upload file catatan berupa file audio mp3</div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-success ms-auto">Tandai Sudah Diperiksa</button>
                    @if(auth()->user()->role === 'admin')
                    <button class="btn btn-primary" onclick="goBack()">Kembali</button>
                    @elseif(auth()->user()->role === 'ustad')
                    <button class="btn btn-primary" onclick="goBack()">Kembali</button>
                    @endif
                </form>
        </div>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
@endsection