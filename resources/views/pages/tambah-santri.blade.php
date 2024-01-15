@extends('template.page')

@section('content')
@if ($errors->any())
                  <div class="alert alert-danger" role="alert">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
  <form method="POST" action="{{ route('admin.santri.store') }}">
    @csrf

    <input type="hidden" name="role" value="santri">

    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan email aktif" required>
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mb-3">
      <label for="exampleInputName" class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Masukkan nama" required>
      <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan password" required>
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

      <div class="mb-3">
        <label for="Role" class="form-label">Halaqoh</label>
        <select name="halaqoh_id" id="halaqoh" class="form-control">
          <option value="">=== Silahkan Pilih Halaqoh ===</option>
          @foreach ($halaqoh as $item)
            <option value="{{ $item->id }}">{{ $item->nama_halaqoh }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="Role" class="form-label">Kelas</label>
        <select name="kelas_id" id="kelas" class="form-control">
          <option value="">=== Silahkan Pilih Kelas ===</option>
          @foreach ($kelas as $item)
            <option value="{{ $item->id }}">{{ $item->kelas }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="nomor_induk" class="form-label">Nomor Induk</label>
        <input type="text" name="nomor_id" class="form-control" id="ni" aria-describedby="nameHelp" placeholder="Masukkan Nomor Induk">
      </div>

    <a href="{{ url('/admin/daftar-akun/') }}" class="btn btn-dark">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>

@endsection
