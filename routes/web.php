<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminC;
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
    return view('welcome');
});

Route::get('/dashboard', [SantriC::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function (){
    Route::get('admin/dashboard',[AdminC::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:ustad'])->group(function (){
    Route::get('ustad/dashboard',[UstadC::class, 'index'])->name('ustad.dashboard-ustad');
});

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