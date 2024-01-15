@extends('template.page')

@section('content')
  <form method="POST" action="{{ route('admin.kelas.store') }}">
    @csrf

    <div class="mb-3">
      <label for="exampleInputName" class="form-label">Nama</label>
      <input type="text" name="kelas" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Masukkan nama kelas" required>
    </div>

    <a href="{{ url('/admin/daftar-kelas/') }}" class="btn btn-dark">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
@endsection