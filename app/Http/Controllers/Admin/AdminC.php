<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HafalanExport;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\Halaqoh;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Ustad;
use App\Models\Surat;
use App\Models\User;

class AdminC extends Controller
{
    public function index()
    {
        $today = Carbon::today(); // Mengambil tanggal hari ini
        $userAddedToday = User::whereDate('created_at', $today)->count();
        $userDeletedToday = User::whereDate('deleted_at', $today)->count();
        $hafalanAddedToday = Hafalan::whereDate('created_at', $today)->count();
        $hafalanDeletedToday = Hafalan::whereDate('deleted_at', $today)->count();

        $userCount = User::whereIn('role', ['ustad', 'santri'])->count();
        $hafalanCount = Hafalan::count();
        $halaqohCount = Halaqoh::count();
        $kelasCount = Kelas::count();
        return view('admin.dashboard', compact('userCount', 'hafalanCount', 'halaqohCount', 'kelasCount', 'userAddedToday', 'userDeletedToday', 'hafalanAddedToday', 'hafalanDeletedToday'));
    }

    public function userTrashed()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function export()
    {
        return Excel::download(new HafalanExport, 'data_hafalan.xlsx');
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

        $title = 'Hapus Data Hafalan!';
        $text = "Apakah anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

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

        return view('pages.tambah-hafalan', compact('users', 'hafalan', 'surat'));
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
            'user_id' => 'required|exists:users,id',
            'surat_id' => 'required|exists:surat,id',
            'surat_id_2' => 'required|exists:surat,id',
            'ayat_setoran_1' => 'required|integer|min:1',
            'ayat_setoran_2' => 'required|integer|min:1',
            'status' => 'in:belum diperiksa,sedang diperiksa,sudah diperiksa',
            'kelancaran' => 'nullable',
            'ulang' => 'in:mengulang,tidak',
            'tanggal_hafalan' => 'required|date',
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
        $hafalan->tanggal_hafalan = $request->input('tanggal_hafalan');;
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

        $request->validate([
            'surat_id' => [
                'required',
                Rule::exists('surat', 'id')->where(function ($query) use ($hafalan) {
                    return $query->where('id', $hafalan->surat_id);
                }),
            ],
            'surat_id_2' => [
                'required',
                Rule::exists('surat', 'id')->where(function ($query) use ($hafalan) {
                    return $query->where('id', $hafalan->surat_id_2);
                }),
            ],
            'ayat_setoran_1' => 'required|integer|min:1',
            'ayat_setoran_2' => 'required|integer|min:1',
            'status' => 'in:belum diperiksa,sedang diperiksa,sudah diperiksa',
            'kelancaran' => 'nullable',
            'ulang' => 'in:mengulang,tidak',
            'diperiksa_oleh' => 'nullable|string|max:255',
            'catatan_teks' => 'nullable|string',
            'tanggal_hafalan' => 'required|date',
            'file_hafalan' => 'nullable|max:0',
        ]);

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
            'status' => $request->input('status'),
            'kelancaran' => $request->input('kelancaran'),
            'ulang' => $request->input('ulang'),
            'diperiksa_oleh' => $request->input('diperiksa_oleh'),
            'catatan_teks' => $request->input('catatan_teks'),
            'tanggal_hafalan' => $request->input('tanggal_hafalan'),
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

        return redirect('admin/detail-hafalan/' . $id)->with('success', 'Data hafalan berhasil diperbarui.');
    }

