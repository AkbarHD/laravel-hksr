<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListLaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PelaporController;
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


Route::middleware('auth')->group(function () {
    Route::get('/admin/homeadmin', [HomeController::class, 'homeadmin'])->name('homeadmin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

    Route::get('/list-pelaporan', [ListLaporanController::class, 'index'])->name('pelapor.index');
});


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProses'])->name('loginProses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerProses'])->name('registerProses');

