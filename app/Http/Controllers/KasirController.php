<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Bahan; // Pastikan model Bahan sudah ada

class KasirController extends Controller
{
    /**
     * Tampilan Utama POS / Kasir
     */
    public function index()
    {
        $transaksi = Transaksi::with('menu')->latest()->get();
        return view('kasir.index', compact('transaksi'));
    }

    /**
     * Form Transaksi Baru
     */
    public function create()
    {
        $menu = Menu::where('stok', '>', 0)->get(); 
        $cabang = Cabang::all();
        return view('kasir.create', compact('menu', 'cabang'));
    }

    /**
     * Simpan Transaksi & Potong Stok Menu
     */
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'menu_id'   => 'required|exists:menu,id',
            'qty'       => 'required|numeric|min:1',
            'total'     => 'required|numeric',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        if ($menu->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi! Sisa: ' . $menu->stok);
        }

        Transaksi::create([
            'menu_id'   => $request->menu_id,
            'cabang_id' => $request->cabang_id, 
            'qty'       => $request->qty,
            'total'     => $request->total,
            'tanggal'   => now()->toDateString(),
        ]);

        $menu->decrement('stok', $request->qty);

        return redirect()->route('kasir.index')->with('success', 'Transaksi Berhasil!');
    }

    /**
     * Form Edit Transaksi
     */
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menu = Menu::all();
        $cabang = Cabang::all();

        return view('kasir.edit', compact('transaksi', 'menu', 'cabang'));
    }

    /**
     * Update Transaksi & Penyesuaian Balik Stok
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menuLama = Menu::find($transaksi->menu_id);
        $menuBaru = Menu::find($request->menu_id);

        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'qty'     => 'required|numeric|min:1',
            'total'   => 'required|numeric'
        ]);

        // 1. Kembalikan stok lama
        $menuLama->increment('stok', $transaksi->qty);

        // 2. Cek apakah stok menu baru cukup (setelah dikembalikan)
        if ($menuBaru->stok < $request->qty) {
            // Rollback stok lama jika gagal
            $menuLama->decrement('stok', $transaksi->qty);
            return back()->with('error', 'Stok menu baru tidak mencukupi!');
        }

        // 3. Potong stok menu baru & Update Transaksi
        $menuBaru->decrement('stok', $request->qty);
        $transaksi->update([
            'menu_id' => $request->menu_id,
            'qty'     => $request->qty,
            'total'   => $request->total
        ]);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // --- FUNGSI UNTUK MANAJEMEN BAHAN MENTAH ---

    /**
     * Simpan Bahan Mentah Baru
     */
    public function storeBahan(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'satuan'     => 'required|string',
            'cabang_id'  => 'required|exists:cabangs,id'
        ]);

        Bahan::create($request->all());

        return redirect()->back()->with('success', 'Bahan mentah berhasil ditambahkan!');
    }


    
    public function createBahan()
    {
        $cabangs = \App\Models\Cabang::all(); // 🔥 WAJIB
        return view('bahan.create', compact('cabangs'));
    }
   /**
 * Menampilkan Form Edit Bahan
 */
public function editBahan($id)
{
    // Mengambil data bahan berdasarkan ID
    $bahan = \App\Models\Bahan::findOrFail($id);
    
    // Mengarahkan ke file resources/views/bahan/edit.blade.php
    return view('bahan.edit', compact('bahan'));
}

/**
 * Memproses Update Data Bahan ke Database
 */
public function updateBahan(Request $request, $id)
{
    // 1. Validasi Input
    $request->validate([
        'nama_bahan' => 'required|string|max:255',
        'jumlah'     => 'required|numeric|min:0',
        'satuan'     => 'required|string'
    ]);

    // 2. Cari data dan Update
    $bahan = \App\Models\Bahan::findOrFail($id);
    $bahan->update([
        'nama_bahan' => $request->nama_bahan,
        'jumlah'     => $request->jumlah,
        'satuan'     => $request->satuan,
    ]);

    // 3. Redirect kembali ke halaman stok dengan pesan sukses
    return redirect()->route('stok.index')->with('success', 'Data bahan berhasil diperbarui!');
}

    /**
     * Hapus Bahan Mentah
     */
    public function destroyBahan($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->back()->with('success', 'Bahan berhasil dihapus!');
    }
}