<?php

namespace App\Http\Controllers\Ustad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\Halaqoh;
use App\Models\Santri;
use App\Models\Surat;
use App\Models\User;

class UstadC extends Controller
{
    public function index()
    {
        $ustadId = Auth::id();
        $halaqohId = Halaqoh::where('ustad_pengampu', $ustadId)->value('id');
        $santriUserIds = Santri::where('halaqoh_id', $halaqohId)->pluck('id_santri');
        $halaqoh = Halaqoh::where('ustad_pengampu', $ustadId)->first();

        $halaqohName = $halaqoh ? $halaqoh->nama_halaqoh : 'Belum ada Halaqoh';
        $santriCount = $santriUserIds->count();

        $today = Carbon::today();

        $hafalanAddedToday = Hafalan::whereDate('created_at', $today)
            ->whereIn('user_id', $santriUserIds)
            ->count();

        $hafalanDeletedToday = Hafalan::whereDate('deleted_at', $today)
            ->whereIn('user_id', $santriUserIds)
            ->count();

        $hafalanNeedChecked = Hafalan::whereIn('user_id', $santriUserIds)
            ->where('status', 'belum diperiksa') // Hanya hitung yang belum diperiksa
            ->count();

        $hafalanCount = Hafalan::whereIn('user_id', $santriUserIds)->count();

        return view('ustad.dashboard-ustad', compact('hafalanCount', 'hafalanAddedToday', 'hafalanDeletedToday', 'hafalanNeedChecked', 'halaqohName', 'santriCount'));
    }

    public function export()
    {
        return Excel::download(new HafalanExport, 'data_hafalan.xlsx');
    }

    // public function daftarHafalan()
    // {
    //     // Only fetch hafalan that has not been reviewed (status is not 'sudah diperiksa')
    //     $hafalan = Hafalan::with(['user', 'surat_1', 'surat_2'])
    //         ->where('status', '!=', 'sudah diperiksa')
    //         ->get();

    //     $surat = Surat::all();
    //     $users = User::all();

    //     return view('pages.daftar-hafalan', compact('users', 'hafalan', 'surat'));
    // }

    public function daftarHafalan(Request $request)
    {
        $ustadId = Auth::id();
        $halaqohId = Halaqoh::where('ustad_pengampu', $ustadId)->value('id');
        $santriUserId = Santri::where('halaqoh_id', $halaqohId)->pluck('id_santri');

        $hafalan = Hafalan::with(['user', 'surat_1', 'surat_2'])
            ->whereIn('user_id', $santriUserId)
            ->where('status', 'belum diperiksa')
            ->paginate($request->input('per_page', 10));

        $surat = Surat::all();
        $users = User::all();


        return view('pages.daftar-hafalan', compact('users', 'hafalan', 'surat'));
    }



    public function tambahHafalan()
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        $surat = Surat::all();
        $ustadId = Auth::id();
        $santriUserIds = Santri::whereIn('halaqoh_id', function ($query) use ($ustadId) {
            $query->select('id')->from('halaqoh')->where('ustad_pengampu', $ustadId);
        })->pluck('id_santri');

        $users = User::whereIn('id', $santriUserIds)
            ->where('role', 'santri')
            ->get();

