@extends('template.page')
@section('content')
<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form class="mr-2 flex-grow-1" action="{{ url()->current() }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari..." name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
        <div class="d-flex flex-grow-1 justify-content-end align-items-center">
            @if(auth()->user()->role === 'admin')
            <a href="{{ url('/admin/riwayat-hafalan/export') }}" class="btn btn-outline-success mx-2"><i class="ti ti-download fs-6"></i> Download Excel</a>
            @elseif(auth()->user()->role === 'ustad')
            <a href="{{ url('/ustad/riwayat-hafalan/export') }}" class="btn btn-outline-success mx-2"><i class="ti ti-download fs-6"></i> Download Excel</a>
            @elseif(auth()->user()->role === 'santri')
            <a href="{{ url('/riwayat-hafalan/export') }}" class="btn btn-outline-success mx-2"><i class="ti ti-download fs-6"></i> Download Excel</a>
            @endif
            <form action="{{ url()->current() }}" method="GET" class="form-inline">
                <label for="per_page" class="mr-2">Tampilkan:</label>
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
</div>
<table class="table">
    <thead>
        <tr>
            <th>Aksi</th>
            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
            <th>Nama</th>
            @endif
            <th>Dari</th>
            <th>Sampai</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Mengulang</th>
            <th>Kelancaran</th>
            <th>Diupdate</th>
            <th>Pemeriksa</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($hafalan as $item)
        <tr>
            <td>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
                @elseif(auth()->user()->role === 'ustad')
                <a href="{{ route('ustad.pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
                @elseif(auth()->user()->role === 'santri')
                <a href="{{ route('pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
                @endif
            </td>
            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
            <td>
                @if($item->user->trashed())
                <strong>{{ $item->user->name }}</strong> <i>(Akun telah dihapus)</i>
                @else
                <strong>{{ $item->user->name }}</strong>
                @endif
            </td>
            @endif
            <td>{{ $item->surat_1->nama_surat }} Ayat {{ $item->ayat_setoran_1 }}</td>
            <td> {{ $item->surat_2->nama_surat }} Ayat {{ $item->ayat_setoran_2 }}</td>
            <td>{{ $item->tanggal_hafalan }}</td>
            <td><span class="badge 
                        {{ $item->status === 'belum diperiksa' ? 'bg-warning' : 
                          ($item->status === 'sedang diperiksa' ? 'bg-primary' : 'bg-success') 
                        }}">{{ $item->status }}</td>
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
                @if ($item->kelancaran)
                {{ $item->kelancaran }}
                @else
                -
                @endif
            </td>
            <td>{{ $item->updated_at }}</td>
            <td>
                @if ($item->ustad)
                {{ $item->ustad->name }}
                @else
                -
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
        {{ $hafalan->links() }}
    </div>
</div>

@endsection