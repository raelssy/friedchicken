<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\StokController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;



Route::get('/', function () {
    return redirect('/login');
});



Route::middleware(['auth'])->group(function () {
    // login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // register
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    //Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Cabang
    Route::resource('cabang', CabangController::class);
    
    // Menu
    Route::resource('menu', MenuController::class);

    // Stok
    Route::resource('stok', StokController::class);
    // Route untuk menampilkan halaman form (Create)

    // Route untuk manajemen Stok Bahan
    Route::get('/stok/bahan/create', [KasirController::class, 'createBahan'])->name('stok.bahan.create');
    Route::post('/stok/bahan/store', [KasirController::class, 'storeBahan'])->name('stok.bahan.store');

    // TAMBAHKAN INI:
    Route::get('/stok/bahan/{id}/edit', [KasirController::class, 'editBahan'])->name('stok.bahan.edit');
    Route::put('/stok/bahan/{id}', [KasirController::class, 'updateBahan'])->name('stok.bahan.update');
    Route::delete('/stok/bahan/{id}', [KasirController::class, 'destroyBahan'])->name('stok.bahan.destroy');
    
    //kasir
    Route::resource('kasir', KasirController::class);

   //profile
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';