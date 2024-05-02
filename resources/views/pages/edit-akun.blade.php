@extends('template.page')
@section('content')
<div class="card-header mb-2">
  <div class="d-flex align-items-center">
    <h4 class="">Edit Akun <b>{{ $users->name }}</b></h4>
  </div>
</div>
<hr class="horizontal dark">
<form action="{{ auth()->user()->role === 'admin' ? route('admin.edit.akun', $users->id) : '' }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PATCH')
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama</label>
    <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $users->name }}">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $users->email }}">
  </div>
  <div class="mb-3">
    <label for="Role" class="form-label">Role</label>
    <select name="role" id="role" class="form-control" required>
      <option value="{{ $users->role }}">{{ $users->role }}</option>
      <option value="admin">Admin</option>
      <option value="ustad">Ustad</option>
      <option value="santri">Santri</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection