<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;

// ── Auth routes (dari Laravel Breeze/Fortify) ─────────────────────────────
require __DIR__.'/auth.php';

// ── Authenticated routes ──────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Barang (inventaris)
    Route::resource('barang', BarangController::class);

    // Transaksi
    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/{transaksi}/nota', [TransaksiController::class, 'nota'])->name('transaksi.nota');
    Route::patch('transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.status');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // API endpoint: cari barang (untuk form transaksi - autocomplete)
    Route::get('/api/barang/search', function (\Illuminate\Http\Request $request) {
        $q = $request->get('q', '');
        $barang = \App\Models\Barang::where('nama_barang', 'like', "%{$q}%")
            ->orWhere('kode_barang', 'like', "%{$q}%")
            ->select('id', 'kode_barang', 'nama_barang', 'harga_jual', 'stok', 'satuan')
            ->limit(10)
            ->get();
        return response()->json($barang);
    })->name('api.barang.search');

});