@extends('template.page')
@section('content')
<div class="card-header mb-2">
    <div class="d-flex align-items-center">
        <h4 class="">Revisi Hafalan</h4>
    </div>
</div>
<hr class="horizontal dark">
<form action="{{ auth()->user()->role === 'santri' ? route('santri.hafalan.edit', $hafalan->id) : '' }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')
                        <div class="row">
                            @if (Auth::user()->role === 'santri')
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
                                            <option value="{{ $item->id }}" @if ($item->id == $hafalan->surat_id) selected @endif>{{ $item->nama_surat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ayat</label>
                                    <input name="ayat_setoran_1" class="form-control" type="number" value="{{ $hafalan->ayat_setoran_1 }}" placeholder="Masukkan ayat" required>
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
                                            <option value="{{ $item->id }}" @if ($item->id == $hafalan->surat_id_2) selected @endif>{{ $item->nama_surat }}</option>
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
                            <div class="col-md-12 mt-3">
                            <label for="filehafalan" class="form-label">File Hafalan Sebelumnya</label>
                             </div>
                            <div class="col-md-12 mt-3">
                            @if($hafalan->file_hafalan)
                            <audio controls>
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
                        </div>
                        <hr class="horizontal dark">
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </form>
@endsection
@push('script')
<script>
    $('#surat_1, #surat_2, #nama_santri').select2();
</script>
@endpush