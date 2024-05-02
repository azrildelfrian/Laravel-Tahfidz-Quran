@extends('template.page')
@section('content')
<div class="card-header mb-2">
    <div class="d-flex align-items-center">
        <h4 class="">Edit santri <b>{{ $santri->user->name }}</b></h4>
    </div>
</div>
<hr class="horizontal dark">
<form action="{{ auth()->user()->role === 'admin' ? route('admin.edit.santri', $santri->id) : '' }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="{{ $santri->user->name }}">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ $santri->user->email }}">
    </div>
    <div class="mb-3">
        <label for="Role" class="form-label">Halaqoh</label>
        <select name="halaqoh_id" id="halaqoh_id" class="form-control" required>
            <option value="">=== Silahkan Pilih Halaqoh ===</option>
            @foreach ($halaqoh as $item)
            <option value="{{ $item->id }}" {{ $item->id == $santri->halaqoh_id ? 'selected' : '' }}>
                {{ $item->nama_halaqoh }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('halaqoh_id')" class="mt-2" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <div class="input-group">
            <input name="password" type="password" class="form-control" id="password" required>
            <span class="input-group-text password-toggle-icon"><i class="ti ti-eye"></i></span>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" required>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
    <button class="btn btn-outline-dark m-1" onclick="goBack()">Kembali</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.password-toggle-icon');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });

    function goBack() {
        window.history.back();
    }
</script>

@endsection