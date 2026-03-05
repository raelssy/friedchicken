<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\StokController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    return redirect('/login');
});



Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Cabang
    Route::resource('cabang', CabangController::class);
    
    // Menu
    Route::resource('menu', MenuController::class);

    // Stok
    Route::resource('stok', StokController::class);
    // Route untuk menampilkan halaman form (Create)
Route::get('/stok/bahan/create', [App\Http\Controllers\StokController::class, 'createBahan'])->name('stok.bahan.create');

// Route untuk memproses penyimpanan data (Store)
Route::post('/stok/bahan/store', [App\Http\Controllers\StokController::class, 'storeBahan'])->name('stok.bahan.store');
    
    
    //kasir
    Route::resource('kasir', KasirController::class);

   //profile
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';