        return view('pages.tambah-hafalan', compact('users', 'hafalan', 'surat'));
    }

    public function detail($id)
    {
        $hafalan = Hafalan::with(['user' => function ($query) {
            $query->withTrashed(); // Include soft-deleted users
        }, 'surat_1', 'surat_2'])->findOrFail($id);
        $surat = Surat::all();
        $users = User::all();

        return view('pages.detail-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function periksa($id)
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);
        if ($hafalan->ulang === 'tidak') {
            abort(404, 'Not Found');
        }
        $surat = Surat::all();
        $users = User::all();

        return view('pages.periksa-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function riwayatHafalan(Request $request)
    {
        $ustadId = Auth::id();
        $halaqohId = Halaqoh::where('ustad_pengampu', $ustadId)->value('id');
        $santriUserId = Santri::where('halaqoh_id', $halaqohId)->pluck('id_santri');

        $hafalanQuery = Hafalan::with(['user' => function ($query) {
            $query->withTrashed(); // Include soft-deleted users
        }, 'surat_1', 'surat_2'])
            ->whereIn('user_id', $santriUserId)
            ->orderBy('status', 'desc');

        // Tambahkan kondisi pencarian jika parameter 'search' ada di URL
        if ($request->has('search')) {
            $search = $request->input('search');
            $hafalanQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($subquery) use ($search) {
                    $subquery->where('name', 'LIKE', '%' . $search . '%');
                })
                    ->orWhereHas('surat_1', function ($subquery) use ($search) {
                        $subquery->where('nama_surat', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('surat_2', function ($subquery) use ($search) {
                        $subquery->where('nama_surat', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhere('tanggal_hafalan', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('ulang', 'LIKE', '%' . $search . '%');
            });
        }

        $hafalan = $hafalanQuery->paginate($request->input('per_page', 10));

        $surat = Surat::all();
        $users = User::all();

        return view('pages.riwayat-hafalan', compact('users', 'hafalan', 'surat'));
    }

    public function store(Request $request)
    {

        // Buat instansiasi model Hafalan
        $hafalan = new Hafalan();
        $hafalan->user_id = $request->input('user_id');
        //$hafalan->user_id = auth()->id(); // Menggunakan ID pengguna yang saat ini login
        $hafalan->surat_id = $request->input('surat_id');
        $hafalan->surat_id_2 = $request->input('surat_id_2');
        $hafalan->ayat_setoran_1 = $request->input('ayat_setoran_1');
        $hafalan->ayat_setoran_2 = $request->input('ayat_setoran_2');
        $hafalan->status = $request->input('status', 'belum diperiksa');
        $hafalan->tanggal_hafalan = now();
        //$hafalan->tanggal_hafalan = $request->input('tanggal_hafalan');

        // Cek apakah ada file hafalan yang diupload
        if ($request->hasFile('file_hafalan') && $request->file('file_hafalan')->isValid()) {

            // Upload gambar baru
            $file_hafalan = $request->file('file_hafalan');
            $file_ekstensi = $file_hafalan->extension();
            $file_name = date('ymdhis') . "." . $file_ekstensi;
            $file_hafalan->move(public_path('file/hafalan/'), $file_name);
            $hafalan->file_hafalan = $file_name;
        }
        // Simpan data hafalan ke database
        $hafalan->save();

        // Redirect atau tampilkan pesan sukses jika perlu
        return redirect('ustad/daftar-hafalan')->with('success', 'Data hafalan berhasil disimpan.');
    }

    public function reviewed(Request $request, $id)
    {
        $hafalan = Hafalan::findOrFail($id);

        // Perbarui kolom-kolom yang diperbolehkan
        $hafalan->update([
            'status' => 'sudah diperiksa',
            'kelancaran' => $request->input('kelancaran'),
            'ulang' => $request->input('ulang'),
            'catatan_teks' => $request->input('catatan_teks'),
            'diperiksa_oleh' => $request->input('diperiksa_oleh'),
        ]);

        // Cek apakah ada file catatan_suara yang diupload
        if ($request->hasFile('catatan_suara') && $request->file('catatan_suara')->isValid()) {
            // Hapus file catatan_suara yang lama
            if ($hafalan->catatan_suara) {
                $file_path = public_path('file/catatan_suara/') . $hafalan->catatan_suara;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            // Upload file baru
            $catatan_suara = $request->file('catatan_suara');
            $suara_name = date('ymdhis') . ".mp3"; // Ekstensi MP3
            $catatan_suara->move(public_path('file/catatan_suara/'), $suara_name);

            // Simpan nama file ke database
            $hafalan->update(['catatan_suara' => $suara_name]);
        }

        return redirect('ustad/daftar-hafalan')->with('success', 'Data hafalan berhasil diperbarui.');
    }
}
