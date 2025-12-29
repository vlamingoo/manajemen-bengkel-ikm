<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - Semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile - Semua role bisa akses
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // CRUD Customer - Admin & finance
    Route::middleware(['role:admin,finance'])->group(function () {
        Route::resource('customers', CustomerController::class);
    });
    
    // CRUD Vehicle - Admin & finance
    Route::middleware(['role:admin,finance'])->group(function () {
        Route::resource('vehicles', VehicleController::class);
    });
    
    // Sparepart routes
    // Allow viewing for owner, admin & finance
    Route::middleware(['role:owner,admin,finance'])->group(function () {
        Route::get('/spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
        Route::get('/spareparts/{sparepart}', [SparepartController::class, 'show'])
            ->whereNumber('sparepart')
            ->name('spareparts.show');
    });

    // Management (create/edit/delete) only for finance
    Route::middleware(['role:finance'])->group(function () {
        Route::get('/spareparts/create', [SparepartController::class, 'create'])->name('spareparts.create');
        Route::post('/spareparts', [SparepartController::class, 'store'])->name('spareparts.store');
        Route::get('/spareparts/{sparepart}/edit', [SparepartController::class, 'edit'])->name('spareparts.edit');
        Route::put('/spareparts/{sparepart}', [SparepartController::class, 'update'])->name('spareparts.update');
        Route::delete('/spareparts/{sparepart}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');
    });
    
    // CRUD Transaction - Admin only (finance dan owner hanya lihat)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });
    
    // Lihat transaksi - Semua role
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    // CRUD User - Khusus Admin ONLY
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Laporan - Owner, Admin & Finance
    Route::middleware(['role:owner,admin,finance'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pendapatan', [LaporanController::class, 'pendapatan'])->name('laporan.pendapatan');
    Route::get('/laporan/sparepart', [LaporanController::class, 'sparepart'])->name('laporan.sparepart');
    Route::get('/laporan/pelanggan', [LaporanController::class, 'pelanggan'])->name('laporan.pelanggan');
    Route::get('/laporan/grafik', [LaporanController::class, 'grafik'])->name('laporan.grafik');
});
    
    // AJAX untuk get vehicles by customer
    Route::get('/get-vehicles/{customerId}', [TransactionController::class, 'getVehicles']);
});

require __DIR__.'/auth.php';