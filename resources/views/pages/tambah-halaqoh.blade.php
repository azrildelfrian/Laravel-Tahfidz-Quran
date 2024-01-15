@extends('template.page')

@section('content')
  <form method="POST" action="{{ route('admin.halaqoh.store') }}">
    @csrf

    <div class="mb-3">
      <label for="exampleInputName" class="form-label">Nama</label>
      <input type="text" name="nama_halaqoh" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Masukkan nama halaqoh" required>
    </div>

    <div class="mb-3">
        <label for="Pengampu" class="form-label">Ustad Pengampu</label>
        <select name="ustad_pengampu" id="nama_ustad" class="form-control" required>
            <option value="">=== Silahkan Pilih Ustad Pengampu ===</option>
            @foreach ($ustads as $item)
                @if ($item->role === 'ustad')
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <a href="{{ url('/admin/daftar-halaqoh/') }}" class="btn btn-dark">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
@endsection