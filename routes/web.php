<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontendKonselorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonselorController;
use App\Http\Controllers\KonselorDashboardController;
use App\Http\Controllers\ListLaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagementUserController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PelaporController;
use App\Http\Controllers\StackholderController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/modul', [FrontController::class, 'modul'])->name('modul');
Route::get('/modul/{slug}', [FrontController::class, 'detailModul'])->name('modul.detail');
Route::get('/modul/download/{id}', [FrontController::class, 'downloadModulPdf'])->name('modul.download.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/admin/homeadmin', [HomeController::class, 'homeadmin'])->name('homeadmin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update');

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });
    Route::prefix('materi')->group(function () {
        Route::get('/', [ModulController::class, 'index'])->name('materi.index');
        Route::post('/store', [ModulController::class, 'store'])->name('materi.store');
        Route::get('/edit', [ModulController::class, 'edit'])->name('materi.edit');
        Route::post('/update/{id}', [ModulController::class, 'update'])->name('materi.update');
        Route::get('/materi/detail', [ModulController::class, 'detail'])->name('materi.detail');
        Route::delete('/delete/{id}', [ModulController::class, 'destroy'])->name('materi.destroy');
    });

    // pelaporan
    Route::get('/pelaporan-kekerasan', [FrontController::class, 'pelaporan'])->name('kekerasan.seksual');
    Route::prefix('pelaporan')->group(function () {
        Route::get('/', [PelaporController::class, 'pelaporan'])->name('pelaporan.index');
        Route::post('/store', [PelaporController::class, 'store'])->name('pelaporan.store');
        Route::delete('/delete/{id}', [PelaporController::class, 'destroy'])->name('pelaporan.destroy');
    });

    // data master konselor
    Route::prefix('list-konselor')->group(function () {
        Route::get('/', [KonselorController::class, 'index'])->name('list.konselor.index');
        Route::get('/create', [KonselorController::class, 'create'])->name('list.konselor.create');
        Route::post('/update/{id}', [KonselorController::class, 'update'])->name('list.konselor.update');
        Route::get('/edit/{id}', [KonselorController::class, 'edit'])->name('list.konselor.edit');
        Route::get('/detail/{id}', [KonselorController::class, 'detail'])->name('list.konselor.detail');
        Route::post('/store', [KonselorController::class, 'store'])->name('list.konselor.store');
        Route::delete('/delete/{id}', [KonselorController::class, 'destroy'])->name('list.konselor.destroy');
    });

    // konselo
    Route::prefix('konselor')->group(function () {
        Route::get('/', [FrontendKonselorController::class, 'index'])->name('konselor.index');
        Route::get('/detail/{id}', [FrontendKonselorController::class, 'show'])->name('konselor.detail');
        Route::post('/send-message', [FrontendKonselorController::class, 'sendMessage'])->name('konselor.send-message');
        Route::get('messages/{id}', [FrontendKonselorController::class, 'getMessage'])->name('konselor.message');
    });

    // web.php - tambahkan route group untuk konselor dashboard
    Route::prefix('konselor-dashboard')->group(function () {
        Route::get('/', [KonselorDashboardController::class, 'index'])->name('konselor-dashboard.index');
        Route::get('/chat/{sessionId}', [KonselorDashboardController::class, 'chat'])->name('konselor-dashboard.chat');
        Route::post('/send-message', [KonselorDashboardController::class, 'sendMessage'])->name('konselor-dashboard.send-message');
        Route::get('/messages/{sessionId}', [KonselorDashboardController::class, 'getMessages'])->name('konselor-dashboard.messages');
    });

    Route::get('/list-pelaporan', [ListLaporanController::class, 'index'])->name('list.laporan.index');
    Route::get('/detail-pelapor/{id}', [ListLaporanController::class, 'show'])->name('list.laporan.detail');
    Route::delete('/delete-pelapor/{id}', [ListLaporanController::class, 'destroy'])->name('list.laporan.destroy');
    // admin
    Route::get('/admin/laporan-pending', [ListLaporanController::class, 'pendingLaporan'])->name('admin.laporan.pending');
    Route::post('/laporan/{id}/verifikasi', [ListLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    Route::post('/laporan/{id}/tolak', [ListLaporanController::class, 'tolak'])->name('laporan.tolak');
    Route::get('/laporan/ajax/detail/{id}', [ListLaporanController::class, 'getDetail'])->name('laporan.ajax.detail');
    Route::get('/laporan/pdf/{id}', [ListLaporanController::class, 'downloadPdf']);


    Route::get('/admin/managament-user', [ManagementUserController::class, 'index'])->name('admin.managament.index');
    Route::post('/admin/managament-user/store', [ManagementUserController::class, 'store'])->name('admin.managament.store');
    Route::delete('/admin/managament-user/delete/{id}', [ManagementUserController::class, 'destroy'])->name('admin.managament.destroy');

    // stackholder
    Route::get('/stackholder/laporan-pending', [StackholderController::class, 'laporanPending'])->name('stackholder.laporan.pending');
    Route::get('/stackholder/laporan/{id}', [StackholderController::class, 'getLaporan']);
    Route::post('/stackholder/tindaklanjut/simpan', [StackholderController::class, 'simpanTindakLanjut']);
    Route::get('/stackholder/laporan/detail/{id}', [StackholderController::class, 'getLaporanById']);
    Route::get('/user/hasil-tindaklanjut', [StackholderController::class, 'hasilTindakLanjut'])->name('user.hasil.tindaklanjut');
    Route::get('/stackholder/laporan/pdf/{id}', [StackholderController::class, 'downloadPDF']);

});


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProses'])->name('loginProses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerProses'])->name('registerProses');
