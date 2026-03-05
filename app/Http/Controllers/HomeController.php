<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil tanggal hari ini
        $hariIni = Carbon::today();

        // Menghitung data dari database
        $totalPenjualan = Transaksi::whereDate('tanggal', $hariIni)->sum('total');
        $totalTransaksi = Transaksi::whereDate('tanggal', $hariIni)->count();
        $menuTerjual    = Transaksi::whereDate('tanggal', $hariIni)->sum('qty');
        
        // Menghitung stok menipis (asumsi kolom 'stok' ada di tabel menu)
        // Jika belum ada kolom stok, ganti angka 0 saja agar tidak error
        $stokMenipis    = Menu::where('stok', '<', 10)->count();

        // MENGIRIM DATA KE VIEW
        return view('dashboard', compact(
            'totalPenjualan', 
            'totalTransaksi', 
            'menuTerjual', 
            'stokMenipis'
        ));
    }
}