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
                        <th>Mengulang</th>
                        <th>Kelancaran</th>
                        <th>Diupdate</th>
                        <th>Ustad</th>
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
                        }}">{{ $item->status }}</td></td>
                        <td>{{ $item->ulang }}</td>
                        <td>{{ $item->kelancaran }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                        @if ($item->ustad)
                            {{ $item->ustad->name }}
                        @else
                            Belum diperiksa
                        @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
@endsection