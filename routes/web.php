<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\StokController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Redirect ke login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Route yang membutuhkan login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------
    | Dashboard
    |--------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------
    | CRUD Master Data
    |--------------------------------
    */

    // Cabang
    Route::resource('cabang', CabangController::class);

    // Menu
    

    // Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

    // Stok
    Route::resource('stok', StokController::class);

    /*
    |--------------------------------
    | POS / Kasir
    |--------------------------------
    */

    Route::resource('kasir', KasirController::class);

    /*
    |--------------------------------
    | Profile User
    |--------------------------------
    */

    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Auth Route (Laravel Breeze / Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';