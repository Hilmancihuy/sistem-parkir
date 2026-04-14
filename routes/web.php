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


// ================= KHUSUS ADMIN =================
// Akses Laporan, Slot, Manajemen User, dan Hapus Riwayat
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [ParkingController::class, 'dashboard'])->name('dashboard');
        
        // Manajemen Slot & Area
        Route::get('slot', [ParkingSlotController::class, 'index'])->name('slot');
        Route::post('slot', [ParkingSlotController::class, 'store'])->name('slot.store');
        Route::put('slot/update/{id}', [ParkingSlotController::class, 'updateSlot'])->name('slot.update');

        // Laporan & Hapus Data
        Route::get('report', [ParkingController::class, 'report'])->name('report');
        Route::delete('history/{id}', [ParkingController::class, 'destroy'])->name('history.destroy');
        Route::delete('history-all', [ParkingController::class, 'destroyAll'])->name('history.destroyAll');

        // Manajemen User (Admin & Petugas)
        Route::get('users', [UserController::class, 'index'])->name('users'); 
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });


// ================= FITUR OPERASIONAL (ADMIN & PETUGAS) =================
// Petugas dan Admin bisa mengakses fitur Masuk, Keluar, dan History
Route::middleware(['auth', 'role:admin|petugas'])
    ->group(function () {
        
        // Rute untuk Petugas
        Route::prefix('petugas')->name('petugas.')->group(function () {
            // DIUBAH: Sekarang memanggil controller, bukan function anonim
            Route::get('dashboard', [ParkingController::class, 'petugasDashboard'])->name('dashboard');

            // Petugas juga butuh akses fitur ini
            Route::get('masuk', [ParkingController::class, 'create'])->name('masuk');
            Route::post('masuk', [ParkingController::class, 'store'])->name('masuk.store');
            Route::get('keluar', [ParkingController::class, 'indexKeluar'])->name('keluar');
            Route::patch('keluar/{id}', [ParkingController::class, 'updateKeluar'])->name('keluar.update');
            Route::get('history', [ParkingController::class, 'history'])->name('history');
            Route::get('cetak/{id}', [ParkingController::class, 'showCetak'])->name('cetak');
        });

        // Duplikasi rute di prefix admin agar rute lama di sidebar admin tidak error
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('masuk', [ParkingController::class, 'create'])->name('masuk');
            Route::post('masuk', [ParkingController::class, 'store'])->name('masuk.store');
            Route::get('keluar', [ParkingController::class, 'indexKeluar'])->name('keluar');
            Route::patch('keluar/{id}', [ParkingController::class, 'updateKeluar'])->name('keluar.update');
            Route::get('history', [ParkingController::class, 'history'])->name('history');
            Route::get('cetak/{id}', [ParkingController::class, 'showCetak'])->name('cetak');
        });
    });


// ================= PROFILE & AUTH =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';