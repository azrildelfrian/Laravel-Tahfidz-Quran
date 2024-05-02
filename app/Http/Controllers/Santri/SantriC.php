<?php

namespace App\Http\Controllers\Santri;

use App\Exports\HafalanExport;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\Santri;
use App\Models\Surat;
use App\Models\User;

class SantriC extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $userlogin = Auth::id();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'ustad') {
            return redirect()->route('ustad.dashboard-ustad');
        }

        $santri = Santri::with('halaqoh')->where('id_santri', $userlogin)->first();
        $revisi = Hafalan::where('user_id', $userlogin)->where('ulang', 'mengulang')->count();

        $today = Carbon::today();
        $hafalanAddedToday = Hafalan::whereDate('created_at', $today)->where('user_id', $userlogin)->count();
        $hafalanDeletedToday = Hafalan::whereDate('deleted_at', $today)->where('user_id', $userlogin)->count();
        $hafalanCount = Hafalan::where('user_id', $userlogin)->count();

        return view('dashboard', compact('hafalanCount', 'hafalanAddedToday', 'hafalanDeletedToday', 'user', 'santri', 'revisi'));
    }

    public function export()
    {
        $fileName = 'data_hafalan.pdf';

        return Excel::download(new HafalanExport, $fileName, \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function detail($id)
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);

        // Pemeriksaan apakah pengguna memiliki hak akses untuk melihat data ini
        if ($hafalan->user_id !== auth()->user()->id) {
            abort(404, 'Not Found');
        }

        $surat = Surat::all();
        $users = User::all();

        return view('pages.detail-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function revisi($id)
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);

        if ($hafalan->user_id !== auth()->user()->id) {
            abort(404, 'Not Found');
        }

        if ($hafalan->ulang != 'mengulang') {
            abort(403, 'Unauthorized');
        }

        // Check if the status is not 'sudah diperiksa'
        if ($hafalan->ulang === 'tidak') {
            abort(403, 'Unauthorized');
        }

        $surat = Surat::all();
        $users = User::all();

        return view('pages.edit-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function daftarHafalan(Request $request)
    {

        $user = Auth::user();
        if ($user->role !== 'santri') {
            abort(404, 'Not Found');
        }

        $userId = Auth::id();
        $hafalanQuery = Hafalan::with(['surat_1', 'surat_2'])
            ->where('user_id', $userId)->orderBy('created_at', 'desc');
        // ->where('ulang', 'mengulang'); // Add this condition to filter by 'mengulang'

        if ($request->has('search')) {
            $search = $request->input('search');
            $hafalanQuery->where(function ($query) use ($search) {
                $query->orWhereHas('surat_1', function ($subquery) use ($search) {
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

        return view('pages.daftar-hafalan', compact('hafalan', 'surat'));
    }

    public function tambahHafalan()
    {
        $user = Auth::user();
        if ($user->role !== 'santri') {
            abort(404, 'Not Found');
        }
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        $surat = Surat::all();
        $users = User::all();

        return view('pages.tambah-hafalan', compact('users', 'hafalan', 'surat'));
    }

    public function riwayatHafalan(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'santri') {
            abort(404, 'Not Found');
        }
        $isAdmin = Auth::user()->role === 'admin';

        $hafalanQuery = Hafalan::with(['user', 'surat_1', 'surat_2'])->orderBy('created_at', 'desc');;

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

        $userId = Auth::id();
        $hafalan = $hafalanQuery->where('user_id', $userId)->paginate($request->input('per_page', 10));

        $surat = Surat::all();
        $users = User::all();

        return view('pages.riwayat-hafalan', compact('users', 'hafalan', 'surat'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'santri') {
            abort(404, 'Not Found');
        }
        $request->validate([
            'file' => 'max:0', // 0 berarti tanpa batasan
        ]);
        // Buat instansiasi model Hafalan
        $hafalan = new Hafalan();
        $hafalan->user_id = $request->input('user_id');
        //$hafalan->user_id = auth()->id(); // Menggunakan ID pengguna yang saat ini login
        $hafalan->surat_id = $request->input('surat_id');
        $hafalan->surat_id_2 = $request->input('surat_id_2');
        $hafalan->ayat_setoran_1 = $request->input('ayat_setoran_1');
        $hafalan->ayat_setoran_2 = $request->input('ayat_setoran_2');
        $hafalan->status = $request->input('status', 'belum diperiksa');
        $hafalan->kelancaran = $request->input('kelancaran', null);
        $hafalan->ulang = $request->input('ulang', 'belum diperiksa');
        $hafalan->tanggal_hafalan = now();
        //$hafalan->tanggal_hafalan = $request->input('tanggal_hafalan');

        // Cek apakah ada file hafalan yang diupload
        if ($request->hasFile('file_hafalan') && $request->file('file_hafalan')->isValid()) {

            // Upload gambar baru
            $file_hafalan = $request->file('file_hafalan');
            $file_name = date('ymdhis') . ".mp3"; // Ekstensi MP3
            $file_hafalan->move(public_path('file/hafalan/'), $file_name);
            $hafalan->file_hafalan = $file_name;
        }
        // Simpan data hafalan ke database
        $hafalan->save();

        // Redirect atau tampilkan pesan sukses jika perlu
        return redirect('/daftar-hafalan')->with('success', 'Data hafalan berhasil disimpan.');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'santri') {
            abort(404, 'Not Found');
        }
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);

        // Hapus file hafalan lama jika ada
        if ($hafalan->file_hafalan) {
            $file_path = public_path('file/hafalan/') . $hafalan->file_hafalan;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Perbarui kolom-kolom yang diperbolehkan
        $hafalan->update([
            'surat_id' => $request->input('surat_id'),
            'surat_id_2' => $request->input('surat_id_2'),
            'ayat_setoran_1' => $request->input('ayat_setoran_1'),
            'ayat_setoran_2' => $request->input('ayat_setoran_2'),
            'status' => 'belum diperiksa',
            'kelancaran' => 'belum diperiksa',
            'ulang' => 'belum diperiksa',
            'updated_at' => now(),
        ]);

        if ($request->hasFile('file_hafalan') && $request->file('file_hafalan')->isValid()) {
            // Upload file hafalan baru
            $file_hafalan = $request->file('file_hafalan');
            $file_name = date('ymdhis') . ".mp3"; // Ekstensi MP3
            $file_hafalan->move(public_path('file/hafalan/'), $file_name);
            $hafalan->file_hafalan = $file_name;
        }

        // Simpan data hafalan ke database
        $hafalan->save();

        return redirect('/detail-hafalan/' . $id)->with('success', 'Data hafalan berhasil diperbarui.');
    }
}
