@extends('template.page')
@section('content')
<div class="table-responsive text-nowrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex">
            <form class="mr-2" action="{{ url()->current() }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
            <a href="{{ route('pages.tambah-santri') }}" class="btn btn-primary mx-2">Tambah santri</a>
        </div>
        <div class="text-right">
            <form action="{{ url()->current() }}" method="GET" class="form-inline">
                <label for="per_page" class="mr-2">Show:</label>
                <select name="per_page" id="per_page" class="form-select mr-2" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $perPage)
                    <option value="{{ $perPage }}" {{ $perPage == $santri->perPage() ? 'selected' : '' }}>
                        {{ $perPage }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <table class="table" border="1">
        <thead>
            <tr>
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                <th>Nama</th>
                @endif
                <th>Email</th>
                <th>Halaqoh</th>
                <th>Nomor Induk</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($santri as $item)
            <tr>
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->user->name }}</strong></td>
                @endif
                <td>{{ $item->user->email }}</td>
                <td>{{ $item->halaqoh->nama_halaqoh }}</td>
                <td>{{ $item->nomor_id }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin.edit-santri', $item->id) }}" class="dropdown-item bg-dark text-white">
                                <i class="ti ti-eye me-1"></i> Detail</a>
                            @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.edit-santri', $item->id) }}" class="dropdown-item bg-warning text-white">
                                <i class="ti ti-edit me-1"></i> Edit</a>
                            <form action="{{ route('admin.delete.santri', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="delete_confirm" data-confirm-delete="true" class="dropdown-item bg-danger text-white"><i class="ti ti-trash me-1"></i> Delete</button>
                            </form>
                            @endif
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
            <span class="font-medium">{{ $santri->firstItem() }}</span>
            to
            <span class="font-medium">{{ $santri->lastItem() }}</span>
            of
            <span class="font-medium">{{ $santri->total() }}</span>
            results
        </p>
    </div>
    <div class="text-right">
        {{ $santri->appends(request()->input())->links() }}
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection