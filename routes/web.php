<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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
Route::middleware('auth')->group(function () {
    Route::get('/admin/homeadmin', [HomeController::class, 'homeadmin'])->name('homeadmin');
     Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/pelaporan-kekerasan', [FrontController::class, 'pelaporan'])->name('pelaporan');
Route::get('/modul', [FrontController::class, 'modul'])->name('modul');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProses'])->name('loginProses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerProses'])->name('registerProses');

