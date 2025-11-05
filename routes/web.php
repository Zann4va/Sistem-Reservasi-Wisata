<?php

use App\Http\Controllers\AuthController;
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

// Public routes
Route::get('/', function () {
    return view('beranda');
});

Route::get('/about', function () {
    return view('about');
});

// Auth routes - untuk user yang belum login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Auth routes - untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// User/Customer dashboard - hanya untuk user dengan role 'user'
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard-user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Admin dashboard - hanya untuk user dengan role 'admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
