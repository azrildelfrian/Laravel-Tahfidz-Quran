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
            <a href="{{ route('auth.register') }}" class="btn btn-primary mx-2">Tambah Akun</a>
        </div>
        <div class="text-right">
            <form action="{{ url()->current() }}" method="GET" class="form-inline">
                <label for="per_page" class="mr-2">Show:</label>
                <select name="per_page" id="per_page" class="form-select mr-2" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $perPage)
                    <option value="{{ $perPage }}" {{ $perPage == $akun->perPage() ? 'selected' : '' }}>
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
                <th>Role</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($akun as $item)
            <tr>
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->name }}</strong></td>
                @endif
                <td>{{ $item->email }}</td>
                <td><span class="badge 
                    {{ $item->role === 'admin' ? 'bg-warning' : 
                        ($item->role === 'ustad' ? 'bg-primary' : 'bg-success') 
                    }}">{{ $item->role }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin.edit-akun', $item->id) }}" class="dropdown-item bg-warning text-white">
                                <i class="ti ti-edit me-1"></i> Edit</a>
                            <form action="{{ route('admin.akun.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="delete_confirm" data-confirm-delete="true" class="dropdown-item bg-danger text-white"><i class="ti ti-trash me-1"></i> Delete</button>
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
            <span class="font-medium">{{ $akun->firstItem() }}</span>
            to
            <span class="font-medium">{{ $akun->lastItem() }}</span>
            of
            <span class="font-medium">{{ $akun->total() }}</span>
            results
        </p>
    </div>
    <div class="text-right">
        {{ $akun->appends(request()->input())->links() }}
    </div>
</div>
@endsection