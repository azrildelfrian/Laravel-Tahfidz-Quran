<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminC;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DaftarHafalan;
use App\Http\Controllers\Santri\SantriC;
use App\Http\Controllers\Ustad\UstadC;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/register', function () {
        return redirect('admin/daftar-akun/tambah');
    });
    Route::get('admin/dashboard', [AdminC::class, 'index'])->name('admin.dashboard');
    //hafalan
    Route::get('admin/daftar-hafalan', [AdminC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
    Route::get('admin/riwayat-hafalan', [AdminC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
    Route::get('admin/tambah-hafalan', [AdminC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
    Route::get('admin/detail-hafalan/{id}', [AdminC::class, 'detail'])->name('admin.pages.detail-hafalan');
    Route::get('admin/periksa-hafalan/{id}', [AdminC::class, 'periksa'])->name('admin.pages.periksa-hafalan');
    Route::get('admin/edit-hafalan/{id}', [AdminC::class, 'ubah'])->name('admin.edit-hafalan');
    Route::post('admin/hafalan/store', [AdminC::class, 'store'])->name('admin.hafalan.store');
    Route::patch('admin/hafalan/reviewed/{id}', [AdminC::class, 'reviewed'])->name('admin.hafalan.reviewed');
    Route::patch('admin/edit-hafalan/{id}', [AdminC::class, 'edit'])->name('admin.hafalan.edit');
    Route::delete('/admin/daftar-hafalan/{id}', [AdminC::class, 'destroy'])->name('admin.daftar-hafalan.destroy');
    Route::get('admin/riwayat-hafalan/export/', [AdminC::class, 'export']);
    //akun
    Route::get('admin/daftar-akun', [AdminC::class, 'daftarAkun'])->name('pages.daftar-akun');
    Route::get('admin/daftar-akun/tambah', [RegisteredUserController::class, 'create'])->name('auth.register');
    Route::get('admin/edit-akun/{id}', [AdminC::class, 'updateAkun'])->name('admin.edit-akun');
    Route::post('/admin/daftar-akun/store', [RegisteredUserController::class, 'store'])->name('admin.auth.store');
    Route::patch('admin/edit-akun/{id}', [AdminC::class, 'editAkun'])->name('admin.edit.akun');
    Route::delete('/admin/daftar-akun/{id}', [AdminC::class, 'destroyAkun'])->name('admin.akun.destroy');
    //halaqoh
    Route::get('admin/daftar-halaqoh', [AdminC::class, 'daftarHalaqoh'])->name('pages.daftar-halaqoh');
    Route::get('admin/daftar-halaqoh/tambah', [AdminC::class, 'tambahHalaqoh'])->name('pages.tambah-halaqoh');
    Route::post('/admin/daftar-halaqoh/store', [AdminC::class, 'storeHalaqoh'])->name('admin.halaqoh.store');
    Route::get('admin/daftar-halaqoh/edit/{id}', [AdminC::class, 'updateHalaqoh'])->name('pages.edit-halaqoh');
    Route::patch('admin/daftar-halaqoh/edit/{id}', [AdminC::class, 'editHalaqoh'])->name('admin.edit.halaqoh');
    Route::delete('admin/daftar-halaqoh/delete/{id}', [AdminC::class, 'deleteHalaqoh'])->name('admin.delete.halaqoh');
    //kelas
    Route::get('admin/daftar-kelas', [AdminC::class, 'daftarKelas'])->name('pages.daftar-kelas');
    Route::get('admin/daftar-kelas/tambah', [AdminC::class, 'tambahKelas'])->name('pages.tambah-kelas');
    Route::post('/admin/daftar-kelas/store', [AdminC::class, 'storeKelas'])->name('admin.kelas.store');
    Route::get('admin/daftar-kelas/edit/{id}', [AdminC::class, 'updateKelas'])->name('pages.edit-kelas');
    Route::patch('admin/daftar-kelas/edit/{id}', [AdminC::class, 'editKelas'])->name('admin.edit.kelas');
    Route::delete('admin/daftar-kelas/delete/{id}', [AdminC::class, 'deleteKelas'])->name('admin.delete.kelas');
    //santri
    Route::get('admin/daftar-santri', [AdminC::class, 'daftarSantri'])->name('pages.daftar-santri');
    Route::get('admin/daftar-santri/tambah', [AdminC::class, 'tambahSantri'])->name('pages.tambah-santri');
    Route::post('/admin/daftar-santri/store', [AdminC::class, 'storeSantri'])->name('admin.santri.store');
    Route::get('admin/daftar-santri/edit/{id}', [AdminC::class, 'updateSantri'])->name('admin.edit-santri');
    Route::patch('admin/daftar-santri/edit/{id}', [AdminC::class, 'editSantri'])->name('admin.edit.santri');
    Route::delete('admin/daftar-santri/delete/{id}', [AdminC::class, 'deleteSantri'])->name('admin.delete.santri');
});

Route::middleware(['auth', 'role:ustad'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/ustad/dashboard');
    });
    Route::get('/ustad', function () {
        return redirect('/ustad/dashboard');
    });
    Route::get('ustad/dashboard', [UstadC::class, 'index'])->name('ustad.dashboard-ustad');
    Route::get('ustad/daftar-hafalan', [UstadC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
    Route::get('ustad/riwayat-hafalan', [UstadC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
    Route::get('ustad/tambah-hafalan', [UstadC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
    Route::get('ustad/detail-hafalan/{id}', [UstadC::class, 'detail'])->name('ustad.pages.detail-hafalan');
    Route::post('ustad/hafalan/store', [UstadC::class, 'store'])->name('ustad.hafalan.store');
    Route::get('ustad/periksa-hafalan/{id}', [UstadC::class, 'periksa'])->name('ustad.pages.periksa-hafalan');
    Route::patch('ustad/hafalan/reviewed/{id}', [UstadC::class, 'reviewed'])->name('ustad.hafalan.reviewed');
    Route::get('ustad/riwayat-hafalan/export/', [AdminC::class, 'export']);
    Route::get('ustad/daftar-santri', [UstadC::class, 'daftarSantri'])->name('pages.daftar-santri');
});

Route::get('/dashboard', [SantriC::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/daftar-hafalan', [SantriC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
Route::get('/tambah-hafalan', [SantriC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
Route::get('/riwayat-hafalan', [SantriC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
Route::get('/detail-hafalan/{id}', [SantriC::class, 'detail'])->name('pages.detail-hafalan');
Route::post('hafalan/store', [SantriC::class, 'store'])->name('santri.hafalan.store');
Route::get('/detail-hafalan/{id}', [SantriC::class, 'detail'])->name('pages.detail-hafalan');
Route::get('/edit-hafalan/{id}', [SantriC::class, 'revisi'])->name('pages.edit-hafalan');
Route::patch('santri/hafalan/edit/{id}', [SantriC::class, 'edit'])->name('santri.hafalan.edit');
Route::get('riwayat-hafalan/export/', [AdminC::class, 'export']);

// Route::middleware(['auth', 'checkHafalanAccess'])->group(function () {
//     Route::get('/home', [SantriC::class, 'dashboard'])->name('dashboard');
//     Route::get('/dashboard', [SantriC::class, 'dashboard'])->name('dashboard');
//     Route::get('/daftar-hafalan', [SantriC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
//     Route::get('/tambah-hafalan', [SantriC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
//     Route::get('/riwayat-hafalan', [SantriC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
//     Route::get('/detail-hafalan/{id}', [SantriC::class, 'detail'])->name('pages.detail-hafalan');
//     Route::post('hafalan/store', [SantriC::class, 'store'])->name('santri.hafalan.store');
//     Route::get('/edit-hafalan/{id}', [SantriC::class, 'revisi'])->name('pages.edit-hafalan');
//     Route::patch('santri/hafalan/edit/{id}', [SantriC::class, 'edit'])->name('santri.hafalan.edit');
// });
    
//Route::middleware(['auth', 'role:admin', 'role:ustad'])->group(function () {
//    Route::get('/daftar-hafalan', [DaftarHafalan::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
//});

/*
Route::middleware(['auth', 'role:santri'])->group(function (){
    Route::get('/dashboard',[SantriC::class, 'index']);
});*/

/*
Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard',[AdminC::class, 'index']);
    Route::get('ustad/dashboard',[UstadC::class, 'index']);
});

*/