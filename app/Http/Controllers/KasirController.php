<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Bahan;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // =========================
    // LIST TRANSAKSI
    // =========================
    public function index()
    {
        $transaksi = Transaksi::with('menu')->latest()->get();
        return view('kasir.index', compact('transaksi'));
    }

    // =========================
    // FORM TRANSAKSI
    // =========================
    public function create()
    {
        $menu = Menu::where('stok', '>', 0)->get();
        $cabang = Cabang::all();

        return view('kasir.create', compact('menu', 'cabang'));
    }

    // =========================
    // SIMPAN TRANSAKSI
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabangs,id', 
            'menu_id'   => 'required|exists:menu,id',   
            'qty'       => 'required|numeric|min:1',
            'total'     => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $menu = Menu::findOrFail($request->menu_id);

            // 🔥 CEK STOK
            if ($menu->stok < $request->qty) {
                return back()->with('error', 'Stok tidak mencukupi! Sisa: ' . $menu->stok);
            }

            // 🔥 SIMPAN TRANSAKSI
            Transaksi::create([
                'menu_id'   => $request->menu_id,
                'cabang_id' => $request->cabang_id,
                'qty'       => $request->qty,
                'total'     => $request->total,
                'tanggal'   => now()->toDateString(),
            ]);

            // 🔥 KURANGI STOK MENU
            $menu->decrement('stok', $request->qty);

            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Transaksi berhasil 🔥');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =========================
    // EDIT TRANSAKSI
    // =========================
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menu = Menu::all();
        $cabang = Cabang::all();

        return view('kasir.edit', compact('transaksi', 'menu', 'cabang'));
    }

    // =========================
    // UPDATE TRANSAKSI
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty'     => 'required|numeric|min:1',
            'total'   => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);

            $menuLama = Menu::findOrFail($transaksi->menu_id);
            $menuBaru = Menu::findOrFail($request->menu_id);

            // 🔥 KEMBALIKAN STOK LAMA
            $menuLama->increment('stok', $transaksi->qty);

            // 🔥 CEK STOK BARU
            if ($menuBaru->stok < $request->qty) {
                // rollback manual
                $menuLama->decrement('stok', $transaksi->qty);

                return back()->with('error', 'Stok menu tidak mencukupi!');
            }

            // 🔥 KURANGI STOK BARU
            $menuBaru->decrement('stok', $request->qty);

            // 🔥 UPDATE TRANSAKSI
            $transaksi->update([
                'menu_id' => $request->menu_id,
                'qty'     => $request->qty,
                'total'   => $request->total
            ]);

            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Transaksi berhasil diupdate 🔥');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // =========================
    // TAMBAH BAHAN
    // =========================
    public function createBahan()
    {
        $cabangs = Cabang::all();
        return view('bahan.create', compact('cabangs'));
    }

    public function storeBahan(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'satuan'     => 'required|string',
            'cabang_id'  => 'required|exists:cabangs,id'
        ]);

        Bahan::create($request->all());

        return back()->with('success', 'Bahan berhasil ditambahkan!');
    }

    // =========================
    // EDIT BAHAN
    // =========================
    public function editBahan($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('bahan.edit', compact('bahan'));
    }

    public function updateBahan(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'satuan'     => 'required|string'
        ]);

        $bahan = Bahan::findOrFail($id);

        $bahan->update([
            'nama_bahan' => $request->nama_bahan,
            'jumlah'     => $request->jumlah,
            'satuan'     => $request->satuan,
        ]);

        return redirect()->route('stok.index')
            ->with('success', 'Bahan berhasil diupdate!');
    }

    // =========================
    // HAPUS BAHAN
    // =========================
    public function destroyBahan($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return back()->with('success', 'Bahan berhasil dihapus!');
    }
}