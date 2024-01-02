<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminC;
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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function (){
    Route::get('/admin', function () {return redirect('/admin/dashboard');});
    Route::get('admin/dashboard',[AdminC::class, 'index'])->name('admin.dashboard');
    Route::get('admin/daftar-hafalan', [AdminC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
    Route::get('admin/riwayat-hafalan', [AdminC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
    Route::get('admin/tambah-hafalan', [AdminC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
    Route::get('admin/detail-hafalan/{id}', [AdminC::class, 'detail'])->name('admin.pages.detail-hafalan');
    Route::post('admin/hafalan/store', [AdminC::class, 'store'])->name('admin.hafalan.store');
    Route::get('admin/periksa-hafalan/{id}', [AdminC::class, 'periksa'])->name('admin.pages.periksa-hafalan');
    Route::patch('admin/hafalan/reviewed/{id}', [AdminC::class, 'reviewed'])->name('admin.hafalan.reviewed');
});

Route::middleware(['auth', 'role:ustad'])->group(function (){
    Route::get('/ustad', function () {return redirect('/ustad/dashboard');});
    Route::get('ustad/dashboard',[UstadC::class, 'index'])->name('ustad.dashboard-ustad');
    Route::get('ustad/daftar-hafalan', [UstadC::class, 'daftarHafalan'])->name('pages.daftar-hafalan');
    Route::get('ustad/riwayat-hafalan', [UstadC::class, 'riwayatHafalan'])->name('pages.riwayat-hafalan');
    Route::get('ustad/tambah-hafalan', [UstadC::class, 'tambahHafalan'])->name('pages.tambah-hafalan');
    Route::get('ustad/detail-hafalan/{id}', [UstadC::class, 'detail'])->name('ustad.pages.detail-hafalan');
    Route::post('ustad/hafalan/store', [UstadC::class, 'store'])->name('ustad.hafalan.store');
    Route::get('ustad/periksa-hafalan/{id}', [UstadC::class, 'periksa'])->name('ustad.pages.periksa-hafalan');
    Route::patch('ustad/hafalan/reviewed/{id}', [UstadC::class, 'reviewed'])->name('ustad.hafalan.reviewed');
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