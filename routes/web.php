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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PelaporController;
use App\Http\Controllers\StackholderController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontController::class, 'index'])->name('home'); // halaman depan
Route::get('/modul', [FrontController::class, 'modul'])->name('modul'); // halaman modul
Route::get('/modul/{slug}', [FrontController::class, 'detailModul'])->name('modul.detail'); // detail modul
Route::get('/modul/download/{id}', [FrontController::class, 'downloadModulPdf'])->name('modul.download.pdf'); // untuk mengunduh modul dalam format PDF

Route::middleware('auth')->group(function () {
    Route::get('/admin/homeadmin', [HomeController::class, 'homeadmin'])->name('homeadmin'); // halaman admin
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // untuk logout

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile'); // halaman profile
    Route::put('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update'); // untuk update profile

    // get notifikasi per role
    Route::get('/notifikasi', [NotificationController::class, 'getNotifikasi'])->name('get.notifikasi');
    // untuk menandai notifikasi sebagai sudah dibaca
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAsRead'])->name('notifikasi.readall');

    // modul untuk admin crud
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    // modul for admin crud
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

    // data master konselor untuk crud dibagian dashboard
    Route::prefix('list-konselor')->group(function () {
        Route::get('/', [KonselorController::class, 'index'])->name('list.konselor.index'); // halaman daftar konselor
        Route::get('/create', [KonselorController::class, 'create'])->name('list.konselor.create'); // halaman tambah konselor
        Route::post('/update/{id}', [KonselorController::class, 'update'])->name('list.konselor.update'); // untuk update konselor
        Route::get('/edit/{id}', [KonselorController::class, 'edit'])->name('list.konselor.edit'); // untuk edit konselor
        Route::get('/detail/{id}', [KonselorController::class, 'detail'])->name('list.konselor.detail'); // untuk detail konselor
        Route::post('/store', [KonselorController::class, 'store'])->name('list.konselor.store'); // untuk menyimpan konselor baru
        Route::delete('/delete/{id}', [KonselorController::class, 'destroy'])->name('list.konselor.destroy'); // untuk menghapus konselor
    });

    // untuk user buat chat dengan konselor di bagian halaman depan
    Route::prefix('konselor')->group(function () {
        Route::get('/', [FrontendKonselorController::class, 'index'])->name('konselor.index'); // halaman daftar konselor
        Route::get('/detail/{id}', [FrontendKonselorController::class, 'show'])->name('konselor.detail'); // detail konselor
        Route::post('/send-message', [FrontendKonselorController::class, 'sendMessage'])->name('konselor.send-message'); // untuk user mengirim pesan ke konselor
        Route::get('messages/{id}', [FrontendKonselorController::class, 'getMessage'])->name('konselor.message'); // untuk mendapatkan pesan konselor
    });

    // untuk konselor membalas chat user di bagian dashboard
    Route::prefix('konselor-dashboard')->group(function () {
        Route::get('/', [KonselorDashboardController::class, 'index'])->name('konselor-dashboard.index'); // halaman utama dashboard konselor
        Route::get('/chat/{sessionId}', [KonselorDashboardController::class, 'chat'])->name('konselor-dashboard.chat'); // halaman chat konselor dengan user
        Route::post('/send-message', [KonselorDashboardController::class, 'sendMessage'])->name('konselor-dashboard.send-message'); // untuk konselor mengirim pesan ke user
        Route::get('/messages/{sessionId}', [KonselorDashboardController::class, 'getMessages'])->name('konselor-dashboard.messages'); // untuk mendapatkan pesan konselor
    });

    // list laporan milik user
    Route::get('/list-pelaporan', [ListLaporanController::class, 'index'])->name('list.laporan.index');
    Route::get('/detail-pelapor/{id}', [ListLaporanController::class, 'show'])->name('list.laporan.detail');
    Route::delete('/delete-pelapor/{id}', [ListLaporanController::class, 'destroy'])->name('list.laporan.destroy');

    // untuk admin mengelola laporan yang pending
    Route::get('/admin/laporan-pending', [ListLaporanController::class, 'pendingLaporan'])->name('admin.laporan.pending'); // halaman laporan pending
    Route::post('/laporan/{id}/verifikasi', [ListLaporanController::class, 'verifikasi'])->name('laporan.verifikasi'); // untuk admin memverifikasi laporan
    Route::post('/laporan/{id}/tolak', [ListLaporanController::class, 'tolak'])->name('laporan.tolak'); // untuk admin menolak laporan
    Route::get('/laporan/ajax/detail/{id}', [ListLaporanController::class, 'getDetail'])->name('laporan.ajax.detail'); // untuk mendapatkan detail laporan via ajax
    Route::get('/laporan/pdf/{id}', [ListLaporanController::class, 'downloadPdf']); // untuk mengunduh laporan dalam format PDF

    // untuk admin mengelola user
    Route::get('/admin/managament-user', [ManagementUserController::class, 'index'])->name('admin.managament.index');
    Route::post('/admin/managament-user/store', [ManagementUserController::class, 'store'])->name('admin.managament.store');
    Route::delete('/admin/managament-user/delete/{id}', [ManagementUserController::class, 'destroy'])->name('admin.managament.destroy');

    // stackholder untuk menindaklanjuti laporan
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
