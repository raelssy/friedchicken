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

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN, REGISTER, LOGOUT)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| SEMUA USER LOGIN (ADMIN + CABANG)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

    // Kasir
    Route::resource('kasir', KasirController::class);

    // Stok
    Route::resource('stok', StokController::class);

    // 🔥 MENU (SEMUA USER BOLEH LIHAT)
    Route::resource('menu', MenuController::class)->only(['index']);

    // 🔥 STOK BAHAN
    Route::get('/stok/bahan/create', [KasirController::class, 'createBahan'])->name('stok.bahan.create');
    Route::post('/stok/bahan/store', [KasirController::class, 'storeBahan'])->name('stok.bahan.store');
    Route::get('/stok/bahan/{id}/edit', [KasirController::class, 'editBahan'])->name('stok.bahan.edit');
    Route::put('/stok/bahan/{id}', [KasirController::class, 'updateBahan'])->name('stok.bahan.update');
    Route::delete('/stok/bahan/{id}', [KasirController::class, 'destroyBahan'])->name('stok.bahan.destroy');

    // 🔥 STOK MENU
    Route::get('/menu/{id}/stok', [MenuController::class, 'editStok'])->name('menu.stok.edit');
    Route::post('/menu/{id}/stok', [MenuController::class, 'updateStok'])->name('menu.stok.update');

    // ================= 🔥 CART (PINDAH KE SINI) =================
    Route::get('/cart', [KasirController::class, 'cart'])->name('cart');
    Route::get('/cart/add/{id}', [KasirController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/remove/{id}', [KasirController::class, 'removeCart'])->name('cart.remove');
    Route::post('/checkout', [KasirController::class, 'checkout'])->name('checkout');
});

/*
|--------------------------------------------------------------------------
| KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Cabang
    Route::resource('cabang', CabangController::class);

    // Menu FULL (admin only)
    Route::resource('menu', MenuController::class)->except(['index']);

    // User Cabang
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

    // Resep
    Route::resource('resep', ResepController::class);


    Route::get('/doku/return', [App\Http\Controllers\KasirController::class, 'dokuReturn']);
    Route::post('/doku/callback', [App\Http\Controllers\DokuController::class, 'callback']);
});