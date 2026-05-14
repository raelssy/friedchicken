<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\DokuController;

// Doku Payment Gateway Webhook (Harus di luar Auth Middleware)
Route::post('/doku/callback', [DokuController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) { 
        abort(404); 
    }
    return response()->file($fullPath);
})->where('path', '.*');

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| SEMUA USER LOGIN (ADMIN & PEGAWAI/CABANG)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kasir & Transaksi
    Route::resource('kasir', KasirController::class);
    Route::resource('stok', StokController::class);
    
    // Menu (Akses Lihat)
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    // Manajemen Stok Bahan
    Route::get('/stok/bahan/create', [KasirController::class, 'createBahan'])->name('stok.bahan.create');
    Route::post('/stok/bahan/store', [KasirController::class, 'storeBahan'])->name('stok.bahan.store');
    Route::get('/stok/bahan/{id}/edit', [KasirController::class, 'editBahan'])->name('stok.bahan.edit');
    Route::put('/stok/bahan/{id}', [KasirController::class, 'updateBahan'])->name('stok.bahan.update');
    Route::delete('/stok/bahan/{id}', [KasirController::class, 'destroyBahan'])->name('stok.bahan.destroy');

    // Update Stok Menu Berdasarkan Resep
    Route::get('/menu/{id}/stok', [MenuController::class, 'editStok'])->name('menu.stok.edit');
    Route::post('/menu/{id}/stok', [MenuController::class, 'updateStok'])->name('menu.stok.update');

    /* 
    |--------------------------------------------------------------------------
    | FITUR KERANJANG (CART)
    |--------------------------------------------------------------------------
    | Menggunakan MenuController untuk fitur Tambah/Kurang agar lebih praktis.
    */
    Route::get('/cart', [KasirController::class, 'cart'])->name('cart');
    Route::get('/cart/remove/{id}', [KasirController::class, 'removeCart'])->name('cart.remove');
    Route::post('/checkout', [KasirController::class, 'checkout'])->name('checkout');

    // Fitur Tambah (+) dan Kurang (-) qty di Card Menu
    Route::get('/cart/add/{id}', [MenuController::class, 'add'])->name('cart.add');
    Route::get('/cart/decrease/{id}', [MenuController::class, 'decrease'])->name('cart.decrease');
});

/*
|--------------------------------------------------------------------------
| KHUSUS ROLE: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Manajemen Cabang & User
    Route::resource('cabang', CabangController::class);
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

    // Manajemen Menu Lengkap (Create, Edit, Delete)
    Route::resource('menu', MenuController::class)->except(['index']);

    // Resep Masakan
    Route::resource('resep', ResepController::class);

    // Laporan Operasional
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

    // Doku Payment Gateway
    Route::get('/doku/return', [KasirController::class, 'dokuReturn']);
});