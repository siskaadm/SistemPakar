<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\RekomendasiSolusiController;
use App\Http\Controllers\Admin\AturanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController as UserDashboardController;
// use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pages\DataController;
use App\Http\Controllers\Pages\DiagnosaController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.proses');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/registrasi', [RegisterController::class, 'index'])->name('register');
Route::post('/registrasi-proses', [RegisterController::class, 'store'])->name('register.proses');

#user
Route::get('data', [DataController::class, 'index'])->name('page.data');
Route::group(['middleware' => ['auth', 'User']],function(){
	Route::get('diagnosa', [DiagnosaController::class, 'index'])->name('page.diagnosa');
	Route::post('diagnosa', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
	Route::get('diagnosa/cetak', [DiagnosaController::class, 'cetak'])->name('diagnosa.cetak');
});

#admin
Route::group(['middleware' => ['auth', 'AdminPakar']],function(){
	Route::resource('gejala', GejalaController::class);
	Route::get('getGejala', [GejalaController::class, 'getGejala'])->name('gejala.list');
	Route::delete('/gejala/{id}/delete', [GejalaController::class, 'destroy']);
	Route::put('/gejala/{id}', [GejalaController::class, 'store']);
	Route::resource('kerusakan', KerusakanController::class);
	Route::get('getKerusakan', [KerusakanController::class, 'getKerusakan'])->name('kerusakan.list');
	Route::delete('/kerusakan/{id}/delete', [KerusakanController::class, 'destroy']);
	Route::put('/kerusakan/{id}', [KerusakanController::class, 'store']);
	Route::resource('kategori', KategoriController::class);
	Route::get('getKategori', [KategoriController::class, 'getKategori'])->name('kategori.list');
	Route::delete('/kategori/{id}/delete', [KategoriController::class, 'destroy']);
	Route::put('/kategori/{id}', [KategoriController::class, 'store']);
	Route::resource('rekomendasisolusi', RekomendasiSolusiController::class);
	Route::get('getRekomendasiSolusi', [RekomendasiSolusiController::class, 'getRekomendasiSolusi'])->name('rekomendasisolusi.list');
	Route::delete('/rekomendasisolusi/{id}/delete', [RekomendasiSolusiController::class, 'destroy']);
	Route::put('/rekomendasisolusi/{id}', [RekomendasiSolusiController::class, 'store']);
	Route::resource('aturan', AturanController::class);
	Route::get('getAturan', [AturanController::class, 'getAturan'])->name('aturan.list');
	Route::delete('/aturan/{id}/delete', [AturanController::class, 'destroy']);
	Route::put('/aturan/{id}', [AturanController::class, 'store']);
});

Route::prefix('admin')->group(function () {
	Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
	Route::get('grafiklaporan', [LaporanController::class, 'grafik'])->name('laporan.grafik');
	Route::get('laporan/detail/{id}', [LaporanController::class, 'detail'])->name('laporan.detail');

    Route::resource('user', UserController::class); //->middleware('level:super_admin');
	Route::delete('/user/{id}/delete', [UserController::class, 'destroy']);
});
