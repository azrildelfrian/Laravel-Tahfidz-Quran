@extends('template.page')
@section('content')
    <div class="card-header mb-2">
        <div class="d-flex align-items-center">
            <h4 class="">Edit santri <b>{{ $santri->user->name }}</b></h4>
        </div>
    </div>
    <hr class="horizontal dark">
    <form action="{{ auth()->user()->role === 'admin' ? route('admin.edit.santri', $santri->id) : '' }}" 
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nama</label>
            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $santri->user->name }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $santri->user->email }}">
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
