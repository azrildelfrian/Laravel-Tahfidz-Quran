<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\Surat;
use App\Models\User;

class AdminC extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    
    public function userTrashed()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function daftarHafalan(Request $request)
    {
        $hafalanQuery = Hafalan::with(['user' => function ($query) {
            $query->withTrashed(); // Include soft-deleted users
        }, 'surat_1', 'surat_2'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $hafalanQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($subquery) use ($search) {
                    $subquery->withTrashed()->where('name', 'LIKE', '%' . $search . '%');
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
        $users = User::all(); // Consider using withTrashed here if needed

        return view('pages.daftar-hafalan', compact('users', 'hafalan', 'surat'));
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

    public function tambahHafalan()
    {
        $hafalan = Hafalan::with(['surat_1', 'surat_2'])->get();
        $surat = Surat::all();
        $users = User::all();

        return view('pages.tambah-hafalan',compact('users','hafalan','surat'));
    }
    
    public function detail($id)
    {
        $hafalan = Hafalan::with(['user' => function ($query) {
            $query->withTrashed(); // Include soft-deleted users
        }, 'surat_1', 'surat_2'])->findOrFail($id);

        $surat = Surat::all();
        $users = User::all(); // Consider using withTrashed here if needed

        return view('pages.detail-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function ubah($id)
    {
        $hafalan = Hafalan::with(['user', 'surat_1', 'surat_2'])->findOrFail($id);
        $surat = Surat::all();
        $users = User::all();
        
        return view('pages.edit-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function periksa($id)
    {
        $hafalan = Hafalan::with(['user', 'surat_1', 'surat_2'])->findOrFail($id);
        $surat = Surat::all();
        $users = User::all();

        return view('pages.periksa-hafalan', compact('id', 'users', 'hafalan', 'surat'));
    }

    public function riwayatHafalan(Request $request)
    {
        $hafalanQuery = Hafalan::with(['user' => function ($query) {
            $query->withTrashed(); // Include soft-deleted users
        }, 'surat_1', 'surat_2'])
            ->orderBy('created_at', 'desc'); // Order by created_at in descending order

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $hafalanQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($subquery) use ($search) {
                    $subquery->withTrashed()->where('name', 'LIKE', '%' . $search . '%');
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
        $users = User::all(); // You might want to consider using withTrashed here as well if needed

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
        return redirect('admin/daftar-hafalan')->with('success', 'Data hafalan berhasil disimpan.');
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
            'status' => $request->input('status'),
            'kelancaran' => $request->input('kelancaran'),
            'ulang' => $request->input('ulang'),
            'diperiksa_oleh' => $request->input('diperiksa_oleh'),
            'catatan_teks' => $request->input('catatan_teks'),
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

        return redirect('admin/detail-hafalan/'.$id)->with('success', 'Data hafalan berhasil diperbarui.');
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
            // Upload file baru
            $catatan_suara = $request->file('catatan_suara');
            $suara_name = date('ymdhis') . ".mp3"; // Ekstensi MP3
            $catatan_suara->move(public_path('file/catatan_suara/'), $suara_name);

            // Simpan nama file ke database
            $hafalan->update(['catatan_suara' => $suara_name]);
        }

        return redirect('admin/daftar-hafalan')->with('success', 'Data hafalan berhasil diperbarui.');
    }

    public function daftarAkun(Request $request)
    {
        $akunQuery = User::query();

        // Tambahkan kondisi pencarian jika parameter 'search' ada di URL
        if ($request->has('search')) {
            $search = $request->input('search');
            $akunQuery->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('role', 'LIKE', '%' . $search . '%');
            });
        }

        $akun = $akunQuery->paginate($request->input('per_page', 10));

        return view('pages.daftar-akun', compact('akun'));
    }
    
    public function updateAkun($id) {
        $users = User::findOrFail($id);
        
        return view('pages.edit-akun', compact('users'));
    }

    public function editAkun(Request $request, $id) {
        $users = User::findOrFail($id);

        $users->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);
        
        return redirect('admin/daftar-akun')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroyAkun($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('admin/daftar-akun')->with('success', 'Data akun berhasil dihapus.');
    }


    public function destroy($id)
    {
        // Temukan data hafalan berdasarkan ID
        $hafalan = Hafalan::find($id);

        // Hapus file_hafalan dari penyimpanan jika ada
        if (!empty($hafalan->file_hafalan)) {
            $file_path = public_path('file/hafalan/') . $hafalan->file_hafalan;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus data hafalan dari database
        $hafalan->delete();

        // Redirect atau tampilkan pesan sukses jika perlu
        return redirect('admin/daftar-hafalan')->with('success', 'Data hafalan berhasil dihapus.');
    }

}
