@extends('template.page')
@section('content')
<div class="card-header mb-2">
    <div class="d-flex align-items-center">
        <h4 class="">Edit/Revisi Hafalan</h4>
    </div>
</div>
<hr class="horizontal dark">
<form action="{{ auth()->user()->role === 'santri' ? route('santri.hafalan.edit', $hafalan->id) : 
    (auth()->user()->role === 'admin' ? route('admin.hafalan.edit', $hafalan->id) : '') }}" 
    method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')
                        <div class="row">
                        @if (Auth::user()->role === 'admin')
                        <div class="mb-3">
                            <h4>Nama Santri</h4>
                            <h6>{{ $hafalan->user->name }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nama Ustad Pemeriksa</label>
                            <select name="diperiksa_oleh" id="nama_ustad" class="form-control" >
                                <option value="">=== Pilih Ustad ===</option>
                                @foreach ($users as $item)
                                    @if ($item->role === 'ustad')
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <input name="user_id" type="hidden" class="form-control" value="{{ $hafalan->user_id }}" required>
                        @elseif (Auth::user()->role === 'santri')
                            <div class="form-group">
                                <input name="user_id" type="hidden" class="form-control" value="{{ Auth::user()->id }}">
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Surat</label>
                                    <select name="surat_id" id="surat_1" class="form-control">
                                        @foreach ($surat as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == $hafalan->surat_id) selected @endif>{{ $item->nama_surat }} - {{ $item->ayat }} ayat</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ayat</label>
                                    <input name="ayat_setoran_1" class="form-control" type="number" value="{{ $hafalan->ayat_setoran_1 }}" placeholder="Masukkan ayat" min="1" required>
                                </div>
                            </div>
                        </div>
                            <hr class="horizontal dark mt-3">
                            <p class="text-uppercase m-2">Sampai</p>
                            <hr class="horizontal dark mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Surat</label>
                                    <select name="surat_id_2" id="surat_2" class="form-control">
                                        @foreach ($surat as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == $hafalan->surat_id_2) selected @endif>{{ $item->nama_surat }} - {{ $item->ayat }} ayat</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ayat</label>
                                    <input name="ayat_setoran_2" class="form-control" type="number" value="{{ $hafalan->ayat_setoran_2 }}"
                                        placeholder="Masukkan ayat" min="1" required>
                                </div>
                            </div>
                            @if (Auth::user()->role === 'admin')
                            <div class="col-md-4 card-header mt-1 p-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="belum diperiksa" id="mengulang"
                                            {{ $hafalan->status == 'belum diperiksa' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="mengulang">Belum Diperiksa</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="sudah diperiksa" id="tidak_ulang"
                                            {{ $hafalan->status == 'sudah diperiksa' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="sudah">Sudah Diperiksa</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 card-header mt-1 p-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Kelancaran</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kelancaran" value="lancar" id="lancar"
                                            {{ $hafalan->kelancaran == 'lancar' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="lancar">Lancar</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kelancaran" value="agak lancar" id="agak_lancar"
                                            {{ $hafalan->kelancaran == 'agak lancar' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="agak_lancar">Agak Lancar</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kelancaran" value="kurang lancar" id="kurang_lancar"
                                            {{ $hafalan->kelancaran == 'kurang lancar' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="kurang_lancar">Kurang Lancar</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kelancaran" value="tidak lancar" id="tidak_lancar"
                                            {{ $hafalan->kelancaran == 'tidak lancar' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="tidak_lancar">Tidak Lancar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 card-header mt-1 p-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mengulang</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ulang" value="mengulang" id="mengulang"
                                            {{ $hafalan->ulang == 'mengulang' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="mengulang">Mengulang</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ulang" value="tidak" id="tidak_ulang"
                                            {{ $hafalan->ulang == 'tidak' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="tidak_ulang">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12 mt-3">
                            <label for="filehafalan" class="form-label">File Hafalan Sebelumnya</label>
                             </div>
                            <div class="col-md-12 mt-3">
                            @if($hafalan->file_hafalan)
                            <audio controls style="width: 100%;">
                            <source src="{{ asset('file/hafalan/' . $hafalan->file_hafalan) }}">
                            Your browser does not support the audio element.
                            </audio>
                            @else
                              <p>Tidak ada file hafalan</p>
                            @endif
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Upload File Hafalan</label>
                                    <input type="file" name="file_hafalan" id="file" accept="audio/mp3" class="input100 form-control form-control-lg" value="{{ $hafalan->file_hafalan }}">
                                    <div id="emailHelp" class="form-text">Silahkan upload file hafalan berupa file audio</div>
                                </div>
                            </div>
                            <div>
                            @if (Auth::user()->role === 'admin')
                            <textarea name="catatan_teks" id="" cols="30" rows="5" class="form-control m-2" placeholder="Berikan catatan untuk santri...">{{ $hafalan->catatan_teks }}</textarea>
                            @endif
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.pages.detail-hafalan', $hafalan->id) }}" class="btn btn-dark">Kembali</a>
                        @endif
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </form>
@endsection
@push('script')
<script>
    $('#surat_1, #surat_2, #nama_ustad').select2();
</script>
@endpush