@extends('template.page')
@section('content')
<div class="table-responsive text-nowrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex px-2">
            <form class="mr-2" action="{{ url()->current() }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="text-right">
            <form action="{{ url()->current() }}" method="GET" class="form-inline">
                <label for="per_page" class="mr-2">Show:</label>
                <select name="per_page" id="per_page" class="form-select mr-2" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $perPage)
                        <option value="{{ $perPage }}" {{ $perPage == $hafalan->perPage() ? 'selected' : '' }}>
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
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                <th>Nama</th>
                @endif
                <th>Dari</th>
                <th>Sampai</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Mengulang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($hafalan as $item)
            <tr>
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                <td>
                @if($item->user->trashed())
                    <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                    <strong>{{ $item->user->name }}</strong> <i>(Akun telah dihapus)</i>
                @else
                    <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                    <strong>{{ $item->user->name }}</strong>
                @endif
                </td>
                @endif
                <td>{{ $item->surat_1->nama_surat }} Ayat {{ $item->ayat_setoran_1 }}</td>
                <td> {{ $item->surat_2->nama_surat }} Ayat {{ $item->ayat_setoran_2 }}</td>
                <td>{{ $item->tanggal_hafalan }}</td>
                <td>
                    <span class="badge 
                    {{ $item->status === 'belum diperiksa' ? 'bg-warning' : 
                        ($item->status === 'sedang diperiksa' ? 'bg-primary' : 'bg-success') 
                    }}">{{ $item->status }}
                    </span>
                </td>
                <td>
                @if($item->ulang === 'mengulang' || $item->ulang === 'tidak')
                <span class="badge 
                    {{ $item->ulang === 'mengulang' ? 'bg-danger' : 
                        ($item->ulang === 'tidak' ? 'bg-primary' : 'bg-warning') 
                    }}">{{ $item->ulang }}
                </span>
                @else
                -
                @endif
                </td>
                <td>
                    @if(auth()->user()->role === 'admin')
                    <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{ route('admin.pages.detail-hafalan', $item->id) }}" class="dropdown-item bg-dark text-white">
                                    <i class="ti ti-eye me-1"></i> Detail</a>
                                <a href="{{ route('admin.edit-hafalan', $item->id) }}" class="dropdown-item bg-warning text-white">
                                    <i class="ti ti-edit me-1"></i> Edit</a>
                                <form action="{{ route('admin.daftar-hafalan.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="delete_confirm" data-confirm-delete="true" class="dropdown-item bg-danger text-white show_confirm"><i class="ti ti-trash me-1"></i> Delete</button>
                                </form>
                            </div>
                          </div>
                    @elseif(auth()->user()->role === 'ustad')
                    <a href="{{ route('ustad.pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
                    @elseif(auth()->user()->role === 'santri')
                    <a href="{{ route('pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
                    @endif
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
            <span class="font-medium">{{ $hafalan->firstItem() }}</span>
            to
            <span class="font-medium">{{ $hafalan->lastItem() }}</span>
            of
            <span class="font-medium">{{ $hafalan->total() }}</span>
            results
        </p>
    </div>
    <div class="text-right">
        {{ $hafalan->appends(request()->input())->links() }}
    </div>
</div>

@endsection
@push('script')
@endpush