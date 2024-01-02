@extends('template.page')
@section('content')
<div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                      @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                        <th>Nama</th>
                      @endif
                        <th>Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($hafalan as $item)
                      <tr>
                      @if (Auth::user()->role === 'admin' || Auth::user()->role === 'ustad')
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->user->name }}</strong></td>
                      @endif
                        <td>{{ $item->surat_1->nama_surat }} Ayat {{ $item->ayat_setoran_1 }} <br>Sampai<br> {{ $item->surat_2->nama_surat }} Ayat {{ $item->ayat_setoran_2 }}</td>
                        <td>{{ $item->tanggal_hafalan }}</td>
                        <td><span class="badge 
                        {{ $item->status === 'belum diperiksa' ? 'bg-warning' : 
                          ($item->status === 'sedang diperiksa' ? 'bg-primary' : 'bg-success') 
                        }}">{{ $item->status }}</td>
                        <td>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.pages.detail-hafalan', $item->id) }}" class="btn btn-dark">Detail</a>
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
@endsection