@extends('template.page')

@section('content')
    <div class="card-header mb-2">
        <div class="d-flex align-items-center">
            <h4 class="">Edit Kelas <b>{{ $kelas->kelas }}</b></h4>
        </div>
    </div>
    <hr class="horizontal dark">
    <form action="{{ route('admin.edit.kelas', $kelas->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nama</label>
            <input name="kelas" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $kelas->kelas }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
