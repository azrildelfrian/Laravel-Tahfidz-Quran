@extends('template.page')

@section('content')
    <div class="card-header mb-2">
        <div class="d-flex align-items-center">
            <h4 class="">Edit Halaqoh <b>{{ $halaqoh->nama_halaqoh }}</b></h4>
        </div>
    </div>
    <hr class="horizontal dark">
    <form action="{{ route('admin.edit.halaqoh', $halaqoh->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nama</label>
            <input name="nama_halaqoh" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $halaqoh->nama_halaqoh }}">
        </div>
        <div class="mb-3">
            <label for="Role" class="form-label">Ustad Pengampu</label>
            <select name="ustad_pengampu" id="role" class="form-control" required>
                @foreach ($ustads as $item)
                    <option value="{{ $item->id }}" {{ $halaqoh->ustad_pengampu == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
