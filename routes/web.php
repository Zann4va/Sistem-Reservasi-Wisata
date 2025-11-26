<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Admin-only Reservation System
|
*/

// Public routes
Route::get('/', function () {
    return view('beranda');
})->name('home');

// Auth routes - untuk admin yang belum login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', function () {
        // Registration logic here (not implemented)
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    })->name('register.store');
});

// Logout route
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes - hanya untuk user dengan role 'admin'
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Destinations CRUD
        Route::resource('destinations', DestinationController::class);

        // Customers CRUD
        Route::resource('customers', CustomerController::class);

        // Status Management - HARUS SEBELUM resource()
        Route::post('/reservations/{reservation}/change-status', [ReservationController::class, 'changeStatus'])->name('reservations.changeStatus');
        Route::post('/reservations/bulk-status-update', [ReservationController::class, 'bulkStatusUpdate'])->name('reservations.bulkStatusUpdate');
        Route::get('/reservations/{reservation}/status-history', [ReservationController::class, 'statusHistory'])->name('reservations.statusHistory');

        // Reservations CRUD
        Route::resource('reservations', ReservationController::class);
    });
});


// Ini persiapan untuk Route User saja.... andai nanti dibutuhkan
Route::middleware(['auth'])->group(function (){

});