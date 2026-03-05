<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\Menu;

class KasirController extends Controller
{

    public function index()
    {
       $transaksi = Transaksi::latest()->get();
    return view('kasir.index', compact('transaksi'));
    }


public function create()
{
    $menu = Menu::all(); 
    $cabang = Cabang::all();
    return view('kasir.create', compact('menu', 'cabang'));
}

public function store(Request $request)
{
    // 1. Validasi input dari form
    $request->validate([
        'cabang_id' => 'required',
        'menu_id'   => 'required',
        'qty'       => 'required|numeric|min:1',
        'total'     => 'required|numeric',
    ]);

    // 2. Cari data menu untuk cek stok
    $menu = Menu::findOrFail($request->menu_id);

    // 3. Validasi: Jika stok di database kurang dari jumlah yang dibeli
    if ($menu->stok < $request->qty) {
        return back()->with('error', 'Stok tidak mencukupi! Sisa stok saat ini: ' . $menu->stok);
    }

    // 4. Jika stok aman, simpan data ke tabel transaksis
    Transaksi::create([
        'menu_id'   => $request->menu_id,
        'cabang_id' => $request->cabang_id, 
        'qty'       => $request->qty,
        'total'     => $request->total,
        'tanggal'   => now()->format('Y-m-d'),
    ]);

    // 5. Kurangi stok di tabel menu secara otomatis
    $menu->decrement('stok', $request->qty);

    // 6. Kembali ke halaman utama kasir dengan pesan sukses
    return redirect()->route('kasir.index')->with('success', 'Transaksi Berhasil dan Stok Berhasil Dipotong!');
}


    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menu = Menu::all();

        return view('kasir.edit', compact('transaksi','menu'));
    }


    public function update(Request $request,$id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'menu_id'=>$request->menu_id,
            'qty'=>$request->qty,
            'total'=>$request->total
        ]);

        return redirect()->route('kasir.index');
    }

}