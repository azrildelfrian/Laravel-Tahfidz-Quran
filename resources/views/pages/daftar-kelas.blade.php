@extends('template.page')
@section('content')
<div class="table-responsive text-nowrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex">
            <form class="mr-2" action="{{ url()->current() }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
            <a href="{{ route('pages.tambah-kelas') }}" class="btn btn-primary mx-2">Tambah kelas</a>
        </div>
        <div class="text-right">
            <form action="{{ url()->current() }}" method="GET" class="form-inline">
                <label for="per_page" class="mr-2">Show:</label>
                <select name="per_page" id="per_page" class="form-select mr-2" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $perPage)
                        <option value="{{ $perPage }}" {{ $perPage == $kelas->perPage() ? 'selected' : '' }}>
                            {{ $perPage }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($kelas as $item)
            <tr>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->kelas }}</strong></td>
                <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.edit.kelas', $item->id) }}" class="dropdown-item bg-warning text-white">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <form action="" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item bg-danger text-white">
                                <i class="ti ti-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between">
    <div class="text-left">
        <p class="text-sm text-gray-700 leading-5">
            Showing
            <span class="font-medium">{{ $kelas->firstItem() }}</span>
            to
            <span class="font-medium">{{ $kelas->lastItem() }}</span>
            of
            <span class="font-medium">{{ $kelas->total() }}</span>
            results
        </p>
    </div>
    <div class="text-right">
        {{ $kelas->appends(request()->input())->links() }}
    </div>
</div>
@endsection