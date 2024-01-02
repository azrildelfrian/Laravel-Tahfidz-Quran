<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $surat = Surat::all();
        $users = User::all();
        
        return view('pages.detail-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function revisi($id)
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->findOrFail($id);
        $surat = Surat::all();
        $users = User::all();
        
        return view('pages.edit-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function daftarHafalan()
    {
        $isAdmin = Auth::user()->role === 'admin';
        
        if ($isAdmin) {
            // Jika admin, ambil semua data hafalan
            $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        } else {
            // Jika bukan admin, ambil data hafalan yang terkait dengan pengguna saat ini
            $userId = Auth::id();
            $hafalan = Hafalan::with(['surat_1', 'surat_2'])
                ->where('user_id', $userId)
                ->get();
        }

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

    public function riwayatHafalan()
    {
        $isAdmin = Auth::user()->role === 'admin';
        
        if ($isAdmin) {
            // Jika admin, ambil semua data hafalan
            $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        } else {
            // Jika bukan admin, ambil data hafalan yang terkait dengan pengguna saat ini
            $userId = Auth::id();
            $hafalan = Hafalan::with(['surat_1', 'surat_2'])
                ->where('user_id', $userId)
                ->get();
        }

        $surat = Surat::all();

        return view('pages.riwayat-hafalan', compact('hafalan', 'surat'));
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

        // Perbarui kolom-kolom yang diperbolehkan
        $hafalan->update([
            'surat_id' => $request->input('surat_id'),
            'surat_id_2' => $request->input('surat_id_2'),
            'ayat_setoran_1' => $request->input('ayat_setoran_1'),
            'ayat_setoran_2' => $request->input('ayat_setoran_2'),
            'status' => 'sedang diperiksa',
            'ulang' => 'belum diperiksa',            
            'updated_at' => now(),
        ]);

        if ($request->hasFile('file_hafalan') && $request->file('file_hafalan')->isValid()) {

            // Upload gambar baru
            $file_hafalan = $request->file('file_hafalan');
            $file_name = date('ymdhis') . ".mp3"; // Ekstensi MP3
            $file_hafalan->move(public_path('file/hafalan/'), $file_name);
            $hafalan->file_hafalan = $file_name;
        }
        // Simpan data hafalan ke database
        return redirect('/detail-hafalan/'.$id)->with('success', 'Data hafalan berhasil diperbarui.');
    }

}