    public function reviewed(Request $request, $id)
    {
        $hafalan = Hafalan::findOrFail($id);

        $request->validate([
            'kelancaran' => 'required|',
            'ulang' => 'required|in:mengulang,tidak',
            'catatan_teks' => 'nullable|string',
            'diperiksa_oleh' => 'nullable|string|max:255',
            'catatan_suara' => 'nullable|max:0',
        ]);

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

    public function daftarAkun(Request $request)
    {
        $akunQuery = User::where('role', 'ustad');

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

        $title = 'Hapus Data Akun?';
        $text = "Apakah anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

        return view('pages.daftar-akun', compact('akun'));
    }

    public function updateAkun($id)
    {
        $users = User::findOrFail($id);

        return view('pages.edit-akun', compact('users'));
    }

    public function editAkun(Request $request, $id)
    {
        $users = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($users->id),
            ],
            'role' => 'required|in:admin,ustad,santri',
        ]);

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
        $role = $user->role;

        if ($role === 'santri') {
            // Pastikan mencari santri berdasarkan id_santri, bukan id
            $santri = Santri::where('id_santri', $user->id)->first();

            if ($santri) {
                $santri->delete();
            }
        }

        $user->delete();

        // Tambahkan pernyataan dd di sini untuk melihat hasilnya
        // dd('Data akun berhasil dihapus.', $user);

        // Redirect setelah melihat hasil jika perlu
        return redirect('admin/daftar-akun')->with('success', 'Data akun berhasil dihapus.');
    }

    public function daftarHalaqoh(Request $request)
    {
        // Use the query builder to get a paginated result
        $halaqoh = Halaqoh::paginate($request->input('per_page', 10));

        $title = 'Hapus Data Halaqoh?';
        $text = "Apakah anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

        return view('pages.daftar-halaqoh', compact('halaqoh'));
    }

    public function tambahHalaqoh()
    {
        $halaqoh = Halaqoh::with(['ustad'])->get();
        $ustads = User::where('role', 'ustad')->get();

        return view('pages.tambah-halaqoh', compact('halaqoh', 'ustads'));
    }

    public function storeHalaqoh(Request $request)
    {
        $request->validate([
            'nama_halaqoh' => 'required|string|max:50',
            'ustad_pengampu' => 'required|exists:users,id,role,ustad',
        ]);
        // Buat instansiasi model Hafalan
        $halaqoh = new Halaqoh();
        $halaqoh->nama_halaqoh = $request->input('nama_halaqoh');
        $halaqoh->ustad_pengampu = $request->input('ustad_pengampu');

        $halaqoh->save();

        // Redirect atau tampilkan pesan sukses jika perlu
        return redirect('admin/daftar-halaqoh')->with('success', 'Data halaqoh berhasil disimpan.');
    }

    public function updateHalaqoh($id)
    {
        $halaqoh = Halaqoh::with(['ustad'])->findOrFail($id);
        $ustads = User::where('role', 'ustad')->get();

        return view('pages.edit-halaqoh', compact('halaqoh', 'ustads'));
    }

    public function editHalaqoh(Request $request, $id)
    {
        $request->validate([
            'nama_halaqoh' => 'required|string|max:50',
            'ustad_pengampu' => 'required|exists:users,id,role,ustad',
        ]);

        $halaqoh = Halaqoh::findOrFail($id);
        $halaqoh->update([
            'nama_halaqoh' => $request->nama_halaqoh,
            'ustad_pengampu' => $request->ustad_pengampu,
        ]);

        return redirect('admin/daftar-halaqoh')->with('success', 'Data halaqoh berhasil diupdate.');
    }

    public function deleteHalaqoh($id)
    {
        $halaqoh = Halaqoh::findOrFail($id);

        // Hapus halaqoh
        $halaqoh->delete();

        return redirect('admin/daftar-halaqoh')->with('success', 'Halaqoh berhasil dihapus.');
    }

    public function daftarKelas(Request $request)
    {
        // Use the query builder to get a paginated result
        $kelas = Kelas::paginate($request->input('per_page', 10));
        $title = 'Hapus Data Kelas?';
        $text = "Apakah anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

        return view('pages.daftar-kelas', compact('kelas'));
    }

    public function tambahKelas()
    {
        $kelas = Kelas::all();

        return view('pages.tambah-kelas', compact('kelas'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([]);
        // Buat instansiasi model Hafalan
        $kelas = new Kelas();
        $kelas->kelas = $request->input('kelas');

        $kelas->save();

        // Redirect atau tampilkan pesan sukses jika perlu
        return redirect('admin/daftar-kelas')->with('success', 'Data kelas berhasil disimpan.');
    }

    public function updateKelas($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view('pages.edit-kelas', compact('kelas'));
    }

    public function editKelas(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required|string|max:50',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'kelas' => $request->kelas,
        ]);

        return redirect('admin/daftar-kelas')->with('success', 'Data kelas berhasil diupdate.');
    }

    public function daftarSantri(Request $request)
    {
        // Use the query builder to get a paginated result
        $santri = Santri::paginate($request->input('per_page', 10));
        $title = 'Hapus Data Santri?';
        $text = "Apakah anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

        return view('pages.daftar-santri', compact('santri'));
    }

    public function tambahSantri()
    {
        $halaqoh = Halaqoh::with(['ustad'])->get();
        $kelas = Kelas::all();

        return view('pages.tambah-santri', compact('halaqoh', 'kelas'));
    }

    public function storeSantri(Request $request)
    {
        $request->validate([
            'role' => 'required|in:santri',
            'email' => ['required', 'email', Rule::unique('users')],
            'name' => 'required|string',
            'password' => 'required|string|min:6',
            'halaqoh_id' => 'required',
            'kelas_id' => 'required',
            'nomor_id' => ['required', Rule::unique('santri')],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            $santri = Santri::create([
                'id_santri' => $user->id,
                'halaqoh_id' => $request->halaqoh_id,
                'kelas_id' => $request->kelas_id,
                'nomor_id' => $request->nomor_id,
            ]);

            return redirect('admin/daftar-santri')->with('success', 'Data santri berhasil ditambah.');
        } catch (\Exception $e) {
            if ($e->errorInfo[1] == 1062) { // Error code for duplicate entry
                return redirect()->back()->with('error', 'Email atau Nomor Induk sudah digunakan.');
            } else {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }


    public function updateSantri($id)
    {
        $santri = Santri::findOrFail($id);
        $halaqoh = Halaqoh::all();
        $users = User::where('role', 'santri');

        return view('pages.edit-santri', compact('santri', 'users', 'halaqoh'));
    }

    public function editSantri(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);
        $request->validate([
            'halaqoh_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $santri->update([
            'halaqoh_id' => $request->halaqoh_id,
        ]);

        $santri->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('admin/daftar-santri')->with('success', 'Data santri berhasil diupdate.');
    }

    public function deleteSantri($id)
    {
        $santri = Santri::findOrFail($id);

        // Hapus halaqoh
        $santri->delete();

        return redirect('admin/daftar-halaqoh')->with('success', 'Data santri berhasil dihapus.');
    }
}
