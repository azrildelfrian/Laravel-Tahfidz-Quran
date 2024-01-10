@extends('template.page')
@section('content')
<div class="card-header mb-2">
    <div class="d-flex align-items-center">
        <h4 class="">Tambah Hafalan</h4>
    </div>
</div>
<hr class="horizontal dark">
                        <form action="{{ 
                            auth()->user()->role === 'admin' ? 
                                route('admin.hafalan.store') : 
                                (auth()->user()->role === 'ustad' ? 
                                    route('ustad.hafalan.store') : 
                                    route('santri.hafalan.store')
                                )
                        }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                            <div class="col-md-12 mb-3">
                            <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nama Santri</label>
                            <select name="user_id" id="nama_santri" class="form-control" required>
                                <option value="">=== Pilih Santri ===</option>
                                @foreach ($users as $item)
                                    @if ($item->role === 'santri')
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!--<input name="user_id" class="form-control" type="hidden" value="{{ Auth::user()->id }}" required>-->
                            </div>
                            @elseif (Auth::user()->role === 'santri')
                            <div class="form-group">
                                <input name="user_id" type="hidden" class="form-control" value="{{ Auth::user()->id }}">
                            </div>
                            @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Surat</label>
                                    <select name="surat_id" id="surat_1" class="form-control" required>
                                        <option value="">=== Silahkan Pilih Surat ===</option>
                                        @foreach ($surat as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_surat }} - {{ $item->ayat }} ayat</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ayat</label>
                                    <input name="ayat_setoran_1" class="form-control" type="number" value="" placeholder="Masukkan ayat" min="1" required>
                                </div>
                            </div>
                        </div>
                            <hr class="horizontal dark mt-3">
                            <p class="text-uppercase m-2">Sampai</p>
                            <hr class="horizontal dark mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Surat</label>
                                    <select name="surat_id_2" id="surat_2" class="form-control" required>
                                        <option value="">=== Silahkan Pilih Surat ===</option>
                                        @foreach ($surat as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_surat }} - {{ $item->ayat }} ayat</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ayat</label>
                                    <input name="ayat_setoran_2" class="form-control" type="number" value=""
                                        placeholder="Masukkan ayat" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="tanggal_hafalan" class="form-control" type="hidden" value="{{ now()->toDateString() }}">
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">File Hafalan</label>
                                    <input type="file" name="file_hafalan" id="file" accept="audio/mp3" class="input100 form-control form-control-lg" required>
                                    <div id="emailHelp" class="form-text">Silahkan upload file hafalan berupa file audio</div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </form>
@endsection
@push('script')
<script>
    $('#surat_1, #surat_2, #nama_santri').select2();
    document.getElementById('surat_2').addEventListener('change', function() {
        var selectedSurat = this.options[this.selectedIndex];
        var jumlahAyat = selectedSurat.getAttribute('jumlah_ayat');
        document.getElementById('ayat_setoran_2').setAttribute('max', jumlahAyat);
    });
</script>
@endpush