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
  <form method="POST" action="{{ route('admin.auth.store') }}">
    @csrf

    <div class="mb-3">
      <label for="Role" class="form-label">Role</label>
      <select name="role" id="role" class="form-control" required>
        <option value="">=== Silahkan Pilih Role ===</option>
        <option value="admin">Admin</option>
        <option value="ustad">Ustad</option>
      </select>
      <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

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

    <a href="{{ url('/admin/daftar-akun/') }}" class="btn btn-dark">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
@endsection
