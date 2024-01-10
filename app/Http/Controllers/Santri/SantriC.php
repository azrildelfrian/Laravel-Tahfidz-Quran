<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Hafalan;
use App\Models\Surat;
use App\Models\User;

class SantriC extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->role === 'admin'){
            return redirect()->route('admin.dashboard');
        } elseif(Auth::user()->role === 'ustad'){
            return redirect()->route('ustad.dashboard-ustad');
        }   
        return view('dashboard');
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
    
        // Check if the status is not 'sudah diperiksa'
        if ($hafalan->ulang === 'tidak') {
            abort(404, 'Not Found');
        }

        $surat = Surat::all();
        $users = User::all();
        
        return view('pages.edit-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function daftarHafalan(Request $request)
    {
        $isAdmin = Auth::user()->role === 'admin';

        if ($isAdmin) {
            // If admin, fetch all hafalan data
            $hafalanQuery = Hafalan::with(['surat_1', 'surat_2']);
        } else {
            // If not admin, fetch hafalan data related to the current user who is revising
            $userId = Auth::id();
            $hafalanQuery = Hafalan::with(['surat_1', 'surat_2'])
                ->where('user_id', $userId)
                ->where('ulang', 'mengulang'); // Add this condition to filter by 'mengulang'

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
        }

        $hafalan = $hafalanQuery->paginate($request->input('per_page', 10));
        $surat = Surat::all();

        return view('pages.daftar-hafalan', compact('hafalan', 'surat'));
    }

    public function tambahHafalan()
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        $surat = Surat::all();
        $users = User::all();

        return view('pages.tambah-hafalan',compact('users','hafalan','surat'));
    }

    public function riwayatHafalan(Request $request)
    {
        $isAdmin = Auth::user()->role === 'admin';

        $hafalanQuery = Hafalan::with(['user', 'surat_1', 'surat_2']);

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

        if ($isAdmin) {
            // Jika admin, ambil semua data hafalan
            $hafalan = $hafalanQuery->paginate($request->input('per_page', 10));
        } else {
            // Jika bukan admin, ambil data hafalan yang terkait dengan pengguna saat ini
            $userId = Auth::id();
            $hafalan = $hafalanQuery->where('user_id', $userId)->paginate($request->input('per_page', 10));
        }

        $surat = Surat::all();
        $users = User::all();

        return view('pages.riwayat-hafalan', compact('users', 'hafalan', 'surat'));
    }


    public function store(Request $request)
    {
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
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);

        // Hapus file hafalan lama jika ada
        if ($hafalan->file_hafalan) {
            Storage::delete('file/hafalan/' . $hafalan->file_hafalan);
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

        return redirect('/detail-hafalan/'.$id)->with('success', 'Data hafalan berhasil diperbarui.');
    }

}
