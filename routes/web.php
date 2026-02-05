<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkingSlotController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

// Redirect dashboard berdasarkan role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    return redirect('/');
})->middleware(['auth'])->name('dashboard');


// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Cukup tulis 'dashboard' karena sudah ada prefix 'admin'
        Route::get('dashboard', [ParkingController::class, 'dashboard'])->name('dashboard');

        Route::get('history', function () {
            return view('admin.history');
        })->name('history');

        // Sesuaikan nama rute 'masuk' agar sesuai dengan tombol di sidebar
        Route::get('masuk', [ParkingController::class, 'create'])->name('masuk');
        Route::post('masuk', [ParkingController::class, 'store'])->name('masuk.store');

        Route::get('slot', [ParkingSlotController::class, 'index'])->name('slot');
        Route::post('slot', [ParkingSlotController::class, 'store'])->name('slot.store');

        Route::get('keluar', [ParkingController::class, 'indexKeluar'])->name('keluar');
        Route::patch('keluar/{id}', [ParkingController::class, 'updateKeluar'])->name('keluar.update');

        Route::get('history', [ParkingController::class, 'history'])->name('history');
        Route::delete('history/{id}', [ParkingController::class, 'destroy'])->name('history.destroy');
        Route::delete('history-all', [ParkingController::class, 'destroyAll'])->name('history.destroyAll');

        Route::get('report', [ParkingController::class, 'report'])->name('report');

        // Di dalam Route::group yang prefix-nya 'admin' dan name-nya 'admin.'
        Route::get('users', [UserController::class, 'index'])->name('users'); 
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('cetak/{id}', [ParkingController::class, 'showCetak'])->name('cetak');
        // Tambahkan ini untuk memproses update kapasitas slot/area
        Route::put('/admin/slot/update/{id}', [ParkingSlotController::class, 'updateSlot'])->name('admin.slot.update');
    });


// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('petugas.dashboard');
        })->name('dashboard');

    });


// ================= PROFILE =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
