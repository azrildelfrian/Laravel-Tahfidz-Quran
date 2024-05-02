<?php

namespace App\Exports;

use App\Models\Hafalan;
use App\Models\Halaqoh;
use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class HafalanExport implements FromCollection, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        if ($userRole === 'admin') {
            return Hafalan::all();
        } elseif ($userRole === 'ustad') {
            $halaqohId = Halaqoh::where('ustad_pengampu', $userId)->value('id');
            $santriIds = Santri::where('halaqoh_id', $halaqohId)->pluck('id');
            $hafalan = Hafalan::whereIn('user_id', $santriIds)->get();
            return $hafalan;
        } elseif ($userRole === 'santri') {
            return Hafalan::where('user_id', $userId)->get();
        }

        // Default, kembalikan koleksi kosong
        return collect();
    }

    public function headings(): array
    {
        return [
            'Nama Santri',
            'Dari',
            'Sampai',
            'Tanggal Hafalan',
            'Diperiksa Oleh',
            'Kelancaran',
            'Mengulang',
        ];
    }

    public function map($hafalan): array
    {
        return [
            $hafalan->user->name,
            $hafalan->surat_1->nama_surat . ' Ayat ' . $hafalan->ayat_setoran_1,
            $hafalan->surat_2->nama_surat . ' Ayat ' . $hafalan->ayat_setoran_2,
            $hafalan->tanggal_hafalan,
            $hafalan->ustad->name ?? '',
            $hafalan->kelancaran,
            $hafalan->ulang,
        ];
    }
}
